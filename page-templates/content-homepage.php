<?php
/**
 * Template Name: Page - Home
 */

get_header();

$feed               = get_field('news_feed');
$length             = get_field('feed_length');
$quick              = get_field('quicklinks');
$poster             = get_field('ql_poster');
$qHeader            = get_field('ql_header');
$qLinks             = get_field('ql_links');
$slider             = get_field('slider');
$slide              = get_field('slide');
$timeout            = get_field('timeout');
$fx                 = get_field('fx');
$navigation         = get_field('navigation');
$pager              = get_field('pager');
$mission            = get_field('mission_statement');
$n                  = 1;
?>

    <div class="container">

        <?php
        if ( $slider === 'on' ) {
            echo '<div class="cycle-slideshow hidden-xs"
                        data-cycle-log="false"
                        data-cycle-pause-on-hover="true"
                        data-cycle-timeout="' . $timeout . '"
                        data-cycle-fx="' . $fx . '"
                        data-cycle-slides=".slide">';
                foreach ($slide as $s) {
                    $slide_text = $s['caption'];
                    $slide_image = $s['image'];
                    $links = $s['link'];
                    $link_close = '</a>';
                    if ( $links === 'none' ) {
                        $link_open = '';
                        $link_close = '';
                    }
                    if ( $links === 'page' ) {
                        $link_open = '<a href="' . $s['page_link'] . '">';
                    }
                    if ( $links === 'film' ) {
                        $link_open = '<a href="' . $s['film_link'] . '">';
                    }
                    if ( $links === 'post' ) {
                        $link_open = '<a href="' . $s['post_link'] . '">';
                    }
                    if ( $links === 'url' ) {
                        $link_open = '<a href="' . $s['url_link'] . '">';
                    }
                    echo '<div class="slide text-center" id="slide-' . $n . '">';
                        echo $link_open;
                            if ( $slide_text ) {
                                echo '<div class="slide-text">' . $slide_text . '</div>';
                            }
                            if ( $slide_image ) {
                                echo '<img class="slide-image img-responsive" src="' . $slide_image . '" alt="slide" />';
                            }
                        echo $link_close;
                    echo '</div>';
                    $n++;
                } // foreach
                if ( $navigation === 'on' ) {
                    echo '<div class="cycle-prev"><i class="fa fa-chevron-left"></i></div>';
                    echo '<div class="cycle-next"><i class="fa fa-chevron-right"></i></div>';
                }
                if ( $pager === 'on' ) {
                    echo '<div class="cycle-pager hidden-xs"></div>';
                }
            echo '</div><!--cycle-slideshow-->';
        }
        ?>

        <div class="row">
            <div class="col-md-8">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">

                        <?php while ( have_posts() ) : the_post(); ?>

                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <header class="entry-header">
                                </header><!-- .entry-header -->

                                <div class="entry-content">
                                <?php
                                if ( $quick == 'on' ) {
                                    echo '<div class="well visible-xs visible-sm hidden-md hidden-lg">';
                                    echo '<div class="row">';
                                    if ( $poster ) {
                                        echo '<div class="col-xs-5">';
                                        echo '<img class="img-responsive" src="'. $poster['url'] .'" alt=" '. $poster['alt'] .'" />';
                                        echo '</div>';
                                    }
                                    if ( $qLinks ) {
                                        echo '<div class="col-xs-7">';
                                        echo '<dl class="quicklinks">';
                                        if ( $qHeader ) echo '<dt class="h4">'.$qHeader.'</dt>';
                                        foreach ($qLinks as $ql) {
                                            echo '<dd><a href="'.$ql['ql_url'].'">'.$ql['ql_text'].'</a></dd>';
                                        }
                                        echo '</dl>';
                                        echo '</div>';
                                    }
                                    echo '</div></div>';
                                }
                                ?>

                                <?php
                                $args = array(
                                            'post_type'      => 'post',
                                            'category__in'   => $feed,
                                            'posts_per_page' => $length,
                                            'orderby'        => 'date',
                                            'order'          => DESC,
                                            'meta_key'       => 'show_on_home',
                                            'meta_value'     => 'yes'
                                        );
                                $loop = new WP_Query( $args );

                                while ( $loop->have_posts() ) : $loop->the_post();
                                    get_template_part( 'content', 'single' );
                                endwhile;
                                wp_reset_postdata();
                                ?>

                                    <ul class="list-inline">
                                        <li>
                                            <a href="category/news/" class="btn btn-info btn-sm">
                                                <i class="fa fa-bookmark"></i>&nbsp;&nbsp;See All POEFF News
                                            </a>
                                        </li>
                                        <li>
                                            <a href="category/news/feed" class="btn btn-info btn-sm" target="_blank">
                                                <i class="fa fa-rss"></i>&nbsp;&nbsp;Subscribe to RSS
                                            </a>
                                        </li>
                                    </ul>

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
                <?php
                if ( $quick == 'on' ) {
                    echo '<div class="well hidden-xs hidden-sm visible-md visible-lg">';
                    echo '<div class="row">';
                    if ( $poster ) {
                        echo '<div class="col-sm-5">';
                        echo '<img class="img-responsive" src="'. $poster['url'] .'" alt=" '. $poster['alt'] .'" />';
                        echo '</div>';
                    }
                    if ( $qLinks ) {
                        echo '<div class="col-sm-7">';
                        echo '<dl class="quicklinks">';
                        if ( $qHeader ) echo '<dt class="h4">'.$qHeader.'</dt>';
                        foreach ($qLinks as $ql) {
                            echo '<dd><a href="'.$ql['ql_url'].'">'.$ql['ql_text'].'</a></dd>';
                        }
                        echo '</dl>';
                        echo '</div>';
                    }
                    echo '</div></div>';
                }
                echo '<div class="mission">';
                    echo '<h2>Our Mission</h2>';
                    echo $mission;
                echo '</div><br>';
                get_sidebar( 'social' );
                ?>
            </div><!-- .col-md-4 -->
        </div><!-- .row -->
    </div><!-- .container -->
<?php get_footer(); ?>
