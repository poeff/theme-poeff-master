<?php
$trailer    = get_field( 'film_trailer' );
$still      = get_field( 'film_still' );
$countries  = get_field( 'film_country' );
$length     = get_field( 'running_time' );
$credits    = get_field( 'filmmakers' );
$poster     = get_field( 'poster' );
$links      = get_field( 'film_links' );
$screening  = get_field( 'screening_day' );
$awards     = wp_get_object_terms($post->ID, 'award');
$years      = wp_get_object_terms($post->ID, 'film_year');
$genres     = wp_get_object_terms($post->ID, 'genre');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="entry-content">

        <?php
        if ( !empty( $awards ) ) {
            echo '<div class="row">';
                echo '<div class="col-sm-12">';
                    echo '<div class="bof-title">';
                        if(!is_wp_error( $awards )){
                            foreach($awards as $award){
                                echo '<h3>';
                                    echo $award->name . ', ';
                                    if(!empty($years)){
                                        if(!is_wp_error( $years )){
                                            foreach($years as $year){
                                                echo $year->name;
                                            }
                                        }
                                    }
                                echo '</h3>';
                            }
                        }
                    echo '</div>'; // bof-title
                echo '</div>'; // col-*-*
            echo '</div>'; // row
        }

        if ( $trailer || $still ) {
            echo '<div class="row">';
                echo '<div class="col-sm-12">';
                if ( $trailer ) {
                    echo '<div class="embed-container">' . $trailer . '</div>';
                } elseif ( $still ) {
                    echo '<img class="img-responsive" src="' . $still . '" alt="' . get_the_title() . '" />';
                }
                echo '</div>';
            echo '</div>';
        }

        echo '<div class="row">';
            if ( $poster || $links ) { echo '<div class="col-sm-8 col-md-9">'; }
            else { echo '<div class="col-sm-12">'; }
                if(!empty($genres)){
                    if(!is_wp_error( $genres )){
                        foreach($genres as $genre){
                            if ( $genre->slug === 'special-screening') {
                                echo '<span class="special">A Special Screening of</span>';
                            }
                        }
                    }
                }
                echo '<h1 class="entry-title">';
                    echo the_title();
                    echo ' <small>(';
                        echo implode(', ', $countries);
                        if ( $length ) echo ', ' . $length . ' min';
                    echo ')</small>';
                echo '</h1>';

                if ( $credits ) {
                    foreach ( $credits as $credit ) {
                        echo '<p><b>' . $credit[ 'filmmaker_role' ] . '&nbsp;' . $credit[ 'filmmaker_name' ] . '</b></p>';
                    }
                }

                echo get_field( 'film_synopsis' );
                // No schedule info before 2011, leave empty for 2010 & 2008
                // TODO: get programs, backfill info
                if ( $screening ) {
                    // Check for legacy screening times
                    if ( preg_match('/\s/',$screening)) {
                        // Check for white space - New schedule builder will print formatted date/time
                        echo '<p class="h3"><i class="fa fa-calendar hidden-xs"></i> Festival Screening: ' . $screening . ' approx. ' . get_field( 'screening_start' ) . '</p>';
                    } else {
                        // Old schedule builder prints unix string
                        echo '<p class="h3"><i class="fa fa-calendar hidden-xs"></i> Festival Screening: ' . date("F jS, Y", strtotime($screening)) . ' approx. ' . date("g:i a", get_field( 'screening_start' )) . '</p>';
                    }
                }
            echo '</div>'; // col-*-*

            if ( $poster || $links ) {
                echo '<div class="col-sm-4 col-md-3 film-sidebar">';
                    echo '<div class="well">';
                        echo '<div class="row">';

                            if ( $poster ) {
                                echo '<div class="col-xs-6 col-sm-12">';
                                    echo '<img class="img-responsive center-block" src="' . $poster . '" alt="' . get_the_title() . '" />';
                                    if ( $links ) echo '<hr class="hidden-xs">';
                                echo '</div>';
                            }
                            if ( $links ) {
                                echo '<div class="col-xs-6 col-sm-12">';
                                    echo '<ul class="fa-ul">';
                                        foreach ( $links as $link ) {
                                            switch ( $link[ 'film_url_text' ] ) {
                                                case "Official Website":    $fa = 'globe';                  break;
                                                case "Website":             $fa = 'globe';                  break;
                                                case "Facebook":            $fa = 'facebook-square';        break;
                                                case "Twitter":             $fa = 'twitter-square';         break;
                                                case "Google+":             $fa = 'google-plus-square';     break;
                                                case "Google Plus":         $fa = 'google-plus-square';     break;
                                                case "Pinterest":           $fa = 'pinterest';              break;
                                                case "Instagram":           $fa = 'instagram';              break;
                                                case "Vimeo":               $fa = 'vimeo-square';           break;
                                                case "YouTube":             $fa = 'youtube-play';           break;
                                                case "Youtube":             $fa = 'youtube-play';           break;
                                                case "Tumblr":              $fa = 'tumblr-square';          break;
                                                case "Vine":                $fa = 'vine';                   break;
                                                default:                    $fa = 'external-link-square';
                                            }
                                            echo '<li><i class="fa-li fa fa-' . $fa . '"></i> <a href="' . $link[ 'film_url' ] . '" target="_blank">' . $link[ 'film_url_text' ] . '</a></li>';
                                        }
                                    echo '</ul>';
                                echo '</div>'; // col-*-*
                            }

                        echo '</div>'; // row

                    echo '</div>'; // well
                echo '</div>'; // col-*-* : film-sidebar
            }

        echo '</div>'; // row

    ?>
        <?php
            wp_link_pages( array(
                'before' => '<div class="page-links">' . __( 'Pages:', 'upbootwp' ),
                'after'  => '</div>',
            ) );
        ?>
    </div><!-- .entry-content -->

    <footer class="film-footer">
        <?php
        echo '<hr>';
        echo '<div class="row">';
            echo '<div class="col-sm-3">' . do_shortcode('[ssba]') . '</div>'; // Don't deactive share button plugin!
            echo '<div class="col-sm-9 tags">';
                echo '<small>Tags: ';
                if(!empty($years)){
                    if(!is_wp_error( $years )){
                        foreach($years as $year){
                            echo '<a class="filter-link" href="/archive/#'.$year->name.'">' . $year->name . ' POEFF</a>';
                        }
                    }
                }
                if(!empty($genres)){
                    if(!is_wp_error( $genres )){
                        foreach($genres as $genre){
                            echo ', <a class="filter-link" href="/archive/#'.$genre->name.'">' . $genre->name . '</a>';
                        }
                    }
                }
                if(!empty($awards)){
                    if(!is_wp_error( $awards )){
                        foreach($awards as $award){
                            echo ', <a class="filter-link" href="/archive/#'.$award->name.'">' . $award->name . '</a>';
                        }
                    }
                }
                echo '</small>';
            echo '</div>'; // col-*-*
        echo '</div>'; // row
        ?>

        <!-- ?php edit_post_link( __( 'Edit', 'upbootwp' ), '<span class="edit-link">', '</span>' ); ? -->

    </footer><!-- .entry-meta -->

</article><!-- #post-## -->


