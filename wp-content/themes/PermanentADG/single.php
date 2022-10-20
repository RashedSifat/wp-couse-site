<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="context-menu-pack" style="display:none;">
				<ul class="context-menu">
					<?php
					
						if( have_rows('blocks') ):
						    while ( have_rows('blocks') ) : the_row();							
					
								if( get_row_layout() == 'full_video' ):
						        	include 'templates/menus.php';
					
						        elseif( get_row_layout() == 'image_text_column' ):
						        	include 'templates/menus.php';
						        	
						        elseif( get_row_layout() == 'full_text_column' ):
						        	include 'templates/menus.php';
						        	
						        elseif( get_row_layout() == 'full_image_column' ):
						        	include 'templates/menus.php';
						        	
						        elseif( get_row_layout() == 'image_gallery' ):
						        	include 'templates/menus.php';
					
						        endif;
						    endwhile;
						endif; 
					?>
				</ul>
			</div>

			<div class="inner">
					
				<?php
					
					$blockNumber = 0;

					if( have_rows('blocks') ):
					    while ( have_rows('blocks') ) : the_row();							

							if( get_row_layout() == 'full_screen_splash' ):
								$blockNumber++;
								include 'templates/full-screen-splash.php';

					        elseif( get_row_layout() == 'tryptic_videos' ):
					        	$blockNumber++;
					        	include 'templates/tryptic-videos.php';

					        elseif( get_row_layout() == 'full_video' ):
					        	$blockNumber++;
					        	include 'templates/full-video.php';

					        elseif( get_row_layout() == 'image_text_column' ):
					        	$blockNumber++;
					        	include 'templates/image-text-column.php';
					        	
					        elseif( get_row_layout() == 'full_text_column' ):
					        	$blockNumber++;
					        	include 'templates/full-text-column.php';
					        	
					        elseif( get_row_layout() == 'full_image_column' ):
					        	$blockNumber++;
					        	include 'templates/full-image-column.php';
					        	
					        elseif( get_row_layout() == 'image_gallery' ):
					        	$blockNumber++;
					        	include 'templates/image-gallery.php';

					        elseif( get_row_layout() == 'spacer' ): 
					        	$blockNumber++;
					        	include 'templates/spacer.php';
					        	
					        elseif( get_row_layout() == 'context_menu' ): 
						        	$blockNumber++;
						        	include 'templates/menu.php';

					        endif;
					    endwhile;
					endif;
				?>
				
			</div>
			
			

		</article>
		<!-- /article -->

	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1><?php _e( 'Sorry, nothing to display.', 'permanent' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>

	</section>
	<!-- /section -->
	</main>

<?php get_footer(); ?>
