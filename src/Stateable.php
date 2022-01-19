<?php

namespace Jxckaroo\StateMachine;

use Exception;
use Jxckaroo\StateMachine\Exceptions\StateMachineException;
use Jxckaroo\StateMachine\Exceptions\StateNotExistException;
use Jxckaroo\StateMachine\Models\State;
use Jxckaroo\StateMachine\Rules\StateRule;

trait Stateable
{
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

        if ($this->validate($this->states[$state])) {
            app(StateMachine::class)->saveState('testing', 'doyle');

        }

        return false;
    }

    /**
     * Validate that all rules pass
     *
     * @param string|[]string $rule
     * @return void
     */
    private function validate(mixed $rule)
    {
        if (is_array($rule)) {
            return count($rule) == collect($rule)->map(fn ($item) => (new $item)->validate($this))->filter(fn ($value) => $value == true)->count();
        } else {
            return (new $rule)->validate($this);
        }
    }
}
