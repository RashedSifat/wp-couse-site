<?php
/**
 * Template Name: Homepage
 * This is the Custom Homepage Template
 * 
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
?>

<!-- Header Banner Area-->
<section class="py-0" id="features">
	<div class="container px-4 px-lg-5">
		<div class="row gx-4 gx-lg-5 align-items-center my-5">
			<div class="col-lg-6">
		        <h2 class="font-weight-light">Learn how to build an audience and monetize your work with courses from SPI</h2>
		        <p>With topics on branding, email marketing, podcasting, online courses, and webinars, we help beginners transform into pros.</p>
		    </div>
		    <div class="col-lg-6"><img class="img-fluid rounded mb-4 mb-lg-0" src="https://dummyimage.com/900x400/dee2e6/6c757d.jpg" alt="..." /></div>

		</div>
	</div>
</section>


<!-- Courses Area-->

<div class="container px-0 px-lg-5">

<h2 class="text-center py-5">Featured Courses</h2>

<?php 
	$homepageCourse = new WP_Query(array(
		'posts_per_page' => 9,
		'post_type' => 'courses',
	));
	?>

	<div class="row gx-4 gx-lg-5">
	<?php
	while ($homepageCourse -> have_posts()) {
		$homepageCourse -> the_post(); ?>
		
		<div class="col-md-4 mb-5">
            <div class="card h-100">
            	<img class="card-img-top" src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'medium');?>" alt="Card image cap">

                <div class="card-body">
                	<h3 class="card-title"><a href="#"><?php the_title()?></a></h3>

                	<?php if(get_post_meta($post->ID, 'Subtitle', true)): ?>

                		<p class="card-text"><?php echo get_post_meta($post->ID, 'Subtitle', true);?></p>
                	<?php endif; ?>
				</div>	
                

				<div class="card-footer">
					<div class="d-flex justify-content-center">
						<div class="text-left">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
						<?php 
						echo get_the_author_meta('first_name').' '.get_the_author_meta('last_name'); 
						?>
		            	</div>
		            	<?php if(get_post_meta($post->ID, 'Price', true)): ?>
							<h4 class="btn btn-primary text-right">Price: <?php echo get_post_meta($post->ID, 'Price', true);?></h4>
						<?php endif; ?>
					</div>
				</div>

            </div>                    
        </div>
                <?php
	}
?>
</div>

<?php get_footer(); ?>
