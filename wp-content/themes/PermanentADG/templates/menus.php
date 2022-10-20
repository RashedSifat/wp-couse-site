<?php 
	$title1 = get_sub_field('section_title');
	$title = $title1['title'];
	$link = preg_replace('#[ -]+#', '-', trim($title));
?>
<?php if($title['section_title']):?>
<li><a href="#<?php echo $link;?>"><?php echo $title;?></a></li>
<?php endif;?>