<?php

namespace Jxckaroo\StateMachine\Rules;

use Illuminate\Database\Eloquent\Model;
use Jxckaroo\StateMachine\Contracts\StateRule;

class ExampleRule extends StateRule
{
    public function validate(Model $model): bool
    {
        return $model->getKey() !== null;
    }

    public function passes()
    {

    }

    public function fails()
    {

    }
}
