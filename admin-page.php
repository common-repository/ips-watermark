<?php 

require_once('paths.php');

// Check if watermark doesnt exist
if ( is_writable(dirname($acw_plugins['path'].'-data')) && !file_exists($acw_plugins['path'].'-data') ) {
    mkdir( $acw_plugins['path'].'-data', 0755, true );
    $successDataDirectory = TRUE;
} 
if ( !is_writable(dirname($acw_plugins['path'].'-data')) ) {
    $successDataDirectory = FALSE;
}

if ( !file_exists($acw_plugins['path'].'-data/'.$acw_watermark['name']) && $successDataDirectory == TRUE ) {
            rename( $acw_relativePaths['adminToPlugins'].'sample-'.$acw_watermark['name'], $acw_plugins['path'].'-data/'.$acw_watermark['name'] );
}

// Check if FILES is submited
if(isset( $_FILES['watermarkFile']['name']) && $_FILES['watermarkFile']['name'] != '' && preg_match('/^image/i', $_FILES['watermarkFile']['type']) && $_FILES['watermarkFile']['error'] == 0) {

    if( substr($_FILES['watermarkFile']['name'], -3 ) == 'png') {
        $success = move_uploaded_file( $_FILES['watermarkFile']['tmp_name'], $acw_plugins['path'].'-data/'.$acw_watermark['name'] );
    } else {

        $successImg = imagepng(imagecreatefromstring(
            file_get_contents($_FILES['watermarkFile']['tmp_name'])), 
        $acw_plugins['path'].'-data/'.$acw_watermark['name']
        );
    }

}

// Check if image submited is wrong
if(isset( $_FILES['watermarkFile']['name']) && $_FILES['watermarkFile']['name'] != '' && (!preg_match('/^image/i', $_FILES['watermarkFile']['type']) || $_FILES['watermarkFile']['error'] != 0)) {

    $successImg = FALSE;

}

// Check if settings are submited
//width
if ( isset( $_POST['watermarkSize'] ) ) {
    $width = $_POST['watermarkSize'];
    if(is_numeric($width)) {
        include 'htaccess.php';
    }
    if(isset($successWidth) && $successWidth == FALSE) {
        $successWidth = FALSE; 
    } else {
        $successWidth = TRUE; 
    }
}

//percentage
if ( isset( $_POST['watermarkpercent'] ) ) {
    $percentage = $_POST['watermarkpercent'];
    if(is_numeric($percentage)) {
        include 'htaccess.php';
    }
    if(isset($successPercentage) && $successPercentage == FALSE) {
        $successPercentage = FALSE; 
    } else {
        $successPercentage = TRUE; 
    }
} 

//opacity
if ( isset( $_POST['watermarkopacity'] ) ) {
    $opacity = $_POST['watermarkopacity'];
    if(is_numeric($opacity)) {
        include 'htaccess.php';
    }
    if(isset($successOpacity) && $successOpacity == FALSE) {
        $successOpacity = FALSE; 
    } else {
        $successOpacity = TRUE; 
    }
} 

// Read width value from htaccess
//width
if( file_exists($acw_uploads['basedir'].'/'.'.htaccess') ) {
    $htaccess = file_get_contents( $acw_uploads['basedir'].'/'.'.htaccess' );
    if( preg_match('/IPs\-watermark/i', $htaccess) ) {
        preg_match('/\[width=([0-9]+)\]/i', $htaccess, $htaccessWidth);
        $htaccessWidth = $htaccessWidth[1];
    } else {
        $htaccessWidth = '';
    }

} else {
    $htaccessWidth = '';
}
//read watermark percentage
if( file_exists($acw_uploads['basedir'].'/'.'.htaccess') ) {
    $htaccess = file_get_contents( $acw_uploads['basedir'].'/'.'.htaccess' );
    if( preg_match('/IPs\-watermark/i', $htaccess) ) {
        preg_match('/\[percentage=([0-9]+)\]/i', $htaccess, $htaccesspercentage);
        $htaccesspercentage = $htaccesspercentage[1];
    } else {
        $htaccesspercentage = '';
    }

} else {
    $htaccesspercentage = '';
}

//read opacity percentage
if( file_exists($acw_uploads['basedir'].'/'.'.htaccess') ) {
    $htaccess = file_get_contents( $acw_uploads['basedir'].'/'.'.htaccess' );
    if( preg_match('/IPs\-watermark/i', $htaccess) ) {
        preg_match('/\[opacity=([0-9]+)\]/i', $htaccess, $htaccessopacity);
        $htaccessopacity = $htaccessopacity[1];
    } else {
        $htaccessopacity = '';
    }

} else {
    $htaccessopacity = '';
}

?>

<link rel="stylesheet" href="<?php echo $acw_relativePaths['adminToPlugins'].'/'; ?>style.css">
<div id="ac-aw-admin-page-container" class="wrap">
    <h2>IP's Watermark <span><?php _e('by ', 'IPswatermark'); ?>Daniel Ip</span></h2>
    <p class="description"><?php _e('Apply a watermark on all your photographies. This action is cancelable just by deactivating the plugin. <br> The watermark will be applied even in your photos already uploaded.', 'IPswatermark'); ?></p>
    <?php if( isset($successDataDirectory) && $successDataDirectory === FALSE ) { ?>
    <div id="setting-error-settings_updated" class="error settings-error"> 
        <p><strong><?php _e('The plugin couldn\'t create a directory to store the watermark. Be sure you can create directory in the plugins directory.', 'IPswatermark'); ?></strong></p></div>
        <?php } ?>
        <?php if( isset($successImg) && $successImg === TRUE ) { ?>
    <div id="setting-error-settings_updated" class="updated settings-error"> 
        <p><strong><?php _e('The watermark has been updated.', 'IPswatermark'); ?></strong></p></div>
        <?php } ?>
        <?php if( isset($successImg) && $successImg === FALSE ) { ?>
        <div id="setting-error-settings_updated" class="error settings-error"> 
            <p><strong><?php _e('There was an error while processing the image submited. Please try again or with a different image format.', 'IPswatermark'); ?></strong></p></div>
            <?php } ?>
            <?php if( isset($successWidth) && $successWidth === TRUE) { ?>
            <div id="setting-error-settings_updated" class="updated settings-error"> 
                <p><strong><?php _e('The settings have been updated.', 'IPswatermark'); ?></strong></p></div>
                <?php } ?>
                <?php if( isset($successWidth) && $successWidth === FALSE ) { ?>
                <div id="setting-error-settings_updated" class="error settings-error"> 
                    <p><strong><?php _e('There was an error while updating the width setting. <br> Apparently you don\'t have rights to modify or create a file on your uploads directory.', 'IPswatermark'); ?></strong></p></div>
                    <?php } ?>
                    <form method="post" enctype="multipart/form-data">
                        <table class="form-table">
                            <tbody>

                                <tr valign="top">
                                    <th scope="row"><label for="watermarkSize"><?php _e('Apply to images', 'IPswatermark'); ?></label></th>
                                    <td>
                                        <select id="watermarkSize" name="watermarkSize">
                                            <option value="9999"<?php if(9999 == $htaccessWidth) { echo ' selected="selected" '; } ?>>only fullsize</option>
                                            <?php for($i = 1; $i <= 9; $i++) { ?>
                                            <option value="<?php echo $i; ?>"<?php if($i == $htaccessWidth) { echo ' selected="selected" '; } ?>><?php _e('on generated thumbs of height = ', 'IPswatermark'); ?><?php echo $i; ?>00px <?php _e('or more', 'IPswatermark'); ?></option>
                                            <?php } ?>
                                            <option value="0"<?php if(0 == $htaccessWidth) { echo ' selected="selected" '; } ?>>All images</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <th scope="row"><label for="watermarkFile"><?php _e('Choose a watermark', 'IPswatermark'); ?></label></th>
                                    <td>
                                        <input type="file" name="watermarkFile" id="watermarkFile">
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <th scope="row"><label for="preview"><?php _e('Preview', 'IPswatermark'); ?></label></th>
                                    <td>
                                        <?php if(file_exists( $acw_plugins['path'].'-data/'.$acw_watermark['name'] )) { ?>
                                        <img class="preview" src="<?php echo $acw_plugins['baseurl'].$acw_plugins['subdir'].'-data/'.$acw_watermark['name'].'?'.rand(0,1500); ?>" alt="watermark">
                                        <p class="description"><?php _e('Real size is actually', 'IPswatermark'); ?> <strong><?php $imageSize = getimagesize( $acw_plugins['path'].'-data/'.$acw_watermark['name']); echo $imageSize[0].'x'.$imageSize[1]; ?>px</strong>. <?php _e('The background gradient is for contrast check.', 'IPswatermark'); ?></p>
                                        <?php } ?>
                                    </td>
                                </tr>
                                
                                <tr valign="top">
                                    <th scope="row"><label for="watermarkpercent"><?php _e('Choose the width of the watermark on the image<br>(1-100%)', 'IPswatermark'); ?></label></th>
                                    <td>
                                        <input type="text" value="<?php echo htmlentities($htaccesspercentage); ?>" name="watermarkpercent" id="watermarkpercent">
                                    </td>
                                </tr>
                                
                                <tr valign="top">
                                    <th scope="row"><label for="watermarkopacity"><?php _e('Set the opacity of the watermark<br>(1-100%,100% is the same of your original watermark image)', 'IPswatermark'); ?></label></th>
                                    <td>
                                        <input type="text" value="<?php echo htmlentities($htaccessopacity); ?>" name="watermarkopacity" id="watermarkopacity">
                                    </td>
                                </tr>                                

                                <tr valign="top">
                                    <th scope="row"></th>
                                    <td>
                                        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Update', 'IPswatermark'); ?>"></p> 
                                    </td>
                                </tr>

                            </tbody>
                        </table>


                    </form>
                    

                </div>