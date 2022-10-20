(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		(function($) {
		  jQuery('a[href*=#]:not([href=#])').click(function() 
		  {
		    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
		        || location.hostname == this.hostname) 
		    {
		      
		      var target = jQuery(this.hash),
		      headerHeight = jQuery(".sticky-header").height() + 20; // Get fixed header height
		            
		      target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
		              
		      if (target.length) 
		      {
		        jQuery('html,body').animate({
		          scrollTop: target.offset().top - headerHeight
		        }, 900);
		        
		        return false;
		      }
		      
		    }
		  });
		})(jQuery);
		
		Chocolat(document.querySelectorAll('.chocolat-image'), {
			container: document.querySelector('body'),
			allowZoom: false
		});
		
		Chocolat(document.querySelectorAll('.chocolat-image-single'), {
			linkImages: false,
			allowZoom: false
		});
		
		
		jQuery(".sticky-header").on('click', function(){
			jQuery("#video-menu").slideToggle();
			var playerMenu = videojs('playermenu');
			playerMenu.play();
		});		
		jQuery("#mb-button").on('click', function(){
			jQuery("#video-menu").slideToggle();
			var playerMenu = videojs('playermenu');
			playerMenu.play();
		});
		jQuery(".menu-close").on('click', function(){
			jQuery("#video-menu").slideToggle();
			var playerMenu = videojs('playermenu');
			playerMenu.pause();
		});	
	
		jQuery(".menu-item-has-children").hover(
		    function () {
		        jQuery(this).children(".sub-menu").slideDown(300);
		        jQuery(this).children(".sub-menu").children("li").addClass('open-li');
		    }, 
		    function () {
		        jQuery(this).children(".sub-menu").slideUp(100);
		        jQuery(this).children(".sub-menu").children("li").removeClass('open-li');
		    }
		);
	
		jQuery('.lightboxbox').on('click', function(e){
			if( jQuery(e.target).closest('.lightbox-inner').length === 0 ) {
				jQuery(".lightbox-overlay").fadeOut();
				jQuery(".lightboxbox").removeClass('lbb-open');
				jQuery('body').removeClass('stuck');
				console.log('active');
			}
		});
		
		jQuery(".lightbox-active").on('click', function(){
			jQuery(".lightbox-overlay").fadeIn();
			jQuery(".lightboxbox").addClass('lbb-open');
			jQuery('.sticky-header').removeClass('nav-down');
			jQuery('body').addClass('stuck');
		});	
		
		jQuery('.lb-close').on('click', function(e){
			jQuery(".lightbox-overlay").fadeOut();
			jQuery(".lightboxbox").removeClass('lbb-open');
			jQuery('body').removeClass('stuck');
		});
		
		
		jQuery(".lightbox-inner").on('mousemove', function(e) {
		    var mouseSide;
		    if ((e.pageX - this.offsetLeft) < jQuery(this).width() / 2) {
		        jQuery('.lb-prev').addClass('lbn-open');
		        jQuery('.lb-next').removeClass('lbn-open');
		    } else {
		        jQuery('.lb-next').addClass('lbn-open');
		        jQuery('.lb-prev').removeClass('lbn-open');
		    }
		});
		
		jQuery(".lightbox-inner").on('mouseout', function(e) {
		    jQuery('.lb-prev').removeClass('lbn-open');
		    jQuery('.lb-next').removeClass('lbn-open');
		});
		
		jQuery(".lightbox-inner").on('click', function(e) {
		    jQuery('.lb-prev').removeClass('lbn-open');
		    jQuery('.lb-next').removeClass('lbn-open');
		});
		
	});
	
})(jQuery, this);
