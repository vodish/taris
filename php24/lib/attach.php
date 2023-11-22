<?php
class attach
{

    # загрузить файл из буфера обмена
    #
    static function clipboard()
    {
        if ( ! user::$id )                      return;
        if ( empty($_FILES) )                   return;
        if ( ! isset(req::$param['attach']) )   return;
        if ( ! isset($_FILES['clipboard']) )    return;
        

        chdir($_SERVER['DOCUMENT_ROOT']);
        #
        # переложить в папку
        #
        $tmp_name   =   $_FILES['clipboard']['tmp_name'];
        $name       =   $_FILES['clipboard']['name'];
        $hash       =   md5(req::$param['rtoken']. $tmp_name);
        $dir        =   'attach/'. implode('/', str_split($hash, 2));
        #
        if ( !file_exists($dir) )   mkdir($dir, 0777, true);
        #
        #
        $image = new Imagick();
        $image->readImage($tmp_name);
        $image->setImageFormat('webp');
        $image->setImageCompressionQuality(80);
        $image->setOption('webp:lossless', 'true');
        #
        #
        $image->writeImage("$dir/$hash");
        $size       =   filesize("{$_SERVER['DOCUMENT_ROOT']}/$dir/$hash");

        

        # добавить запись в базу
        #
        db::query("
            INSERT INTO `attach` (
                 `hash`
                ,`name`
                ,`size`
                ,`author_email`
                ,`author`
                ,`file`
                ,`host`
            )
            VALUES (
                 " .db::v( $hash ). "
                ," .db::v( $name ). "
                ," .db::v( $size ). "
                ," .db::v( author::$email ). "
                ," .db::v( author::$id ). "
                ," .db::v( pack::$file ). "
                ," .db::v( HTTP_HOST ). "
            )
        ");



        # вернуть путь к файлу
        #
        res::$ret['clipboard']  =   $_SERVER['REQUEST_SCHEME']. "://". HTTP_HOST. "/$hash";
        
    }
}