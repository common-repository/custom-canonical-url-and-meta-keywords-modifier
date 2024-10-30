<?php
// If the uninstall is not called by WordPress, exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

// Remove custom meta data for canonical URL and meta keywords
$meta_keys = ['ccuamkm_custom_canonical_url', 'ccuamkm_custom_meta_keywords'];

$posts = get_posts(array('numberposts' => -1, 'post_type' => 'any', 'post_status' => 'any'));

foreach ($posts as $post) {
    foreach ($meta_keys as $meta_key) {
        delete_post_meta($post->ID, $meta_key);
    }
}
