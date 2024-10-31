<?php
/***
 * Plugin Name: Saint of the Day
 * Plugin URI: https://wordpress.org/plugins/liturgical-day-of-the-week/
 * Description: This plugin is being rolled into the <a href="https://wordpress.org/plugins/liturgical-day-of-the-week/" target="_blank">Liturgical Day of the Week</a> plugin, since so many of the same features are already present in both. Please uninstall this one and install the LDotW plugin. <strong><u>It will be removed from the WordPress.org repositories early January 2024</u></strong>.
 * Version: 1.0.2
 * Requires at least: 5.2
 * Author: Doug "BearlyDoug" Hazard
 * Author URI: https://wordpress.org/support/users/bearlydoug/
 * Text Domain: saint-of-the-day
 * License: GPLv3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * This program is free software; you can redistribute it and/or modify it under 
 * the terms of the [GNU General Public License](http://wordpress.org/about/gpl/)
 * as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, on an "AS IS", but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, see [GNU General Public Licenses](http://www.gnu.org/licenses/), or write to the
 * Free Software Foundation, Inc., 51 Franklin Street, 5th Floor, Boston, MA 02110, USA.
 */

/***
 *	Setting up security stuff and paths...
 */
defined('ABSPATH') or die('Sorry, Charlie. No access for you!');

/***
 * Including the BearlyDoug functions file...
 */
require_once('functions-bd.php');

/***
 * DEFINE VERSION HERE
 */
define('sotdVersion', '1.0.2');
define('sotd', 'sotd');

/***
 * Saint of the Day link.
 */
function bearlydougplugins_add_sotd_submenu(){
	add_submenu_page(
		'bearlydoug',				// Parent Slug
		'Please switch to the LDotW Plugin',			// Page Title
		'Saint of the Day',			// Menu Title
		'edit_posts',				// Capabilities
		'sotd',					// Nav Menu Link
		'sotd_main_admin_interface'	// Function name
	);
}
add_action('admin_menu', 'bearlydougplugins_add_sotd_submenu', 15);

/***
 * Loading both the Admin and Plugin CSS and JavaScript files here. Will also check to see if the main
 * BearlyDoug CSS file is enqueued. If not, then enqueue it.
 */
add_action('admin_enqueue_scripts', 'sotd_enqueue_admin_files', 15);
function sotd_enqueue_admin_files(){
	wp_register_style('sotd', plugins_url('/includes/_CSS-sotd.css',__FILE__ ));
	wp_enqueue_style('sotd');

	/***
	 * This has to get loaded into the footer, only if on the "sotd" page.
	 */
	if(isset($_GET['page']) && $_GET['page'] == 'sotd') {
		wp_enqueue_script('sotdscbuilder', plugins_url('/includes/_JS-sotdSCBuilder.js',__FILE__ ), array(), false, true);
	}

	if(!wp_style_is('bearlydougCSS', $list = 'enqueued')) {
		wp_register_style('bearlydougCSS', plugins_url('/includes/_CSS-bearlydoug.css',__FILE__ ));
		wp_register_script('bearlydougJS', plugins_url('/includes/_JS-bearlydoug.js',__FILE__) );
		wp_enqueue_style('bearlydougCSS');
		wp_enqueue_script('bearlydougJS');
	}
}

/***
 * Loading only the Plugin CSS file here.
 */
add_action('wp_enqueue_scripts', 'sotd_enqueue_shortcode_files', 15);
function sotd_enqueue_shortcode_files(){
	wp_register_style('sotd', plugins_url('/includes/_CSS-sotd.css',__FILE__ ));
	wp_enqueue_style('sotd');
}

/***
 * Handling the Saint of the Day admin page and tags saving function...
 */
function sotd_main_admin_interface(){
	echo '
	<h1 class="bdCTR">Saying good bye to the "Saint of the Day" plugin...</h1>
	<div class="bdTabs">
<!-- bdTabs Navigation Tabs -->
		<input type="radio" name="bdTabs" class="bdRadio" id="bdTab1" checked >
		<label class="bdLabel" for="bdTab1"><i class="dashicons dashicons-info"></i><span> Details...</span></label>

<!-- bdTabs Content Tabs -->
		<div id="bdTab-content1" class="bdTab-content">
			<p class="bdCTR" style="font-weight: bold; color: red;">PLEASE NOTE: This plugin will be deactivated on the WordPress.org plugin repository shortly after the new year starts.</p>

			<p><br />Because the code bases and data structures were nearly identical with both "Saint of the Day" and "Liturgical Day of the Week",  it was logical to bring the two plugins together.</p>
			<p>Version 1.0.4 of the LDotW plugin contains the updated list of Saints for the Year B cycle (which starts November 26th, 2023) and goes to the end of December , 2024 (a month into the Year C cycle).</p>
			<p>Please see the important instructions down below. They change, depending on if you have LDotW installed or not.</p>

			<h2 class="bdCTR">Replacing SotD with LDotW...</h2>';

	if(is_plugin_active('liturgical-day-of-the-week/ldotw.php')) { 
		echo '
			<p>Since you have the "Liturgical Day of the Week" plugin installed, please follow these directions:</p>
			<p><a href="' . admin_url("admin.php?page=ldotw") . '">Head over to the LDotW page</a> and use the shortcode builder. You can configure that shortcode to only display the Saint of the Day, if you\'d like.</p>
			<p>Once you have it configured, copy the shortcode shown and replace any instances of the "[sotd]" shortcode you\'re using.</p>
			<p>When that\'s been done, deactivate the "Saint of the Day" plugin and delete it.</p>';
	} else {
		echo '
			<p>Since you do not have the "Liturgical Day of the Week" plugin installed AND ACTIVATED, please follow these directions:</p>
			<p>Head over to <a href="https://wordpress.org/plugins/liturgical-day-of-the-week/" target="_blank">the LDotW plugin page on WordPress.org</a> and download that plugin.</p>
			<p>Install and activate LDotW.</p>
			<p><a href="' . admin_url("admin.php?page=ldotw") . '">Head over to the LDotW page</a> and use the shortcode builder. You can configure that shortcode to only display the Saint of the Day, if you\'d like.</p>
			<p>Once you have it configured, copy the shortcode shown and replace any instances of the "[sotd]" shortcode you\'re using.</p>
			<p>When that\'s been done, deactivate the "Saint of the Day" plugin and delete it.</p>';
	}

	echo '
			<p><br />Thank you for ALL your support with using the Saint of the Day plugin!</p>
			<p class="bdCTR" style="font-weight: bold; color: red;"><br />PLEASE NOTE: This plugin will be deactivated on the WordPress.org plugin repository shortly after the new year starts.</p>
		</div>
	</div>';
}
?>