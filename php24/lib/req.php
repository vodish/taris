<?php
class req
{
    static $param   =   array();
    static $wait    =   array();

    
    # запросы через url
    #
    static function fromUrl()
    {
        if ( $_POST )               return;

        # тип ответа
        #
        res::$render    =   'html';

        self::fromMain();
        self::fromPack();
        
        
    }


    
        # запрос главной страницы
        #
        private static function fromMain()
        {
            if ( url::$path != '/' )                return;

            req::$wait      =   ['userList'];
        }
        #
        # запрос страницы пака
        #
        private static function fromPack()
        {
            if ( ! isset(url::$level[0]) )          return;
            if ( ! is_numeric(url::$level[0]) )     return;
            if ( url::$level[0] < 1 )               return;
            

            # операция
            #
            req::$param['pack'] =   url::$level[0];
            

            # ответ
            #
            $wait       =   self::packSokr(['pack*']);
            req::$wait  =   self::packCheckWait($wait);

            

            if      ( !isset(url::$level[1]) )      req::$wait[]  =   'lineHtml';
            elseif  ( url::$level[1] == 'line' )    req::$wait[]  =   'lineText';
            elseif  ( url::$level[1] == 'tree' )    req::$wait[]  =   'treeText';
            elseif  ( url::$level[1] == 'access' )  req::$wait    =   array_merge(req::$wait, ['accessArray', 'accessText']);
            else                                    req::$wait[]  =   '404';
            
        }







    
    # развернуть сокращение для перменной pack*
    #
    private static function packSokr($list)
    {
        if ( ! in_array('pack*', $list) )   return $list;

        unset($list[ array_search('pack*', $list) ]);
        
        $list = array_merge($list, [
            'packStart',
            'packBc',
            'packTree',
            'packHeap',
            'packMenu',
            'packTitle',
            'packProject',
        ]);

        return $list;
    }




    # запросы к api
    #
    static function fromApi()
    {
        if ( empty($_POST['rtoken']) )      return;
        if ( !isset(url::$level[0]) )       return;
        if ( url::$level[0] != 'api' )      return;

        # тип ответа
        #
        res::$render    =   "json";


        # главная страница
        #
        self::mainInit();
        self::userGetCode();
        self::userCheckCode();
        #
        #
        self::packInit();

    }        



        # идентификация запросов
        #
        private static function mainInit()
        {
            if ( ! isset($_POST['wait']) )                  return;
            if ( ! in_array('userList', $_POST['wait']) )   return;

            self::$wait   =   ['userList'];

            
        }

        private static function userGetCode()
        {
            if ( !isset($_POST['userGetCode']) )            return;
            if ( empty($_POST['email']) )                   return;

            self::$param[]          =   'userGetCode';
            self::$param['email']   =   $_POST['email'];
        }

        private static function userCheckCode()
        {
            if ( !isset($_POST['userGetCode']) )            return;
            if ( empty($_POST['email']) )                   return;

            self::$param[]          =   'userGetCode';
            self::$param['email']   =   $_POST['email'];
        }


        private static function packInit()
        {
            if ( ! isset($_POST['pack']) )          return;
            if ( ! is_numeric($_POST['pack']) )     return;
            if ( $_POST['pack'] < 1 )               return;
            if ( empty($_POST['wait']) )            return;
            

            
            # параметры
            #
            req::$param['pack'] =   $_POST['pack'];


            # ожидания
            #
            $_POST['wait']  =   self::packSokr( $_POST['wait'] );
            req::$wait      =   self::packCheckWait( $_POST['wait'] );

        }



            private static function packCheckWait($wait)
            {
                $add    =   array();
                $vars   =   array(
                    'packStart',
                    'packBc',
                    'packTree',
                    'packHeap',
                    'packMenu',
                    'packTitle',
                    'packProject',
                    'lineHtml',
                    'lineText',
                    'treeText',
                    'accessHtml',
                    'accessText',
                );
                
                foreach( $vars as $v )
                {
                    if ( ! in_array($v, $wait) )        continue;
                    if ( in_array($v, req::$wait) )     continue;

                    $add[] = $v;
                }
                

                return  array_merge(req::$wait, $add);
            }

    

}