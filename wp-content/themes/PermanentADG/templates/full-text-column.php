<?php 
	$text = get_sub_field('text');
	$width = get_sub_field('text_width');
	$title1 = get_sub_field('section_title');
	$title = $title1['title'];
	$link = preg_replace('#[ -]+#', '-', trim($title));
?>
<div class="pad" id="<?php echo $link;?>">
	<div class="full-text" style="width: <?php echo $width;?>%;">
		<?php echo $text; ?>
	</div>
</div>