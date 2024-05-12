<?php
namespace app\forms;

use std, gui, framework, app;


class FilesManager extends AbstractForm
{

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        global $dir, $page;
        $dir = '/root';
        $this->EDir->text = $dir;
        $page = 0;
        $this->hideAllInfo->call();
        $this->updateFiles->callAsync();
        $this->fillData->callAsync();
    }

    /**
     * @event LKey2.click 
     */
    function doLKey2Click(UXMouseEvent $e = null)
    {    
        $this->toast('Ключ скопирован в буфер обмена');
        UXClipboard::setText($this->LKey2->text);
    }
    
    /**
     * @event BRefresh.action 
     */
    function doBRefreshAction(UXEvent $e = null)
    {    
        $this->hideAllInfo->call();
        $this->updateFiles->callAsync();
    }


    /**
     * @event EDir.globalKeyDown-Enter 
     */
    function doEDirGlobalKeyDownEnter(UXKeyEvent $e = null)
    {    
        global $dir, $page;
        $dir = $this->EDir->text;
        $page = 0;
        $this->PPage->selectedPage = 0;
        $this->hideAllInfo->call();
        $this->updateFiles->callAsync();
    }

    /**
     * @event BDir.action 
     */
    function doBDirAction(UXEvent $e = null)
    {    
        global $dir, $page;
        $dir = $this->EDir->text;
        $page = 0;
        $this->hideAllInfo->call();
        $this->updateFiles->callAsync();
    }

    /**
     * @event IFile1.mouseDown-Left 
     */
    function doIFile1MouseDownLeft(UXMouseEvent $e = null)
    {    
        $this->hideAll->call();
        global $isClick, $select;
        $isClick = true;
        $select = 1;
        $this->hideAll->call();
        $this->RFile1->show();
        Logger::debug('Click');
    }

    /**
     * @event IFile1.mouseUp-Left 
     */
    function doIFile1MouseUpLeft(UXMouseEvent $e = null)
    {    
        global $isClick;
        $isClick = false;
    }

    /**
     * @event IFile2.mouseDown-Left 
     */
    function doIFile2MouseDownLeft(UXMouseEvent $e = null)
    {    
        $this->hideAll->call();
        global $isClick, $select;
        $isClick = true;
        $select = 2;
        $this->hideAll->call();
        $this->RFile2->show();
        //$this->RFile1->fillColor = UXColor::rgb(0, 0, 255);
        Logger::debug('Click');
    }

    /**
     * @event IFile2.mouseUp-Left 
     */
    function doIFile2MouseUpLeft(UXMouseEvent $e = null)
    {    
        global $isClick;
        $isClick = false;
    }

    /**
     * @event IFile3.mouseDown-Left 
     */
    function doIFile3MouseDownLeft(UXMouseEvent $e = null)
    {    
        $this->hideAll->call();
        global $isClick, $select;
        $isClick = true;
        $select = 3;
        $this->hideAll->call();
        $this->RFile3->show();
        //$this->RFile1->fillColor = UXColor::rgb(0, 0, 255);
        Logger::debug('Click');
    }

    /**
     * @event IFile3.mouseUp-Left 
     */
    function doIFile3MouseUpLeft(UXMouseEvent $e = null)
    {    
        global $isClick;
        $isClick = false;
    }

    /**
     * @event IFile4.mouseDown-Left 
     */
    function doIFile4MouseDownLeft(UXMouseEvent $e = null)
    {    
        $this->hideAll->call();
        global $isClick, $select;
        $isClick = true;
        $select = 4;
        $this->hideAll->call();
        $this->RFile4->show();
        //$this->RFile1->fillColor = UXColor::rgb(0, 0, 255);
        Logger::debug('Click');
    }

    /**
     * @event IFile4.mouseUp-Left 
     */
    function doIFile4MouseUpLeft(UXMouseEvent $e = null)
    {    
        global $isClick;
        $isClick = false;
    }

    /**
     * @event IFile5.mouseDown-Left 
     */
    function doIFile5MouseDownLeft(UXMouseEvent $e = null)
    {    
        $this->hideAll->call();
        global $isClick, $select;
        $isClick = true;
        $select = 5;
        $this->hideAll->call();
        $this->RFile5->show();
        //$this->RFile1->fillColor = UXColor::rgb(0, 0, 255);
        Logger::debug('Click');
    }

    /**
     * @event IFile5.mouseUp-Left 
     */
    function doIFile5MouseUpLeft(UXMouseEvent $e = null)
    {    
        global $isClick;
        $isClick = false;
    }

    /**
     * @event LFile1.mouseDown-Left 
     */
    function doLFile1MouseDownLeft(UXMouseEvent $e = null)
    {    
        $this->hideAll->call();
        global $isClick, $select;
        $isClick = true;
        $select = 1;
        $this->hideAll->call();
        $this->RFile1->show();
        //$this->RFile1->fillColor = UXColor::rgb(0, 0, 255);
        Logger::debug('Click');
    }

    /**
     * @event LFile1.mouseUp-Left 
     */
    function doLFile1MouseUpLeft(UXMouseEvent $e = null)
    {    
        global $isClick;
        $isClick = false;
    }

    /**
     * @event LFile2.mouseDown-Left 
     */
    function doLFile2MouseDownLeft(UXMouseEvent $e = null)
    {    
        $this->hideAll->call();
        global $isClick, $select;
        $isClick = true;
        $select = 2;
        $this->hideAll->call();
        $this->RFile2->show();
        //$this->RFile1->fillColor = UXColor::rgb(0, 0, 255);
        Logger::debug('Click');
    }

    /**
     * @event LFile2.mouseUp-Left 
     */
    function doLFile2MouseUpLeft(UXMouseEvent $e = null)
    {    
        global $isClick;
        $isClick = false;
    }

    /**
     * @event LFile3.mouseDown-Left 
     */
    function doLFile3MouseDownLeft(UXMouseEvent $e = null)
    {    
        $this->hideAll->call();
        global $isClick, $select;
        $isClick = true;
        $select = 3;
        $this->hideAll->call();
        $this->RFile3->show();
        //$this->RFile1->fillColor = UXColor::rgb(0, 0, 255);
        Logger::debug('Click');
    }

    /**
     * @event LFile3.mouseUp-Left 
     */
    function doLFile3MouseUpLeft(UXMouseEvent $e = null)
    {    
        global $isClick;
        $isClick = false;
    }

    /**
     * @event LFile4.mouseDown-Left 
     */
    function doLFile4MouseDownLeft(UXMouseEvent $e = null)
    {    
        $this->hideAll->call();
        global $isClick, $select;
        $isClick = true;
        $select = 4;
        $this->hideAll->call();
        $this->RFile4->show();
        //$this->RFile1->fillColor = UXColor::rgb(0, 0, 255);
        Logger::debug('Click');
    }

    /**
     * @event LFile4.mouseUp-Left 
     */
    function doLFile4MouseUpLeft(UXMouseEvent $e = null)
    {    
        global $isClick;
        $isClick = false;
    }

    /**
     * @event LFile5.mouseDown-Left 
     */
    function doLFile5MouseDownLeft(UXMouseEvent $e = null)
    {    
        $this->hideAll->call();
        global $isClick, $select;
        $isClick = true;
        $select = 5;
        $this->hideAll->call();
        $this->RFile5->show();
        //$this->RFile1->fillColor = UXColor::rgb(0, 0, 255);
        Logger::debug('Click');
    }

    /**
     * @event LFile5.mouseUp-Left 
     */
    function doLFile5MouseUpLeft(UXMouseEvent $e = null)
    {    
        global $isClick;
        $isClick = false;
    }

    /**
     * @event mouseDown-Left 
     */
    function doMouseDownLeft(UXMouseEvent $e = null)
    {    
        $this->hideAll->call();
    }

    /**
     * @event PPage.action 
     */
    function doPPageAction(UXEvent $e = null)
    {    
        global $page;
        $page = $this->PPage->selectedPage;
        $this->hideAllInfo->call();
        $this->updateFiles->callAsync();
    }

    /**
     * @event IFile1.click-2x 
     */
    function doIFile1Click2x(UXMouseEvent $e = null)
    {    
        global $dir, $page, $files, $number1, $select;
        $tmp = $number1 + ($select - 1) - 1;
        Logger::debug('Файл: ' . $tmp);
        $tmp2 = $files[$tmp];
        $tmp2 = str::split($tmp2, ',');
        var_dump($tmp2);
        if ($tmp2[1] == 'folder'){
            $dir = $dir . '/' . $tmp2[2];
            $page = 0;
            $this->EDir->text = $dir;
            $this->hideAllInfo->call();
            $this->updateFiles->callAsync();
        }else if ($tmp2[1] == 'file'){
            $this->startEditor->callAsync();
        }else if ($tmp2[1] == 'chat'){
            $this->startChat->callAsync();
        }
    }


    /**
     * @event keyDown-F5 
     */
    function doKeyDownF5(UXKeyEvent $e = null)
    {    
        $this->hideAllInfo->call();
        $this->updateFiles->callAsync();
    }

    /**
     * @event BCreate.action 
     */
    function doBCreateAction(UXEvent $e = null)
    {    
        app()->showForm('Create');
    }

    /**
     * @event IFile2.click-2x 
     */
    function doIFile2Click2x(UXMouseEvent $e = null)
    {    
        global $dir, $page, $files, $number1, $select;
        $tmp = $number1 + ($select - 1) - 1;
        Logger::debug('Файл: ' . $tmp);
        $tmp2 = $files[$tmp];
        $tmp2 = str::split($tmp2, ',');
        var_dump($tmp2);
        if ($tmp2[1] == 'folder'){
            $dir = $dir . '/' . $tmp2[2];
            $page = 0;
            $this->EDir->text = $dir;
            $this->hideAllInfo->call();
            $this->updateFiles->callAsync();
        }else if ($tmp2[1] == 'file'){
            $this->startEditor->callAsync();
        }else if ($tmp2[1] == 'chat'){
            $this->startChat->callAsync();
        }
    }

    /**
     * @event IFile3.click-2x 
     */
    function doIFile3Click2x(UXMouseEvent $e = null)
    {    
        global $dir, $page, $files, $number1, $select;
        $tmp = $number1 + ($select - 1) - 1;
        Logger::debug('Файл: ' . $tmp);
        $tmp2 = $files[$tmp];
        $tmp2 = str::split($tmp2, ',');
        var_dump($tmp2);
        if ($tmp2[1] == 'folder'){
            $dir = $dir . '/' . $tmp2[2];
            $page = 0;
            $this->EDir->text = $dir;
            $this->hideAllInfo->call();
            $this->updateFiles->callAsync();
        }else if ($tmp2[1] == 'file'){
            $this->startEditor->callAsync();
        }else if ($tmp2[1] == 'chat'){
            $this->startChat->callAsync();
        }
    }

    /**
     * @event IFile4.click-2x 
     */
    function doIFile4Click2x(UXMouseEvent $e = null)
    {    
        global $dir, $page, $files, $number1, $select;
        $tmp = $number1 + ($select - 1) - 1;
        Logger::debug('Файл: ' . $tmp);
        $tmp2 = $files[$tmp];
        $tmp2 = str::split($tmp2, ',');
        var_dump($tmp2);
        if ($tmp2[1] == 'folder'){
            $dir = $dir . '/' . $tmp2[2];
            $page = 0;
            $this->EDir->text = $dir;
            $this->hideAllInfo->call();
            $this->updateFiles->callAsync();
        }else if ($tmp2[1] == 'file'){
            $this->startEditor->callAsync();
        }else if ($tmp2[1] == 'chat'){
            $this->startChat->callAsync();
        }
    }

    /**
     * @event IFile5.click-2x 
     */
    function doIFile5Click2x(UXMouseEvent $e = null)
    {    
        global $dir, $page, $files, $number1, $select;
        $tmp = $number1 + ($select - 1) - 1;
        Logger::debug('Файл: ' . $tmp);
        $tmp2 = $files[$tmp];
        $tmp2 = str::split($tmp2, ',');
        var_dump($tmp2);
        if ($tmp2[1] == 'folder'){
            $dir = $dir . '/' . $tmp2[2];
            $page = 0;
            $this->EDir->text = $dir;
            $this->hideAllInfo->call();
            $this->updateFiles->callAsync();
        }else if ($tmp2[1] == 'file'){
            $this->startEditor->callAsync();
        }else if ($tmp2[1] == 'chat'){
            $this->startChat->callAsync();
        }
    }

    /**
     * @event LFile1.click-2x 
     */
    function doLFile1Click2x(UXMouseEvent $e = null)
    {    
        global $dir, $page, $files, $number1, $select;
        $tmp = $number1 + ($select - 1) - 1;
        Logger::debug('Файл: ' . $tmp);
        $tmp2 = $files[$tmp];
        $tmp2 = str::split($tmp2, ',');
        var_dump($tmp2);
        if ($tmp2[1] == 'folder'){
            $dir = $dir . '/' . $tmp2[2];
            $page = 0;
            $this->EDir->text = $dir;
            $this->hideAllInfo->call();
            $this->updateFiles->callAsync();
        }else if ($tmp2[1] == 'file'){
            $this->startEditor->callAsync();
        }else if ($tmp2[1] == 'chat'){
            $this->startChat->callAsync();
        }
    }

    /**
     * @event LFile2.click-2x 
     */
    function doLFile2Click2x(UXMouseEvent $e = null)
    {    
        global $dir, $page, $files, $number1, $select;
        $tmp = $number1 + ($select - 1) - 1;
        Logger::debug('Файл: ' . $tmp);
        $tmp2 = $files[$tmp];
        $tmp2 = str::split($tmp2, ',');
        var_dump($tmp2);
        if ($tmp2[1] == 'folder'){
            $dir = $dir . '/' . $tmp2[2];
            $page = 0;
            $this->EDir->text = $dir;
            $this->hideAllInfo->call();
            $this->updateFiles->callAsync();
        }else if ($tmp2[1] == 'file'){
            $this->startEditor->callAsync();
        }else if ($tmp2[1] == 'chat'){
            $this->startChat->callAsync();
        }
    }

    /**
     * @event LFile3.click-2x 
     */
    function doLFile3Click2x(UXMouseEvent $e = null)
    {    
        global $dir, $page, $files, $number1, $select;
        $tmp = $number1 + ($select - 1) - 1;
        Logger::debug('Файл: ' . $tmp);
        $tmp2 = $files[$tmp];
        $tmp2 = str::split($tmp2, ',');
        var_dump($tmp2);
        if ($tmp2[1] == 'folder'){
            $dir = $dir . '/' . $tmp2[2];
            $page = 0;
            $this->EDir->text = $dir;
            $this->hideAllInfo->call();
            $this->updateFiles->callAsync();
        }else if ($tmp2[1] == 'file'){
            $this->startEditor->callAsync();
        }else if ($tmp2[1] == 'chat'){
            $this->startChat->callAsync();
        }
    }

    /**
     * @event LFile4.click-2x 
     */
    function doLFile4Click2x(UXMouseEvent $e = null)
    {    
        global $dir, $page, $files, $number1, $select;
        $tmp = $number1 + ($select - 1) - 1;
        Logger::debug('Файл: ' . $tmp);
        $tmp2 = $files[$tmp];
        $tmp2 = str::split($tmp2, ',');
        var_dump($tmp2);
        if ($tmp2[1] == 'folder'){
            $dir = $dir . '/' . $tmp2[2];
            $page = 0;
            $this->EDir->text = $dir;
            $this->hideAllInfo->call();
            $this->updateFiles->callAsync();
        }else if ($tmp2[1] == 'file'){
            $this->startEditor->callAsync();
        }else if ($tmp2[1] == 'chat'){
            $this->startChat->callAsync();
        }
    }

    /**
     * @event LFile5.click-2x 
     */
    function doLFile5Click2x(UXMouseEvent $e = null)
    {    
        global $dir, $page, $files, $number1, $select;
        $tmp = $number1 + ($select - 1) - 1;
        Logger::debug('Файл: ' . $tmp);
        $tmp2 = $files[$tmp];
        $tmp2 = str::split($tmp2, ',');
        var_dump($tmp2);
        if ($tmp2[1] == 'folder'){
            $dir = $dir . '/' . $tmp2[2];
            $page = 0;
            $this->EDir->text = $dir;
            $this->hideAllInfo->call();
            $this->updateFiles->callAsync();
        }else if ($tmp2[1] == 'file'){
            $this->startEditor->callAsync();
        }else if ($tmp2[1] == 'chat'){
            $this->startChat->callAsync();
        }
    }

    /**
     * @event BUp.action 
     */
    function doBUpAction(UXEvent $e = null)
    {    
        global $dir, $page;
        $tmp = str::split($dir, '/');
        $newDir = '';
        for ($i = 0; $i < count($tmp); $i++){
            if ($i + 1 != count($tmp)){
                $newDir = $newDir . $tmp[$i] . '/';
            }
        }
        $newDir = substr($newDir, 0, -1);
        Logger::debug('Новый путь: ' . $newDir);
        $dir = $newDir;
        $this->EDir->text = $dir;
        $page = 0;
        $this->hideAllInfo->call();
        $this->updateFiles->callAsync();
    }



}
