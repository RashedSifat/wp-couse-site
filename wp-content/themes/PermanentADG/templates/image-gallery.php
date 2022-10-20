<?php
	$title1 = get_sub_field('section_title');
	$title = $title1['title'];
	$link = preg_replace('#[ -]+#', '-', trim($title));
	$square = get_sub_field('shape');
?>
<div class="image-gallery pad" id="<?php echo $link;?>">
	<?php 
	$images = get_sub_field('images');
	if( $images ): ?>
	        <?php foreach( $images as $image ): ?>
	            <div class="half<?php if(!$square):?> square-image<?php endif;?>">
	                	<div class="workgalleryinner mobileHide " style="background-image:url(<?php echo esc_url($image['sizes']['medium']); ?>);"></div>
	                    <a href="<?php echo esc_url($image['sizes']['large']); ?>" class="full-link chocolat-image" rel="lightbox"><img class="mobileShow" src="<?php echo esc_url($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
	                    </a>
	                
	            </div>
	        <?php endforeach; ?>
	<?php endif; ?>
</div>