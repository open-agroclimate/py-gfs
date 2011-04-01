<?php
/*
 * Plugin Name: Paraguay GFS Forecast
 * Version: 1.0
 * Plugin URI: http://open.agroclimate.org/downloads/
 * Description: The GFS Forecast for Paraguay, provided by NOAA
 * Author: The Open AgroClimate Project
 * Author URI: http://open.agroclimate.org/
 * License: BSD Modified
 */

class PYGFS {
    private static $location_scope = null;
    private static $plugin_url = '';

    public static function initialize() {
        OACBase::init();
        $plugin_dir = basename( dirname( __FILE__ ) );
        load_plugin_textdomain( 'py_gfs', null, $plugin_dir . '/languages' );
    }


    public static function ui_panel()    {
        $output  = '<div id="pygfs-ui-container" class="oac-ui-container">';
        $output .= '<div id="oac-user-input-panel" class="oac-user-input">';
        $output .= '<div id="forecast-container"><label for="forecast">'.__( 'Select Forecast', 'py_gfs' ).'</label>';
        $output .= '<select id="forecast" name="forecast" class="oac-input oac-select">';
        $output .= '<option value="1">'.__( 'Week 1', 'py_gfs' ).'</option>';
        $output .= '<option value="2">'.__( 'Week 2', 'py_gfs' ).'</option>';
        $output .= '</select></div>';
        $output .= '<div id="type-container"><label for="type">'.__( 'Forecast Type', 'py_gfs' ).'</label>';
        $output .= '<select id="type" name="type" class="oac-input oac-select">';
        $output .= '<option value="a">'.__( 'Total', 'py_gfs' ).'</option>';
        $output .= '<option value="b">'.__( 'Anomaly', 'py_gfs' ).'</option>';
        $output .= '</select>';
        $output .= '</div></div>';
        $output .= '<div id="oac-output-panel" class="oac-output" style="padding-top: 10px;">';
        $output .= '</div><div style="clear:both;"></div></div>';
        return $output;
    }
    
    public static function output() {
        $output = self::ui_panel();
        return $output;
    }

    public static function hijack_header() {
        global $post;
        global $is_IE;
        $regex = get_shortcode_regex();
        preg_match('/'.$regex.'/s', $post->post_content, $matches);
        if ((isset( $matches[2])) && ($matches[2] == 'py_gfs')) {
            //wp_enqueue_style( 'pygfs', plugins_url( 'css/py-gfs.css', __FILE__ ), array( 'oacbase' ) );
            wp_enqueue_style( 'oacbase' );
            wp_register_script( 'py_gfs', plugins_url( 'js/py-gfs.js', __FILE__ ),
                array( 'mootools' )
            );
            wp_enqueue_script( 'py_gfs' );
            add_action( 'wp_head', array( 'OACBase', 'ie_conditionals' ), 3 );
        }
    }
}

// WordPress Hooks and Actions
if( !is_admin()) {
    // Add front-end specific actions/hooks here
    add_action( 'init', array( 'PYGFS', 'initialize' ) );
    add_action( 'template_redirect', array( 'PYGFS', 'hijack_header' ) );
    add_shortcode('py_gfs', array( 'PYGFS', 'output' ) );
}
?>
