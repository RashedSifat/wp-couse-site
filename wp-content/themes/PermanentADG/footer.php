			<!-- footer -->
			<footer class="footer" role="contentinfo">
				
				<div class="soc-icons">
					<a href="" target="_blank" id="email"><img src="<?php echo get_template_directory_uri(); ?>/img/email-black.svg" height="14"></a>
					<a href="" target="_blank" id="insta"><img src="<?php echo get_template_directory_uri(); ?>/img/insta-black.svg" height="14"></a>
					<a href="" target="_blank" id="vim"><img src="<?php echo get_template_directory_uri(); ?>/img/vim-black.svg" height="14"></a>
				</div>
				
				<!-- copyright -->
				<p class="copyright">
					&copy; <?php echo date('Y'); ?> Copyright Theo Stanley
				</p>
				<!-- /copyright -->

			</footer>
			<!-- /footer -->
			<div class="lightbox-overlay"></div>
			<div class="lightboxbox">
				
				<div class="lightbox-inner">
					<div class="lb-close"><img src="<?php echo get_template_directory_uri(); ?>/img/x-gradient-2.svg" height="25"></div>
					<div class="lb-next"><img src="<?php echo get_template_directory_uri(); ?>/img/next-gradient-2.svg" height="31"></div>
					<div class="lb-prev"><img src="<?php echo get_template_directory_uri(); ?>/img/prev-gradient.svg" height="31"></div>
				</div>
			</div>
		</div>
		<!-- /wrapper -->
		<?php 
			$videoMobile = get_field('video_url_mobile', 60); 
			if($videoMobile) {
				//$videoMobile2 = get_field('video_url_mobile'); 
			} else {
				//$videoMobile2 = get_field('video_url_mobile', 60); 
			}
		?>

		<?php wp_footer(); ?>
		

		<!-- analytics -->
		<script>
		(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
		(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
		l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
		ga('send', 'pageview');
		</script>
		<script>							  
			  
			jQuery( document ).ready(function() {
				
				var didScroll;
				var lastScrollTop = 0;
				var delta = 5;
				
				jQuery(window).scroll(function(event){
				    didScroll = true;
				});
				
				setInterval(function() {
				    if (didScroll) {
				        hasScrolled();
				        didScroll = false;
				    }
				}, 70);
				
				function hasScrolled() {
				    var st = jQuery(this).scrollTop();
				    
				    // Make sure they scroll more than delta
				    if(Math.abs(lastScrollTop - st) <= delta)
				        return;

				    if (st > lastScrollTop){
				        jQuery('.sticky-header').removeClass('nav-up').addClass('nav-down');
				    } else if(st < 400) {
					    jQuery('.sticky-header').removeClass('nav-down');
				    } else {
				        if(st + jQuery(window).height() < jQuery(document).height()) {
				            jQuery('.sticky-header').removeClass('nav-up').addClass('nav-down');
				        }
				    }
				    lastScrollTop = st;
				}
			});
			
			(function($) {
				var timeoutID;
	 
				function setup() {
				    this.addEventListener("mousemove", resetTimer, false);
				    this.addEventListener("mousedown", resetTimer, false);
				    this.addEventListener("keypress", resetTimer, false);
				    this.addEventListener("DOMMouseScroll", resetTimer, false);
				    this.addEventListener("mousewheel", resetTimer, false);
				    this.addEventListener("touchmove", resetTimer, false);
				    this.addEventListener("MSPointerMove", resetTimer, false);
				 
				    startTimer();
				}
				setup();
				 
				function startTimer() {
				    // wait 2 seconds before calling goInactive
				    timeoutID = window.setTimeout(goInactive, 3000);
				}
				 
				function resetTimer(e) {
				    window.clearTimeout(timeoutID);
				 
				    goActive();
				}
				 
				function goInactive() {
				    console.log("inactive");
				    jQuery('.sticky-header').removeClass('nav-down');
				}
				 
				function goActive() {
				    
				         
				    startTimer();
				}
			})(jQuery);
		</script>

	</body>
</html>
