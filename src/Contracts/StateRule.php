<?php

namespace Jxckaroo\StateMachine\Contracts;

use Illuminate\Database\Eloquent\Model;

abstract class StateRule
{
    /**
     * Rules should return true if passed & false if failed.
     * If no response is given, false will be assumed.
     *
     * @return bool
     */
    abstract public function validate(Model $model): bool;

    /**
     * Runs when validation passes
     */
    abstract public function passes();

    /**
     * Runs when validation fails
     */
    abstract public function fails();
}
