<?php
namespace app\forms;

use std, gui, framework, app;


class Login extends AbstractForm
{

    /**
     * @event LIReg.action 
     */
    function doLIRegAction(UXEvent $e = null)
    {    
        $this->loadForm('Register');
    }

    /**
     * @event BLogin.action 
     */
    function doBLoginAction(UXEvent $e = null)
    {    
        global $login, $password;
        $login = $this->ELogin->text;
        $password = $this->EPassword->text;
        $this->login->callAsync();
    }

    /**
     * @event LIResetPassword.action 
     */
    function doLIResetPasswordAction(UXEvent $e = null)
    {
        $this->loadForm('ResetPassword');
    }

    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {    
        $this->loadImage->call();
        if (file_exists('system/save/login.php')) {
            $this->ELogin->text = base64_decode(file_get_contents('system/save/login.php'));
            $this->EPassword->text = base64_decode(file_get_contents('system/save/password.php'));
            $this->CSave->selected = true;
        }
    }

    /**
     * @event construct 
     */
    function doConstruct(UXEvent $e = null)
    {    
        $this->loadImage->call();
    }

    /**
     * @event CSave.action 
     */
    function doCSaveAction(UXEvent $e = null)
    {    
        if ($this->CSave->selected){
            mkdir('system/save');
            file_put_contents('system/save/login.php', base64_encode($this->ELogin->text));
            file_put_contents('system/save/password.php', base64_encode($this->EPassword->text));
        }else{
            unlink('system/save/login.php');
            unlink('system/save/password.php');
        }
    }


}
