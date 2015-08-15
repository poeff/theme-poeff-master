<?php
/**
 * Template Name: Page - Film Archive
 */

get_header(); 

?>

    <div class="container">

        <div class="row">
            <div class="col-md-12   ">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">

                        <?php while ( have_posts() ) : the_post(); ?>
            
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <header class="entry-header page-header">
                                    <h1 class="entry-title"><?php the_title(); ?></h1>
                                </header><!-- .entry-header -->

                                <div class="entry-content">
                                    <div class="table-responsive">
                                        <table id="films-archive" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Director</th>
                                                    <th>Country</th>
                                                    <th>Category</th>
                                                    <th>Best of Fest</th>
                                                    <th>Year</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                            $args = array(
                                                        'post_type'         => 'film',
                                                        'posts_per_page'    => '-1',
                                                        'orderby'           => 'name',
                                                        'order'             => 'ASC',
                                                    );
                                            $query = new WP_Query( $args );
                                            while ( $query->have_posts() ) : $query->the_post();
                                                $genre      = wp_get_object_terms($post->ID, 'genre');
                                                $award      = wp_get_object_terms($post->ID, 'award');
                                                $year       = wp_get_object_terms($post->ID, 'film_year');
                                                $credits    = get_field( 'filmmakers' );
                                                $countries  = get_field( 'film_country' );
                                                echo '<tr>';
                                                    echo '<td>';
                                                        echo '<a href="' . get_permalink() . '">';
                                                            echo get_the_title();
                                                        echo '</a>';
                                                    echo '</td>';
                                                    echo '<td>';
                                                    if ( $credits ) {
                                                        $credit = reset($credits);
                                                        echo $credit['filmmaker_name'];
                                                    }
                                                    echo '</td>';
                                                    echo '<td>';
                                                    if ( $countries ) {
                                                        foreach ($countries as $country) {
                                                            echo '<span class="country">' . $country . '</span>';
                                                        }
                                                    }
                                                    echo '</td>';
                                                    echo '<td>';  
                                                    if(!empty($genre)){
                                                        if(!is_wp_error( $genre )){
                                                            foreach($genre as $term){
                                                                echo $term->name; 
                                                            }
                                                        }
                                                    }
                                                    echo'</td>';
                                                    echo '<td>';
                                                    if(!empty($award)){
                                                        if(!is_wp_error( $award )){
                                                            foreach($award as $term){
                                                                echo $term->name . '<br>'; 
                                                            }
                                                        }
                                                    }  
                                                    echo'</td>';
                                                    echo '<td>';
                                                    if(!empty($year)){
                                                        if(!is_wp_error( $year )){
                                                            foreach($year as $term){
                                                                echo $term->name; 
                                                            }
                                                        }
                                                    }
                                                    echo'</td>';
                                                echo '</tr>';

                                            endwhile;
                                            wp_reset_postdata();
                                            ?>
                                            </tbody>
                                        </table>
                                        <?php  //the_content();  ?>
                                        <?php
                                            wp_link_pages( array(
                                                'before' => '<div class="page-links">' . __( 'Pages:', 'upbootwp' ),
                                                'after'  => '</div>',
                                            ));
                                        ?>
                                    </div> <!-- table-respnsive -->

                                </div><!-- .entry-content -->


                                <!-- ?php edit_post_link( __( 'Edit', 'upbootwp' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?-->
                            

                            </article><!-- #post-## -->

                    </main><!-- #main -->
                </div><!-- #primary -->
            </div><!-- .col-md-8 -->


                        <?php endwhile; // end of the loop. ?>

            </div><!-- .col-md-4 -->
        </div><!-- .row -->
    </div><!-- .container -->
<?php get_footer(); ?>
