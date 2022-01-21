<?php

namespace Jxckaroo\StateMachine;

use Jxckaroo\StateMachine\Exceptions\StateMachineException;
use Jxckaroo\StateMachine\Exceptions\StateNotExistException;
use Jxckaroo\StateMachine\Models\State;
use Jxckaroo\StateMachine\Models\StateHistory;

trait Stateable
{
    /**
     * Get the current state record of a model
     *
     * @return void
     */
    public function state()
    {
        return $this->morphOne(State::class, 'model');
    }

    /**
     * Get the history of states for a model
     *
     * @return void
     */
    public function stateHistory()
    {
        return $this->morphMany(StateHistory::class, 'model');
    }

    /**
     * Transition the model to a selected state
     * if the rules pass.
     *
     * @param string $state
     * @param boolean $silent
     * @return StateMachine
     */
    public function transitionTo(string $state, bool $silent = false): StateMachine
    {
        if (!property_exists($this, 'states') || !is_array($this->states)) {
            if ($silent) {
                return false;
            }

            throw new StateMachineException("`\$states` property not configured correctly on `" . $this::class . "`");
        }

        if (!array_key_exists($state, $this->states)) {
            if ($silent) {
                return false;
            }

            throw new StateNotExistException("State `$state` does not exist on `" . $this::class . "`");
        }

        return app(StateMachine::class)
            ->setModel($this)
            ->logStateChanges()
            ->setRules($this->states[$state])
            ->transitionModelState(
                [
                    'name' => $state,
                    'model_id' => $this->getKey(),
                    'model_type' => get_class($this)
                ]
            );
    }
}
