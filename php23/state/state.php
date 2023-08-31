<?php
class state
{   

    

    # Проект
    #
    static function pack()
    {
        if ( !isset(url::$level[0]) || !is_numeric(url::$level[0]) )    return;
        

        # компоненты ui
        #
        ui::html('../ui/default.ui.php');
        ui::html('../ui/pack/pack.ui.php');


        # подключиться к базе
        # пачки пользователя
        # пользователи
        # права
        #
        db::init();
        pack::init( (int)url::$level[0] );
        
        user::list();
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
            ui::html('../ui/pack/view.ui.php');

            line::dbInit();

        }              
        elseif ( url::$level[1]=='line' )
        {
            ui::html('../ui/pack/line.ui.php');

            line::dbInit();
            line::actionSave();
            
        }
        elseif  ( url::$level[1]=='tree' )
        {
            ui::html('../ui/pack/tree.ui.php');

            project::actionSave();

        }
        elseif ( url::$level[1]=='access' )
        {
            ui::html('../ui/pack/access.ui.php');

            access::actionSave();
            access::actionCreateLink();
            
        }

    }
    


}