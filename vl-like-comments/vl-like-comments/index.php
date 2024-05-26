<?php
/**
* Plugin Name: VL Like Comment Info Plugin
* Description: A Custom Plugin for VL Posts Like Comments Info
* call login files */

    

    // Login Hook
    include plugin_dir_path( __FILE__ ) . 'plugin-files/plugin-like-hook.php';
    include plugin_dir_path( __FILE__ ) . 'plugin-files/plugin-remove-like-hook.php';
    include plugin_dir_path( __FILE__ ) . 'plugin-files/plugin-comment-hook.php';

    // calling style function 
    function vl_plugin_like_comment_style() {
        wp_enqueue_style('vl-plugin-like-comment-main-style', plugin_dir_url( __FILE__ )  . "/style.css", array(), '1.0.0', 'all');
    }
    add_action('wp_enqueue_scripts', 'vl_plugin_like_comment_style');

    function enqueue_plugin_files() {

        // enqueue JS
        wp_enqueue_script('vl-like-comment-info', plugin_dir_url( __FILE__ ) . "plugin-files/plugin-info.js", array('jquery'), '',true); 


        // Admin Ajax Global Flags
        wp_localize_script('vl-like-comment-info', 'global_vars', array(
            'adminURL' => admin_url('admin-ajax.php'),
            'siteURL' => get_site_url(),
            //'checkUserSuccess',
            //'checkEmailSuccess',
            //'wpCreateUserResponed',
            //'userNameOperatorInput',
        ));
    
    }
    add_action( 'wp_enqueue_scripts', 'enqueue_plugin_files');
    
    
    /* creating shortcode for plugin */
    function shortcode_likeCommentPlugin() {
        //var_dump("iam here");

        function plugin_like_comment_view_shortcode() { 
            include plugin_dir_path( __FILE__ ) . 'plugin-files/view.php';
        } 
        // shortcode
        add_shortcode('plugin_like_comment_hook_shortcode', 'plugin_like_comment_view_shortcode'); 
    }
    add_action('init', 'shortcode_likeCommentPlugin');
?>