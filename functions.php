<?php
/**
 * Test Theme functions and definitions
 *
 * @package Test Theme
 * @since Test Theme 1.0
 */

 function enqueue_bootstrap_styles_and_scripts() {
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap_styles_and_scripts');

function enqueue_cookie_script() {
    wp_enqueue_script('custom-cookie-js', get_template_directory_uri() . '/assets/js/post/cookie.js', array('jquery'), '', true);
    $post_id = get_the_ID();
    $post_type = get_post_type();
    wp_localize_script( 'custom-cookie-js', 'post_data', array(
        'postId' => $post_id,
        'postType' => $post_type
    ) );

    
}
add_action('wp_enqueue_scripts', 'enqueue_cookie_script');

function add_custom_meta_box() {
    add_meta_box(
        'custom_meta_box',
        'Custom Field',
        'display_custom_meta_box',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_custom_meta_box');

function display_custom_meta_box($post) {
    $custom_field_value = get_post_meta($post->ID, '_custom_field', true);
    ?>
    <p>
        <label for="custom_field">Custom Field Content:</label><br>
        <textarea id="custom_field" name="custom_field" rows="4" style="width: 100%;"><?php echo esc_textarea($custom_field_value); ?></textarea>
    </p>
    <?php
}

function save_custom_meta_box($post_id) {
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (!isset($_POST['custom_field'])) {
        return;
    }

    $custom_field_value = sanitize_textarea_field($_POST['custom_field']);
    update_post_meta($post_id, '_custom_field', $custom_field_value);
}
add_action('save_post', 'save_custom_meta_box');

function show_post_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'id' => 0,
        ),
        $atts,
        'show_post'
    );

    $post = get_post($atts['id']);

    if ($post && ($post->post_type == 'page' || $post->post_type == 'post')) {
        $title = get_the_title($post);

        $excerpt = get_the_excerpt($post);

        $custom_field_value = get_post_meta($post->ID, '_custom_field', true);

        $output = '<div class="show-post">';
        $output .= '<h2>' . $title . '</h2>';
        $output .= '<p>' . $excerpt . '</p>';
        if (!empty($custom_field_value)) {
            $output .= '<p>' . $custom_field_value . '</p>';
        }
        $output .= '</div>';

        return $output;
    }

    return 'Post not found';
}
add_shortcode('show_post', 'show_post_shortcode');

