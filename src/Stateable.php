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
     * @return boolean
     */
    public function transitionTo(string $state, bool $silent = false): bool
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

        // If the state is already active, just return true
        if ($this->state->name == $state) {
            return true;
        }

        if ($this->stateValidates($this->states[$state])) {
            app(StateMachine::class)
                ->logStateChanges()
                ->saveModelState(
                    $this,
                    [
                        'name' => $state,
                        'model_id' => $this->getKey(),
                        'model_type' => get_class($this)
                    ]
                );
        }

        return false;
    }

    /**
     * Validate that all rules pass
     *
     * @param string|[]string $rule
     * @return void
     */
    private function stateValidates(mixed $rule)
    {
        if (is_array($rule)) {
            return count($rule) == collect($rule)->map(fn ($item) => (new $item)->validate($this))->filter(fn ($value) => $value == true)->count();
        } else {
            return (new $rule)->validate($this);
        }
    }
}
