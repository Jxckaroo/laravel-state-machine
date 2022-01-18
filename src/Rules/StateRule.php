<?php

namespace Jxckaroo\StateMachine\Rules;

class StateRule
{
    /**
     * Rules should return true if passed & false if failed.
     * If no response is given, false will be assumed.
     *
     * @return bool
     */
    public function validate(): bool
    {
        return false;
    }

    /**
     * Runs when validation passes
     */
    public function passes()
    {}

    /**
     * Runs when validation fails
     */
    public function fails()
    {}
}
