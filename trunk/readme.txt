=== Delete Usermetas ===
Contributors: jose-lazo, lebiramdc
Tags: users, usermetas
Requires at least: 4.2
Tested up to: 6.1
Stable tag: 5.3
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Delete Usermetas is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Delete Usermetas is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Delete Usermetas. If not, see https://www.gnu.org/licenses/gpl-2.0.html.

You can delete a user metadata one by one or a metadata of all users.

== Description ==

You can delete a user metadata one by one or a metadata of all users. It is a powerful tool, so use it responsibly.
The deleted data can not be recovered, so we strongly recommend making a backup of your database before deleting the metadata.

If you leave the User ID field blank, the deletion of the metadata will apply to ALL users. But if you add a user ID, only the chosen metadata of that user will be deleted.

You can know the user ID by going to Admin --> Users --> Edit. The ID will appear in the URL with something like "user_id=3".

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/delete-usermetas` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->Plugin Name screen to configure the plugin

== Frequently Asked Questions ==

= Can I delete one metadata in all users? =

Yes you can. You have to select one metadata and leave blank the field "User ID".

= Can I selected multiple users to delete one usermeta? =

No, you can't yet (next release). If you need to delete one metadata to multiple user, you need do it one by one.

== Screenshots ==

1. Easy and intuitive interface

== Changelog ==

= 1.1.2 =
* Tested 6.1

= 1.1.1 =
* Tested 5.8.1

= 1.1 =
* Tested 5.5.3
* Fixed minor bugs

= 1.0 =
* Initial release
