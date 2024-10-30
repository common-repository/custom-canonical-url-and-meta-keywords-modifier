<?php
/*
Plugin Name: Custom Canonical URL and Meta Keywords Modifier
Plugin URI: https://ditotaro.wordpress.com
Description: Allows users to modify the canonical URL and meta keywords in the Quick Edit interface.
Version: 1.0.0
Author: Claudio Di Totaro
Author URI: https://ditotaro.wordpress.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) )
	 exit; // Exit if accessed directly



class Custom_Canonical_Keywords_Modifier {
    public function __construct() {
        // Add the custom columns
        add_filter('manage_posts_columns', array($this, 'ccuamkm_add_custom_columns'));
        add_filter('manage_pages_columns', array($this, 'ccuamkm_add_custom_columns'));

        // Render the custom column content
        add_action('manage_posts_custom_column', array($this, 'ccuamkm_manage_custom_column'), 10, 2);
        add_action('manage_pages_custom_column', array($this, 'ccuamkm_manage_custom_column'), 10, 2);

        // Add Quick Edit fields
        add_action('quick_edit_custom_box', array($this, 'ccuamkm_quick_edit_custom_box'), 10, 2);

        // Save Quick Edit data
        add_action('save_post', array($this, 'ccuamkm_save_quick_edit_data'));

        // Enqueue scripts
        add_action('admin_enqueue_scripts', array($this, 'ccuamkm_enqueue_scripts'));

        // Modify canonical tag and keywords output
        remove_action('wp_head', 'rel_canonical');
        add_action('wp_head', array($this, 'ccuamkm_output_custom_meta'));
    }

    // Add custom columns to the posts/pages list
    public function ccuamkm_add_custom_columns($columns) {
        $columns['custom_canonical_url'] = 'Canonical URL';
        $columns['custom_meta_keywords'] = 'Meta Keywords';
        return $columns;
    }

    // Display the custom canonical URL and meta keywords in the custom column
    public function ccuamkm_manage_custom_column($column_name, $post_id) {
        if ($column_name == 'custom_canonical_url') {
            $canonical_url = get_post_meta($post_id, 'ccuamkm_custom_canonical_url', true);
            echo esc_html($canonical_url ? $canonical_url : '');
        } elseif ($column_name == 'custom_meta_keywords') {
            $meta_keywords = get_post_meta($post_id, 'ccuamkm_custom_meta_keywords', true);
            echo esc_html($meta_keywords ? $meta_keywords : '');
        }
    }

    // Enqueue the JavaScript file for Quick Edit
    public function ccuamkm_enqueue_scripts($hook) {
        global $current_screen;

        if ($hook == 'edit.php' && ($current_screen->post_type == 'post' || $current_screen->post_type == 'page')) {
            wp_enqueue_script('custom_canonical_quick_edit', plugin_dir_url(__FILE__) . 'custom_canonical_and_keywords_quick_edit.js', array('jquery', 'inline-edit-post'), '1.0.0', true);
        }
    }

    // Add the custom fields to the Quick Edit interface
    public function ccuamkm_quick_edit_custom_box($column_name, $post_type) {
        if ($column_name == 'custom_canonical_url' || $column_name == 'custom_meta_keywords') {
            ?>
            <fieldset class="inline-edit-col-right">
                <div class="inline-edit-col">
                    <?php if ($column_name == 'custom_canonical_url'): ?>
                        <label class="inline-edit-group">
                            <span class="title">Canonical</span>
                            <span class="input-text-wrap">
                                <input type="text" name="custom_canonical_url" class="custom_canonical_url" value="">
                            </span>
                        </label>
                    <?php endif; ?>
                    <?php if ($column_name == 'custom_meta_keywords'): ?>
                        <label class="inline-edit-group">
                            <span class="title">Keywords</span>
                            <span class="input-text-wrap">
                                <input type="text" name="custom_meta_keywords" class="custom_meta_keywords" value="">
                            </span>
                        </label>
                    <?php endif; ?>
                </div>
            </fieldset>
            <?php
            // Add the nonce field for verification
            wp_nonce_field( 'ccuamkm_quick_edit_nonce_action', 'ccuamkm_quick_edit_nonce_name' );
        }
    }

    // Save the custom canonical URL and meta keywords when the post is saved
    public function ccuamkm_save_quick_edit_data($post_id) {
        // Check for nonce and permissions
        if (!isset($_POST['post_type'])) {
            return;
        }

        // Verify the nonce
		if ( ! isset( $_POST['ccuamkm_quick_edit_nonce_name'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ccuamkm_quick_edit_nonce_name'] ) ), 'ccuamkm_quick_edit_nonce_action' ) ) {
			return; // Nonce check failed, do not save data
}


        $post_type = sanitize_text_field( wp_unslash( $_POST['post_type'] ) );

        if (!current_user_can('edit_' . $post_type, $post_id)) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['custom_canonical_url'])) {
            $canonical_url = sanitize_text_field( wp_unslash($_POST['custom_canonical_url']));
            if (!empty($canonical_url)) {
                update_post_meta($post_id, 'ccuamkm_custom_canonical_url', esc_url_raw($canonical_url));
            } else {
                delete_post_meta($post_id, 'ccuamkm_custom_canonical_url');
            }
        }

        if (isset($_POST['custom_meta_keywords'])) {
            $meta_keywords = sanitize_text_field( wp_unslash($_POST['custom_meta_keywords']));
            if (!empty($meta_keywords)) {
                update_post_meta($post_id, 'ccuamkm_custom_meta_keywords', esc_html($meta_keywords));
            } else {
                delete_post_meta($post_id, 'ccuamkm_custom_meta_keywords');
            }
        }
    }

    // Output the custom canonical tag and meta keywords in the page header
    public function ccuamkm_output_custom_meta() {
        if (!is_singular()) {
            return;
        }

        global $post;
        $canonical_url = get_post_meta($post->ID, 'ccuamkm_custom_canonical_url', true);
        $meta_keywords = get_post_meta($post->ID, 'ccuamkm_custom_meta_keywords', true);

        if (empty($canonical_url)) {
            $canonical_url = get_permalink($post);
        }

        echo '<link rel="canonical" href="' . esc_url($canonical_url) . '" />' . "\n";

        if (!empty($meta_keywords)) {
            echo '<meta name="keywords" content="' . esc_attr($meta_keywords) . '" />' . "\n";
        }
    }
}

register_uninstall_hook(__FILE__, 'uninstall_custom_canonical_keywords_modifier');
new Custom_Canonical_Keywords_Modifier();
