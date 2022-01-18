<?php

namespace Jxckaroo\StateMachine\Rules;

class ExampleRuleFalse extends StateRule
{
    public function validate(): bool
    {
        return false;
    }
}
