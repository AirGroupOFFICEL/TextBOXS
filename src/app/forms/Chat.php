<?php
namespace app\forms;

use std, gui, framework, app;


class Chat extends AbstractForm
{

    /**
     * @event BBack.action 
     */
    function doBBackAction(UXEvent $e = null)
    {    
        $this->updateChatTimer->enabled = false;
        $this->loadForm('FilesManager');
        $this->updateFiles->callAsync();
    }

    /**
     * @event EMessage.globalKeyDown-Enter 
     */
    function doEMessageGlobalKeyDownEnter(UXKeyEvent $e = null)
    {    
        global $message;
        $message = $this->EMessage->text;
    }

}
