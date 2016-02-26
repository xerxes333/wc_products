<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://triple3studios.com
 * @since      1.0.0
 *
 * @package    Wc_products
 * @subpackage Wc_products/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_products
 * @subpackage Wc_products/admin
 * @author     Jeremy <JDraxler@gmail.com>
 */
class Wc_products_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
    
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    /**
     * Custom Post type name
     * @since    1.0.0
     * @access   private
     * @var      string    $post_type_name    The name of the custom post type
     */
    private $post_type_name = "wc_product";
    
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_products_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_products_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc_products-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_products_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_products_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc_products-admin.js', array( 'jquery' ), $this->version, false );

	}
    
    /**
     * Register the custom post type
     *
     * @since    1.0.0
     */
    public function wc_products_create_product_post_type(){
        register_post_type( $this->post_type_name,
            array(
                'labels' => array(
                    'name'          => __( 'Products' ),
                    'singular_name' => __( 'Product' ),
                    'edit_item'     => __( 'Edit Product' ),
                    'add_new_item'  => __( 'Add New Product' )
                ),
                'hierarchical'          => false,
                'public'                => false,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 100,
                'menu_icon'             => 'dashicons-cart',
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => false,        
                'exclude_from_search'   => false,
                'publicly_queryable'    => false,
                'capability_type'       => 'post',
                'taxonomies'            => array(''),
                'supports'              => array('title', 'editor'), //custom-fields
                
            )
        );
    }

    /**
     * Register the DiffBot meta box for products.
     *
     * @since    1.0.0
     */
    public function wc_products_my_admin(){
        add_meta_box(
            $this->plugin_name.'_api_meta_box',
            'Diffbot Search',
            array($this, $this->plugin_name.'_api_meta_box'),
            $this->post_type_name, 
            'normal', 
            'high'
        );
    }
    
    /**
     * Render the DiffBot meta box for a product.
     *
     * @since    1.0.0
     */
    public function wc_products_api_meta_box($product){
        $token          = get_option( $this->plugin_name . '_token' );
        $offerPrice     = get_post_meta($product->ID, $this->plugin_name.'_offerPrice', true);
        $regularPrice   = get_post_meta($product->ID, $this->plugin_name.'_regularPrice', true);
        $pageUrl        = get_post_meta($product->ID, $this->plugin_name.'_pageUrl', true);
        $optionsLink    = admin_url( 'options-general.php?page=' .$this->plugin_name );
        include_once 'partials/wc_products-api-meta-box.php';
    }

    /**
     * Save product post meta data.
     * 
     * Saves the product data offerPrice, regularPrice, and PageUrl retrieved from DiffBot
     * if the values exist and are not empty. The product title and description are saved
     * as the post_title and post_content.
     *
     * @since    1.0.0
     */
    public function wc_products_add_product_fields( $product_id, $product ) {
        
        if ( isset( $_POST[$this->plugin_name.'_offerPrice_input'] ) ) {
            $this->wc_products_update_meta_data( $product_id, $this->plugin_name.'_offerPrice', $_POST[$this->plugin_name.'_offerPrice_input'] );
        }
        
        if ( isset( $_POST[$this->plugin_name.'_regularPrice_input'] ) ) {
            $this->wc_products_update_meta_data( $product_id, $this->plugin_name.'_regularPrice', $_POST[$this->plugin_name.'_regularPrice_input'] );
        }
        
        if ( isset( $_POST[$this->plugin_name.'_pageUrl_input'] ) ) {
            $this->wc_products_update_meta_data( $product_id, $this->plugin_name.'_pageUrl', $_POST[$this->plugin_name.'_pageUrl_input'] );
        }
        
    }
    
    /**
     * Adding Product Settings to the admin menu.
     *
     * @since    1.0.0
     */
    public function wc_products_add_options_page() {
    
        $this->plugin_screen_hook_suffix = add_options_page(
            __( 'Products Settings', $this->plugin_name ),
            __( 'Product Settings', $this->plugin_name ),
            'manage_options',
            $this->plugin_name,
            array( $this, $this->plugin_name.'_display_options_page' )
        );
    
    }
    
    /**
     * Render Product Settings page.
     *
     * @since    1.0.0
     */
    public function wc_products_display_options_page() {
        include_once 'partials/wc_products-admin-display.php';
    }
    
    
    /**
     * Register product settings for DiffBot API token.
     *
     * @since    1.0.0
     */
    public function wc_products_register_setting() {
        add_settings_section(
            $this->plugin_name . '_general',
            '',
            array( $this, $this->plugin_name . '_general_cb' ),
            $this->plugin_name
        );
        
        add_settings_field(
            $this->plugin_name . '_token',
            __( 'Diffbot API Token', $this->plugin_name ),
            array( $this, $this->plugin_name . '_token_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_general',
            array( 'label_for' => $this->plugin_name . '_token' )
        );
        
        register_setting( 
            $this->plugin_name, 
            $this->plugin_name . '_token', 
            array( $this, $this->plugin_name . '_validate_input_token_cb' )
            
        );
    }
    
    /**
     * Render settings section
     *
     * @since    1.0.0
     */
    public function wc_products_general_cb() {
        echo '<p>' . __( 'Please supply the Diffbot API token.', $this->plugin_name ) . '</p>';
    }

    /**
     * Render settings token input
     *
     * @since    1.0.0
     */
    public function wc_products_token_cb() {
        $token = get_option( $this->plugin_name . '_token' );
        echo '<input type="text" name="' . $this->plugin_name . '_token' . '" id="' . $this->plugin_name . '_token' . '" value="' . sanitize_text_field($token) . '" size="30"> ';
    }
    
    /**
     * Validate the Diffbot API token.
     * 
     * Check the user supplied API token to make sure it only uses 
     * numbers, lowercase letters and is exactly 32 characters in length.
     * These conditions are assumptions made by me about how the DiffBot
     * API tokens are generated.  Before deploying to a production 
     * environment, token format should be discussed with DiffBot support.
     * 
     * @since   1.0.0
     * @param   string  $input  API Token
     * 
     * @return Call to apply_filters function to apply any other possible filters.
     */
    public function wc_products_validate_input_token_cb($input){
        
        if( preg_match("/^[a-z0-9]+/", $input) == 1 && strlen($input) == 32 ) {
            $return = $input;
        } else {
            
            $return = get_option( $this->plugin_name . '_token', '' );
            
            add_settings_error(
                'invalid_wc_products_token',
                '',
                'DiffBot API Token may only contain numbers, lowercase letters, and must be 32 characters in length.',
                'error'
            );
            
        }
        
        return apply_filters( 'wc_products_validate_input_token_cb', $return, $input );
    }
    
    /**
     * Updates or delete product meta 
     * 
     * Utility method to update a product meta_value or remove the record
     * to keep clutter out the table. 
     * 
     * @since   1.0.0
     * @param   string  $product_id     Product post_id value
     * @param   string  $meta_name      Post meta meta_key
     * @param   string  $meta_value     Post meta meta_value
     * 
     */
    private function wc_products_update_meta_data($product_id, $meta_name, $meta_value){
        
         if( empty($meta_value) ) {
            delete_post_meta( $product_id, $meta_name );
        } else {
            update_post_meta( $product_id, $meta_name, $meta_value );
        }
        
    }
}
