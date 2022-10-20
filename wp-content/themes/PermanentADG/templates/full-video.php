<?php 
	$video = get_sub_field('video_url');
	$image = get_sub_field('poster_image');
	$menu = get_sub_field('menu_id');
	$playColor = get_sub_field('play_button_color');
	$title1 = get_sub_field('section_title');
	$autoplay = get_sub_field('autoplay');
	$title = $title1['title'];
	$link = preg_replace('#[ -]+#', '-', trim($title));
?>
<div class="boxed-video pad" id="<?php echo $link;?>">
	<div class="embed-container">
		<video-js class="boxed-video vjs-theme-sea" id=splash-<?php echo $blockNumber;?> playsinline controls>
		  <source
		     src="<?php echo $video;?>"
		     type="application/x-mpegURL">
		</video-js>
	</div>
	
	<script>
		jQuery(window).load(function(){
		var player<?php echo $blockNumber;?> = videojs('splash-<?php echo $blockNumber;?>');
			<?php if($autoplay):?>
				player<?php echo $blockNumber;?>.play();
			<?php endif;?>
		});
			
	</script>
	<?php if($playColor):?>
		<style>
			#splash-<?php echo $blockNumber;?> .vjs-big-play-button {
				background-image: url('<?php echo get_template_directory_uri(); ?>/img/play-gradient-3.svg');
			}
			
			#splash-<?php echo $blockNumber;?> .vjs-big-play-button .vjs-icon-placeholder {
				display:none;
			}
		</style>
	<?php endif;?>
</div>