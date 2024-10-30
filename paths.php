<?php 
require_once 'functions.php';

// Clean paths
$acw_uploads            = wp_upload_dir();

$acw_plugins            = array(
                            'path'      => WP_PLUGIN_DIR.'/'.dirname(plugin_basename( __FILE__ )), // plugindir
                            'url'       => plugins_url( '', __FILE__ ), // plugindirsub
                            'subdir'    => '/'.dirname(plugin_basename( __FILE__ )), // pluginBase + /
                            'basedir'   => WP_PLUGIN_DIR,
                            'baseurl'   => WP_PLUGIN_URL,
                            );

$acw_watermark              = array(
                            'name'      => 'watermark.png',
                            'tempname'  => 'watermark-temp.png'
                        );

$acw_relativePaths      = array(
                            'uploadsToPlugins'  => getRelativePath(
                                    str_replace(get_bloginfo('wpurl'), '', $acw_uploads['baseurl'].'/'), 
                                    str_replace(get_bloginfo('wpurl'), '', $acw_plugins['url'].'/')
                                ),
                            'pluginsToUploads'   => getRelativePath(
                                    str_replace(get_bloginfo('wpurl'), '', $acw_plugins['baseurl'].'/'), 
                                    str_replace(get_bloginfo('wpurl'), '', $acw_uploads['url'].'/')
                                ),
                            'adminToPlugins'    => getRelativePath(
                                    str_replace(get_bloginfo('wpurl'), '', admin_url()), 
                                    str_replace(get_bloginfo('wpurl'), '', $acw_plugins['url'].'/')
                                ),
                        );

