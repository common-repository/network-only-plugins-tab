<?php
/**
 * Plugin Name: Network Only Plugins Tab
 * Plugin URI:  http://wordpress.org/plugins/network-only-plugins-tab
 * Description: List only plugins that are exclusive for Networks
 * Author:      Rodolfo Buaiz
 * Version:     1.2
 * Author URI:  https://brasofilo.com
 * Text Domain: b5f_nopt
 * Domain Path: /languages
 * Network:     true
 * License:     GPLv3
 * Last Change: 10/17/2013
 */

/**
 *  License:
 *  ==============================================================================
 *  Copyright Rodolfo Buaiz  License:  (email : rodolfo@rodbuaiz.com)
 *  
 *	This program is free software; you can redistribute it and/or
 *	modify it under the terms of the GNU General Public License
 *	as published by the Free Software Foundation; either version 2
 *	of the License, or (at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */


# Busted!
!defined( 'ABSPATH' ) AND exit(
        "<pre>Hi there! I'm just part of a plugin, 
            <h1>&iquest;what exactly are you looking for?" );

# Main class
require_once __DIR__ . '/inc/class-nopt-core.php';


# Plugin basename
define( 'B5F_MNPT_FILE', plugin_basename( __FILE__ ) );


# STart uP
if( is_admin() )
{
    add_action(
        'plugins_loaded',
        array ( B5F_Network_Only_Plugins_Tab::get_instance(), 'plugin_setup' ), 
        10
    );
}