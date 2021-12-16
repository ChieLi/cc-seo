<?php
/**
 * 
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @package    cc-seo
 * @subpackage cc-seo/includes
 * @authors chie (liqianhui0522@163.com)
 * @date    2021-12-15 22:56:23
 * @version $Id$
 */

class CC_SEO_i18n {


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            'cc-seo',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );

    }



}