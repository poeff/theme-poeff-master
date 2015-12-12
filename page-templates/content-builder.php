<?php
/**
 * Template Name: Page - Layout Builder
 */
get_header(); 

$rows = get_field('row');
?>

<?php while (have_posts()) : the_post(); ?>
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
                    foreach ($rows as $row) {
                        $anchor  = $row['row_anchor'];
                        $columns = $row['column'];
                        
                        if ($anchor) echo '<a id="' . $anchor . '"></a>';
                        echo '<div class="row">';

                            foreach ($columns as $column) {
                                $width      = $column['col_width'];
                                $class      = str_replace('_', '-', $width);
                                $text       = $column['col_text'];
                                $p_obj      = $column['col_post`'];
                                $image      = $column['col_image'];
                                $align      = $column['col_image_align'];
                                $link       = $column['col_image_link'];
                                $target     = $column['col_image_link_target'];
                                $video      = $column['col_video'];
                                $form       = $column['col_form'];
                                $accordions = $column['col_accordions'];
                                $extra      = $column['col_class'];
                                $visible    = $column['col_hide'];
                                if ( $visible != 1 ) 
                                {
                                    if ( $extra ) echo '<div class="' . $class . ' ' . $extra . '">';
                                    else          echo '<div class="' . $class . '">';
                                        if ( $text ) echo $text;
                                        if ( $p_obj )
                                        {
                                            $p = $p_obj;
                                            setup_postdata( $p );
                                                echo '<h3>' . the_title() . '</h3>';
                                                echo the_content();
                                            wp_reset_postdata();
                                        }
                                        if ( $align != 'none' ) {
                                        	$alignClass = $align;
                                        } else {
                                        	$alignClass = '';
                                        }
                                        if ( $image ) {
                                        	if ( $link ) echo '<a href="'.$link.'" target="'.$target.'">';
                                        		echo '<img class="img-responsive '.$alignClass.'" alt="" src="' . $image . '" />';
                                        	if ( $link ) echo '</a>';
                                        }
                                        if ( $video ) echo '<div class="embed-container">' . $video . '</div>';
                                        if ( $form )  echo $form;
                                        if ( $accordions ) {
                                            $a = get_the_ID();
                                            $p = 1;
                                            echo '<div class="panel-group" id="accordion-'.$a.'">';
                                            foreach ($accordions as $accordion) {
                                                echo'
                                                  <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                      <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion-'.$a.'" href="#collapse-'.$a.'-'.$p.'">
                                                          ' . $accordion['accordion_title'] . '
                                                        </a>
                                                      </h4>
                                                    </div>
                                                    <div id="collapse-'.$a.'-'.$p.'" class="panel-collapse collapse">
                                                      <div class="panel-body">
                                                        ' . $accordion['accordion_content'] . '
                                                      </div>
                                                    </div>
                                                  </div>';
                                            $p++;
                                            }
                                            echo '</div>';
                                        }
                                    echo '</div>';
                                }
                            }
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
<!--
                < ?php edit_post_link( __( 'Edit', 'upbootwp' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
-->
            </div><!-- .col-md-12 -->
        </div><!-- .row -->
    </div><!-- .container -->
<?php get_footer(); ?>
