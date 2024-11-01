<?php

/*
	Plugin Name: WP-Seventag
	Plugin URI: https://wordpress.org/plugins/wp-seventag
	Description: WP-Seventag plugin integrates your WordPress site with 7tag.
	Version: 1.4.1
	Author: Clearcode | Piotr Niewiadomski | Irena Szukała
	Author URI: http://clearcode.cc
	Text Domain: wp-seventag
	Domain Path: /languages/
	License: GPLv3
	License URI: http://www.gnu.org/licenses/gpl-3.0.txt

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace Clearcode\Seventag;

use Clearcode\Seventag;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'get_plugin_data' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

foreach ( array( 'class-singleton.php', 'class-plugin.php', 'class-seventag.php', 'functions.php' ) as $file ) {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/' . $file );
}

if ( ! has_action( Seventag::get( 'slug' ) ) ) {
	do_action( Seventag::get( 'slug' ), Seventag::instance() );
}
