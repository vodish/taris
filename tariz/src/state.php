<?php
class state
{

    
    # главная страница
    #
    static function main()
    {
        if ( url::$path != '/' )    return;

        # компоненты ui
        #
        load::setUi('../ui/default.ui.php');
        load::setUi('../ui/main/main.ui.php');
        load::$title    =   'Состояние + Компоненты';
        

        # подключиться к бд
        #
        db::init();

        # пользователи
        # операции авторизации
        #
        user::actionCodeSend();
        user::actionCodeCheck();
        
        
        # список профилей
        #
        user::dbInit();
        
    }


    static function pack()
    {
        if ( !isset(url::$level[0]) || !is_numeric(url::$level[0]) )    return;

        # компоненты ui
        #
        load::setUi('../ui/default.ui.php');
        load::setUi('../ui/pack/pack.ui.php');


        # подключиться к базе
        # пачки пользователя
        # пользователи
        # права
        #
        db::init();
        pack::dbInit( (int)url::$level[0] );
        user::dbInit();
        access::dbInit();
        #
        project::init();
        project::setTitle();


        # не найден пользователь
        #
        // if ( ! pack::$user )    url::redir("/");
        

        # варианты
        #
        if ( !isset(url::$level[1]) )
        {
            line::dbInit();
            load::setUi('../ui/pack/view.ui.php');
        }              
        elseif ( url::$level[1]=='line' )
        {
            # сохранить содержание файла
            line::dbInit();
            line::actionSave();
            load::setUi('../ui/pack/line.ui.php');
        }
        elseif  ( url::$level[1]=='tree' )
        {
            # сохранить дерево проекта
            project::actionSave();
            load::setUi('../ui/pack/tree.ui.php');
        }
        elseif ( url::$level[1]=='access' )
        {
            # сохрание права
            access::actionSave();
            access::actionCreateLink();
            
            load::setUi('../ui/pack/access.ui.php');
        }

        

    }

        
}