<?php
class attach
{

    # загрузить файл из буфера обмена
    #
    static function clipboard()
    {
        // $file   =   "attach/f3/97/3a/cc/3d/3e/88/a0/8f/5b/62/23/b1/51/18/4f/f3973acc3d3e88a08f5b6223b151184f.png";
        // die;


        if ( ! user::$id )      return;
        if ( empty($_FILES) )   return;
        if ( ! isset(req::$param['attach']) )   return;
        if ( ! isset($_FILES['clipboard']) )    return;
        

        # переложить в папку
        #
        $tmp_name   =   $_FILES['clipboard']['tmp_name'];
        $fname      =   md5(req::$param['rtoken']. $tmp_name);
        $fdir       =   'attach/'. implode('/', str_split($fname, 2));
        #
        chdir($_SERVER['DOCUMENT_ROOT']);
        if ( !file_exists($fdir) )   mkdir($fdir, 0777, true);
        #
        #
        // move_uploaded_file($tmp_name, "$fdir/$fname");
        #
        $image = new Imagick();
        $image->readImage($tmp_name);

        $image->setImageFormat('webp');
        $image->setImageCompressionQuality(80);
        $image->setOption('webp:lossless', 'true');
        
        chdir($fdir);
        $image->writeImage($fname);

        // $img    =   imagecreatefrompng($tmp_name);
        // imagepalettetotruecolor($img);
        // imagealphablending($img, true);
        // imagesavealpha($img, true);
        // imagewebp($img, "$fdir/$fname", 80);
        // imagedestroy($img);
        


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
                 " .db::v( $fname ). "
                ," .db::v( $_FILES['clipboard']['name'] ). "
                ," .db::v( $_FILES['clipboard']['size'] ). "
                ," .db::v( author::$email ). "
                ," .db::v( author::$id ). "
                ," .db::v( pack::$file ). "
                ," .db::v( HTTP_HOST ). "
            )
        ");



        # вернуть путь к файлу
        #
        res::$ret['clipboard']  =   $_SERVER['REQUEST_SCHEME']. "://". HTTP_HOST. "/$fname";
        
    }
}