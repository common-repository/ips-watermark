<?php 
global $width;
global $percentage;
global $opacity;

if ($percentage>100) {
	$percentage = 100;
}

if ($percentage<1) {
	$percentage = 1;
}

if ($opacity>100) {
	$opacity = 100;
}

if ($opacity<1) {
	$opacity = 1;
}

$widthRegex = '';
//need modify
if ( isset($width) ) {
	if( $width == 9999 ) {
		$widthRegex = '\-([0-9]{1,5})x([0-9]{1,5})';
	} else {
		$widthRegex = '\-([0-9]{1,5})(';
			for ($i = 1; $i < $width; $i++) {
				$widthRegex .= 'x'.$i;
				if ( $i+1 < $width ) $widthRegex .= '|';
			}
			$widthRegex .= ')([0-9]{1,2})';
}
} else {
	$widthRegex = '\-([0-9]{1,5})(x1|x2|x3|x4)([0-9]{1,2})';
}

// check if htaccess already exists
if ( file_exists($acw_uploads['basedir'].'/'.'.htaccess') && !preg_match('/IPs\-watermark/i', file_get_contents( $acw_uploads['basedir'].'/'.'.htaccess' )) ) {
	$htaccessContent = file_get_contents( $acw_uploads['basedir'].'/'.'.htaccess' );
	$htaccessContent .= "\n\r\n";
} 
else {
	if ( file_exists($acw_uploads['basedir'].'/'.'.htaccess') && preg_match('/^(.+)\# BEGIN IPs\-watermark/s', file_get_contents( $acw_uploads['basedir'].'/'.'.htaccess' ), $htaccessContentPreviousContent) )  {
		echo $acw_uploads['basedir'];
		$htaccessContent = $htaccessContentPreviousContent[1];
	} else {
		$htaccessContent = "";
	}
}

$htaccessContent     .= '# BEGIN IPs-watermark Plugin'."\n\r\n";
$htaccessContent     .= 'RewriteEngine on'."\n";
$htaccessContent     .= 'RewriteRule ^((.*)@2x\.(jpg|jpeg|png)$) (.+)@2@(\.(jpg|jpeg|png))$ '."\n";
$htaccessContent     .= 'RewriteRule ^(?!.*'.$widthRegex.'\.(jpg|jpeg|png)$)(.+)(\.(jpg|jpeg|png))$ '.$acw_relativePaths['uploadsToPlugins'].'watermark.php?imageRequested=$0&watermarkName='.$acw_plugins['baseurl'].$acw_plugins['subdir'].'-data/'.$acw_watermark['name'].'&widthPercentage='.$percentage.'&opacity='.$opacity."\n\r\n";
$htaccessContent     .= '# END IPs-watermark Plugin. (generated on '.date('Y-m-d H:i.s').') [width='.$width.']'.' [percentage='.$percentage.']'.'[opacity='.$opacity.']'."\n";

if( is_writable($acw_uploads['basedir'].'/') ) {
	file_put_contents( $acw_uploads['basedir'].'/'.'.htaccess', $htaccessContent );
} else {
	$successWidth = FALSE;
}
$successPercentage = TRUE;
$successOpacity = TRUE;

