<?php
/**
 * Twitter/Facebook/Instagram widgets.
 */

$facebook_widget    = get_field('facebook_widget', options);
$twitter_widget     = get_field('twitter_widget', options);

?>

    <div id="secondary" class="widget-area" role="complementary">
        <div class="row">
            <div class="col-xs-12">
                <aside id="twitter" class="widget">
                    <?php if ( $twitter_widget ) echo $twitter_widget; ?>
                </aside>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-xs-12">
                <aside id="facebook" class="widget">
                    <?php if ( $facebook_widget ) echo $facebook_widget; ?>
                </aside>
            </div>
        </div>
    </div><!-- #secondary -->
