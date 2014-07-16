<?php

/*
Plugin Name: Rockethouse Wordpress Admin UI
Plugin URI: http://www.rockethouse.com.au
Description: Rockethouse Wordpress Admin UI Theme - Upload and Activate.
Author: Rockethouse
Version: 2.0
Author URI: http://www.rockethouse.com.au
*/

function my_admin_theme_style() {
    wp_enqueue_style('default-admin', plugins_url('css/wp-admin.css', __FILE__));
    wp_enqueue_style('default-colours', plugins_url('css/colors.css', __FILE__));
    //wp_enqueue_style('selectize', '//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.9.0/css/selectize.css', __FILE__);
    wp_enqueue_script('modernizr', plugins_url('js/modernizr.custom.63321.js', __FILE__));
    wp_enqueue_script('altcheckbox', plugins_url('js/jquery.alt-checkbox.min.js', __FILE__));
    // wp_enqueue_script('chosen', '//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js', __FILE__);
    //wp_enqueue_script('selectize', '//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.9.0/js/standalone/selectize.min.js', __FILE__);
    wp_enqueue_script('adminjs', plugins_url('js/admin.js', __FILE__));

}


add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_admin_theme_style');

// this will remove the stylesheet when init fires
add_action('admin_init','your_remove_default_stylesheets');
// this is your function to deregister the default admin stylesheet
function your_remove_default_stylesheets() {
    wp_deregister_style('wp-admin');
    //wp_deregister_style('dashicons');
}

add_action( 'admin_menu', 'admin_remove_menu_pages' );

function admin_remove_menu_pages() {

    $user_id = get_current_user_id();
    if (in_array($user_id, array(1))) { // Add Admin User ID's here
        remove_menu_page('edit-comments.php');
        remove_menu_page('edit.php');
    }
}

add_action( 'admin_menu', 'manager_remove_menu_pages', 9999 );

function manager_remove_menu_pages() {

    $user_id = get_current_user_id();
    if (in_array($user_id, array(3, 5))) { // Add Admin User ID's here
        remove_menu_page('edit-comments.php');
        remove_menu_page('edit.php');
        remove_menu_page('upload.php');
        remove_menu_page('profile.php');
        remove_menu_page('plugins.php');
        remove_menu_page('users.php');
        remove_menu_page('options-general.php');
        remove_menu_page('themes.php');
        remove_menu_page('tools.php');
        remove_menu_page('edit.php?post_type=acf');
        remove_menu_page('cpt_main_menu');
        remove_menu_page('eml-taxonomies-options');
        remove_menu_page('wpa_dashboard');
    }
}

add_action( 'admin_menu', 'register_menu_page' );

function register_menu_page(){
    add_menu_page( __( 'Webletter', 'text_domain' ), __( 'Webletter', 'text_domain' ), 'manage_options', 'webletter', 'redirect_url', 6 );
}

function redirect_url() {
    $redirect_url = get_bloginfo('url').'/wp-admin/admin.php?page=webletter';
    $pageURL = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    $external_redirect_url = 'http://enews.rockethouse.com.au';

    if ($pageURL == $redirect_url) {
        // header ('location:' + $external_redirect_url);
        wp_redirect( $external_redirect_url, 302 );
    }
}

add_action( 'admin_menu', 'redirect_url' );


function add_grav_forms(){
    $role = get_role('editor');
    $role->add_cap('gform_full_access');
}
add_action('admin_menu','add_grav_forms');



add_filter('gettext', 'rename_admin_menu_items');
add_filter('ngettext', 'rename_admin_menu_items');

function rename_admin_menu_items( $menu ) {
    $menu = str_ireplace( 'WooCommerce', 'Store', $menu );
    return $menu;
}


function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    $wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
    $wp_admin_bar->remove_menu('view-site');        // Remove the view site link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');      // Remove the content link
    $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
    //$wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );


// add_action( 'admin_head', 'disable_admin_hoverintent' );

// function disable_admin_hoverintent() {
//     wp_enqueue_script(
//         // Script handle
//         'disable-admin-hoverintent',
//         // Script URL
//         array( 'admin-bar', 'common' )
//     );
// }


/* ------------------------------------ *\
 | RocketHouse Custom Admin Theme Menu
\* ------------------------------------ */

/*add_action('admin_menu', 'rha_theme_menu_init', 10);
function rha_theme_menu_init() {
    add_menu_page("RocketPanel", "RocketPanel", "administrator", "rha-settings", "rha_theme_menu", plugin_dir_url( __FILE__ ).'/images/rockethouse_logo.png', 3);
}

function rha_theme_menu() {
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    if (!user_can($user_id, 'create_users'))
        return false;
    ?>
    <div class="wrap">
        <h2>RocketPanel</h2>

    </div>



    <?
}*/
/* ------------------------------------ *\
 | End Custom Theme Menu
\* ------------------------------------ */
?>