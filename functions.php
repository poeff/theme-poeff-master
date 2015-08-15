<?php

/**
*   Custom Actions
*   ---------------------------------------------------------------------------
*/

// Remove WP version meta
remove_action('wp_head', 'wp_generator');


// Load custom scripts
function custom_scripts() {
    if ( !is_admin() )
    {
        // Remove parent jQuery
        wp_deregister_script( 'upbootwp-jQuery' );
        wp_dequeue_script( 'upbootwp-basefile' );
        // Register css
        wp_register_style( 'datatable-bs3', '//cdn.datatables.net/plug-ins/725b2a2115b/integration/bootstrap/3/dataTables.bootstrap.css', array(), '1.10.2' );
        wp_register_style( 'datatable-fa', '//cdn.datatables.net/plug-ins/725b2a2115b/integration/font-awesome/dataTables.fontAwesome.css', array(), '1.10.2' );
        // Register js
        wp_register_script( 'datatable', '//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js', array( 'jquery-2-1-1' ), '1.10.2', true );
        wp_register_script( 'datatable-bootstrap', '//cdn.datatables.net/plug-ins/725b2a2115b/integration/bootstrap/3/dataTables.bootstrap.js', array( 'jquery-2-1-1' ), '1.10.2', true );
        wp_register_script( 'datatable-init', get_stylesheet_directory_uri().'/js/datatable-init.js', array( 'datatable' ), '1.0' ,true );
        wp_register_script( 'cycle2', get_stylesheet_directory_uri().'/js/jquery.cycle2.min.js', array( 'jquery-2-1-1' ), '2.1.5', true );
        wp_register_script( 'cycle-swipe', get_stylesheet_directory_uri().'/js/jquery.cycle2.swipe.min.js', array( 'jquery-2-1-1' ), '2.1.5', true );
        // Enqueue global css
        wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
        wp_enqueue_style( 'poeff', get_stylesheet_directory_uri().'/css/poeff.min.css', array( 'upbootwp-css' ), '1.0' );
        // Enqueue global js
        wp_enqueue_script( 'jquery-2-1-1', '//code.jquery.com/jquery-2.1.1.min.js', array(), '2.1.1', true );
        wp_enqueue_script( 'upbootwp-basefile' );
        wp_enqueue_script( 'js', get_stylesheet_directory_uri().'/js/js.js', array( 'jquery-2-1-1' ), '1.0', true );
        // Enqueue home page js
        if ( is_front_page() ) {
            wp_enqueue_script( 'cycle2' );
            wp_enqueue_script( 'cycle-swipe' );
        }
        // Enqueue archive page css, js
        if ( is_page_template( 'page-templates/content-history.php' ) ) {
            wp_enqueue_style( 'datatable-bs3' );
            wp_enqueue_style( 'datatable-fa' );
            wp_enqueue_script( 'datatable' );
            wp_enqueue_script( 'datatable-bootstrap' );
            wp_enqueue_script( 'datatable-init' );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'custom_scripts', 100 );


// Admin
// function custom_admin_scripts() {
//     wp_enqueue_style( 'custom-admin-css', get_stylesheet_directory_uri().'/css/admin.css', array(), '1.0');
// }
// add_action( 'admin_enqueue_scripts', 'custom_admin_scripts' );


/**
*   Custom Filters
*   ---------------------------------------------------------------------------
*/

// Remove Pingback
function remove_pingback_url( $output, $show ) {
    if ( $show == 'pingback_url' ) $output = '';
    return $output;
}
add_filter( 'bloginfo_url', 'remove_pingback_url', 10, 2 );


// Enable shortcodes
add_filter('widget_text', 'do_shortcode');
add_filter('the_content', 'do_shortcode');


// Move Options menu link
function custom_menu_order( $menu_ord ) {
    if (!$menu_ord) return true;
    $menu = 'acf-options';
    $menu_ord = array_diff($menu_ord, array( $menu ));
    array_splice( $menu_ord, 1, 0, array( $menu ) );
    return $menu_ord;
}
add_filter('custom_menu_order', 'custom_menu_order');
add_filter('menu_order', 'custom_menu_order');


// Allow SVG upload
function custom_upload_mimes ( $existing_mimes=array() ) {
    $existing_mimes['svg'] = 'mime/type';
    return $existing_mimes;
}
add_filter('upload_mimes', 'custom_upload_mimes');


// Responsive oEmbed
function oembed_wrap($html, $url, $attr, $post_id) {
  return '<div class="embed-container">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'oembed_wrap', 99, 4);


/**
*   Custom Functions
*   ---------------------------------------------------------------------------
*/

// Add Menu Locations
register_nav_menus( array(
    'footer' => __( 'Footer Menu', 'Bootstrap WP Footer' ),
) );

// Add ACF Options Page
if(function_exists('acf_add_options_page')) {
    acf_add_options_page();
    //acf_add_options_sub_page('Header');
}


// Turn permalink into slug
function the_slug()
{
    $slug = basename(get_permalink());
    do_action('before_slug', $slug);
    $slug = apply_filters('slug_filter', $slug);
    if( $echo ) echo $slug;
    do_action('after_slug', $slug);
    return $slug;
}

// Get formatted content
function get_fomratted_content ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '')
{
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}

/**
*   Custom Post Types
*   ---------------------------------------------------------------------------
*/

include_once('CPT.php');

/**
 *  -------------
 *      FILMS
 *  -------------
 */
$films = new CPT('film', array(
    'supports' => array('title', 'editor', 'comments')
));

// Films taxonomy
$films->register_taxonomy('genre');
$films->register_taxonomy('film_year');
$films->register_taxonomy('award');

// Films columns
$films->columns(array(
    'cb'        => '<input type="checkbox" />',
    'title'     => __('Title'),
    'film_year' => __('Festival Year'),
    'genre'     => __('Genre'),
    'award'     => __('Best of Fest'),
    'date'      => __('Date')
));
$films->sortable(array(
    'genre'     => array('genre', true),
    'film_year' => array('film_year', true),
    'award'     => array('award', true)
));

// Films menu
$films->menu_icon("dashicons-video-alt2");
$films->menu_position(5);


/**
 *  ----------------
 *      PANELS
 *  ----------------
 */
$panel = new CPT('panel', array(
    'supports' => array('title', 'editor', 'comments')
));

// Panels taxonomy
$panel->register_taxonomy('panel_year');

// Panels columns
$panel->columns(array(
    'cb'         => '<input type="checkbox" />',
    'title'      => __('Title'),
    'panel_year' => __('Festival Year'),
    'date'       => __('Date')
));
$panel->sortable(array(
    'panel_year' => array('panel_year', true)
));

// Panels icon
$panel->menu_icon("dashicons-megaphone");
$panel->menu_position(6);


/**
 *  ----------------
 *      SCHEDULE
 *  ----------------
 */
$schedule = new CPT('schedule');

// Schedule taxonomy
$schedule->register_taxonomy('schedule_year');

// Schedule columns
$schedule->columns(array(
    'cb'            => '<input type="checkbox" />',
    'title'         => __('Title'),
    'schedule_year' => __('Festival Year'),
    'date'          => __('Date')
));
$schedule->sortable(array(
    'schedule_year' => array('schedule_year', true)
));

// Schedule icon
$schedule->menu_icon("dashicons-schedule");
$schedule->menu_position(7);


/**
 *  ----------------
 *      SPONSORS
 *  ----------------
 */
$sponsors = new CPT('sponsor');

// Sponsors taxonomy
$sponsors->register_taxonomy('level');

// Sponsors columns
$sponsors->columns(array(
    'cb'    => '<input type="checkbox" />',
    'title' => __('Title'),
    'level' => __('Sponsor Level'),
    'date'  => __('Date')
));
$sponsors->sortable(array(
    'level' => array('level', true)
));

// Sponsors menu
$sponsors->menu_icon("dashicons-heart");
$sponsors->menu_position(8);



/**
*   Shortcodes
*   ---------------------------------------------------------------------------
*/

// SPONSORS - [sponsors level="premuium" columns="3"]
add_shortcode( 'sponsors', 'postsponsors' );

function postsponsors( $atts )
{
    extract( shortcode_atts( array( 'level'=>'', 'columns'=>'', 'mobile'=>'' ), $atts ) );
    $output = '';
    $term   = $atts['level'];
    $cols   = $atts['columns'];
    switch ( $cols ) {
        case '1': $smClass = 'col-sm-12'; break;
        case '2': $smClass = 'col-sm-6';  break;
        case '3': $smClass = 'col-sm-4';  break;
        case '4': $smClass = 'col-sm-3';  break;
        case '6': $smClass = 'col-sm-2';  break;
    }
    $mobile   = $atts['mobile'];
    switch ( $mobile ) {
        case '1': $xsClass = 'col-xs-12'; break;
        case '2': $xsClass = 'col-xs-6';  break;
        case '3': $xsClass = 'col-xs-4';  break;
        case '4': $xsClass = 'col-xs-3';  break;
        case '6': $xsClass = 'col-xs-2';  break;
    }

    $args = array(
                'post_type' => 'sponsor',
                'showposts' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'level',
                        'terms'    => $term,
                        'field'    => 'slug',
                    )
                ),
                'orderby'   => 'name',
                'order'     => ASC
            );

    $sponsors = new WP_Query( $args );
    if ( $sponsors ) {

        $i = 1;
        $output .= '<div class="hidden-sm visible-xs">';
            $output .= '<div class="row">';
                while ( $sponsors->have_posts() ) : $sponsors->the_post();
                $logo = get_field('sponsor_logo');
                $link = get_field('sponsor_url');
                $output .= '<div class="' . $xsClass .' text-center">';
                    if ( $link ) $output .= '<a href="' . $link . '" target="_blank">';
                        $output .= '<img class="img-responsive thumbnail" src="' . $logo .'" alt="' . get_the_title() . '" />';
                    if ( $link ) $output .= '</a>';
                $output .= '</div>';
                if ($i % $mobile == 0) {
                    $output .= '</div><div class="row">';
                }
                $i++;
                endwhile;
            $output .= '</div>';
        $output .= '</div>';

        $i = 1;
        $output .= '<div class="hidden-xs">';
            $output .= '<div class="row">';
                while ( $sponsors->have_posts() ) : $sponsors->the_post();
                $logo = get_field('sponsor_logo');
                $link = get_field('sponsor_url');
                $output .= '<div class="'. $smClass .' text-center">';
                    if ( $link ) $output .= '<a href="' . $link . '" target="_blank">';
                        $output .= '<img class="img-responsive thumbnail" src="' . $logo .'" alt="' . get_the_title() . '" />';
                    if ( $link ) $output .= '</a>';
                $output .= '</div>';
                if ($i % $cols == 0) {
                    $output .= '</div><div class="row">';
                }
                $i++;
                endwhile;
            $output .= '</div>';
        $output .= '</div>';

        $i = 1;

    }
    wp_reset_query();
    return $output;
}



// PRESS RELEASES - [press type="release"]
add_shortcode( 'press', 'pressreleases' );

function pressreleases( $atts )
{
    extract( shortcode_atts( array( 'type'=>'' ), $atts ) );
    $type   = $atts['type'];
    $output = '';
    $args   = array(
                'post_type'     => 'post',
                'show_posts'    => -1,
                'category_name' => $type,
                'orderby'       => 'date',
                'order'         => DESC
            );
    $query = new WP_Query( $args );
    if ( $query ) : while ( $query->have_posts() ) : $query->the_post();
        $output .= '<article class="press-item">';
        $output .= '    <header>';
        $output .= '        <h2>'. get_the_title() . '</h2>';
        $output .= '    </header>';
        $output .= '    <div class="entry">';
        $output .=          get_fomratted_content();
        $output .= '    </div>';
        $output .= '</article>';
    endwhile; wp_reset_query(); endif;
    return $output;
}



// BEST OF FEST - [best_of_fest year="2014"]
add_shortcode( 'best_of_fest', 'bestoffest' );

function bestoffest( $atts )
{
    extract( shortcode_atts( array( 'year'=>'' ), $atts ) );
    $year = $atts['year'];
    $output = '';
    $args   = array(
                'post_type' => 'film',
                'showposts' => -1,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'film_year',
                        'terms'    => $year,
                        'field'    => 'slug',
                    )
                ),
                // After festival, assign awards to films from Features -> SVP
                'orderby'   => 'modified',
                'order'     => ASC
            );
    $posts  = get_posts( $args );
    if ( $posts ) : foreach ( $posts as $post )
    {
        $p          = $post->ID;
        $award      = wp_get_object_terms( $p, 'award' );
        $title      = get_the_title( $p );
        $link       = get_permalink( $p );
        $still      = get_field( 'best_of_still', $p );
        $excerpt    = get_field( 'best_of_excerpt', $p );
        $synopsis   = get_field( 'film_synopsis', $p );
        $credits    = get_field( 'filmmakers', $p );
        $countries  = get_field( 'film_country', $p );
        $length     = get_field( 'running_time', $p );
        if ( $award )
        {
            $output .= ' <div class="winner">';
            $output .= '     <div class="row">';
            if( ! empty( $award ) ) {
                if( !is_wp_error( $award ) ){
            $output .= '         <div class="col-xs-12 col-sm-6">';
                    foreach($award as $term){
            $output .= '             <span class="laurel ' . $term->slug . '"></span>';
                    }
            $output .= '         </div>';
                }
            }
            if ( ! empty( $still ) ) {
            $output .= '         <div class="hidden-xs col-sm-6">';
            $output .= '             <img class="img-responsive thumbnail" src="'.$still.'" alt="'.$title.'" />';
            $output .= '         </div>';
            }
            $output .= '     </div>';
            $output .= '     <h3>';
            $output .= '         <a href="' . $link . '">' . $title . '</a> ';
            $output .= '         <small>(' . implode(', ', $countries) . ', ' . $length . ' min)</small>';
            $output .= '     </h3>';
            if ( $credits ) {
            $output .= '     <ul class="list-inline">';
                foreach ( $credits as $credit ){
                    $role = $credit[ 'filmmaker_role' ];
                    $name = $credit[ 'filmmaker_name' ];
            $output .= '         <li><b>' . $role . ' ' . $name . '</b></li>';
                }
            $output .= '     </ul>';
            }
            if ( $excerpt ) {
            $output .=       $excerpt;
            } else {
            $output .=       $synopsis;
            }
            $output .= ' </div>';
        }
    } endif;
    return $output;
}



?>