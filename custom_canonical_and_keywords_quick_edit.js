jQuery(document).ready(function($) {
    var $wp_inline_edit = inlineEditPost.edit;
    inlineEditPost.edit = function(id) {
        $wp_inline_edit.apply(this, arguments);
        var post_id = 0;
        if (typeof(id) == 'object') {
            post_id = parseInt(this.getId(id));
        }
        if (post_id > 0) {
            var $edit_row = $('#edit-' + post_id);
            var $post_row = $('#post-' + post_id);

            // Fetch and populate the Canonical URL
            var canonical_url = $('.column-custom_canonical_url', $post_row).text().trim();
            $('input[name="custom_canonical_url"]', $edit_row).val(canonical_url);

            // Fetch and populate the Meta Keywords
            var meta_keywords = $('.column-custom_meta_keywords', $post_row).text().trim();
            $('input[name="custom_meta_keywords"]', $edit_row).val(meta_keywords);
        }
    };
});
