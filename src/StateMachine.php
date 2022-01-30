<?php

namespace Jxckaroo\StateMachine;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Jxckaroo\StateMachine\Models\State;
use Jxckaroo\StateMachine\Models\StateHistory;

class StateMachine
{
    /**
     * @var bool
     */
    protected bool $logStateChanges = false;

    /**
     * @var string|[]string
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
     * @var array
     */
    protected array $errors;

    /**
     * Get the state of the current model.
     *
     * @return \Illuminate\Database\Eloquent\Model|static
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
    public function transitionModelState(array $attributes = [])
    {
        if ($this->canTransition($this->rules)) {
            $activeState = $this->getModelState($this->model);

            if ($this->logStateChanges && $activeState->getKey() !== null) {
                $this->createStateHistoryEntry($activeState->getAttributes());
            }

            foreach ($attributes as $attr => $val) {
                $activeState->{$attr} = $val;
            }

            $activeState->save();
            $activeState = $activeState->fresh();

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
    public function createStateHistoryEntry(array $attributes = [])
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
    public function logStateChanges()
    {
        $this->logStateChanges = true;

        return $this;
    }

    /**
     * Validate that all rules pass.
     *
     * @param string|[]string $rule
     * @return void
     */
    public function canTransition(mixed $rule)
    {
        $rule = Arr::wrap($rule);

        $ruleset = collect($rule)->map(function ($ruleString) {
            $rule = new $ruleString;
            $validation = $rule->validate($this->model);

            if ($validation == false) {
                $this->errors[] = $rule::class;
            }

            return $validation;
        })
            ->filter(fn ($value) => $value == true)
            ->count();

        return count($rule) == $ruleset;
    }

    public function setRules(mixed $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    public function setSuccess(bool $success)
    {
        $this->success = $success;

        return $this;
    }

    public function setErrors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isSuccessful()
    {
        return $this->success === true;
    }
}
