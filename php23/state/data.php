<?php
class data
{
  static $method;
  static $user = array();


  static function returnd($arr)
  {
    echo json_encode($arr);
    die;
  }



  # проверить пользователя в бд
  #
  static function checkUserHash()
  {
    if ( !isset($_SERVER['HTTP_USER_HASH']) )
    {
      self::returnd(['error'=>'user_unknown']);
    }
    
    self::$user = array('id'=>15, 'email'=>'test@test');
    
  }

  
  # получить список вещей
  #
  static function goodList()
  {
    if ( url::$path != '/data/good/list' )  return;


    $list  =   db::select("
      SELECT
          `good`.`id`
        , `good`.`name`
        , `file`.`url`    AS    `main_file_url`
      FROM
        `good`
          LEFT JOIN `file`  ON `good`.`main_file` = `file`.`id`
      WHERE
        `good`.`user` = " .db::v(self::$user['id']). "

      ORDER BY
        `good`.`order` DESC
    ");

    self::returnd($list);
  }


  # получить список вещей
  #
  static function goodClearAll()
  {
    if ( url::$path != '/data/good/clear-all' )  return;

    db::query("
      SELECT
        `file`.*
      FROM
        `good`
          LEFT JOIN `file`  ON `good`.`id` = `file`.`good`
      WHERE
        `good`.`user` = " .db::v(self::$user['id']). "
    ");

    while( $v = db::fetch() )
    {
      $full   =   $v['root'].$v['url'];
      $prew   =   str_replace('full.', 'prew.', $v['root'].$v['url']);

      if ( is_file($full) )   unlink($full);
      if ( is_file($prew) )   unlink($prew);
    }

    db::query("
      DELETE
        `good`.*
        ,`file`.*
      FROM
        `good`
          LEFT JOIN `file`  ON `good`.`id` = `file`.`good`
      WHERE
        `good`.`user` = " .db::v(self::$user['id']). "
    ");


    self::returnd(['action'=>'goodClearAll']);
  }

















  # добавить вещи с картинками
  #
  static function goodUpload()
  {
    if ( url::$path != '/data/good/actionUpload' )  return;
    if ( empty($_FILES) )     self::returnd(['error'=>'empty file list']);;
    
    

    # найти вещь, если она задана
    #
    $getGood   =   null;
    #
    if ( !empty($_GET['good']) )
    {
      $getGood   =   db::one("SELECT *  FROM `good`  WHERE `user` = " .db::v(self::$user['id']). "  AND `id` = " .db::v($_GET['good']). " ")['id']  ??  null;
    }

    
    // print_r($_FILES);
    // die;



    # перебрать картинки
    #
    #
    foreach($_FILES['file']['type'] as $k => $type )
    {
      if ( !in_array($type, ['image/png', 'image/jpeg']) )  continue;


      # прочитать  картинку
      #
      if ($type == 'image/jpeg')  $img    =   imagecreatefromjpeg($_FILES['file']['tmp_name'][ $k ]);
      if ($type == 'image/png')   $img    =   imagecreatefrompng($_FILES['file']['tmp_name'][ $k ]);
      #
      # размер картинки
      #
      $w    = $width  = imagesx($img);
      $h    = $height = imagesy($img);
      $max  = 1200;
      #
      if ( $w > $max  ||  $h > $max )
      {
        if ($w > $h)
        {
          $width  = $max;
          $height = floor(($max * $h) / $w);
          $square = $h;
          $xprew  = ($w / 2) - ($h / 2);
          $yprew  = 0;
        }
        else {
          $height = $max;
          $width  = floor(($max * $w) / $h);
          $square = $w;
          $xprew  = 0;
          $yprew  = ($h / 2) - ($w / 2);
        }
      }
      #
      #
      # папка и названия картинок хранения
      #
      $root     =   $_SERVER['DOCUMENT_ROOT'];
      $url      =   '/file/'. time(). $k;
      $path     =   $_SERVER['DOCUMENT_ROOT']. $url;
      $dir      =   dirname($path);
      #
      if ( !is_dir($dir) )   mkdir($dir, 0777, true);
      #
      #
      # сохранить картинку с уменьшением
      #
      $full     =   imagecreatetruecolor($width,$height);
      imagecopyresampled($full,$img,  0,0, 0,0,  $width,$height, $w,$h);
      imagewebp($full,  $path. 'full.webp',  60);
      $size     =   filesize($path. 'full.webp');
      #
      #
      # сохранить превьюшку
      #
      $max      =   300;   
      $prew     =   imagecreatetruecolor($max,$max);
      imagecopyresampled($prew,$img,  0,0, $xprew,$yprew,  $max,$max, $square,$square);
      imagewebp($prew,  $path. 'prew.webp',  60);
      $size     +=  filesize($path. 'prew.webp');
      
      




      # добавить вещицу в базу данных
      #
      if ( $getGood )
      {
        $good   =   $getGood;
      }
      else {
        $good     =   db::query("INSERT INTO `good` (`user`)  VALUES (" .db::v(self::$user['id']). ")");
        $good     =   db::lastId();
      }
      #
      # добавить картинку
      #
      $file = db::query("
        INSERT INTO `file` (
            `good`
          , `root`
          , `url`
          
          , `order`
          , `size`
          , `src_name`
        )
        VALUES (
            " .db::v($good). "
          , " .db::v($root). "
          , " .db::v($url.'full.webp'). "

          , (SELECT IFNULL(MAX(`order`)+1, 0)  FROM `file` as `t`  WHERE `good` = " .db::v($good). " )
          , " .db::v($size). "
          , " .db::v($_FILES['file']['name'][ $k ]). "
        )
      ");
      #
      # указать главную картинку
      #
      if ( !$getGood )
      {
        db::query("UPDATE `good`  SET `main_file` = " .$file. "  WHERE `id` = " .$good );
      }

    }

    

    
    self::returnd($_FILES);
  }

}