<?php
/**
 * Plugin Name:     Ngrokwordpress
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     ngrokwordpress
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Ngrokwordpress
 */

function change_urls($page_html) {
    if(defined('LOCALTUNNEL_ACTIVE') && LOCALTUNNEL_ACTIVE === true) {

        $wp_home_url = esc_url(home_url('/'));
        $rel_home_url = wp_make_link_relative($wp_home_url);

        $esc_home_url = str_replace('/', '\/', $wp_home_url);
        $rel_esc_home_url = str_replace('/', '\/', $rel_home_url);

        $rel_page_html = str_replace($wp_home_url, $rel_home_url, $page_html);
        $esc_page_html = str_replace($esc_home_url, $rel_esc_home_url, $rel_page_html);

        return $esc_page_html;
    }
}

function buffer_start_relative_url() { 
    if(defined('LOCALTUNNEL_ACTIVE') && LOCALTUNNEL_ACTIVE === true) {
        ob_start('change_urls'); 
    }
}
function buffer_end_relative_url() { 
    if(defined('LOCALTUNNEL_ACTIVE') && LOCALTUNNEL_ACTIVE === true) {
        @ob_end_flush(); 
    }
}

add_action('registered_taxonomy', 'buffer_start_relative_url');
add_action('shutdown', 'buffer_end_relative_url');