=== Flickr Press ===
Contributors:		ajferg
Tags:				flickr, photo, gallery
Requires at least:	3.1
Tested up to:		3.1
Stable tag:			1.3.1

Use this plugin to display your Flickr photosets on your WordPress site.

== Description ==

Flickr is a great solution for managing your photos, but it can be a bit tough to show those photos on your site.

This plugin provides an easy method to display your Flickr sets & photos on your site.  You can put custom CSS in your theme's stylesheet to redefine the look and feel of your galleries.

You can also choose to not display 'private' photos on your site, or to not show certain albums.

== Installation ==

1. Upload plugin to your wordpress installation plugin directory
1. Activate plugin through the `Plugins` menu in Wordpress
1. Look at the configuration screen (found under `Settings` in the Wordpress menu)
1. Choose which page to use for showing photos, and enter your Flickr API key.

== Frequently Asked Questions ==

= Can I choose not to display certain albums? =
Sure - there's a settings page which lists all of your albums. You can tick which ones you want to hide.

= Can I choose not to display certain photos? =
Sure - just mark the photo as 'private' in your Flickr account, and tick the "Hide private photos" setting your WordPress admin area.

= Why am I getting 404 errors? =
Maybe you haven't set up "pretty permalinks" yet.  If you're still using the default permalink structure (site.com/?p=3) then you're going to have some problems.

= How do I apply my own CSS rules? =
The plugin contains a file called "skeleton.css".  Copy/paste the contents of this to your theme's custom CSS file, and over-ride any style rules you like.

== Changelog ==

= 1.3.1 = 
* Wordpress SVN didn't bundle a necessary folder into the ZIP file.  Trying again.

= 1.3 =
* Better "Clear API Settings" buttons should you need to unlink from your Flickr account
* Better cache system to reduce calls to Flickr API
* Admin includes button to "Clear Flickr Cache", causing you to immediately refresh all your data from Flickr
* Extensively re-written to fix some reported bugs
* Feature: You can now select whether to insert your initial list of albums before or after your existing page content

= 1.2 =
* Add a "Clear" button to remove your API details from memory
* View Album page now has a link back to List Albums
* View Photo page now has links to View Album and List Albums
* View Photo "Uploaded" date was showing a timestamp. Now formatting as a date, according to your WordPress setting.

= 1.1 =
* Initial release.
