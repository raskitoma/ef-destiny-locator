<?php
/*
Plugin Name: EF-Destiny-Locator
Plugin URI: https://raskitoma.com
Description: A plugin to generate a Destiny Store Locator shortcode.
Version: 1.0
Author: Raskitoma
Author URI: https://raskitoma.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: ef-destiny-locator
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Register the shortcode
add_shortcode('ef_destiny_locator', 'ef_destiny_locator_shortcode');

// Function to handle the shortcode
function ef_destiny_locator_shortcode($atts) {
    // Retrieve stored settings
    $options = get_option('ef_destiny_locator_options');

    // Define default attribute values
    $atts = shortcode_atts(
        array(
            'id' => !empty($options['id']) ? $options['id'] : 'destini-locator-code',
            'class' => !empty($options['class']) ? $options['class'] : 'destini-locator-class',
            'data_locator_id' => !empty($options['data_locator_id']) ? $options['data_locator_id'] : '1234',
            'data_alpha_code' => !empty($options['data_alpha_code']) ? $options['data_alpha_code'] : '1234',
            'apo' => '1234567890', // This must be set in the shortcode
            'src' => !empty($options['src']) ? $options['src'] : 'https://lets.shop/productFirstSnippet.js',
        ),
        $atts,
        'ef_destiny_locator'
    );

    // Create the HTML output
    $output = '<div '
            . 'id="' . esc_attr($atts['id']) . '" '
            . 'class="' . esc_attr($atts['class']) . '" '
            . 'data-locator-id="' . esc_attr($atts['data_locator_id']) . '" '
            . 'data-alpha-code="' . esc_attr($atts['data_alpha_code']) . '" '
            . 'apo="' . esc_attr($atts['apo']) . '"'
            . '></div>'
            . '<script src="' . esc_url($atts['src']) . '" charset="utf-8"></script>';

    return $output;
}

// Add settings menu
add_action('admin_menu', 'ef_destiny_locator_add_admin_menu');
function ef_destiny_locator_add_admin_menu() {
    add_options_page(
        'EF Destiny Locator Settings',
        'EF Destiny Locator',
        'manage_options',
        'ef_destiny_locator',
        'ef_destiny_locator_options_page'
    );
}

// Register settings
add_action('admin_init', 'ef_destiny_locator_settings_init');
function ef_destiny_locator_settings_init() {
    register_setting('ef_destiny_locator', 'ef_destiny_locator_options');

    add_settings_section(
        'ef_destiny_locator_section',
        __('EF Destiny Locator Settings', 'ef_destiny_locator'),
        'ef_destiny_locator_settings_section_callback',
        'ef_destiny_locator'
    );

    add_settings_field(
        'ef_destiny_locator_id',
        __('ID', 'ef_destiny_locator'),
        'ef_destiny_locator_id_render',
        'ef_destiny_locator',
        'ef_destiny_locator_section'
    );

    add_settings_field(
        'ef_destiny_locator_class',
        __('Class', 'ef_destiny_locator'),
        'ef_destiny_locator_class_render',
        'ef_destiny_locator',
        'ef_destiny_locator_section'
    );

    add_settings_field(
        'ef_destiny_locator_data_locator_id',
        __('Data Locator ID', 'ef_destiny_locator'),
        'ef_destiny_locator_data_locator_id_render',
        'ef_destiny_locator',
        'ef_destiny_locator_section'
    );

    add_settings_field(
        'ef_destiny_locator_data_alpha_code',
        __('Data Alpha Code', 'ef_destiny_locator'),
        'ef_destiny_locator_data_alpha_code_render',
        'ef_destiny_locator',
        'ef_destiny_locator_section'
    );

    add_settings_field(
        'ef_destiny_locator_src',
        __('Script Source URL', 'ef_destiny_locator'),
        'ef_destiny_locator_src_render',
        'ef_destiny_locator',
        'ef_destiny_locator_section'
    );
}

// Render settings fields
function ef_destiny_locator_id_render() {
    $options = get_option('ef_destiny_locator_options');
    ?>
    <input type='text' name='ef_destiny_locator_options[id]' value='<?php echo esc_attr($options['id'] ?? ''); ?>'>
    <?php
}

function ef_destiny_locator_class_render() {
    $options = get_option('ef_destiny_locator_options');
    ?>
    <input type='text' name='ef_destiny_locator_options[class]' value='<?php echo esc_attr($options['class'] ?? ''); ?>'>
    <?php
}

function ef_destiny_locator_data_locator_id_render() {
    $options = get_option('ef_destiny_locator_options');
    ?>
    <input type='text' name='ef_destiny_locator_options[data_locator_id]' value='<?php echo esc_attr($options['data_locator_id'] ?? ''); ?>'>
    <?php
}

function ef_destiny_locator_data_alpha_code_render() {
    $options = get_option('ef_destiny_locator_options');
    ?>
    <input type='text' name='ef_destiny_locator_options[data_alpha_code]' value='<?php echo esc_attr($options['data_alpha_code'] ?? ''); ?>'>
    <?php
}

function ef_destiny_locator_src_render() {
    $options = get_option('ef_destiny_locator_options');
    ?>
    <input type='text' name='ef_destiny_locator_options[src]' value='<?php echo esc_attr($options['src'] ?? ''); ?>'>
    <?php
}

function ef_destiny_locator_settings_section_callback() {
    echo __('Set default values for the EF Destiny Locator shortcode.', 'ef_destiny_locator');
}

// Settings page HTML
function ef_destiny_locator_options_page() {
    ?>
    <form action='options.php' method='post'>
        <?php
        settings_fields('ef_destiny_locator');
        do_settings_sections('ef_destiny_locator');
        submit_button();
        ?>
    </form>
    <?php
}
