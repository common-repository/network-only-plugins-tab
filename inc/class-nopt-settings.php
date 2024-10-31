<?php
/**
 * Settings Class 
 * 
 * @plugin Network Only Plugins Tab
 */

# Busted!
!defined( 'ABSPATH' ) AND exit(
        "<pre>Hi there! I'm just part of a plugin, 
            <h1>&iquest;what exactly are you looking for?" );

class B5F_NOPT_Settings
{
    /**
     * Plugin settings name
     * @var string
     */
    public $option_name = 'network_only_plugins_tab_settings';
    
    
    /**
     * Plugin settings value
     * @var array
     */
    private $option_value;

    
    /** 
     * Controls the visibility of "Settings Updated"
     * 
     * @var boolean
     */
    private $posted_data;
    
    /**
     *
     * @see plugin_setup()
     * @wp-hook plugins_loaded
     * @return  void
     */
    public function __construct()
    {
        $this->check_posted_data();
        $this->get_options();
        
        add_action(
            'after_plugin_row_' . B5F_MNPT_FILE, 
            array( $this, 'add_config_form' ), 
            10, 3
        );

        add_action( 'admin_print_scripts-plugins.php', array( $this, 'enqueue' ) );
    }


    /**
     * Check for $_POSTed data and update settings
     * 
     * @return void
     */
    public function check_posted_data()
    {
        $this->posted_data = false;
        if( !isset( $_POST['noncename_nopt'] ) )
            return;
        
        if( wp_verify_nonce( $_POST['noncename_nopt'], plugin_basename( B5F_MNPT_FILE ) ) )
        {
            $this->option_value = $this->get_options();

            if ( isset($_POST['nopt_config-icon']) )
                $this->option_value['icon'] = esc_html( $_POST['nopt_config-icon'] );

            $this->set_options();
            $this->posted_data = true;
        }
    }
    
    
    /**
     * Style and Scripts
     */
    public function enqueue()
    {
        wp_enqueue_style(
            'nopt-style', 
            plugin_dir_url( B5F_MNPT_FILE ) . 'css/network-only-style.css'
        );
        
        # FONT AWESOME
        wp_enqueue_style(
            'font-awesome',
            plugin_dir_url( B5F_MNPT_FILE ) . 'css/font-awesome.min.css'
        );
        
        wp_register_script(
            'nopt-js',
            plugin_dir_url( B5F_MNPT_FILE ) . 'js/network-only-script.js',
            array(),
            '',
            TRUE
        );
        wp_enqueue_script( 'nopt-js' );
        wp_localize_script(
            'nopt-js',
            'nopt_ajax_vars', 
            array(
                'ajaxurl'   => admin_url( 'admin-ajax.php' ),
                '_nonce'    => wp_create_nonce( 'nopt-nonce' ),
                'open_btn'  => __( 'Open settings', 'b5f_nopt' ),
                'close_btn' => __( 'Close settings', 'b5f_nopt' ),
            )
        );
    }
    
    
    /**
     * Prints the settings form
     * 
     * @param   $wm_pluginfile Object
     * @param   $wm_plugindata Object (array)
     * @param   $wm_context    Object (all, active, inactive)
     * @return  void
     * @wp-hook after_plugin_row
     */
    public function add_config_form( $wm_pluginfile, $wm_plugindata, $wm_context )
    {
        $value = $this->get_options();        
        $config_row_class = 'config_hidden'; 
        require_once 'html-settings.php';
    }

    
    /**
     * Return the options, check for install and active on WP multisite
     * 
     * @return  array $values
     */
    public function get_options() 
    {
        return get_site_option( $this->option_name );
    }

    
    /**
     * Return the options, check for install and active on WP multisite
     * 
     * @return  array $values
     */
    private function set_options() 
    {
        update_site_option( $this->option_name, $this->option_value );
    }

   
    /**
     * Function to escape strings
     * Use WP default, if exists
     * - I don't know why it doesn't exist, 
     * - - but may be related to that require /wp-includes above
     * 
     * @param  String
     * @return String
     */
    private function esc_attr( $text ) {

        if ( function_exists('esc_attr') )
            $text = esc_attr($text);
        else
            $text = attribute_escape($text);

        return $text;
    }
}