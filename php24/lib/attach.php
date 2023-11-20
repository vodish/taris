<?php
class attach
{
    static function upload()
    {
        if ( ! user::$id )      return;
        if ( empty($_FILES) )   return;
        if ( ! isset(req::$param['attachUpload']) )     return;
        
        chdir($_SERVER['DOCUMENT_ROOT']);

        // ui::vd();
        // ui::vdd();

        foreach( $_FILES['f']['tmp_name']  as  $k => $tmp_name )
        {
            $fname  =   md5(req::$param['rtoken']. $tmp_name);
            $fdir   =   'attach/'. implode('/', str_split($fname, 3));
            
            if ( !file_exists($fdir) )   mkdir($fdir, 0777, true);

            move_uploaded_file($tmp_name, "$fdir/$fname");


            res::$ret['attach'][]   =   $fname;
        }

    }
}