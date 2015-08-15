<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <?php
            if ( is_singular( 'film' ) ) {
                echo '<div class="col-md-12">';
            } else {
                echo '<div class="col-md-8">';
            }
            ?>
                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">

                    <?php
                    while ( have_posts() ) : the_post();

                        if ( is_singular( 'film' ) ) {
                            get_template_part( 'content', 'film' );
                            //upbootwp_content_nav( 'nav-below' );
                        } else {
                            get_template_part( 'content', 'single' );
                            $categories = get_the_category();
                            foreach ($categories as $c) {
                                $name = $c->name;
                            }
                            if ( $name == 'Blog' ) {
                                $author  = get_field('blog_author_name');
                                $bio   = get_field('blog_author_bio');
                                $photo = get_field('blog_author_photo');
                                if ($bio){ 
                                echo '<div class="well blog-bio">';
                                    echo '<div class="media">';
                                        if ($photo) {
                                            echo '<div class="media-left">';
                                                echo '<img class="media-object img-rounded hidden-xs" src="'.$photo['url'].'" alt="'.$photo['alt'].'">';
                                            echo '</div>';
                                        }
                                        echo '<div class="media-body">';
                                        if ($author) echo '<h4 class="media-heading">'.$author.'</h4>';
                                        echo $bio;
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                                }
                            }
                        }

                        // If comments are open or we have at least one comment, load up the comment template
                        // echo '<hr>';
                        echo '<div class="row">';
                            echo '<div class="col-xs-12">';
                                if ( comments_open() || '0' != get_comments_number() )
                                    comments_template();
                            echo '</div>';
                        echo '</div>';

                    endwhile; // end of the loop.
                    ?>

                    </main><!-- #main -->
                </div><!-- #primary -->
            </div><!-- .col-md-8 -->

            <?php
            if ( !is_singular( 'film' ) ) {

                echo '<div class="col-md-4">';
                    get_sidebar( 'social' );
                echo '</div>';
            }
            ?>

        </div><!-- .row -->
    </div><!-- .container -->
<?php get_footer(); ?>