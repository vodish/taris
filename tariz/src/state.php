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
        ui::$title =  'Состояние + Компоненты';
        #
        ui::reg('../ui/default.ui.php');
        ui::reg('../ui/main/main.ui.php');
        ui::reg('../ui/main/item.ui.php');
        
        

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
        ui::reg('../ui/default.ui.php');
        ui::reg('../ui/pack/pack.ui.php');


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
        project::actionCreate();
        project::actionCansel();


        # не найден пользователь
        #
        // if ( ! pack::$user )    url::redir("/");
        

        # варианты
        #
        if ( !isset(url::$level[1]) )
        {
            ui::reg('../ui/pack/view.ui.php');

            line::dbInit();

        }              
        elseif ( url::$level[1]=='line' )
        {
            ui::reg('../ui/pack/line.ui.php');

            line::dbInit();
            line::actionSave();
            
        }
        elseif  ( url::$level[1]=='tree' )
        {
            ui::reg('../ui/pack/tree.ui.php');

            project::actionSave();

        }
        elseif ( url::$level[1]=='access' )
        {
            ui::reg('../ui/pack/access.ui.php');

            access::actionSave();
            access::actionCreateLink();
            
        }

    }

        
}