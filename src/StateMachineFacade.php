<?php

namespace Jxckaroo\StateMachine;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jxckaroo\StateMachine\Skeleton\SkeletonClass
 */
class StateMachineFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'state-machine';
    }
}
