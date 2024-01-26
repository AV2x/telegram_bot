<?php

namespace App\Helpers;

class Storage
{
   static  public function dirToArray($dir) {

   $result = array();
   $cdir = scandir($dir);

   foreach ($cdir as $key => $value)
   {
      if (!in_array($value,array(".","..", ".gitignore")))
      {
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
         {
            $result[$value] = self::dirToArray($dir . DIRECTORY_SEPARATOR . $value);
         }
         else
         {
             $file = explode('.', $value);
             $icon = (in_array($file[count($file)-1], ['webp', 'png', 'jpg', 'jpeg']))
                 ? 'mdi-image-outline' : 'mdi-file-document-alert-outline';
             //$value = ($value) ?
            $result[] = [
                'file_name' => $value,
                'icon' => $icon,
                'type' => $file[count($file)-1],
                'size' => round(filesize($dir.'/'.$value) / 1024 / 1024, 3)];
         }
      }
   }
   return $result;

}
}
