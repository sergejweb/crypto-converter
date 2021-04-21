<?php
function pc_activate_plugin(){
    if( version_compare( get_bloginfo( 'version' ), '5.0', '<' ) ){
        wp_die( __( "You must update WordPress to use this plugin.", 'recipe' ) );
    }

    global $wpdb;
    $createSQL      =   "CREATE TABLE `wp_crypto_converter` (
	`ID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`currency` TEXT NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`converted` TEXT NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`amount` FLOAT UNSIGNED NOT NULL DEFAULT '0',
	`convert_date` datetime NOT NULL default '0000-00-00 00:00:00',
	PRIMARY KEY (`ID`)
) " . $wpdb->get_charset_collate() . ";";

    require( ABSPATH . "/wp-admin/includes/upgrade.php" );
    dbDelta( $createSQL );
}