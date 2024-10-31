<?php
/**
 * Main class
 * 
 * @plugin Network Only Plugins Tab
 * 
 */

# Busted!
!defined( 'ABSPATH' ) AND exit(
        "<pre>Hi there! I'm just part of a plugin, 
            <h1>&iquest;what exactly are you looking for?" );

class B5F_Network_Only_Plugins_Tab
{
	/**
	 * Plugin instance.
	 * @type object
	 */
	protected static $instance = NULL;

    
	/**
	 * URL to this plugin's directory.
	 * @type string
	 */
	public $plugin_url;

    
	/**
	 * Path to this plugin's directory.
	 * @type string
	 */
	public $plugin_path;
    
    
	/**
	 * Total number of plugins to jQuery fix.
	 * @type string
	 */
	public $all_count;
    
    
	/**
	 * Number of Network-only plugins
	 * @type integer
	 */
    private $networked_count;
	
    
    /**
     * Hold the plugin settings from SettingsClass
     * @var array
     */
    private $options;
    
    
    /**
	 * Constructor. Intentionally left empty and public.
	 *
	 * @see plugin_setup()
	 * @since 2012.09.12
	 */
	public function __construct() {}
		

	/**
	 * Access this plugin's working instance.
	 *
	 * @wp-hook plugins_loaded
	 * @since   2012.09.13
	 * @return  object of this class
	 */
	public static function get_instance()
	{
		NULL === self::$instance and self::$instance = new self;
		return self::$instance;
	}

    
	/**
	 * Plugin starts working
	 *
	 * @wp-hook plugins_loaded
	 * @return  void
	 */
	public function plugin_setup()
	{
        global $pagenow;
        if( 'plugins.php' != $pagenow )
            return;
        
        # Plugin settings
        include_once __DIR__ . '/class-nopt-settings.php';
        $settings = new B5F_NOPT_Settings();
        
		$this->plugin_url    = plugins_url( '/', dirname( __FILE__ ) );
		$this->plugin_path   = plugin_dir_path( dirname( __FILE__ ) );
        $this->load_language( 'b5f_nopt' );
        
        # Get plugin options
        $this->options = $settings->get_options();
        
        $translate_title = __( 'Network Only Plugins Tab', 'b5f_nopt' );
        $translate_desc = __( 'List only plugins that are exclusive for Networks', 'b5f_nopt' );
        
		add_filter( 'views_plugins-network', array( $this, 'add_tab_link' ) );
        add_action( 'load-plugins.php', array( $this, 'filter_network_only' ) );
		add_action( 'network_admin_plugin_action_links', array( $this, 'add_plugin_icon' ), 10, 4 );
   }


	/**
	 * Each plugin row action links. Check if active is any site. If so, mark it.
	 *
	 * @wp-hook network_admin_plugin_action_links
	 * @return array
	 */
	public function add_plugin_icon( $actions, $plugin_file, $plugin_data, $context )
	{
        $our_screen = isset( $_GET['plugin_status'] ) 
            && 'network_only' == $_GET['plugin_status'] ;
        
        if( !$plugin_data['Network'] || $our_screen )
            return $actions;
        
        $in = !empty( $this->options['icon'] )
            ? $this->strip_slashes_recursive( $this->options['icon'] ) : '&#xf0e8;';
        $in = '<span title="'. __( 'Network only', 'b5f_nopt' ) . '" class="nopt-icon">' . $in . '</span>';

        array_unshift( $actions, $in );
		return $actions;
	}

    
    /**
     * 
	 * Add links to the row All|Active|Inactive|etc
     * 
     * @wp-hook views_plugins
	 */
	public function add_tab_link( $tabs )
	{
        $count = !empty( $this->networked_count ) ? ' ('.$this->networked_count.')' : '';
		$tabs['network_only'] = sprintf(
            '<a href="%s">%s%s</a>',
            network_admin_url( 'plugins.php?plugin_status=network_only' ),
            __( 'Network only', 'b5f_nopt' ),
            $count
        );
		return $tabs;
	}


    /**
     * Add hooks in our screen
     * 
     * @wp-hook load-plugins.php
     */
    public function filter_network_only()
    {
        add_filter( 'all_plugins', array( $this, 'filter_and_count_plugins' ) );
        add_filter( 'plugin_row_meta', array( $this, 'donate_link' ), 10, 4 );
        if( 
            isset( $_GET['plugin_status'] ) 
            && 'network_only' == $_GET['plugin_status'] 
            )
            add_action( 'admin_footer', array( $this, 'fix_css' ) );
    }
    
    
    /**
     * jQuery fix for Current tab
     */
    public function fix_css()
    {
        $total = '(' . $this->all_count . ')';
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {   
                $('li.all a').removeClass('current');
                $('li.network_only a').addClass('current');
                $('li.all .count').text('<?php echo $total; ?>');
                console.log('<?php echo $total; ?>');
            });             
        </script>
        <?php
    }


   /**
    * Filter the list of plugins according to user_login
    *
    * @return array List of plugins
    */
   public function filter_and_count_plugins( $plugins )
   {
       $this->all_count = count( $plugins );
       $count = 0;
       foreach ( $plugins as $name => $data ) 
       { 
           if( !$data['Network'] ) 
           {
               # It's our screen, unset unrelated plugins
               if( 
                   isset( $_GET['plugin_status'] ) 
                   && 'network_only' == $_GET['plugin_status'] 
                   )
                    unset( $plugins[ $name ] );
           }
           # All screens, make the count
           else
               $count++;
       }
       $this->networked_count = $count;
       return $plugins;
   }

   
    /**
     * Add donate link to plugin description in /wp-admin/plugins.php
     * 
     * @param array $plugin_meta
     * @param string $plugin_file
     * @param string $plugin_data
     * @param string $status
     * @return array
     */
    public function donate_link( $plugin_meta, $plugin_file, $plugin_data, $status ) 
	{
        $icon = !empty( $this->options['icon'] )
            ? $this->strip_slashes_recursive( $this->options['icon'] ) : '&#xf0e8;';

		if( B5F_MNPT_FILE == $plugin_file )
			$plugin_meta[] = sprintf(
                '<span  class="nopt-icon">%s</span> <a href="%s">%s</a>',
                $icon,
                'https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=JNJXKWBYM9JP6&lc=US&item_name=Rodolfo%20Buaiz&item_number=Network%20Only%20Plugins%20Tab&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted',
                __( 'Buy me a beer', 'b5f_nopt' )
            );
		return $plugin_meta;
	}


    /**
	 * Loads translation file.
	 *
	 * Accessible to other classes to load different language files (admin and
	 * front-end for example).
	 *
	 * @wp-hook init
	 * @param   string $domain
	 * @since   2012.09.11
	 * @return  void
	 */
	public function load_language( $domain )
	{
        $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
        $plugin_filename = '/' . basename( B5F_MNPT_FILE, '.php' ) . '/';
        
        load_textdomain(
            $domain, 
            WP_LANG_DIR . $plugin_filename . $domain . '-' . $locale . '.mo'
        );

		load_plugin_textdomain(
			$domain,
			FALSE,
			$this->plugin_path . '/languages'
		);
	}
    
    /**
     * Prepares text output
     * 
     * @param string $str
     * @return string
     */
    private function strip_slashes_recursive( $str )
    {
        $str = html_entity_decode( stripslashes($str) );
        return $str;
    }

}