<?php
namespace app\forms;

use bundle\updater\UpdateMe;
use std, gui, framework, app;


class MainForm extends AbstractForm
{

    const VERSION = '1.1.0';

    /**
     * @event IExit.click 
     */
    function doIExitClick(UXMouseEvent $e = null)
    {    
        app()->shutdown();
    }

    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {    
        global $ver;
        UpdateMe::start($ver, 'updater.jar', function (){
            $this->loadForm('Login');
        });
    }

}
