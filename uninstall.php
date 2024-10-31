<?php
/**
 * Uninstall 
 * 
 * @plugin Network Only Plugins Tab
 */

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

delete_site_option( 'network_only_plugins_tab_settings' );