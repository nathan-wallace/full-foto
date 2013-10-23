<?php get_header(); ?>

     <!-- Wrap the rest of the page in another container to center all the content. -->
<div class="filter">  <div class="container">  
<div class="filtered">  
      
 <?php /* The Loop — with comments! */ ?>         
<?php while ( have_posts() ) : the_post() ?>
 
<?php /* Create a div with a unique ID thanks to the_ID() and semantic classes with post_class() */ ?>       
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>            
<?php /* an h2 title */ ?>                           
                    <div class="page-header"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'full-foto'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></div>
                     

<?php /* The entry content */ ?>                 
                    <div class="entry-content">  
<?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'full-foto' )  ); ?>
<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'full-foto' ) . '&after=</div>') ?>
                    </div><!-- .entry-content -->
 
                </div><!-- #post-<?php the_ID(); ?> -->
 
<?php /* Close up the post div and then end the loop with endwhile */ ?>     
     
<?php endwhile; ?>        
 
<?php get_footer(); ?>