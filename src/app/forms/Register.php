<?php
namespace app\forms;

use std, gui, framework, app;


class Register extends AbstractForm
{

    /**
     * @event LIReg.action 
     */
    function doLIRegAction(UXEvent $e = null)
    {
        $this->loadForm('Login');
    }

    /**
     * @event BRegister.action 
     */
    function doBRegisterAction(UXEvent $e = null)
    {    
        global $login, $password;
        $login = $this->ELogin->text;
        $password = $this->EPassword->text;
        $this->register->callAsync();
    }

    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {    
        $this->loadImage->call();
    }

}
