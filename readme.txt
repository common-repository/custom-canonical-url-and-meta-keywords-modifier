=== Custom Canonical URL and Meta Keywords Modifier ===
Contributors: claudioditotaro
Tags: custom meta tags, canonical, url, keywords, subdomain
Requires at least: 6.5
Tested up to: 6.6.2
Requires PHP: 7.2.24
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Modify or set the canonical URL and meta keywords in the Quick Edit interface of posts and pages.

== Description ==

> Modify or set the canonical URL and meta keywords in the Quick Edit interface of posts and pages.

This plugin lets you modify or set the meta tags of the canonical URL and meta keywords in the Quick Edit interface of each post or page.

**Why do I need to set the canonical URL?**
If you use a subdomain and point it to specific pages / posts then Wordpress automatically sets the canonical URL to the main domain (usually www.), but for SEO and indexing reasons you may want to set the canonical URL to the subdomain instead.

**Why do I need to set Meta Keywords?**
It helps Search Engines to index your content better, especially when you have important content which is generated automatically on the page and is not part of the HTML. 

= Basic Features =

* Go to Posts or Pages, click on **Quick Edit** and maintain **Canonical URL** or **Keywords** (multiple comma separated)

= Support =
To get your queries resolved related to 'Custom Canonical URL and Keywords Modifier', you can always take help from [Support.](https://ditotaro.wordpress.com/ccuakm)


== Installation ==

= Requirements =

* PHP version 8 or greater.
* WordPress version 5.8 or greater.

= Automatic installation =

1. Install the plugin via Plugins > New plugin. Search for 'Custom Canonical URL and Keywords Modifier'.
2. Activate the 'Custom Canonical URL and Keywords Modifier' plugin through the 'Plugins' menu in WordPress.

= Manual installation =

1. Unpack the downloaded package
2. Unzip and upload the directory 'custom-canonical-url-and-keywords-modifier' to the `/wp-content/plugins/` directory
3. Activate the 'Custom Canonical URL and Keywords Modifier' plugin through the 'Plugins' menu in WordPress

= Uninstall =

1. Deactivate 'Custom Canonical URL and Keywords Modifier' in the 'Plugins' menu in WordPress.
2. Select 'Custom Canonical URL and Keywords Modifier' in the 'Recently Active Plugins' section and select 'Delete' from the 'Bulk Actions' drop down menu.
3. This will delete all the plugin files from the server as well as erasing all meta data the plugin has stored in the database (table wp_postmeta).

== Frequently Asked Questions ==

= **Where can I edit the Canonical URL or Keywords?** =

Go to Posts or Pages, click on the standard WP 'Quick Edit' and maintain Canonical URL or Keywords (multiple by comma separated)

= **Where does these Meta data get stored?** =

Each posts/pages meta data will be stored by the plugin in the WP database in the table 'wp_postmeta'.

= **Will the meta data be deleted when I delete the plugin?** =

Yes, the stored meta data by the plugin in the WP database in the table 'wp_postmeta' will be deleted when uninstalling the plugin.

== Screenshots ==

1. Post or Page: the **Quick Edit Link** to enter custom canonical URL or keywords.
2. The Quick Edit area: Enter **custom canonical URL** or **Meta keywords** (multiple comma separated).

