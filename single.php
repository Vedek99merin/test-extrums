<?php
/**
 * Template For Single Post
 *
 * @package WordPress
 * @subpackage Test
 * @since Test 1.0
 */

get_header(); ?>
<h1 class="text-center"><?php the_title(); ?></h1>
<div class="text-center">
    <?php the_content(); ?>
</div>

<h2><?php esc_html_e( 'Displayed Last Visited Post:', 'test' ); ?></h2>
<?php
if ( isset( $_COOKIE['last_visited_post_id'] ) ) {
    $last_visited_post_id = $_COOKIE['last_visited_post_id'];
    $last_visited_post = get_post( $last_visited_post_id );

    if ( $last_visited_post ) {
        $last_visited_post_title = get_the_title( $last_visited_post );
        $last_visited_post_excerpt = get_the_excerpt( $last_visited_post );
        $last_visited_post_custom_field = get_post_meta( $last_visited_post->ID, '_custom_field', true );
        ?>
        <div class="last-visited-post mt-4">
            <h3><?php esc_html_e( 'Last Visited Post:', 'test' ); ?></h3>
            <h4><?php echo $last_visited_post_title; ?></h4>
            <p><?php echo $last_visited_post_excerpt; ?></p>
            <?php if ( ! empty( $last_visited_post_custom_field ) ) : ?>
                <p><?php echo $last_visited_post_custom_field; ?></p>
            <?php endif; ?>
        </div>
        <?php
    }
}
?>

<?php get_footer(); ?>