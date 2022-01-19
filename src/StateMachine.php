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
     * Get the state of the current model
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function getModelState(Model $model)
    {
        return State::query()->where("model_type", get_class($model))->where("model_id", $model->getKey())->firstOrNew();
    }

    /**
     * Save the state of the model
     *
     * @param Model $model
     * @param array $attributes
     * @return self
     */
    public function saveModelState(Model $model, array $attributes = [])
    {
        $activeState = $this->getModelState($model);

        if ($this->logStateChanges && $activeState->getKey() !== null) {
            $this->createStateHistoryEntry($activeState->getAttributes());
        } else {
            foreach ($attributes as $attr => $val) {
                if (property_exists($activeState, $attr)) {
                    $activeState->{$attr} = $val;
                }
            }

            $activeState->save();

            $activeState = $activeState->fresh();

            $this->createStateHistoryEntry($activeState->getAttributes());
        }

        return $this;
    }

    /**
     * Save the state of the model
     *
     * @param Model $model
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
}
