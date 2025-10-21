<?php

/*
* Plugin Name: Ads Landing Pages
* Plugin URI: https://jasonmarshall.dev
* Description: A Landing page plugin with conversion focused templates.
* Version: 1.0.0
* Requires at least: 5.2
* Requires PHP: 7.2
* Author: Jason Marshall
* Author URI: https://jasonmarshall.dev
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


class ADSLandingPagesPlugin
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'adminPage'));
        add_action('admin_init', array($this, 'settings'));
    }

    function settings()
    {
        add_settings_section('alp_settings_section', 'Setup', null, 'alp-settings-page');
        add_settings_section('alp_styles_section', 'Styles', null, 'alp-settings-page');

        add_settings_field('alp_template', 'Landing Page Template', array($this, 'templateHTML'), 'alp-settings-page', 'alp_settings_section');
        register_setting('adslandingpagesplugin', 'alp_template', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default' => '0',
        ));

        add_settings_field('alp_slug_prefix', 'Customize Slug Prefix', array($this, 'slugPrefixHTML'), 'alp-settings-page', 'alp_settings_section');
        register_setting('adslandingpagesplugin', 'alp_slug_prefix', array(
            'sanitize_callback' => 'sanitize_title',
            'default' => 'lp',
        ));

        add_settings_field('alp_header', 'Include Site Header', array($this, 'checkboxHTML'), 'alp-settings-page', 'alp_settings_section', array('theName' => 'alp_header'));
        register_setting('adslandingpagesplugin', 'alp_header', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default' => '1',
        ));

        add_settings_field('alp_footer', 'Include Site Footer', array($this, 'checkboxHTML'), 'alp-settings-page', 'alp_settings_section', array('theName' => 'alp_footer'));
        register_setting('adslandingpagesplugin', 'alp_footer', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default' => '1',
        ));

        add_settings_field('alp_primary_color', 'Primary Color', array($this, 'primaryColorHTML'), 'alp-settings-page', 'alp_styles_section');
        register_setting('adslandingpagesplugin', 'alp_primary_color', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default' => '#ffffff',
        ));

        add_settings_field('alp_secondary_color', 'Secondary Color', array($this, 'secondaryColorHTML'), 'alp-settings-page', 'alp_styles_section');
        register_setting('adslandingpagesplugin', 'alp_secondary_color', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default' => '#000000',
        ));
    }

    function templateHTML()
    { ?>
        <select name="alp_template">
            <option value="0" <?php selected(get_option('alp_template'), '0') ?>>Template 1</option>
            <option value="1" <?php selected(get_option('alp_template'), '1') ?>>Template 2</option>
            <option value="2" <?php selected(get_option('alp_template'), '2') ?>>Template 3</option>
        </select>
    <?php
    }

    function slugPrefixHTML()
    { ?>
        <input type="text" name="alp_slug_prefix" value="<?php echo esc_attr(get_option('alp_slug_prefix')); ?>" />
    <?php
    }

    // Reusable checkbox HTML function
    function checkboxHTML($args)
    { ?>
        <input type="checkbox" name="<?php echo $args['theName'] ?>" value="1" <?php checked(get_option($args['theName']), '1') ?> />
    <?php
    }

    function primaryColorHTML()
    { ?>
        <input type="text" name="alp_primary_color" value="<?php echo esc_attr(get_option('alp_primary_color')); ?>" />
    <?php
    }

    function secondaryColorHTML()
    { ?>
        <input type="text" name="alp_secondary_color" value="<?php echo esc_attr(get_option('alp_secondary_color')); ?>" />
    <?php
    }

    function adminPage()
    {
        add_options_page(
            'Landing Page Settings',
            'Landing Pages',
            'manage_options',
            'alp-settings-page',
            array($this, 'adminHTML'),
        );
    }

    function adminHTML()
    { ?>
        <div class="wrap">
            <h1>Landing Page Settings</h1>
            <form action="options.php" method="POST">
                <?php
                settings_fields('adslandingpagesplugin');
                do_settings_sections('alp-settings-page');
                submit_button();
                ?>
            </form>
        </div>
<?php
    }
}

$adsLandingPagesPlugin = new ADSLandingPagesPlugin();
