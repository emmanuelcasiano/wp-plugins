<?php
// Permission
function advanced_ajax_crud_require_auth_capability()
{
    if (!is_user_logged_in() || !current_user_can('edit_posts')) {
        wp_send_json_error('Unauthorized', 403);
    }
}

// Nonce
function advanced_ajax_crud_verify_nonce()
{
    check_ajax_referer('advanced_ajax_crud_nonce', 'nonce');
}
