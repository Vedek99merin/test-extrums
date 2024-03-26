<?php
/**
 * Template Name: Home Page
 *
 * @package WordPress
 * @subpackage Test
 * @since Test 1.0
 */

get_header();

the_content();

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 10,
    'orderby' => 'date',
    'order' => 'DESC'
);
$query = new WP_Query( $args );

if ( $query->have_posts() ) :
    ?>
    <div class="container">
        <h1 class="text-center"><?php esc_html_e( 'Example using Bootstrap and display posts with WP_Query', 'test' ); ?></h1>
        <div class="row">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'medium', array( 'class' => 'card-img-top img-fluid' ) ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="card-body">
                            <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="card-text"><?php the_excerpt(); ?></p>
                        </div>
                        <div class="card-footer">
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php esc_html_e( 'Read More', 'test' ); ?></a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php
    wp_reset_postdata(); 
else :
    echo '<div class="col-md-12"><p>' . esc_html__( 'Sorry, no posts matched your criteria.', 'test' ) . '</p></div>';
endif;

get_footer();
?>