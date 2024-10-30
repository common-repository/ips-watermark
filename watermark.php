<?php   

//convert @2@ back to @2x
if (
    (substr( $_GET['imageRequested'], -3) == 'jpg')
    ||
    (substr( $_GET['imageRequested'], -4) == 'jpeg')
    ||
    (substr( $_GET['imageRequested'], -3) == 'png')
    ) {
  $temppath   = $_GET['imageRequested'];
  }
if (substr( $_GET['imageRequested'], -7) == '@2@.jpg') {
  $temppath   = substr( $_GET['imageRequested'],0,(strlen($_GET['imageRequested'])-7)).'@2x.jpg';
  }
if (substr( $_GET['imageRequested'], -8) == '@2@.jpeg') {
  $temppath   = substr( $_GET['imageRequested'],0,(strlen($_GET['imageRequested'])-8)).'@2x.jpeg';
  }
if (substr( $_GET['imageRequested'], -7) == '@2@.png') {
  $temppath   = substr( $_GET['imageRequested'],0,(strlen($_GET['imageRequested'])-7)).'@2x.png';
  }

// Add watermark to image
if ( 
  $_GET['imageRequested'] 
  && 
  (substr( $_GET['imageRequested'], -3) == 'jpg'
   ||
  substr( $_GET['imageRequested'], -4) == 'jpeg')
  && 
  $_GET['watermarkName']
  &&
  $_GET['widthPercentage']
  &&
  $_GET['opacity']
  ) 
{
  require_once 'functions.php';

// Get File and Path info
  $watermarkName    = $_GET['watermarkName'];
  $imageRequested   = $temppath;
  $waterPercentage = $_GET['widthPercentage'];
  $opacity = $_GET['opacity'];
  $pluginData       = pathinfo(__FILE__);
  $pluginsToUploads = pathinfo(getRelativePath($_SERVER['SCRIPT_NAME'], $_SERVER['REQUEST_URI']) );

// Works only with JPG Files
  $formats = 'jpg|jpeg|jpe';

  if ( 
    ( is_file( $pluginsToUploads['dirname'].'/'.basename($_GET['imageRequested']) ) 
    // depending of server configs
||
is_file( utf8_decode($pluginsToUploads['dirname'].'/'.basename($_GET['imageRequested']) )) 
// depending of server configs
)
    && preg_match('/('.$formats.')$/i', $pluginsToUploads['extension']) )
  {
    if(is_file( $pluginsToUploads['dirname'].'/'.$_GET['imageRequested'] )) {
      $imagePathName = $pluginsToUploads['dirname'].'/'.$_GET['imageRequested'];
    } else {
      $imagePathName = utf8_decode($pluginsToUploads['dirname'].'/'.basename($_GET['imageRequested']) );
    }

    $watermark      = imagecreatefrompng($watermarkName);
    $image          = imagecreatefromjpeg( $imagePathName );
    $photowidth     = imagesx($image);
    $originalwwidth = imagesx($watermark);
    $originalwheight = imagesy($watermark);
    $watermarkwidth = (($photowidth * $waterPercentage) / 100);
    $watermarkheight = (($originalwheight * $watermarkwidth) / $originalwwidth);
    $resizedwatermark = imagecreatetruecolor($watermarkwidth, $watermarkheight);
    imagealphablending($resizedwatermark, false);
    imagesavealpha($resizedwatermark,true);
    $transparent = imagecolorallocatealpha($resizedwatermark, 255, 255, 255, 127);
    imagefilledrectangle($resizedwatermark, 0, 0, $watermarkwidth, $watermarkheight, $transparent);
    imagecopyresized($resizedwatermark, $watermark, 0, 0, 0, 0, $watermarkwidth, $watermarkheight, $originalwwidth, $originalwheight);
 
    imagefilledrectangle(
      $image, 
      0 , 
      (imagesy($image))-(imagesy($resizedwatermark)) , 
      imagesx($image) , 
      imagesy($image) , 
      imagecolorallocatealpha($image, 0, 0, 0, 127) 
      );
    imagecopymerge_alpha(
      $image, 
      $resizedwatermark, 
      (imagesx($image)-(imagesx($resizedwatermark))), 
      (imagesy($image))-(imagesy($resizedwatermark)), 
      0, 
      0, 
      imagesx($resizedwatermark), 
      imagesy($resizedwatermark),$opacity 
      );

    header('Last-Modified: '.gmdate('D, d M Y H:i:s T', filemtime ( $imagePathName )));
    header('Content-Type: image/jpeg');
    imagejpeg($image, NULL, 100);
    imagedestroy($watermark);
    imagedestroy($resizedwatermark);
    imagedestroy($image);

  } 
  else {
    }
}elseif ( 
  $_GET['imageRequested'] 
  && 
  substr( $_GET['imageRequested'], -3) == ('png')
  && 
  $_GET['watermarkName']
  &&
  $_GET['widthPercentage']
  &&
  $_GET['opacity']
  ) 
{
  require_once 'functions.php';

// Get File and Path info
  $watermarkName    = $_GET['watermarkName'];
  $imageRequested   = $temppath;
  $waterPercentage = $_GET['widthPercentage'];
  $opacity = $_GET['opacity'];
  $pluginData       = pathinfo(__FILE__);
  $pluginsToUploads = pathinfo(getRelativePath($_SERVER['SCRIPT_NAME'], $_SERVER['REQUEST_URI']) );

// Works only with PNG Files
  $formats = 'png';

  if ( 
    ( is_file( $pluginsToUploads['dirname'].'/'.basename($_GET['imageRequested']) ) 
    // depending of server configs
||
is_file( utf8_decode($pluginsToUploads['dirname'].'/'.basename($_GET['imageRequested']) )) 
// depending of server configs
)
    && preg_match('/('.$formats.')$/i', $pluginsToUploads['extension']) )
  {
    if(is_file( $pluginsToUploads['dirname'].'/'.$_GET['imageRequested'] )) {
      $imagePathName = $pluginsToUploads['dirname'].'/'.$_GET['imageRequested'];
    } else {
      $imagePathName = utf8_decode($pluginsToUploads['dirname'].'/'.basename($_GET['imageRequested']) );
    }
    $watermark      = imagecreatefrompng($watermarkName);
    $image          = imagecreatefrompng( $imagePathName );
    $photowidth     = imagesx($image);
    $originalwwidth = imagesx($watermark);
    $originalwheight = imagesy($watermark);
    $waterPercentage = $_GET['widthPercentage'];
    $watermarkwidth = (($photowidth * $waterPercentage) / 100);
    $watermarkheight = (($originalwheight * $watermarkwidth) / $originalwwidth);
    $resizedwatermark = imagecreatetruecolor($watermarkwidth, $watermarkheight);
    imagealphablending($resizedwatermark, false);
    imagesavealpha($resizedwatermark,true);
    $transparent = imagecolorallocatealpha($resizedwatermark, 255, 255, 255, 127);
    imagefilledrectangle($resizedwatermark, 0, 0, $watermarkwidth, $watermarkheight, $transparent);
    imagecopyresized($resizedwatermark, $watermark, 0, 0, 0, 0, $watermarkwidth, $watermarkheight, $originalwwidth, $originalwheight);
    
    imagefilledrectangle(
      $image, 
      0 , 
      (imagesy($image))-(imagesy($resizedwatermark)) , 
      imagesx($image) , 
      imagesy($image) , 
      imagecolorallocatealpha($image, 0, 0, 0, 127) 
      );
    imagecopymerge_alpha(
      $image, 
      $resizedwatermark, 
      (imagesx($image)-(imagesx($resizedwatermark))), 
      (imagesy($image))-(imagesy($resizedwatermark)), 
      0, 
      0, 
      imagesx($resizedwatermark), 
      imagesy($resizedwatermark),$opacity
      );

    header('Last-Modified: '.gmdate('D, d M Y H:i:s T', filemtime ( $imagePathName )));
    header('Content-Type: image/png');
    imagepng($image, NULL);
    imagedestroy($watermark);
    imagedestroy($resizedwatermark);
    imagedestroy($image);

  } 
  else {
    header('HTTP/1.1 404 Not Found', true, 404);
    echo utf8_decode($pluginsToUploads['dirname'].'/'.$_GET['imageRequested'] );
  }

} else {
  header('HTTP/1.1 404 Not Found', true, 404);
}