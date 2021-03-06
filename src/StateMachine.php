<?php

namespace Jxckaroo\StateMachine;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Jxckaroo\StateMachine\Contracts\StateRule;
use Jxckaroo\StateMachine\Exceptions\StateMachineRuleNotFoundException;
use Jxckaroo\StateMachine\Models\State;
use Jxckaroo\StateMachine\Models\StateHistory;

class StateMachine
{
    /**
     * @var bool
     */
    protected bool $logStateChanges = false;

    /**
     * @var mixed
     */
    protected mixed $rules;

    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @var bool
     */
    protected bool $success;

    /**
     * @var Collection
     */
    protected Collection $errors;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->errors = collect();
    }

    /**
     * Get the state of the current model.
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
     */
    public function getModelState()
    {
        return State::query()
            ->where('model_type', get_class($this->model))
            ->where('model_id', $this->model->getKey())
            ->firstOrNew();
    }

    /**
     * Save the state of the model.
     *
     * @param array $attributes
     * @return self
     */
    public function transitionModelState(array $attributes = []): self
    {
        if ($this->canTransition($this->rules)) {
            $activeState = $this->getModelState();

            if ($this->logStateChanges && $activeState->getKey() !== null) {
                $this->createStateHistoryEntry($activeState->getAttributes());
            }

            foreach ($attributes as $attr => $val) {
                $activeState->{$attr} = $val;
            }

            $activeState->save();
            $activeState->fresh();

            $this->setSuccess(true);
        } else {
            $this->setSuccess(false);
        }

        return $this;
    }

    /**
     * Save the state of the model.
     *
     * @param array $attributes
     * @return self
     */
    public function createStateHistoryEntry(array $attributes = []): self
    {
        $attributes['state_id'] = $attributes['id'];
        unset($attributes['id']);
        unset($attributes['created_at']);
        unset($attributes['updated_at']);

        StateHistory::create($attributes);

        return $this;
    }

    /**
     * Enable logging of state change.
     *
     * @return self
     */
    public function logStateChanges(): self
    {
        $this->logStateChanges = true;

        return $this;
    }

    /**
     * Validate that all rules pass.
     *
     * @param mixed $rule
     * @return bool
     */
    public function canTransition(mixed $rule): bool
    {
        $rule = Arr::wrap($rule);

        $ruleset = collect($rule)->map(function ($ruleClass) {
            if (!class_exists($ruleClass)) {
                throw new StateMachineRuleNotFoundException("`{$ruleClass}` does not exist.");
            }

            $rule = new $ruleClass;

            if (!is_subclass_of($rule, StateRule::class)) {
                throw new StateMachineRuleNotFoundException("`{$ruleClass}` does not extend \Jxckaroo\StateMachine\Contracts\StateRule::class.");
            }

            if (!method_exists($rule, 'validate')) {
                throw new StateMachineRuleNotFoundException("`{$ruleClass}` does not have a `validate` method.");
            }

            $validation = $rule->validate($this->model);

            if ($validation == false) {
                $this->setErrors(
                    $this->errors->merge($rule->errors())
                );
            }

            return $validation;
        })
            ->filter(fn ($value) => $value == true)
            ->count();

        return count($rule) == $ruleset;
    }

    /**
     * @param mixed $rules
     * @return StateMachine
     */
    public function setRules(mixed $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function setSuccess(bool $success): self
    {
        $this->success = $success;

        return $this;
    }

    public function setErrors(Collection $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    public function getErrors(): Collection
    {
        return $this->errors;
    }

    public function isSuccessful()
    {
        return $this->success === true;
    }
}
