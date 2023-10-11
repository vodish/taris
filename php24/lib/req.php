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



        # запрос главной страницы
        #
        if ( url::$path == '/' )
        {
            req::$wait  =  array('userList');
        }
        


        # запрос страницы пачки
        #
        elseif ( isset(url::$level[0])  && is_numeric(url::$level[0])  && url::$level[0] > 0 )
        {
            req::$param['pack'] =   url::$level[0];
            req::$wait  =   [
                'packBc',
                'packTree',
                'packTitle',
            ];
            
            
            if      ( !isset(url::$level[1]) )      req::$wait[]  =   'lineHtml';
            elseif  ( url::$level[1] == 'line' )    req::$wait[]  =   'lineText';
            elseif  ( url::$level[1] == 'tree' )    req::$wait[]  =   'treeText';
            elseif  ( url::$level[1] == 'access' )  req::$wait    =   array_merge(req::$wait, ['accessArray', 'accessText']);
            else    req::$wait[]  =   '404';      
        }
        
    }


    
    
    # запросы к api
    #
    static function fromApi()
    {
        if ( empty($_POST['rtoken'])    )   return;
        if ( !isset(url::$level[0])     )   return;
        if ( url::$level[0] != 'api'    )   return;

        
        # тип ответа
        #
        res::$render    =   "json";
        #
        # ожидаемые данные
        #
        if ( !empty($_POST['wait']) && is_array($_POST['wait']) )
        {
            req::$wait  =   $_POST['wait'];
        }
        #
        # распарсить параметры
        #
        if ( isset($_POST['href']) )
        {
            url::parse( $_POST['href'] );
        }
        #
        # параметры
        #
        req::$param =   $_POST;
        unset(req::$param['wait']);
        


        


        # запрос пачки
        #
        if ( isset(url::$level[0])  && is_numeric(url::$level[0])  && url::$level[0] > 0 )
        {
            req::$param['pack']  =  url::$level[0];
        }


        # добавить ожидания относительно запроса
        #
        if     ( !isset(url::$level[1])     )   req::$wait[]  = 'lineHtml';
        elseif ( url::$level[1] == 'line'   )   req::$wait[]  = 'lineText';
        elseif ( url::$level[1] == 'tree'   )   req::$wait[]  = 'treeText';
        elseif ( url::$level[1] == 'access' )   req::$wait    = array_merge(req::$wait, ['accessArray', 'accessText']);

    }        



}