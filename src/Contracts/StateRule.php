<?php

namespace Jxckaroo\StateMachine\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class StateRule
{
    /**
     * @var Collection
     */
    protected Collection $errors;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->errors = collect();
    }

    /**
     * Rules should return true if passed & false if failed.
     * If no response is given, false will be assumed.
     *
     * @return bool
     */
    abstract public function validate(Model $model): bool;

    /**
     * Add an error message when a rule fails to validate.
     *
     * @return self
     */
    public function addError(string $error = ''): self
    {
        $this->errors->add(['message' => $error, 'rule' => get_class($this)]);

        return $this;
    }

    /**
     * Return a collection of errors.
     *
     * @return Collection
     */
    public function errors()
    {
        return $this->errors;
    }
}
