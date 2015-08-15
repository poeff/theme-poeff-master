<?php
/**
 * Template Name: Page - Panels
 */
 get_header();

$intro  = get_field( 'panel_text_before' );
$outro  = get_field( 'panel_text_after' );
$cat    = get_field( 'panel_category' );
$args   = array(
                'post_type' => 'panel',
                'showposts' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'panel_year',
                        'terms'    => $cat,
                        'field'    => 'term_id',
                    )
                ),
                'orderby'   => 'date',
                'order'     => DESC
            );
$loop   = new WP_Query( $args );
$i      = 1;

while ( have_posts() ) : the_post();

?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
<!--
                < ?php if(function_exists('upbootwp_breadcrumbs')) upbootwp_breadcrumbs(); ?>
-->
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

                    // Panels
                    if ( $loop ) {

                        echo '<div class="row">';

                            while ( $loop->have_posts() ) : $loop->the_post();

                            $day    = get_field( 'panel_day' );
                            $start  = get_field( 'panel_start' );
                            // $end    = get_field( 'panel_end' );
                            $videos = get_field( 'panel_videos' );

                            if ( $videos ) {
                                echo '<div class="col-sm-4 col-sm-push-8">';

                                    foreach ( $videos as $vid ) {
                                        $title = $vid[ 'panel_video_title' ];
                                        $desc  = $vid[ 'panel_video_description' ];
                                        if ( $title ) echo '<h4>' . $title . '</h4>';
                                        echo '<div class="embed-container">' . $vid[ 'panel_video_link' ] . '</div>';
                                        if ( $desc ) echo '<div class="well well-sm video-caption">' . $desc . '</div>';
                                    }

                                echo '</div>';
                                echo '<div class="col-sm-8 col-sm-pull-4 panel-post">';
                            } else {
                                echo '<div class="col-sm-12 panel-post">';
                            }
                                    echo '<a id="'.the_slug().'"></a>';
                                    echo '<h2>' . get_the_title() . '</h2>';

                                    if ( $day ) {
                                        // Check for legacy screening times
                                        if ( preg_match('/\s/',$day)) {
                                            // Check for white space - New schedule builder will print formatted date/time
                                            echo '<p>' . $day .' approx. '. $start . '</p>';
                                        } else {
                                            // Old schedule builder prints unix string
                                            echo '<p>' . date("F jS, Y", strtotime($day)) .' approx. '. date("g:i a", $start) . '</p>';
                                        }
                                    }

                                    the_content();

                            echo '</div>';

                            $i++;
                            endwhile;
                            wp_reset_postdata();
                        echo '</div>';
                    }

                    // Outro Text
                    if ( $outro ) {
                        echo '<div class="row">';
                            echo '<div class="col-xs-12">';
                                echo $outro;
                            echo '</div>';
                        echo '</div>';
                    }

                    //the_content();
                    ?>
                    <?php endwhile; // end of the loop. ?>
                    <?php
                        wp_link_pages(array(
                            'before' => '<div class="page-links">'.__('Pages:', 'upbootwp'),
                            'after'  => '</div>',
                        ));
                    ?>
                </div><!-- .entry-content -->

                <?php //edit_post_link( __( 'Edit', 'upbootwp' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>

            </div><!-- .col-md-12 -->
        </div><!-- .row -->
    </div><!-- .container -->
<?php get_footer(); ?>
