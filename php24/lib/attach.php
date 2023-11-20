<?php
class attach
{

    # загрузить файл из буфера обмена
    #
    static function clipboard()
    {
        if ( ! user::$id )      return;
        if ( empty($_FILES) )   return;
        if ( ! isset(req::$param['attach']) )   return;
        if ( ! isset($_FILES['clipboard']) )    return;
        

        chdir($_SERVER['DOCUMENT_ROOT']);
        #
        $tmp_name   =   $_FILES['clipboard']['tmp_name'];
        $fname      =   md5(req::$param['rtoken']. $tmp_name);
        $fdir       =   'attach/'. implode('/', str_split($fname, 3));
        #
        if ( !file_exists($fdir) )   mkdir($fdir, 0777, true);
        #
        #
        move_uploaded_file($tmp_name, "$fdir/$fname");


        # вернуть путь к файлу
        #
        res::$ret['attach']   =   $_SERVER['REQUEST_SCHEME']. "://". HTTP_HOST. "/$fname";
    }
}