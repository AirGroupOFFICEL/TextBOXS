<?php
namespace app\forms;

use std, gui, framework, app;


class ResetPassword extends AbstractForm
{

    /**
     * @event BBack.action 
     */
    function doBBackAction(UXEvent $e = null)
    {    
        $this->EPassword->enabled = false;
        $this->BComplect->enabled = false;
        $this->BCheck->enabled = true;
        $this->ELogin->enabled = true;
        $this->EKey->enabled = true;
        $this->loadForm('Login');
    }

    /**
     * @event BCheck.action 
     */
    function doBCheckAction(UXEvent $e = null)
    {    
        global $login, $key;
        $login = $this->ELogin->text;
        $key = $this->EKey->text;
        $this->checkData->callAsync();
    }

    /**
     * @event BComplect.action 
     */
    function doBComplectAction(UXEvent $e = null)
    {    
        global $password;
        $password = $this->EPassword->text;
        $this->resetPass->callAsync();
    }

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        $this->EPassword->enabled = false;
        $this->BComplect->enabled = false;
        $this->BCheck->enabled = true;
        $this->ELogin->enabled = true;
        $this->EKey->enabled = true;
        $this->loadImage->call();
    }

}
