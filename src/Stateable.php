<?php

namespace Jxckaroo\StateMachine;

use Jxckaroo\StateMachine\Exceptions\StateMachineException;
use Jxckaroo\StateMachine\Exceptions\StateNotExistException;
use Jxckaroo\StateMachine\Rules\StateRule;

trait Stateable
{
    /**
     * Undocumented function
     *
     * @param string $state
     * @param mixed $primary
     * @param string|null $primaryField
     * @return boolean
     */
    public function transitionTo(string $state, mixed $primary = null, string $primaryField = null, bool $silent = false): bool
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

        $self = $this;
        $field = "id";

        if ($primaryField !== null) {
            $field = $primaryField;
        }

        if ($primary !== null) {
            $self = $this::where($field, $primary)->firstOrfail();
        }

        return $this->validate($this->states[$state]);
    }

    /**
     * Undocumented function
     *
     * @param string|[]string $rule
     * @return void
     */
    private function validate(mixed $rule)
    {
        if (is_array($rule)) {
            return count($rule) == collect($rule)->map(fn ($item) => (new $item)->validate())->filter(fn ($value) => $value == true)->count();
        } else {
            return (new $rule)->validate();
        }
    }
}
