<?php
/**
 * 
* Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @package    cc-seo
 * @subpackage cc-seo/admin
 * @authors chie (liqianhui0522@163.com)
 * @date    2021-12-16 16:49:31
 * @version $Id$
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="post">
        <?php
            // output security fields for the registered setting "wporg_options"
            settings_fields( 'cc_seo' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( 'cc_seo' );
            // output save settings button
            submit_button( __( 'Save Settings', 'textdomain' ) );
        ?>
    </form>
</div>