<?php
namespace app\forms;

use std, gui, framework, app;


class Create extends AbstractForm
{

    /**
     * @event BCreate.action 
     */
    function doBCreateAction(UXEvent $e = null)
    {    
        global $name, $type, $files;
        $name = $this->EName->text;
        
        switch ($this->RType->selectedIndex){
            case 0:
                $type = 'folder';
                break;
            case 1:
                $type = 'file';
                break;
            case 2:
                $type = 'chat';
                break;
        }
        
        for ($i = 0; $i < count($files); $i++){
            $tmp = str::split($files[$i], ',');
            if ($tmp[2] == $name){
                UXDialog::showAndWait('Объект с таким именем уже существует!' . "\n" . 'Выбирите другое имя!', 'ERROR');
                return;
            }
        }
        
        $this->hideAllInfo->call();
        $this->create->callAsync();
    }

}
