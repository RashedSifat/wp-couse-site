<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
        <link rel="stylesheet" href="https://use.typekit.net/iir6dpi.css">
        <link href="//vjs.zencdn.net/7.3.0/video-js.min.css" rel="stylesheet">
		<script src="//vjs.zencdn.net/7.3.0/video.min.js"></script>

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">
		

		<?php wp_head(); ?>
		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
        </script>

	</head>
	<body <?php body_class(); ?>>

		<!-- wrapper -->
		<div class="wrapper">

			<!-- header -->
			<header class="header clear" role="banner">

				<div class="main-logo">
					<a href="<?php echo home_url(); ?>">
						
						<img src="<?php echo get_template_directory_uri(); ?>/img/logo-black.svg" alt="Logo" class="logo-img mobileHide">
						<img src="<?php echo get_template_directory_uri(); ?>/img/logo-black.svg" alt="Logo" class="logo-img mobileShow">
					</a>
				</div>
				<div class="main-menu">
					<?php 
						wp_nav_menu( array( 'menu' => '2' ) );
					?>
				</div>
				<div class="mobile-button mobileShow" id="mb-button">
					<img src="<?php echo get_template_directory_uri(); ?>/img/menu-button-gradient.svg">
				</div>
			</header>
			<!-- /header -->
			<div class="sticky-header">
				<img src="<?php echo get_template_directory_uri(); ?>/img/logo-white.svg">
				<div class="mobile-button">
					<img src="<?php echo get_template_directory_uri(); ?>/img/menu-button-gradient.svg">
				</div>
			</div>
			
			<div class="full-screen" style="display:none;" id="video-menu">
				
				
				<div id="player-parent">
					<video-js class="full-video" id=playermenu autoplay muted loop>
					  <source
					  src="https://player.vimeo.com/external/400778940.m3u8?s=799c11450406facad660ed8f84192c73c522209b"
					    type="application/x-mpegURL">
					</video-js>
				</div>
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
					<div class="splash-footer" role="contentinfo">
						<div class="soc-icons">
							<a href="" target="_blank" id="email2"><img src="<?php echo get_template_directory_uri(); ?>/img/email-black.svg" height="14"></a>
							<a href="" target="_blank" id="insta2"><img src="<?php echo get_template_directory_uri(); ?>/img/insta-black.svg" height="14"></a>
							<a href="" target="_blank" id="vim2"><img src="<?php echo get_template_directory_uri(); ?>/img/vim-black.svg" height="14"></a>
						</div>
						<p class="copyright">
							&copy; <?php echo date('Y'); ?> Copyright Theo Stanley
						</p>
					</div>
				</div>
				<div class="menu-close">
					<img src="<?php echo get_template_directory_uri(); ?>/img/x-gradient-2.svg" height="34">
				</div>
			</div>
