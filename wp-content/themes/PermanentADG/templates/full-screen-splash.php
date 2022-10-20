<?php 
	$video = get_sub_field('video_url');
	$image = get_sub_field('poster_image');
	$menu = get_sub_field('menu_id');

?>
<div class="full-screen">
	<video-js class="full-video" id=splash-<?php echo $blockNumber;?> autoplay muted loop>
	  <source
	     src="<?php echo $video;?>"
	     type="application/x-mpegURL">
	</video-js>
	
	<script>
		jQuery(window).load(function(){
			var player<?php echo $blockNumber;?> = videojs('splash-<?php echo $blockNumber;?>');
			player<?php echo $blockNumber;?>.play();
		});
		
	</script>
	
	<div class="splash-header">
		<div class="splash-logo">
			<a href="<?php echo home_url(); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/img/logo-white.svg" alt="Logo" class="logo-img mobileHide">
				<img src="<?php echo get_template_directory_uri(); ?>/img/logo-white.svg" alt="Logo" class="logo-img mobileShow">
			</a>
		</div>
		<div class="splash-menu">
			<div class="splash-menu-button mobileShow">MENU</div>
			<?php 
				wp_nav_menu( array( 'menu' => '2' ) );
			?>
			<script>
				jQuery('.splash-menu-button').on('click', function(){
					jQuery('.splash-menu ul.menu').slideToggle();
				});
			</script>
		</div>
		
		<!-- footer -->
		<div class="splash-footer" role="contentinfo">
			
			<div class="soc-icons">
				<a href="" target="_blank" id="email2"><img src="<?php echo get_template_directory_uri(); ?>/img/email-black.svg" height="14"></a>
				<a href="" target="_blank" id="insta2"><img src="<?php echo get_template_directory_uri(); ?>/img/insta-black.svg" height="14"></a>
				<a href="" target="_blank" id="vim2"><img src="<?php echo get_template_directory_uri(); ?>/img/vim-black.svg" height="14"></a>
			</div>
			
			<!-- copyright -->
			<p class="copyright">
				&copy; <?php echo date('Y'); ?> Copyright Theo Stanley
			</p>
			<!-- /copyright -->

		</div>
		<!-- /footer -->
	</div>
	
</div>