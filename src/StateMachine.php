<?php

namespace Jxckaroo\StateMachine;

use Illuminate\Database\Eloquent\Model;
use Jxckaroo\StateMachine\Models\State;
use Jxckaroo\StateMachine\Models\StateHistory;

class StateMachine
{
    /**
     * @var boolean $logStateChanges
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
     * @var boolean
     */
    protected bool $success;

    /**
     * Get the state of the current model
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function getModelState()
    {
        return State::query()
            ->where("model_type", get_class($this->model))
            ->where("model_id", $this->model->getKey())
            ->firstOrNew();
    }

    /**
     * Save the state of the model
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

            $this->success = true;
        } else {
            $this->success = false;
        }

        return $this;
    }

    /**
     * Save the state of the model
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
     * Enable logging of state change
     *
     * @return self
     */
    public function logStateChanges()
    {
        $this->logStateChanges = true;

        return $this;
    }

    /**
     * Validate that all rules pass
     *
     * @param string|[]string $rule
     * @return void
     */
    public function canTransition(mixed $rule)
    {
        if (is_array($rule)) {
            return count($rule) == collect($rule)->map(fn ($item) => (new $item)->validate($this->model))->filter(fn ($value) => $value == true)->count();
        } else {
            return (new $rule)->validate($this->model);
        }
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

    public function isSuccessful()
    {
        return $this->success === true;
    }
}
