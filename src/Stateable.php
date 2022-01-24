<?php

namespace Jxckaroo\StateMachine;

use Jxckaroo\StateMachine\Exceptions\StateMachineException;
use Jxckaroo\StateMachine\Exceptions\StateNotExistException;
use Jxckaroo\StateMachine\Models\State;
use Jxckaroo\StateMachine\Models\StateHistory;

/**
 * @package Jxckaroo\StateMachine
 */
trait Stateable
{
    /**
     * @var StateMachine $stateMachine
     */
    private StateMachine $stateMachine;

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeStateable()
    {
        $this->stateMachine = app(StateMachine::class);
    }

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
                return $this->stateMachine;
            }

            throw new StateMachineException("`\$states` property not configured correctly on `" . $this::class . "`");
        }

        if (!array_key_exists($state, $this->states)) {
            if ($silent) {
                return $this->stateMachine;
            }

            throw new StateNotExistException("State `$state` does not exist on `" . $this::class . "`");
        }

        return $this->stateMachine
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

    public function transitionToNext(): StateMachine
    {
        return $this->transitionTo($this->nextState());
    }

    public function transitionToPrevious(): StateMachine
    {
        return $this->transitionTo($this->previousState());
    }

    /**
     * Retrieve the previous state of a model
     *
     * @return string|null
     */
    public function previousState()
    {
        if ($this->state == null) {
            return null;
        }

        $keys = array_keys($this->states);
        $index = array_search($this->state->name, $keys);

        if ($index == false) {
            return null;
        }

        if (!isset($keys[$index - 1])) {
            return null;
        }

        return $keys[$index - 1];
    }

    /**
     * Retrieve the previous state of a model
     *
     * @return string|null
     */
    public function nextState()
    {
        if ($this->state == null) {
            return null;
        }

        $keys = array_keys($this->states);
        $index = array_search($this->state->name, $keys);

        if ($index == false) {
            return null;
        }

        if (!isset($keys[$index + 1])) {
            return null;
        }

        return $keys[$index + 1];
    }
}
