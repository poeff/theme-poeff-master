<?php
/**
  * Template Name: Page - Schedule
 */
 get_header();

$intro  = get_field( 'schedule_text_before' );
$outro  = get_field( 'schedule_text_after' );
$cat    = get_field( 'schedule_category' );
$args   = array(
                'post_type' => 'schedule',
                'showposts' => 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'schedule_year',
                        'terms'    => $cat,
                        'field'    => 'term_id',
                    )
                ),
                'orderby'   => 'date',
                'order'     => ASC
            );
$loop   = new WP_Query( $args );
$i      = 1;
$dash   = html_entity_decode('&#x2013;', ENT_COMPAT, 'UTF-8');

while (have_posts()) : the_post();

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

                    // Schedule Grid
                    if ( $loop ) {

                        echo '<div class="row" id="schedule-grid">';

                            while ( $loop->have_posts() ) : $loop->the_post();

                                $blocks     = get_field('block');
                                $festDay    = get_field('festival_day');
                                $time       = preg_split("/:|[\s,]+/", get_field('day_start'));
                                $blockTime  = new DateTime();
                                if ( $time[2] === 'pm' ) {
                                    $blockTime->setTime($time[0]+12, $time[1]);
                                } else {
                                    $blockTime->setTime($time[0], $time[1]);
                                }

                                echo '<div class="col-md-3">';
                                    echo '<dl class="schedule" id="schedule-column-'. $i.'">';
                                        echo '<dt>' . $festDay .'</dt>';

                                        foreach ($blocks as $block) :

                                            $type   = $block[ 'block_type' ];
                                            $level  = $block[ 'content_level' ];
                                            $style  = $block[ 'block_style' ];
                                            if ( $type === 'film' ) {
                                                $p_obj  = $block[ 'block_film' ];
                                                $post   = $p_obj;

                                                if ( $post ) {
                                                    setup_postdata( $post );
                                                    $p_id = get_the_ID();
                                                    $duration = get_field('running_time');
                                                    wp_reset_postdata();
                                                }
                                            } else {
                                                $duration = $block[ 'block_duration' ];
                                            }
                                            $start = $blockTime->format('g:i a');
                                            $end = $blockTime->add(new DateInterval('PT'.$duration.'M'))->format('g:i a');

                                            // Text Blocks
                                            if ( $type === 'text' )
                                            {
                                                if ( $style ) {
                                                    echo '<dd class="' . $style . '">';
                                                } else {
                                                    echo '<dd>';
                                                }
                                                        echo '<span class="block-time">';
                                                            echo $start . ' ' . $dash . ' ' . $end;
                                                        echo '</span>';
                                                        echo '<span class="block-info">';
                                                            echo $block[ 'block_text' ];
                                                        echo '</span>';
                                                    echo '</dd>';
                                            }

                                            // Break Blocks
                                            if ( $type === 'break' )
                                            {
                                                if ( $style ) {
                                                    echo '<dd class="break ' . $style . '">';
                                                } else {
                                                    echo '<dd class="break">';
                                                }
                                                        echo '<span class="block-time">';
                                                            echo $start . ' ' . $dash . ' ' . $end;
                                                        echo '</span>';
                                                        echo '<span class="block-info">';
                                                            echo 'Break';
                                                        echo '</span>';
                                                    echo '</dd>';
                                            }

                                            // Film Blocks
                                            if ( $type === 'film' )
                                            {
                                                $p_obj  = $block[ 'block_film' ];
                                                $post   = $p_obj;
                                                if ( $style ) {
                                                    echo '<dd class="' . $style . '">';
                                                } else {
                                                    echo '<dd>';
                                                }
                                                if ( $post ) : setup_postdata( $post );
                                                    $special    = wp_get_object_terms($post->ID, 'genre');
                                                    echo '<span class="block-time">';
                                                        echo '<i class="fa fa-warning level-'.$level.' pull-right"></i> ';
                                                        echo $start . ' ' . $dash . ' ' . $end;
                                                    echo '</span>';
                                                    echo '<span class="block-info">';
                                                        if(!empty($special)){
                                                            if(!is_wp_error( $special )){
                                                                foreach($special as $term){
                                                                    if ( $term->slug === 'special-screening') {
                                                                        echo '<span class="special">Special Screening of </span><br>';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        echo '<a href="' . get_permalink() . '"><b>' . get_the_title() . '</b></a>';
                                                    echo '</span>';
                                                    wp_reset_postdata();
                                                endif;
                                                echo '</dd>';

                                                // Save Schedule info for film page
                                                $day_key = "field_55b40e51da29c";
                                                update_field( $day_key, $festDay, $p_id );

                                                $start_key = "field_55b40e76da29d";
                                                update_field( $start_key, $start, $p_id );

                                            }

                                            // Panel Blocks
                                            if ( $type === 'panel' )
                                            {
                                                $p_obj  = $block[ 'block_panel' ];
                                                $post   = $p_obj;
                                                if ( $style ) {
                                                    echo '<dd class="' . $style . '">';
                                                } else {
                                                    echo '<dd>';
                                                }
                                                if ( $post ) : setup_postdata( $post );
                                                    $panel_id = get_the_ID();
                                                    echo '<span class="block-time">';
                                                        echo $start . ' ' . $dash . ' ' . $end;
                                                    echo '</span>';
                                                    echo '<span class="block-info">';
                                                        echo '<a href="/panels/#'.the_slug().'"><b>' . get_the_title() . '</b></a>';
                                                    echo '</span>';
                                                    wp_reset_postdata();
                                                endif;
                                                var_dump($panel_id);
                                                echo '</dd>';

                                                // Save Schedule info for panels page
                                                $panel_day_key = "field_53e914a201dc8";
                                                update_field( $panel_day_key, $festDay, $panel_id );

                                                $panel_start_key = "field_53e9150b01dc9";
                                                update_field( $panel_start_key, $start, $panel_id );
                                            }

                                        endforeach;

                                    echo '<dl>';
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
