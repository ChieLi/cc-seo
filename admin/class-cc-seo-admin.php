<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 * 
 * @package    cc-seo
 * @subpackage cc-seo/admin
 * @authors chie (liqianhui0522@163.com)
 * @date    2021-12-15 21:50:31
 */

class CC_SEO_Admin {

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
         * defined in CC_SEO_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The CC_SEO_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cc-seo-admin.css', array(), $this->version, 'all' );

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
         * defined in CC_SEO_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The CC_SEO_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cc-seo-admin.js', array( 'jquery' ), $this->version, false );

    }

    public function cc_seo_options_page() {
        add_menu_page(
            'CC-SEO',
            __( 'CC-SEO Options', 'cc-seo'),
            'manage_options',
            plugin_dir_path(__FILE__) . 'partials/cc-seo-admin-display.php'
        );
    }

    public function cc_seo_settings_init() {
        register_setting( 'cc_seo', 'cc_seo_options');

        add_settings_section(
            'cc_seo_section_image', 
            __( 'image', 'cc-seo'),
            array( $this, 'cc_seo_section_image_callback'),
            'cc_seo'
        );

        add_settings_field(
            // $id
            'cc_seo_field_image_diable_dragging',
            // $title
            __( 'disable dragging', 'cc-seo'),
            // $callback
            array( $this, 'cc_seo_field_checkbox_callback'),
            // $page
            'cc_seo',
            // $section
            'cc_seo_section_image',
            // $args
            // (array) (Optional) Extra arguments used when outputting the field.
            array(
                'label_for' => 'cc_seo_field_image_diable_dragging',
                'class'     => 'cc_seo_options_row',
                'description' => __( 'If checked, the html element img will be added attribute draggable=false.', 'cc-seo' ) 
            )
        );

        add_settings_section(
            'cc_seo_section_url', 
            __( 'URL', 'cc-seo'),
            array( $this, 'cc_seo_section_url_callback'),
            'cc_seo'
        );

        add_settings_field(
            // $id
            'cc_seo_field_search_page_slug',
            // $title
            __( 'search page slug', 'cc-seo'),
            // $callback
            array( $this, 'cc_seo_field_text_callback'),
            // $page
            'cc_seo',
            // $section
            'cc_seo_section_url',
            // $args
            // (array) (Optional) Extra arguments used when outputting the field.
            array(
                'label_for' => 'cc_seo_field_search_page_slug',
                'class'     => 'cc_seo_options_row',
                'description' => __( 'If set, the search url structure(home_url/?s=search-term)will set to structure(home_url/($search_page_slug)/search-term)', 'cc-seo' ) 
            )
        );

    }

    public function cc_seo_image_content_filter( $content ) {
        global $post;
        $options = get_option( 'cc_seo_options' );

        if (isset( $options['cc_seo_field_image_diable_dragging'] ) && $options['cc_seo_field_image_diable_dragging'] == 1) {
            
            $pattern ="/<img(.*?)src=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
            $replacement = '<img$1src=$2$3.$4$5 draggable="false">';
            $content = preg_replace($pattern, $replacement, $content);
       }
       return $content;
    }

    public function cc_seo_dynamic_urls_to_static_urls( $content) {
        
        if ( is_search() && ! empty( $_GET['s'] ) ) {

            $options = get_option( 'cc_seo_options' );
            $search_page_slug = $options['cc_seo_field_search_page_slug'];
            if ( isset( $search_page_slug ) && ! empty( $search_page_slug ) ) {
                wp_redirect( home_url( '/'. $search_page_slug .'/' ) . urlencode( get_query_var( 's' ) ) ) ;
                exit();
            }
        }  
    }


    function cc_seo_section_image_callback( $args ) {
        ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Setiing options abount html img element.', 'cc-seo' ); ?></p>
        <?php
    }

    function cc_seo_section_url_callback( $args ) {
        ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Setiing options abount url.', 'cc-seo' ); ?></p>
        <?php
    }


    function cc_seo_field_checkbox_callback( $args ) {
        $options = get_option( 'cc_seo_options' );
        ?>
        <input id="<?php echo esc_attr( $args['id'] ); ?>"
            type="checkbox" 
            name="cc_seo_options[<?php echo esc_attr( $args['label_for'] ); ?>]" 
            value="1"  <?php checked( 1, isset( $options[ $args['label_for'] ] ) && $options[ $args['label_for'] ]); ?>
            >
        <lable for="cc_seo_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
            <?php echo esc_attr( $args['description'] ) ?>
        </lable>
        <?php
    }

    function cc_seo_field_text_callback( $args ) {
        $options = get_option( 'cc_seo_options' );
        ?>
        <input id="<?php echo esc_attr( $args['id'] ); ?>"
            type="text" 
            name="cc_seo_options[<?php echo esc_attr( $args['label_for'] ); ?>]" 
            value="<?php echo isset( $options[ $args['label_for'] ] ) ? esc_attr( $options[ $args['label_for'] ] ) : ''; ?>"
            >
        <p>
            <lable for="cc_seo_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
                <?php echo esc_attr( $args['description'] ) ?>
            </lable>
        </p>
        <?php
    }

}