<?php
/**
 * Template Name: Page - Selections
 */

get_header();

$laurels    = get_field( 'laurels', options );
$intro      = get_field( 'selections_text_before' );
$outro      = get_field( 'selections_text_after' );
$display    = get_field( 'selections_content' );
$year       = get_field( 'selections_category' );
$yr         = get_terms( 'film_year', array( 'fields' => 'names' ) );
$args       = array(
                'post_type' => 'film',
                'showposts' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'film_year',
                        'terms'    => $year,
                        'field'    => 'term_id',
                    )
                ),
                'orderby'   => 'name',
                'order'     => ASC
            );
$loop       = new WP_Query( $args );

while ( have_posts() ) : the_post();

?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">

                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header class="entry-header page-header">
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                            </header><!-- .entry-header -->

                            <div class="entry-content">

                            <?php
                            // Intro text
                            if ( $intro ) {
                                echo '<div class="row">';
                                    echo '<div class="col-xs-12">';
                                        echo $intro;
                                    echo '</div>';
                                echo '</div>';
                            }

                            if ( $loop ): while ( $loop->have_posts() ) : $loop->the_post();

                                $credits    = get_field( 'filmmakers' );
                                $countries  = get_field( 'film_country' );
                                $length     = get_field( 'running_time' );

                            endwhile; wp_reset_postdata(); endif;

                            // Tables
                            $years = get_terms( 'film_year', array( 'orderby' => 'slug', 'order' => 'ASC' ) );
                            $genres = get_terms( 'genre', array( 'orderby' => 'slug', 'order' => 'ASC' ) );
                            $i      = 0;

                            echo '<a id="all-selections"></a>';
                            echo '<h2>'. end( $yr ) .' Peace On Earth Film Festival Official Selections</h2>';


echo '<table class="table selections">';

                            //echo '<div class="selections">';
                            foreach ( $genres as $genre ) {

                                $args_2 = array(
                                            'post_type' => 'film',
                                            'showposts' => -1,
                                            'tax_query' => array(
                                                'relation' => 'AND',
                                                array(
                                                    'taxonomy' => 'film_year',
                                                    'terms'    => $year,
                                                    'field'    => 'id'
                                                ),
                                                array(
                                                    'taxonomy' => 'genre',
                                                    'terms'    => $genre,
                                                    'field'    => 'slug'
                                                )
                                            ),
                                            'orderby'   => 'name',
                                            'order'     => ASC
                                        );

                                $header = 0;
                                $loop_2 = new WP_Query( $args_2 );

                                if ( $loop_2 ): while ( $loop_2->have_posts() ) : $loop_2->the_post();

                                    $header++;
                                    $credits    = get_field( 'filmmakers' );
                                    $countries  = get_field( 'film_country' );
                                    $length     = get_field( 'running_time' );

echo '<tr class="row-'.$i.'">';
                                    if ($header == 1){
echo '<th>';
                                        // echo '<div class="row headers">';
                                        //     echo '<div class="col-sm-7">';
                                                echo '<h4>' . $genre->name . '</h4>';
echo '</th>';
                                            // echo '</div>';
                                            // echo '<div class="col-sm-5">';
echo '<th>';
                                                echo '<h4>';
                                                    echo '<span class="director">Director</span>';
                                                echo '</h4>';
                                        //     echo '</div>';
                                        // echo '</div>';
echo '</th>';
echo '</tr>';
                                    }
echo '<tr>';
                                    // echo '<div class="row">';
                                    //     echo '<div class="col-sm-7">';
echo '<td>';
                                            echo '<h5>';
                                                echo '<a href="' . get_permalink() . '">';
                                                    echo get_the_title();
                                                echo '</a> ';
                                                echo ' <small>(';
                                                    echo implode(', ', $countries) . ', ';
                                                    echo $length . ' min';
                                                echo ')</small>';
                                            echo '</h5>';
echo '</td>';
                                        // echo '</div>';
                                        // echo '<div class="col-sm-5">';
echo '<td>';
                                        if ( $credits ) {
                                            $credit = reset($credits);
                                            echo $credit['filmmaker_name'];
                                        }
echo '</td>';
                                    //     echo '</div>';
                                    // echo '</div>';
echo '</tr>';

                                $i++;
                                endwhile; wp_reset_postdata(); endif;
                            }
echo '</table>';
                            //echo '</div>';

                            //the_content();

                            // Outro Text
                            if ( $outro ) {
                                echo '<div class="row">';
                                    echo '<div class="col-xs-12">';
                                        echo $outro;
                                    echo '</div>';
                                echo '</div>';
                            }

                            ?>
                            <?php
                                wp_link_pages( array(
                                    'before' => '<div class="page-links">' . __( 'Pages:', 'upbootwp' ),
                                    'after'  => '</div>',
                                ));
                            ?>

                            </div><!-- .entry-content -->

                    <!-- ?php edit_post_link( __( 'Edit', 'upbootwp' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?-->

                    </article><!-- #post-## -->
                </main><!-- #main -->
            </div><!-- #primary -->
        </div><!-- .col-md-12 -->
    </div><!-- .row -->
</div><!-- .container -->
<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>
