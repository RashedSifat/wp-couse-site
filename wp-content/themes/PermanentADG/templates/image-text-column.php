<?php 
	$image = get_sub_field('image');
	$text = get_sub_field('text');
	$position = get_sub_field('image_position');
	$title1 = get_sub_field('section_title');
	$title = $title1['title'];
	$width = get_sub_field('width');
	$link = preg_replace('#[ -]+#', '-', trim($title));
?>
<div class="pad">
<div class="full" id="<?php echo $link;?>" style="width: <?php echo $width;?>%;">
	<div class="half-image" <?php if(!$position):?>style="float:right;"<?php endif;?>>
		<a href="<?php echo esc_url($image['sizes']['large']); ?>" class="chocolat-image-single" rel="lightbox"><img src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" /></a>
	</div>
	<div class="half-text" <?php if(!$position):?>style="padding-right:10px;"<?php else:?>style="padding-left:10px;"<?php endif;?>>
		<?php echo $text; ?>
	</div>
</div>
</div>