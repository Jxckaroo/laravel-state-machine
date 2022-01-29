<?php

namespace Jxckaroo\StateMachine\Rules;

use Illuminate\Database\Eloquent\Model;
use Jxckaroo\StateMachine\Contracts\StateRule;

class ExampleRuleFalse extends StateRule
{
    public function validate(Model $model): bool
    {
        return false;
    }
}
