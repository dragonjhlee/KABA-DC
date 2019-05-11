=== MailChimp for WordPress - Captcha ===
Contributors: Ibericode, DvanKooten, hchouhan, lapzor
Donate link: https://mc4wp.com/#utm_source=wp-plugin-repo&utm_medium=mc4wp-captcha&utm_campaign=donate-link
Tags: mailchimp, mc4wp, captcha, recaptcha, google recaptcha, forms
Requires at least: 3.8
Tested up to: 4.9.4
Stable tag: 1.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add a Captcha field to your MailChimp for WordPress sign-up forms.

== Description ==

Add a Captcha field to your MailChimp sign-up forms.

This plugin requires you to install the following two plugins:

- [MailChimp for WordPress](https://wordpress.org/plugins/mailchimp-for-wp/)
- [Google Captcha by BestWebSoft](https://wordpress.org/plugins/google-captcha/)

After installing the plugin, adding the following code to your sign-up forms will render a Google reCAPTCHA field.

`
{captcha}
`


== Installation ==

= MailChimp for WordPress - Captcha =

Since this plugin depends on the [MailChimp for WordPress plugin](https://wordpress.org/plugins/mailchimp-for-wp/), you will need to install that first.

= Installing the plugin =

1. In your WordPress admin panel, go to *Plugins > New Plugin*, search for **MailChimp for WordPress - Captcha** and click "*Install now*"
1. Alternatively, download the plugin and upload the contents of `mc4wp-captcha.zip` to your plugins directory, which usually is `/wp-content/plugins/`.
1. Activate the plugin
1. Add the following code to your form, where you want the captcha to appear.

`
{captcha}
`

== Frequently Asked Questions ==

= How does this work? =

After activating the plugin, you can render a Google reCAPTCHA field by adding the following code to your form mark-up.

`
{captcha}
`


== Screenshots ==



== Changelog ==


#### 1.1.2 -February 16, 2018

**Fixes**

- Reset reCaptcha after form is submitted with errors when using AJAX.


#### 1.1.1 - October 13, 2017

**Fixes**

- Issue with form being processed while captcha is invalid when using AJAX enabled forms.


#### 1.1 - August 16, 2017

This update includes compatibility for the [Google reCAPTCHA plugin](https://wordpress.org/plugins/google-captcha/). 

Please note that this will break your existing captcha field if you're still using the older Captcha plugin, which was pulled from the WordPress.org plugin repository.


#### 1.0.2 - August 2, 2016

**Improvements**

- Compatibility with [upcoming MailChimp for WordPress 4.0 release](https://mc4wp.com/kb/upgrading-to-4-0/).


#### 1.0.1 - March 1, 2016

**Fixes**

- Captcha validation always passing, regardless of input value.


#### 1.0 - November 23, 2015

Initial release.

== Upgrade Notice ==

This update will break your existing captcha field. The plugin now depends on the Google reCAPTCHA plugin.
