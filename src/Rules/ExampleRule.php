<?php

namespace Jxckaroo\StateMachine\Rules;

class ExampleRule extends StateRule
{
    public function validate(): bool
    {
        return true;
    }
}
