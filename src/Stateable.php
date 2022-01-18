<?php

namespace Jxckaroo\StateMachine;

use Jxckaroo\StateMachine\Exceptions\StateMachineException;
use Jxckaroo\StateMachine\Exceptions\StateNotExistException;

trait Stateable
{
    /**
     * @param string $state
     * @param mixed $primary
     * @param string|null $primaryField
     * @return void
     */
    public function transitionTo(string $state, mixed $primary = null, string $primaryField = null)
    {
        if (!property_exists($this, 'states') || !is_array($this->states)) {
            throw new StateMachineException("`\$states` property not configured correctly on `" . $this::class . "`");
        }

        if (!array_key_exists($state, $this->states)) {
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

        echo "<pre>";
        print_r([
            'class' => $self::class,
            'id' => $self->{$field},
            'state' => $state,
            'rules' => $this->states[$state]
        ]);
        echo "</pre>";
        exit;
    }
}
