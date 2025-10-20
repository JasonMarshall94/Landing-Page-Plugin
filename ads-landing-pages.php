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
        add_settings_section('alp_settings_section', null, null, 'alp-settings-page');
        add_settings_field('alp_template', 'Landing Page Template', array($this, 'templateHTML'), 'alp-settings-page', 'alp_settings_section');
        register_setting('adslandingpagesplugin', 'alp_template', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default' => '0',
        ));
    }

    function templateHTML()
    { ?>
        <select name="alp_template">
            <option value="0">Template 1</option>
            <option value="1">Template 2</option>
            <option value="2">Template 3</option>
        </select>
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
