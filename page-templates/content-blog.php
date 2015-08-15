<?php
/**
 * Template Name: Page - Blog
 */

get_header(); 

$blog = get_field('blog_feed');
?>

    <div class="container">

        <div class="row">
            <div class="col-md-8">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">

                        <?php while ( have_posts() ) : the_post(); ?>
            
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <header class="entry-header">
                                    <!-- <h1 class="entry-title">< ?php the_title(); ?></h1> -->
                                </header><!-- .entry-header -->

                                <div class="entry-content">
                                    <?php 
                                    $args = array( 
                                                'post_type'      => 'post', 
                                                'category__in'   => $blog,
                                                'posts_per_page' => -1, 
                                                'orderby'        => 'date', 
                                                'order'          => DESC 
                                            );
                                    $loop = new WP_Query( $args );
                                    while ( $loop->have_posts() ) : $loop->the_post();
                                        get_template_part( 'content' );
                                    endwhile;
                                    wp_reset_postdata();
                                    
                                    //the_content(); 
                                    ?>
                                    <?php
                                        wp_link_pages( array(
                                            'before' => '<div class="page-links">' . __( 'Pages:', 'upbootwp' ),
                                            'after'  => '</div>',
                                        ));
                                    ?>
                                </div><!-- .entry-content -->
                                <?php edit_post_link( __( 'Edit', 'upbootwp' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
                            </article><!-- #post-## -->
                        <?php endwhile; // end of the loop. ?>
                    </main><!-- #main -->
                </div><!-- #primary -->
            </div><!-- .col-md-8 -->
            
            <div class="col-md-4">
                <?php get_sidebar( 'social' ); ?>
            </div><!-- .col-md-4 -->
        </div><!-- .row -->
    </div><!-- .container -->
<?php get_footer(); ?>
