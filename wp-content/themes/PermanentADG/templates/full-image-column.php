<?php 
	$image = get_sub_field('image');
	$width = get_sub_field('image_width');
	$title1 = get_sub_field('section_title');
	$title = $title1['title'];
	$link = preg_replace('#[ -]+#', '-', trim($title));
?>
<div class="pad" id="<?php echo $title;?>">
<div class="full-image" style="width: <?php echo $width;?>%;" >
	<a href="<?php echo esc_url($image['sizes']['large']); ?>" class="chocolat-image-single" rel="lightbox"><img src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" /></a>
</div>
</div>