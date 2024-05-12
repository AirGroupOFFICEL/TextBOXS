<?php
namespace app\forms;

use std, gui, framework, app;


class Font extends AbstractForm
{

    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {    
        $this->CFont->items->addAll(UXFont::getFamilies());
    
        $font = $this->form('Editor')->MText->font->family;
        $size = $this->form('Editor')->MText->font->size;
        $bold = $this->form('Editor')->MText->font->bold;
        $italic = $this->form('Editor')->MText->font->italic;
        
        $this->TBold->selected = $bold;
        $this->TItalic->selected = $italic;
        $this->CFont->value = $font;
        
        $fontC = UXFont::of($font, $size, $bold ? 'BOLD' : 'THIN', $italic);
        $this->LPrem->font = $fontC;
    }

    /**
     * @event CFont.action 
     */
    function doCFontAction(UXEvent $e = null)
    {    
        $font = $this->CFont->value;
        $size = intval($this->SSize->value);
        $bold = $this->TBold->selected;
        $italic = $this->TItalic->selected;
        
        $fontC = UXFont::of($font, $size, $bold ? 'BOLD' : 'THIN', $italic);
        $this->LPrem->font = $fontC;
    }

    /**
     * @event TBold.action 
     */
    function doTBoldAction(UXEvent $e = null)
    {    
        $font = $this->CFont->value;
        $size = intval($this->SSize->value);
        $bold = $this->TBold->selected;
        $italic = $this->TItalic->selected;
        
        $fontC = UXFont::of($font, $size, $bold ? 'BOLD' : 'THIN', $italic);
        $this->LPrem->font = $fontC;
    }

    /**
     * @event TItalic.action 
     */
    function doTItalicAction(UXEvent $e = null)
    {    
        $font = $this->CFont->value;
        $size = intval($this->SSize->value);
        $bold = $this->TBold->selected;
        $italic = $this->TItalic->selected;
        
        $fontC = UXFont::of($font, $size, $bold ? 'BOLD' : 'THIN', $italic);
        $this->LPrem->font = $fontC;
    }


    /**
     * @event SSize.mouseMove 
     */
    function doSSizeMouseMove(UXMouseEvent $e = null)
    {    
        $font = $this->CFont->value;
        $size = intval($this->SSize->value);
        $bold = $this->TBold->selected;
        $italic = $this->TItalic->selected;
        
        $fontC = UXFont::of($font, $size, $bold ? 'BOLD' : 'THIN', $italic);
        $this->LPrem->font = $fontC;
    }

    /**
     * @event SSize.mouseUp-Left 
     */
    function doSSizeMouseUpLeft(UXMouseEvent $e = null)
    {    
        $font = $this->CFont->value;
        $size = intval($this->SSize->value);
        $bold = $this->TBold->selected;
        $italic = $this->TItalic->selected;
        
        $fontC = UXFont::of($font, $size, $bold ? 'BOLD' : 'THIN', $italic);
        $this->LPrem->font = $fontC;
    }

    /**
     * @event SSize.mouseEnter 
     */
    function doSSizeMouseEnter(UXMouseEvent $e = null)
    {    
        $font = $this->CFont->value;
        $size = intval($this->SSize->value);
        $bold = $this->TBold->selected;
        $italic = $this->TItalic->selected;
        
        $fontC = UXFont::of($font, $size, $bold ? 'BOLD' : 'THIN', $italic);
        $this->LPrem->font = $fontC;
    }

    /**
     * @event BComplect.action 
     */
    function doBComplectAction(UXEvent $e = null)
    {    
        $font = $this->CFont->value;
        $size = intval($this->SSize->value);
        $bold = $this->TBold->selected;
        $italic = $this->TItalic->selected;
        
        $fontC = UXFont::of($font, $size, $bold ? 'BOLD' : 'THIN', $italic);
        $this->form('Editor')->MText->font = $fontC;
        app()->hideForm('Font');
    }

    /**
     * @event BCanel.action 
     */
    function doBCanelAction(UXEvent $e = null)
    {    
        app()->hideForm('Font');
    }

}
