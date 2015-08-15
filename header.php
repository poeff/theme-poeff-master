<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/favicon-194x194.png" sizes="194x194">
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffc40d">
<meta name="msapplication-TileImage" content="/mstile-144x144.png">
<meta name="theme-color" content="#ffffff">
<script type="text/javascript">
  (function(d) {
    var config = {
      kitId: 'ywo0yzp',
      scriptTimeout: 3000
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
  })(document);
</script>
<?php wp_head(); ?>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body <?php body_class(); ?>>
<?
if ( is_front_page() || is_page_template( 'page-templates/content-blog.php' ) || is_single() ) {
    $facebook_widget_script = get_field('facebook_widget_script', options);
    if ( $facebook_widget_script ) echo $facebook_widget_script . "\n";
}
?>
<div id="page" class="hfeed site">
    <?php do_action( 'before' ); ?>
    <header id="masthead" class="site-header container" role="banner">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="navbar-header pull-left">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
<!--
                            <a href="< ?php echo esc_url( home_url( '/' ) ); ?>" title="< ?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"  class="navbar-brand">< ?php bloginfo( 'name' ); ?></a>
-->
                        </div>

                        <ul class="nav navbar-nav navbar-right" id="donate-nav">
                            <li><button type="button" class="btn btn-success navbar-btn pull-right" data-toggle="modal" data-target="#donateModal">Donate to POEFF!</button></li>
                        </ul>

                        <?php
                        $args = array('theme_location' => 'primary',
                                      'container_class' => 'navbar-collapse collapse',
                                      'menu_class' => 'nav navbar-nav',
                                      'fallback_cb' => '',
                                      'menu_id' => 'main-menu',
                                      'walker' => new Upbootwp_Walker_Nav_Menu());
                        wp_nav_menu($args);
                        ?>
                    </div><!-- .col-md-12 -->
                </div><!-- row -->
            </div><!-- container -->
        </nav>

    </header><!-- #masthead -->

<div class="site-header">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="site-title">
                    <ul class="list-inline clearfix">
                        <li class="logo-globe">
                            <img class="img-responsive" src="<?php the_field( 'site_logo', options ); ?>" alt="" />
                        </li>
                        <li class="logo-text">
                            <span class="site-name">
                                <span class="site-name-top">Peace On Earth</span>
                                <span class="site-name-bottom">Film Festival</span>
                            </span>
                            <span class="site-slogan"><?php bloginfo( 'description' ); ?></span>
                        </li>
                        <li class="logo-year">
                            <span class="festival-date"><?php the_field('festival_date', options); ?></span>
                            <span class="festival-year">
                                <?php
                                $icons      = get_field( 'site_icons', options );
                                $icon1      = $icons[0];
                                $icon2      = $icons[1];
                                $icon3      = $icons[2];
                                $icon4      = $icons[3];
                                $full_year  = get_field( 'festival_year', options );
                                $year       = str_split( $full_year );
                                ?>
                                <span style="background-image:url(<?= $icon1['icon_image']; ?>);" class="dove"><?= $year[0]; ?></span>
                                <span style="background-image:url(<?= $icon2['icon_image']; ?>);" class="heart"><?= $year[1]; ?></span>
                                <span style="background-image:url(<?= $icon3['icon_image']; ?>);" class="justice"><?= $year[2]; ?></span>
                                <span style="background-image:url(<?= $icon4['icon_image']; ?>);" class="recycle"><?= $year[3]; ?></span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

    <div id="content" class="site-content">
