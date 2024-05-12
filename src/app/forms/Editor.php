<?php
namespace app\forms;

use std, gui, framework, app;


class Editor extends AbstractForm
{

    /**
     * @event Bfont.action 
     */
    function doBfontAction(UXEvent $e = null)
    {    
        app()->showFormAndWait('Font');
    }

    /**
     * @event BSave.action 
     */
    function doBSaveAction(UXEvent $e = null)
    {    
        global $font, $size, $style, $text;
        
        $text = $this->MText->text;
        $font = $this->MText->font->family;
        $size = $this->MText->font->size;
        if ($this->MText->font->bold == true) $style = 'B';
        if ($this->MText->font->italic == true) $style = $style . 'I';
        if ($style == '') $style = 'N';
        
        $this->saveFile->callAsync();
    }

    /**
     * @event BClose.action 
     */
    function doBCloseAction(UXEvent $e = null)
    {
        $this->loadForm('FilesManager');
    }

}
