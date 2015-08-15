<?php
/**
 *  Content Template
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        <?php if ( 'post' == get_post_type() ) : ?>
        <div class="entry-meta">
            <?php
            $categories = get_the_category();
            foreach ( $categories as $c ) {
                $name = $c->name;
                $slug = $c->slug;
                switch( $name ) {
                    case 'News':    $label = 'label-success';   break;
                    case 'Blog':    $label = 'label-warning';   break;
                    case 'Press':   $label = 'label-danger';    break;
                    default:        $label = 'label-info';
                }
                echo '<span class="cat-links label '.$label.'"><a href="/category/'.$slug.'">'.$name.'</a></span>';
            }
            ?>
            <?php upbootwp_posted_on(); ?>
        </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <?php if ( is_search() || is_home() ) : // Only display Excerpts for Search ?>
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div><!-- .entry-summary -->
    <?php else : ?>
    <div class="entry-content">
        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'upbootwp')); ?>
        <?php
            wp_link_pages( array(
                'before' => '<div class="page-links">' . __( 'Pages:', 'upbootwp' ),
                'after'  => '</div>',
            ));
        ?>
    </div><!-- .entry-content -->
    <?php endif; ?>

    <footer class="entry-meta">
        <?php if ( !is_search() ) : ?>
            <div class="row">
                <div class="col-xs-6">
                    <?php echo do_shortcode('[ssba url="'.get_permalink().'" title="'.get_the_title().'"]'); ?>
                </div>

                <div class="col-xs-6 text-right">
                    <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
                    <span class="comments-link btn btn-info">
                        <i class="fa fa-comments"></i>
                        <?php comments_popup_link( __( 'Leave a comment', 'upbootwp' ), __( '1 Comment', 'upbootwp' ), __( '% Comments', 'upbootwp' ) ); ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </footer><!-- .entry-meta -->
</article><!-- #post-## -->
