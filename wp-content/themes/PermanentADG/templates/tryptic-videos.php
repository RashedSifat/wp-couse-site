<?php 
	$video1 = get_sub_field('video_1');
	$video2 = get_sub_field('video_2');
	$video3 = get_sub_field('video_3');
	$video1L = $video1['link'];
	$video2L = $video2['link'];
	$video3L = $video3['link'];
	$title = get_sub_field('section_title');
	$link = preg_replace('#[ -]+#', '-', trim($title));
	$left = 'left center';
	$right = 'right center';
	$center = 'center center';
	if($video1['poster_position'] == 'Left') {
		$video1PP = $left;
	} elseif($video1['poster_position'] == 'Right') {
		$video1PP = $right;
	} else {
		$video1PP = $center;
	}
	if($video2['poster_position'] == 'Left') {
		$video2PP = $left;
	} elseif($video2['poster_position'] == 'Right') {
		$video2PP = $right;
	} else {
		$video2PP = $center;
	}
	if($video3['poster_position'] == 'Left') {
		$video3PP = $left;
	} elseif($video3['poster_position'] == 'Right') {
		$video3PP = $right;
	} else {
		$video3PP = $center;
	}
	
	
?>
<div class="tryptic-outer">
	<div class="tryptic-inner" id="tryp<?php echo $blockNumber;?>1" style="background-image:url(<?php echo $video1['poster_image']['sizes']['small'];?>);background-position:<?php echo $video1PP;?>">
		<div class="tryp-video">
			<video-js class="full-video" id=splash-<?php echo $blockNumber;?>a muted>
				<source
			    src="<?php echo $video1['video_url'];?>"
			    type="application/x-mpegURL">
			</video-js>
			<script>
				var player<?php echo $blockNumber;?>a = videojs('splash-<?php echo $blockNumber;?>a');
			</script>
		</div>
		<div class="tryp-info">
			<?php if( $video1L ): $post = $video1L;setup_postdata( $post ); ?>
				<div class="tryp-info-inner">
				
						<a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/play-gradient-3.svg" width="30"></a>
						<div class="info-inner">
				    		<h3><?php the_title(); ?></h3>
							<a href="<?php the_permalink(); ?>" class="full-link"></a>
						</div>
				    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
				
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="tryptic-inner" id="tryp<?php echo $blockNumber;?>2" style="background-image:url(<?php echo $video2['poster_image']['sizes']['small'];?>);background-position:<?php echo $video2PP;?>">
		<div class="tryp-video">
			<video-js class="full-video" id=splash-<?php echo $blockNumber;?>b muted>
				<source
			    src="<?php echo $video2['video_url'];?>"
			    type="application/x-mpegURL">
			</video-js>
			<script>
				var player<?php echo $blockNumber;?>b = videojs('splash-<?php echo $blockNumber;?>b');
			</script>
		</div>
		<div class="tryp-info">
			<?php if( $video2L ): $post = $video2L;setup_postdata( $post ); ?>
				<div class="tryp-info-inner">
				
						<a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/play-gradient-3.svg" width="30"></a>
						<div class="info-inner">
				    		<h3><?php the_title(); ?></h3>
							<a href="<?php the_permalink(); ?>" class="full-link"></a>
						</div>
				    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
				
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="tryptic-inner" id="tryp<?php echo $blockNumber;?>3" style="background-image:url(<?php echo $video3['poster_image']['sizes']['small'];?>);background-position:<?php echo $video3PP;?>">
		<div class="tryp-video">
			<video-js class="full-video" id=splash-<?php echo $blockNumber;?>c muted>
				<source
			    src="<?php echo $video3['video_url'];?>"
			    type="application/x-mpegURL">
			</video-js>
			<script>
				var player<?php echo $blockNumber;?>c = videojs('splash-<?php echo $blockNumber;?>c');
			</script>
		</div>
		<div class="tryp-info">
			<?php if( $video3L ): $post = $video3L;setup_postdata( $post ); ?>
				<div class="tryp-info-inner">
				
						<a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/play-gradient-3.svg" width="30"></a>
						<div class="info-inner">
				    		<h3><?php the_title(); ?></h3>
							<a href="<?php the_permalink(); ?>" class="full-link"></a>
						</div>
				    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
				
				</div>
			<?php endif; ?>
		</div>
	</div>
	<script>
		jQuery( "#tryp<?php echo $blockNumber;?>1" ).mouseenter(function() {
			jQuery(this).addClass('tryp-open');
			jQuery("#tryp<?php echo $blockNumber;?>1 .tryp-info").addClass('info-open');
			jQuery("#tryp<?php echo $blockNumber;?>2").addClass('tryp-squish');
			jQuery("#tryp<?php echo $blockNumber;?>3").addClass('tryp-squish');
			player<?php echo $blockNumber;?>a.play();
		});
		jQuery( "#tryp<?php echo $blockNumber;?>1" ).mouseleave(function() {
			jQuery(this).removeClass('tryp-open');
			jQuery("#tryp<?php echo $blockNumber;?>1 .tryp-info").removeClass('info-open');
			jQuery("#tryp<?php echo $blockNumber;?>2").removeClass('tryp-squish');
			jQuery("#tryp<?php echo $blockNumber;?>3").removeClass('tryp-squish');
			player<?php echo $blockNumber;?>a.pause();
		});
		jQuery( "#tryp<?php echo $blockNumber;?>2" ).mouseenter(function() {
			jQuery(this).addClass('tryp-open');
			jQuery("#tryp<?php echo $blockNumber;?>2 .tryp-info").addClass('info-open');
			jQuery("#tryp<?php echo $blockNumber;?>1").addClass('tryp-squish');
			jQuery("#tryp<?php echo $blockNumber;?>3").addClass('tryp-squish');
			player<?php echo $blockNumber;?>b.play();
		});
		jQuery( "#tryp<?php echo $blockNumber;?>2" ).mouseleave(function() {
			jQuery(this).removeClass('tryp-open');
			jQuery("#tryp<?php echo $blockNumber;?>2 .tryp-info").removeClass('info-open');
			jQuery("#tryp<?php echo $blockNumber;?>1").removeClass('tryp-squish');
			jQuery("#tryp<?php echo $blockNumber;?>3").removeClass('tryp-squish');
			player<?php echo $blockNumber;?>b.pause();
		});
		jQuery( "#tryp<?php echo $blockNumber;?>3" ).mouseenter(function() {
			jQuery(this).addClass('tryp-open');
			jQuery("#tryp<?php echo $blockNumber;?>3 .tryp-info").addClass('info-open');
			jQuery("#tryp<?php echo $blockNumber;?>2").addClass('tryp-squish');
			jQuery("#tryp<?php echo $blockNumber;?>1").addClass('tryp-squish');
			player<?php echo $blockNumber;?>c.play();
		});
		jQuery( "#tryp<?php echo $blockNumber;?>3" ).mouseleave(function() {
			jQuery(this).removeClass('tryp-open');
			jQuery("#tryp<?php echo $blockNumber;?>3 .tryp-info").removeClass('info-open');
			jQuery("#tryp<?php echo $blockNumber;?>2").removeClass('tryp-squish');
			jQuery("#tryp<?php echo $blockNumber;?>1").removeClass('tryp-squish');
			player<?php echo $blockNumber;?>c.pause();
		});
	</script>
</div>