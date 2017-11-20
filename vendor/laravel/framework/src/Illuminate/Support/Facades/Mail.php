<?php

namespace Illuminate\Support\Facades;

/**
 * @see \Illuminate\Mail\Mailer
 */
class Mail extends Facade
{
    public $tester;

    public function __construct()
    {
        $this->tester = '123';
    }

    public function re(){
        return 'ok';
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mailer';
    }
}
