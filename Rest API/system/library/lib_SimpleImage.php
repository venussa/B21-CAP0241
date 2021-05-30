<?php

namespace system\library;

 /**
 * SimpleImage Class
 *
 * for rewrite image to be small size and can 
 * modify image from url access
 *
 * @package     system
 * @subpackage  library
 * @category    magic image
 */

class SimpleImage {

   /**
    * Get image information from scanning image
    *
    * @var  boolean
    */

   private $image;
   private $image_type;

   // --------------------------------------------------------------------

   /**
    * Native Iamge Loader
    *
    * @param   string $filename filename
    * @param   boolean $image_type filetype
    * @return  void
    */

   public function load($filename) {

      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {

         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {

         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {

         $this->image = imagecreatefrompng($filename);
      }
   }

   // --------------------------------------------------------------------

   /**
    * Native Saving Image
    *
    * @param   string $filename filename
    * @param   boolean $image_type filetype
    * @param   int $compression image quality
    * @param   int $permition file permition system
    * @return  void
    */

   public function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {

      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {

         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {

         imagepng($this->image,$filename);
      }
      if( $permissions != null) {

         chmod($filename,$permissions);
      }
   }

   // --------------------------------------------------------------------

  /**
    * Native Output Image
    *
    * @param   string $filename filename
    * @param   boolean $image_type filetype
    * @return  void
    */
   public function output($image_type=IMAGETYPE_JPEG) {

      if( $image_type == IMAGETYPE_JPEG ) {
         header("Content-Type: image/jpeg");
         imagejpeg($this->image);
         
      } elseif( $image_type == IMAGETYPE_GIF ) {
         header("Content-Type: image/gif");
         imagegif($this->image);

      } elseif( $image_type == IMAGETYPE_PNG ) {
         header("Content-Type: image/png");
         imagepng($this->image);

      }
   }

   // --------------------------------------------------------------------

     /**
    * Get image Witdh
    *
    * @uses   String $this->image image path
    * @return  void
    */
   protected function getWidth() {

      return imagesx($this->image);
   }

   // --------------------------------------------------------------------

   /**
    * Get Image Height
    *
    * @uses   String $this->image image path
    * @return  void
    */
   protected function getHeight() {

      return imagesy($this->image);
   }

   // --------------------------------------------------------------------

   /**
    * Calculate iamge height to resize
    *
    * @uses   String self::getHeight() image
    * @param   int $height image height
    * @return  void
    */
   public function resizeToHeight($height) {

      $ratio = $height / self::getHeight();
      $width = self::getWidth() * $ratio;
      $this->resize($width,$height);
   }

   // --------------------------------------------------------------------

   /**
    * Calculate image width to resize
    *
    * @uses   String self::getWidth() image
    * @param   int $width image width
    * @return  void
    */
   public function resizeToWidth($width) {
      $ratio = $width / self::getWidth();
      $height = self::getHeight() * $ratio;
      $this->resize($width,$height);
   }

   // --------------------------------------------------------------------

   /**
    * Set image rander
    *
    * @uses   String self::getHeight() image
    * @uses   String self::getWidth() image
    * @param   int $scale image scale
    * @return  void
    */
   public function scale($scale) {
      $width = self::getWidth() * $scale/100;
      $height = self::getHeight() * $scale/100;
      $this->resize($width,$height);
   }

   // --------------------------------------------------------------------

   /**
    * Resize image
    *
    * @uses   String self::getHeight() image
    * @uses   String self::getWidth() image
    * @param   int $width image width
    * @param   int $height image height
    * @return  void
    */
   public function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, self::getWidth(), self::getHeight());
      $this->image = $new_image;
   } 

   // --------------------------------------------------------------------  

   /**
    * generate Image Url
    *
    * @return  string
    */

   public function generate_url($url = null,$width = null,$height = null){

      if(!empty($url)){

        $filename = get_file_name($url);

        $get = getimagesize($url);

        if(!is_array($get)) return false;

        list($width_x, $height_x, $type, $attr) = $get;

        if(empty($width) and empty($height)){
          $width = $width_x;
          $height = $height_x;
        
        }elseif(!empty($height) and empty($width)){

          $width = $width_x;
          $height = $height_x;

        }else if(empty($height) and !empty($width)){

          $calc = $width * 100 / $width_x;
          $calc = $calc * $height_x / 100;
          $height = $calc;

        }

        return "/image/".base64_encode($url)."/".$width."/".$height."/".get_extention($url)."/".$filename;

      }

    }   

}