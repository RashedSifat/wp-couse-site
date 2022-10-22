<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->

	<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

	<footer class="py-5 bottom-menu bottom-menu-inverse">
	  <div class="container">
	    <div class="row">
	      <div class="col-xs-12 col-sm-4 col-md-4 footer-column">
	        <p>
	          ©
	          SK Courses
	          2022
	        </p>
	      </div>
	      <div class="col-xs-12 col-sm-4 col-md-4 footer-column">
	        <ul class="list-unstyled">
	          <li>
	            <a href="/p/terms">
	              Terms of Use
	            </a>
	          </li>
	          <li>
	            <a href="/p/privacy">
	              Privacy Policy
	            </a>
	          </li>
	        </ul>
	      </div>
	      <div class="col-xs-12 col-sm-4 col-md-4 footer-column">
			</div>

	      </div>
	    </div>
	  </footer><!-- #colophon -->

</div><!-- #page -->


<?php wp_footer(); ?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


</body>
</html>
