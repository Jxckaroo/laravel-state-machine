<?php

namespace Jxckaroo\StateMachine\Tests;

use Jxckaroo\StateMachine\StateMachineServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            StateMachineServiceProvider::class,
        ];
    }
}
