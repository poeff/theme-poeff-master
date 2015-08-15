<?php
$copyright  = get_field('copyright_info', options);
$legal      = get_field('legal_info', options);
$facebook   = get_field('facebook_link', options);
$twitter    = get_field('twitter_link', options);
$vimeo      = get_field('vimeo_link', options);
$instagram  = get_field('instagram_link', options);
$email      = get_field('email_link', options);
$modals     = get_field('modals', options);
?>
    </div><!-- #content -->
    <footer id="colophon" class="site-footer" role="contentinfo">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="sponsors col-sm-7">
                        <h3>Sponsors <small><a href="/sponsors">View All</a></small></h3>
<!--                         <div class="hidden-xs hidden-sm">
                            < ?php echo do_shortcode( '[sponsors level="premium" columns="3"]' ); ?>
                        </div>
                        <div class="visible-xs visible-sm">
                            < ?php echo do_shortcode( '[sponsors level="premium" columns="2"]' ); ?>
                        </div> -->
                        <?php echo do_shortcode( '[sponsors level="premium" columns="3" mobile="2"]' ); ?>
                    </div>

                    <div class="site-info col-sm-4 col-sm-offset-1">

                            <h3>Sign up for our Newsletter</h3>
                            <?php echo do_shortcode( '[mc4wp_form]' ); ?>


                        <div class="social-links text-center">
                            <ul class="list-inline">
                                <li class="search" id="search-wrap">
                                    <?php get_search_form(); ?>
                                </li>
                                <?php if ( $twitter) : ?>
                                    <li>
                                        <a href="//twitter.com/<?php echo $twitter; ?>" target="_blank">
                                            <i class="fa fa-twitter fa-2x"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>                                
                                <?php if ( $facebook ) : ?>
                                    <li>
                                        <a href="//facebook.com/<?php echo $facebook; ?>" target="_blank">
                                            <i class="fa fa-facebook-official fa-2x"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if ( $instagram ) : ?>
                                    <li>
                                        <a href="//instagram.com/<?php echo $instagram; ?>" target="_blank">
                                            <i class="fa fa-instagram fa-2x"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if ( $vimeo ) : ?>
                                    <li>
                                        <a href="//vimeo.com/<?php echo $vimeo; ?>" target="_blank">
                                            <i class="fa fa-vimeo fa-2x"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a href="#contactModal" data-toggle="modal">
                                        <i class="fa fa-envelope fa-2x"></i>
                                    </a>
                                </li>

                                <li class="search">
                                    <a href="#" class="show-search">
                                        <i class="fa fa-search fa-2x"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .site-info -->
                </div>

                <div class="row">
                    <div class="col-xs-12 legal">

                        <nav>
                        <?php
                        $args = array('theme_location' => 'footer',
                                      'container_class' => '',
                                      'menu_class' => 'nav navbar-nav',
                                      'fallback_cb' => '',
                                      'menu_id' => 'footer-menu',
                                      'walker' => new Upbootwp_Walker_Nav_Menu());
                        wp_nav_menu($args);
                        ?>
                        <p class="navbar-text navbar-right">
                            &copy; 2008&ndash;<?php echo date('Y'); ?><?php if ( $copyright ) echo ', ' . $copyright; ?>
                        </p>
                        </nav>
                    </div>
                </div>

            </div><!-- .col-md-12 -->
        </div><!-- .row -->
    </div><!-- container -->
                </footer><!-- #colophon -->

<div class="disclaimer">
    <div class="container">
        <?php if ( $legal ) echo $legal; ?>
    </div>
</div>


</div><!-- #page -->

<?php
if ( $modals )
{
    foreach ( $modals as $modal )
    {
        $modal_title    = $modal['modal_title'];
        $modal_content  = $modal['modal_content'];
        $modal_link     = $modal['modal_link'];

        echo '<div class="modal fade" id="' . $modal_link . 'Modal" tabindex="-1" role="dialog" aria-labelledby="' . $modal_link . 'ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="' . $modal_link . 'ModalLabel">' . $modal_title . '</h3>
                    </div>
                    <div class="modal-body">'. $modal_content .'</div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->';
    }
}
?>

<?php wp_footer(); ?>
</body>
</html>