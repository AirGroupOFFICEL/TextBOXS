<?php
namespace app\modules;

use bundle\updater\UpdateMe;
use std, gui, framework, app;
use php\io\Stream;
use php\io\IOException;


class MainModule extends AbstractModule
{

    /**
     * @event startApp.action 
     */
    function doStartAppAction(ScriptEvent $e = null)
    {
    
        global $url, $ver;
        $verCore = file_get_contents('system/settings/verCore.php');
        $ver = file_get_contents('system/settings/verProgram.php');
        $typeConnect = 'http://';
        $urlScripts = 'airgroup.temp.swtest.ru/program/scripts/';
        $urlNormal = 'airgroup.temp.swtest.ru/program/';
        $url = $typeConnect . $urlScripts;
        Logger::info('Ядро программы версии: ' . $verCore);
        Logger::info('Версия программы: ' . $ver);
        Logger::info('Работа программы по протоколу URL');
        Logger::info('Тип протокола: ' . str::split($typeConnect, ':')[0]);
        Logger::info('URL для скриптов: ' . $urlScripts);
        Logger::info('URL: ' . $urlNormal);
        Logger::info('Оснавная папка для программы: system');
    
        $this->ILogo->image = new UXImage("system/community.png");
        $this->IExit->image = new UXImage("system/exit.png");
        $this->form('Login')->ILogo->image = new UXImage("system/icon.png");
        $this->form('Register')->ILogo->image = new UXImage("system/icon.png");
        $this->form('ResetPassword')->ILogo->image = new UXImage("system/icon.png");
        $this->form('ResetPassword')->BComplect->enabled = false;
        $this->form('ResetPassword')->EPassword->enabled = false;
        
        $this->startURL->callAsync();
    }

    /**
     * @event startURL.action 
     */
    function doStartURLAction(ScriptEvent $e = null)
    {    
        Logger::info('Начало работы URL движка');
        global $url;
        $stream = "";
        try{
            $stream = Stream::getContents($url . 'check.php');
        }catch(IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER');
            uiLaterAndWait(function (){
                global $er;
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
            return;
        }
        if ($stream != 'ok'){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SCRIPT_ON_SERVER');
            uiLaterAndWait(function (){
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SCRIPT_ON_SERVER', 'ERROR');
            });
            return;
        }
        
        $takeCheckOnline = file_get_contents('system/settings/takeCheck.php');
        if ($takeCheckOnline == 'off'){
            try{
                $stream = Stream::getContents($url . 'isonline.php');
            }catch(IOException $ex){
                Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER');
                uiLaterAndWait(function (){
                    UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
                });
                return;
            }
            if ($stream == 'work'){
                Logger::error('Сервер на тех. работах! Работа программы не возможна!');
                uiLaterAndWait(function (){
                    UXDialog::showAndWait('Сервер на тех. работах!', 'ERROR');
                });
                return;
            }else if ($stream == 'close'){
                Logger::error('Сервер закрыт! Работа программы не возможна!');
                uiLaterAndWait(function (){
                    UXDialog::showAndWait('Сервер закрыт!' . "\n" . 'Возможно скоро выйдет новая версия! Но это не точно!(', 'ERROR');
                });
                return;
            }else{
                Logger::info('Сервер жив!');
            }
        }else{
            Logger::warn('Пропущен проверки соединения с сервером! Это может повлиять на работу программы!');
        }
    }

    /**
     * @event register.action 
     */
    function doRegisterAction(ScriptEvent $e = null)
    {    
        global $login, $password, $url;
        
        uiLaterAndWait(function (){
            $this->showPreloader('Регистрация аккаунта');
        });
        
        $key = '';
        $chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'M');
        for ($i = 0; $i < 4; $i++){
            for ($j = 0; $j < 6; $j++){
                $key = $key . $chars[rand(0, 15)];
            }
            if ($i <= 2) $key = $key . '-';
        }
        
        Logger::info('Ключ: ' . $key);
        Logger::info('Шифр: ' . urlencode($key));
        
        try{
            $stream = Stream::getContents($url . 'register.php?login=' . urlencode($login) . '&password=' . urlencode($password) . '&key=' . urlencode($key));
        }catch (IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
        }
        
        Logger::info('Ответ: ' . $stream);
        
        if ($stream == 'ok'){
            Logger::info('Регистрация завершина!');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Регистрация завершина!', 'INFORMATION');
                if (file_get_contents('system/settings/autoToLoginForm.php') == 'true'){
                    $this->loadForm('login');
                }
            });
        } else if ($stream == 'login yes'){
            Logger::error('Произошла ошибка: ERROR_USER_YES_ON_SERVER');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Пользователь уже существует!' . "\n" . 'Код ошибки: ERROR_USER_YES_ON_SERVER', 'ERROR');
            });
        }else{
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SCRIPT_ON_SERVER');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка при регистрации!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SCRIPT_ON_SERVER', 'ERROR');
            });
        }
    }

    /**
     * @event loadImage.action 
     */
    function doLoadImageAction(ScriptEvent $e = null)
    {    
        $this->form('Login')->ILogo->image = new UXImage("system/icon.png");
        $this->form('Register')->ILogo->image = new UXImage("system/icon.png");
        $this->form('ResetPassword')->ILogo->image = new UXImage("system/icon.png");
    }

    /**
     * @event login.action 
     */
    function doLoginAction(ScriptEvent $e = null)
    {    
        global $login, $password, $url;
        
        uiLaterAndWait(function (){
            $this->showPreloader('Вход в аккаунт');
            if ($this->CSave->selected){
                mkdir('system/save');
                file_put_contents('system/save/login.php', base64_encode($this->ELogin->text));
                file_put_contents('system/save/password.php', base64_encode($this->EPassword->text));
            }
        });
        
        try{
            $stream = Stream::getContents($url . 'login.php?login=' . urlencode($login) . '&password=' . urlencode($password));    
        } catch (IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
        }
        
        if ($stream == 'ok'){
            Logger::info('Пользователь авторизирован!');
            uiLaterAndWait(function (){
                $this->loadForm('FilesManager');
            });
        }else if ($stream == 'no user'){
            Logger::error('Произошла ошибка: ERROR_NO_USER_ON_SERVER');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Пользователя не существует!' . "\n" . 'Код ошибки: ERROR_NO_USER_ON_SERVER', 'ERROR');
            });
        }else if ($stream == 'data'){
            Logger::error('Произошла ошибка: ERROR_IN_DATA_SEND_ON_SERVER_FOR_LOGIN');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Не верный логин или пароль!' . "\n" . 'Код ошибки: ERROR_IN_DATA_SEND_ON_SERVER_FOR_LOGIN', 'ERROR');
            });
        }else{
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SCRIPT_ON_SERVER');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SCRIPT_ON_SERVER', 'ERROR');
            });
        }
    }

    /**
     * @event fillData.action 
     */
    function doFillDataAction(ScriptEvent $e = null)
    {    
        global $login, $url, $key;
        
        try{
            $key = Stream::getContents($url . 'getkey.php?login=' . urlencode($login));    
        } catch (IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            uiLaterAndWait(function (){
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
        }
        
        uiLaterAndWait(function (){
            global $login, $key;
            $this->LKey2->text = $key;
            $this->LName2->text = $login;
        });
    }

    /**
     * @event checkData.action 
     */
    function doCheckDataAction(ScriptEvent $e = null)
    {    
        global $url, $login, $key;
        
        uiLaterAndWait(function (){
            $this->showPreloader('Проверка данных');
        });
        
        try{
            $stream = Stream::getContents($url . 'checkDataForResetPassword.php?login=' . urlencode($login) . '&key=' . urlencode($key));
        } catch (IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
        }
        
        if ($stream == 'ok'){
            uiLaterAndWait(function (){
                $this->hidePreloader();
                $this->EPassword->enabled = true;
                $this->BComplect->enabled = true;
                $this->BCheck->enabled = false;
                $this->ELogin->enabled = false;
                $this->EKey->enabled = false;
            });
        }else if ($stream == 'data'){
            Logger::error('Произошла ошибка: ERROR_DATA_SEND_ON_SERVER_FOR_CHECK_DATA');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Не верный логин или ключ!' . "\n" . 'Код ошибки: ERROR_DATA_SEND_ON_SERVER_FOR_CHECK_DATA', 'ERROR');
            });
        }else{
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SCRIPT_ON_SERVER');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SCRIPT_ON_SERVER', 'ERROR');
            });
        }
    }

    /**
     * @event resetPass.action 
     */
    function doResetPassAction(ScriptEvent $e = null)
    {    
        global $url, $login, $password;
        
        uiLaterAndWait(function (){
            $this->showPreloader('Сбор пароля');
        });
        
        try{
            $stream = Stream::getContents($url . 'resetPass.php?login=' . urlencode($login) . '&password=' . urlencode($password));
        } catch(IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
        }
        
        if ($stream == 'ok'){
            Logger::info('Пароль сменён!');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Пароль был сменён!' . "\n" . 'Используйте его для входа');
                $this->loadForm('Login');
            });
        }else{
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SCRIPT_ON_SERVER');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SCRIPT_ON_SERVER', 'ERROR');
            });
        }
    }

    /**
     * @event updateFiles.action 
     */
    function doUpdateFilesAction(ScriptEvent $e = null)
    {    
        global $login, $url, $dir, $maxFiles, $page, $number1, $number2, $files;
        
        uiLaterAndWait(function (){
            $this->showPreloader('Обнавление файлов');
        });
        
        if (str::contains($dir, 'root') == false){
            uiLaterAndWait(function (){
                $this->form('FilesManager')->BCreate->enabled = false;
            });
        }else{
            uiLaterAndWait(function (){
                $this->form('FilesManager')->BCreate->enabled = true;
            });
        }
        
        Logger::debug('Page old: ' . $page);
        
        try{
            $stream = Stream::getContents($url . 'maxfiles.php?login=' . urlencode($login) . '&dir=' . urlencode($dir));
        } catch (IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
        }
        
        Logger::debug('Старый: ' . $stream);
        Logger::debug('Старый тип: ' . gettype($stream));
        $maxFiles = intval(str::trim($stream));
        Logger::debug('Новый тип: ' . gettype($maxFiles));
        Logger::debug('Новый: ' . $maxFiles);
        
        uiLaterAndWait(function (){
            global $maxFiles, $page;
            $this->form('FilesManager')->PPage->total = $maxFiles;
            $this->form('FilesManager')->PPage->selectedPage = $page;
        });
        
        if ($maxFiles == 0){
            uiLaterAndWait(function (){
                $this->form('FilesManager')->LNonFile->visible = true;
            });
        }else{
            Logger::debug('Page old: ' . $page);
            Logger::debug('Old: ' . $maxFiles);
            Logger::debug('Type: ' . gettype($maxFiles));
            $maxFiles = intval(str::trim($maxFiles));
            Logger::debug('Int: ' . $maxFiles);
            $tmp = $maxFiles / 5;
            $maxPages = intval($tmp);
            if (is_float($tmp)) $maxPages++;
            Logger::debug('Файлов: ' . $maxFiles);
            if ($page == -1) $page = 0;
            Logger::debug('Page old: ' . $page);
            Logger::debug('Page: ' . ($page + 1));
            if (($page + 1) == 1){
                Logger::debug('Number 1.1: ' . $number1);
                $number1 = 1;
            }else{
                Logger::debug('Number 1.2: ' . $number1);
                $number1 = $page * 5 + 1;
            }
            if ($maxFiles < 5) {
                $number2 = $maxFiles;
                Logger::debug('1');
            }else if ($page == $maxPages) {
                $number2 = $maxFiles;
                Logger::debug('2');
            }else{
                $number2 = $number1 + 4;
            }
            Logger::debug('От: ' . $number1);
            Logger::debug('До: ' . $number2);
        }
        
        try{
            $stream = Stream::getContents($url . 'files.php?login=' . urlencode($login) . '&dir=' . urlencode($dir));
        } catch (IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
        }
        
        $files = $stream;
        $files = str::split($files, ';');
        var_dump($files);
        
        if ($maxFiles > 0){
            Logger::debug('Поиск элементов');
            for ($i = 0; $i < count($files); $i++){
            $tmp = str::split($files[$i], ',');
            var_dump($tmp);
            $is1 = intval(str::trim($tmp[0]));
            $is1++;
            Logger::debug($is1);
            if ($is1 >= $number1 and $is1 <= $number2){
                global $name2, $text, $name1;
                Logger::debug('Number: ' . $tmp[0]);
                Logger::debug('Name: ' . $tmp[2]);
                Logger::debug('Type: ' . $tmp[1]);
                $is2 = $is1 - $number1 + 1;
                Logger::debug('is2: ' . $is2);
                $name1 = 'IFile' . $is2;
                $name2 = 'LFile' . $is2;
                $text = $tmp[2];
                Logger::debug('Name 1: ' . $name1);
                Logger::debug('Name 2: ' . $name2);
                uiLaterAndWait(function (){
                    global $name2, $text;
                    $this->form('FilesManager')->$name2->visible = true;
                    $this->form('FilesManager')->$name2->text = $text;
                });
                if (str::trim($tmp[1]) == "file") {
                    Logger::debug('file');
                    uiLaterAndWait(function (){
                        global $name1;
                        $this->form('FilesManager')->$name1->visible = true;
                        $this->form('FilesManager')->$name1->image = new UXImage('system/icons/file.png'); 
                    });
                }else if (str::trim($tmp[1]) == "folder") {
                    uiLaterAndWait(function (){
                        global $name1;
                        $this->form('FilesManager')->$name1->visible = true;
                        $this->form('FilesManager')->$name1->image = new UXImage('system/icons/folder.png'); 
                    });
                }else if (str::trim($tmp[1]) == "chat") {
                    uiLaterAndWait(function (){
                        global $name1;
                        $this->form('FilesManager')->$name1->visible = true;
                        $this->form('FilesManager')->$name1->image = new UXImage('system/icons/chat.png'); 
                    });
                }
            }
        }
        }
        uiLaterAndWait(function (){
            $this->hidePreloader();
        });
    }

    /**
     * @event hideAll.action 
     */
    function doHideAllAction(ScriptEvent $e = null)
    {    
        global $isClick, $select;
        if ($isClick) return;
        $select = 0;
        for ($i = 1; $i < 6; $i++){
            $name1 = 'RFile' . $i;
            $this->form('FilesManager')->$name1->visible = false;
        }
    }

    /**
     * @event hideAllInfo.action 
     */
    function doHideAllInfoAction(ScriptEvent $e = null)
    {    
        $this->form('FilesManager')->LNonFile->visible = false;
        for ($i = 1; $i <= 5; $i++){
            $id1 = 'RFile' . $i;
            $id2 = 'LFile' . $i;
            $id3 = 'IFile' . $i;
            Logger::debug('ID 1:' . $id1);
            Logger::debug('ID 2:' . $id2);
            Logger::debug('ID 3:' . $id3);
            $this->form('FilesManager')->$id1->hide();
            $this->form('FilesManager')->$id2->hide();
            $this->form('FilesManager')->$id3->hide();
        }
    }

    /**
     * @event create.action 
     */
    function doCreateAction(ScriptEvent $e = null)
    {    
        global $login, $url, $name, $type, $dir;
        
        try{
            $stream = Stream::getContents($url . 'create.php?login=' . urlencode($login) . '&dir=' . urlencode($dir) . '&name=' . urlencode($name) . '&type=' . urlencode($type));
        } catch (IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            uiLaterAndWait(function (){
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
        }
        
        uiLaterAndWait(function (){
            app()->hideForm('Create');
        });
        
        $this->hideAllInfo->call();
        $this->updateFiles->callAsync();
    }

    /**
     * @event startEditor.action 
     */
    function doStartEditorAction(ScriptEvent $e = null)
    {    
        global $url, $login, $select, $number1, $dir, $files;
        
        uiLaterAndWait(function (){
            $this->showPreloader('Запуск редактора');
        });
        
        $name = str::split($files[$number1 + ($select - 1) - 1], ',')[2];
        var_dump($name);
        
        Logger::debug($url . 'files/getinfo.php?login=' . urlencode($login) . '&dir=' . urlencode($dir) . '&name=' . urlencode($name));
        
        try{
            $stream = Stream::getContents($url . 'files/getinfo.php?login=' . urlencode($login) . '&dir=' . urlencode($dir) . '&name=' . urlencode($name));
        } catch(IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
        }
        
        Logger::debug($url . 'files/gettext.php?login=' . urlencode($login) . '&dir=' . urlencode($dir) . '&name=' . urlencode($name));
        
        try{
            $stream2 = Stream::getContents($url . 'files/gettext.php?login=' . urlencode($login) . '&dir=' . urlencode($dir) . '&name=' . urlencode($name));
        } catch(IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
        }
        
        global $text, $nm;
        $text = $stream2;
        $nm = $name;
        
        uiLaterAndWait(function (){
            global $text, $nm;
            $this->form('Editor')->MText->text = $text;
            $this->form('Editor')->LName->text = $nm;
            $this->loadForm('Editor');
        });
        
        $dataStyle = str::split($stream, ';');
        var_dump($dataStyle);
        if ($dataStyle[0] != '' and $dataStyle[1] != '' and $dataStyle[2] != ''){
            global $font;
            $font = $dataStyle;
            uiLaterAndWait(function (){
                global $font;
                if ($font[1] == 'N'){
                    $this->form('Editor')->MText->font = UXFont::of($font[0], intval(str::trim($font[2])), 'THIN', false);
                }else if ($font[1] == 'B'){
                    $this->form('Editor')->MText->font = UXFont::of($font[0], intval(str::trim($font[2])), 'BOLD', false);
                }else if ($font[1] == 'I'){
                    $this->form('Editor')->MText->font = UXFont::of($font[0], intval(str::trim($font[2])), 'THIN', true);
                }else if ($font[1] == 'BI'){
                    $this->form('Editor')->MText->font = UXFont::of($font[0], intval(str::trim($font[2])), 'BOLD', true);
                }
            });
        }
    }

    /**
     * @event saveFile.action 
     */
    function doSaveFileAction(ScriptEvent $e = null)
    {    
        uiLaterAndWait(function (){
           $this->showPreloader('Сохрание файла'); 
        });
    
        global $url, $login, $nm, $font, $size, $style, $dir, $text;
        
        try{
            $stream = Stream::getContents($url . 'files/saveinfo.php?login=' . urlencode($login) . '&dir=' . urlencode($dir) . '&name=' . urlencode($nm) . '&font=' . urlencode($font) . '&size=' . urlencode($size) . '&style=' . urlencode($style));
        } catch (IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
        }
        
        $strings = str_split($text, 15);
        for ($i = 0; $i < count($strings); $i++){
            uiLaterAndWait(function (){
                $this->BSave->text = $i + 1 . '/' . count($strings);
            });
            Logger::debug(urlencode($strings[$i]));
            if ($i == 0) $start = true;
            else $start = false;
            try{
                if (!$start) $stream = Stream::getContents($url . 'files/save.php?login=' . urlencode($login) . '&dir=' . urlencode($dir) . '&name=' . urlencode($nm) . '&text=' . urlencode($strings[$i]) . '&action=ADD');
                else $stream = Stream::getContents($url . 'files/save.php?login=' . urlencode($login) . '&dir=' . urlencode($dir) . '&name=' . urlencode($nm) . '&text=' . urlencode($strings[$i]) . '&action=CLEAR');
            }catch(IOException $ex){
                Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
                uiLaterAndWait(function (){
                    $this->hidePreloader();
                    $this->BSave->text = 'Сохранить';
                    UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
                });
                return;
            }
        }
        uiLaterAndWait(function (){
            $this->BSave->text = 'Сохранить';
        });
        
        uiLaterAndWait(function (){
            $this->hidePreloader();
            UXDialog::showAndWait('Файл сохранён в вашем каталоге!', 'INFORMATION');
        });
    }

    /**
     * @event startChat.action 
     */
    function doStartChatAction(ScriptEvent $e = null)
    {    
        uiLaterAndWait(function (){
           $this->showPreloader('Запуск чата'); 
        });
    
        global $url, $login, $number1, $select, $files, $dir, $textChat, $name;
        
        $tmp = $number1 + ($select - 1) - 1;
        $name = str::split($files[$tmp], ',')[2];
        
        try{
            $textChat = Stream::getContents($url . 'chats/getText.php?login=' . urlencode($login) . '&dir=' . urlencode($dir) . '&name=' . urlencode($name));
        }catch (IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
            return;
        }
        
        try{
            $users = Stream::getContents($url . 'chats/getUsers.php?login=' . urlencode($login) . '&dir=' . urlencode($dir) . '&name=' . urlencode($name));
        }catch (IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Произошла ошибка!' . "\n" . 'Код ошибки: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
            });
            return;
        }
        
        $users = str::split($users, "\n");
        $yesUser = false;
        for ($i = 0; $i < count($users); $i++){
            if ($users[$i] == $login) $yesUser = true;
        }
        if ($yesUser == false){
            $this->updateChatTimer->enabled = false;
            uiLaterAndWait(function (){
                $this->hidePreloader();
                UXDialog::showAndWait('Вас нету в этом чате', 'ERROR');
            });
            return;
        }
        
        $this->updateChatTimer->enabled = true;
        
        uiLaterAndWait(function (){
            global $textChat, $name;
            $this->form('Chat')->LName->text = $name;
            $this->form('Chat')->MText->text = $textChat;
            $this->hidePreloader();
            $this->loadForm('Chat');
        });
    }

    /**
     * @event updateChat.action 
     */
    function doUpdateChatAction(ScriptEvent $e = null)
    {    
        global $url, $login, $number1, $select, $files, $dir, $textChat, $yesUser;
        
        $tmp = $number1 + ($select - 1) - 1;
        $name = str::split($files[$tmp], ',')[2];
        
        try{
            $textChat = Stream::getContents($url . 'chats/getText.php?login=' . urlencode($login) . '&dir=' . urlencode($dir) . '&name=' . urlencode($name));
        }catch (IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
        }
        
        try{
            $users = Stream::getContents($url . 'chats/getUsers.php?login=' . urlencode($login) . '&dir=' . urlencode($dir) . '&name=' . urlencode($name));
        }catch (IOException $ex){
            Logger::error('Произошла ошибка: ERROR_IN_COMMUNICATION_WITH_SERVER', 'ERROR');
        }
        
        $users = str::split($users, "\n");
        $yesUser = false;
        for ($i = 0; $i < count($users); $i++){
            if ($users[$i] == $login) $yesUser = true;
        }
        if ($yesUser == false){
            $this->updateChatTimer->enabled = false;
            uiLaterAndWait(function (){
                $this->loadForm('FilesManager');
                //UXDialog::showAndWait('Вас нету в этом чате', 'ERROR');
            });
            return;
        }
        
        uiLaterAndWait(function (){
            global $textChat;
            if ($this->form('Chat')->MText->text != $textChat){
                $this->form('Chat')->MText->text = $textChat;
                $this->form('Chat')->MText->end();
            }
        });
    }

    /**
     * @event updateChatTimer.action
     */
    function doUpdateChatTimerAction(ScriptEvent $e = null)
    {    
        $this->updateChat->callAsync();
    }

    /**
     * @event sendMessage.action 
     */
    function doSendMessageAction(ScriptEvent $e = null)
    {    
        global $login, $message, $dir, $number1, $select, $files, $url;
        
        $name = str::split($files[$number1 + ($select - 1) - 1], ',')[1];
        
        try{
            $stream = Stream::getContents($url . 'sendMessage.php?');
        }
    }

}
