=== htaccess Watermark ===
Contributors: Daniel Ip
Tags: watermark, medias, photography, picture, copyright, photos, logo, upload, signature, images, uploads, media, marca de agua, filigrane
Requires at least: 3.0.1
Tested up to: 3.9.1
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows to add a watermark on your images uploaded.

== Description ==

This plugin allows to add a watermark on the images uploaded. 

It make use of .htaccess, so all images that are uploaded or to be upload will all have the watermark. Your source images will not be affected, and after you delete/deactivate your plugin, all watermark will disappear. This plugin also work with @2x images that use on retina display or high resolution screen devices.

With this plugin, you may :

*	change the size of the watermark proportion to the images width.
*	change the opacity of the watermark, you are recommended to upload a png with solid color, as you may adjust the opacity after you upload.
*	(soon)set the position of the watermark and the offset position.
*	(soon)choose repetitive mode to display your watermark.
*	(soon, but later)choose the path that images in that path will have watermark.

The watermark is only visible if you try to download/view the images from a web browser.

You have to know that :

*	you need to be able to create a htaccess file in your uploads directory.
*	you need the GD library.
*	works only with JPG/JPEG/PNG files.

Available languages in :

* English

== Installation ==

1. Upload `IPs-watermark` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

Note : GD library is needed and be able to create a htaccess file in uploads directory.

== Screenshots ==

1. Administration Page for the plugin.

== Changelog ==

= 0.1 =
* Initial release
