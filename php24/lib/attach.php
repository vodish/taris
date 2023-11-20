<?php
class attach
{
    static function upload()
    {
        if ( ! user::$id )      return;
        if ( ! isset(req::$param['attachUpload']) )  return;

        ui::vd(req::$param);
        ui::vd($_FILES);
        die;
    }
}