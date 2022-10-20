<?php
/**
 * Boxers and Swipers
 *
 * @package    Boxers and Swipers
 * @subpackage BoxersAndSwipersAdmin Management screen
/**
	Copyright (c) 2014- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; version 2 of the License.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

$boxersandswipersadmin = new BoxersAndSwipersAdmin();

/** ==================================================
 * Management screen
 *
 * @since 1.00
 */
class BoxersAndSwipersAdmin {

	/** ==================================================
	 * Path
	 *
	 * @var $plugin_base_url  plugin_base_url.
	 */
	private $plugin_base_url;

	/** ==================================================
	 * Construct
	 *
	 * @since 3.05
	 */
	public function __construct() {

		$this->plugin_base_url = plugin_dir_url( __DIR__ );

		add_action( 'admin_menu', array( $this, 'plugin_menu' ) );
		add_filter( 'plugin_action_links', array( $this, 'settings_link' ), 10, 2 );
		add_action( 'admin_menu', array( $this, 'add_exclude_boxersandswipers_custom_box' ) );
		add_action( 'save_post', array( $this, 'save_exclude_boxersandswipers_postdata' ) );
		add_filter( 'manage_posts_columns', array( $this, 'posts_columns_boxersandswipers' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'posts_custom_columns_boxersandswipers' ), 10, 2 );
		add_filter( 'manage_pages_columns', array( $this, 'pages_columns_boxersandswipers' ) );
		add_action( 'manage_pages_custom_column', array( $this, 'pages_custom_columns_boxersandswipers' ), 10, 2 );
		add_action( 'quick_edit_custom_box', array( $this, 'display_custom_quickedit_boxersandswipers' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'wp_boxersandswipers_admin_enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_custom_wp_admin_style' ) );

	}

	/** ==================================================
	 * Add a "Settings" link to the plugins page
	 *
	 * @param  array  $links  links array.
	 * @param  string $file   file.
	 * @return array  $links  links array.
	 * @since 1.00
	 */
	public function settings_link( $links, $file ) {
		static $this_plugin;
		if ( empty( $this_plugin ) ) {
			$this_plugin = 'boxers-and-swipers/boxersandswipers.php';
		}
		if ( $file == $this_plugin ) {
			$links[] = '<a href="' . admin_url( 'options-general.php?page=boxersandswipers' ) . '">' . __( 'Settings' ) . '</a>';
		}
			return $links;
	}

	/** ==================================================
	 * Settings page
	 *
	 * @since 1.0
	 */
	public function plugin_menu() {
		add_options_page( 'Boxers and Swipers Options', 'Boxers and Swipers', 'manage_options', 'boxersandswipers', array( $this, 'plugin_options' ) );
	}

	/** ==================================================
	 * Add Css and Script
	 *
	 * @since 1.26
	 */
	public function load_custom_wp_admin_style() {
		if ( $this->is_my_plugin_screen() ) {
			wp_enqueue_style( 'jquery-responsiveTabs', $this->plugin_base_url . 'css/responsive-tabs.css', array(), '1.4.0' );
			wp_enqueue_style( 'jquery-responsiveTabs-style', $this->plugin_base_url . 'css/style.css', array(), '1.4.0' );
			wp_enqueue_style( 'boxersandswipers-style', $this->plugin_base_url . 'css/boxersandswipers.css', array(), '1.00' );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-responsiveTabs', $this->plugin_base_url . 'js/jquery.responsiveTabs.min.js', array(), '1.4.0', false );
			wp_enqueue_script( 'boxersandswipers-js', $this->plugin_base_url . 'js/jquery.boxersandswipers.admin.js', array( 'jquery' ), '1.00', false );

		}
	}

	/** ==================================================
	 * For only admin style
	 *
	 * @since 2.28
	 */
	private function is_my_plugin_screen() {
		$screen = get_current_screen();
		if ( is_object( $screen ) && 'settings_page_boxersandswipers' == $screen->id ) {
			return true;
		} else {
			return false;
		}
	}

	/** ==================================================
	 * Settings page
	 *
	 * @since 1.0
	 */
	public function plugin_options() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.' ) );
		}

		$this->options_updated();

		$scriptname = admin_url( 'options-general.php?page=boxersandswipers' );

		$boxersandswipers_apply = get_option( 'boxersandswipers_apply' );
		$boxersandswipers_effect = get_option( 'boxersandswipers_effect' );
		$boxersandswipers_useragent = get_option( 'boxersandswipers_useragent' );
		$boxersandswipers_colorbox = get_option( 'boxersandswipers_colorbox' );
		$boxersandswipers_slimbox = get_option( 'boxersandswipers_slimbox' );
		$boxersandswipers_nivolightbox = get_option( 'boxersandswipers_nivolightbox' );
		$boxersandswipers_imagelightbox = get_option( 'boxersandswipers_imagelightbox' );
		$boxersandswipers_photoswipe = get_option( 'boxersandswipers_photoswipe' );
		$boxersandswipers_slideshow = get_option( 'boxersandswipers_slideshow' );
		$boxersandswipers_swipebox = get_option( 'boxersandswipers_swipebox' );

		$applytypes = $this->apply_type();

		?>

		<div class="wrap">
		<h2>Boxers and Swipers</h2>

	<div id="boxersandswipers_admin_tabs">
	  <ul>
		<li><a href="#boxersandswipers_admin_tabs-1"><?php esc_html_e( 'Device Settings', 'boxers-and-swipers' ); ?></a></li>
		<li><a href="#boxersandswipers_admin_tabs-2">Colorbox&nbsp<?php esc_html_e( 'Settings' ); ?></a></li>
		<li><a href="#boxersandswipers_admin_tabs-3">Slimbox&nbsp<?php esc_html_e( 'Settings' ); ?></a></li>
		<li><a href="#boxersandswipers_admin_tabs-4">Nivo Lightbox&nbsp<?php esc_html_e( 'Settings' ); ?></a></li>
		<li><a href="#boxersandswipers_admin_tabs-5">Image Lightbox&nbsp<?php esc_html_e( 'Settings' ); ?></a></li>
		<li><a href="#boxersandswipers_admin_tabs-6">PhotoSwipe&nbsp<?php esc_html_e( 'Settings' ); ?></a></li>
		<li><a href="#boxersandswipers_admin_tabs-7">Swipebox&nbsp<?php esc_html_e( 'Settings' ); ?></a></li>
		<li><a href="#boxersandswipers_admin_tabs-8"><?php esc_html_e( 'Exclude', 'boxers-and-swipers' ); ?></a></li>
		<li><a href="#boxersandswipers_admin_tabs-9"><?php esc_html_e( 'Donate to this plugin &#187;' ); ?></a></li>
	<!--
		<li><a href="#boxersandswipers_admin_tabs-10">FAQ</a></li>
	 -->
	  </ul>

	  <div id="boxersandswipers_admin_tabs-1">
		<div class="wrap">

			<form method="post" action="<?php echo esc_url( $scriptname ); ?>">
			<?php wp_nonce_field( 'bxsw_settings1', 'boxersandswipers_tabs1' ); ?>

			<h2><?php esc_html_e( 'Device Settings', 'boxers-and-swipers' ); ?></h2>

			<p class="submit">
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', false ); ?>
			<?php submit_button( __( 'Default' ), 'large', 'Default', false ); ?>
			</p>

			<div>
				<div style="padding:10px;border:#CCC 2px solid; margin:0 0 20px 0">
					<div style="display:block"><b>PC</b></div>
					<div style="display:block;padding:20px 0">
					<?php $target_effect_pc = $boxersandswipers_effect['pc']; ?>
					<select id="boxersandswipers_effect_pc" name="boxersandswipers_effect_pc">
						<option value='colorbox' 
						<?php
						if ( 'colorbox' == $target_effect_pc ) {
							echo 'selected="selected"';}
						?>
						>Colorbox</option>
						<option value='slimbox' 
						<?php
						if ( 'slimbox' == $target_effect_pc ) {
							echo 'selected="selected"';}
						?>
						>Slimbox</option>
						<option value='nivolightbox' 
						<?php
						if ( 'nivolightbox' == $target_effect_pc ) {
							echo 'selected="selected"';}
						?>
						>Nivo Lightbox</option>
						<option value='imagelightbox' 
						<?php
						if ( 'imagelightbox' == $target_effect_pc ) {
							echo 'selected="selected"';}
						?>
						>Image Lightbox</option>
						<option value='photoswipe' 
						<?php
						if ( 'photoswipe' == $target_effect_pc ) {
							echo 'selected="selected"';}
						?>
						>PhotoSwipe</option>
						<option value='swipebox' 
						<?php
						if ( 'swipebox' == $target_effect_pc ) {
							echo 'selected="selected"';}
						?>
						>Swipebox</option>
					</select>
					</div>
					<div>
					<?php
					foreach ( $applytypes as $key => $value ) {
						?>
						<div style="float:left;margin:7px">
						<input name="boxersandswipers_apply_pc[<?php echo esc_attr( $key ); ?>]" type="checkbox" value="1" <?php checked( '1', $boxersandswipers_apply[ $key ]['pc'] ); ?>><?php echo wp_kses_post( $value ); ?></div>&nbsp;&nbsp;
						<?php
					}
					?>
					<div style="clear:both"></div>
					</div>
				</div>

				<div style="padding:10px; border:#CCC 2px solid">
					<div style="display:block"><b>Tablet</b></div>
					<div style="display:block;padding:20px 0">
					<?php $target_effect_tb = $boxersandswipers_effect['tb']; ?>
					<select id="boxersandswipers_effect_tb" name="boxersandswipers_effect_tb">
						<option value='colorbox' 
						<?php
						if ( 'colorbox' == $target_effect_tb ) {
							echo 'selected="selected"';}
						?>
						>Colorbox</option>
						<option value='slimbox' 
						<?php
						if ( 'slimbox' == $target_effect_tb ) {
							echo 'selected="selected"';}
						?>
						>Slimbox</option>
						<option value='nivolightbox' 
						<?php
						if ( 'nivolightbox' == $target_effect_tb ) {
							echo 'selected="selected"';}
						?>
						>Nivo Lightbox</option>
						<option value='imagelightbox' 
						<?php
						if ( 'imagelightbox' == $target_effect_tb ) {
							echo 'selected="selected"';}
						?>
						>Image Lightbox</option>
						<option value='photoswipe' 
						<?php
						if ( 'photoswipe' == $target_effect_tb ) {
							echo 'selected="selected"';}
						?>
						>PhotoSwipe</option>
						<option value='swipebox' 
						<?php
						if ( 'swipebox' == $target_effect_tb ) {
							echo 'selected="selected"';}
						?>
						>Swipebox</option>
					</select>
					</div>
					<div style="padding:0 0 20px">
					<?php
					foreach ( $applytypes as $key => $value ) {
						?>
						<div style="float:left;margin:7px">
						<input name="boxersandswipers_apply_tb[<?php echo esc_attr( $key ); ?>]" type="checkbox" value="1" <?php checked( '1', $boxersandswipers_apply[ $key ]['tb'] ); ?>><?php echo wp_kses_post( $value ); ?></div>&nbsp;&nbsp;
						<?php
					}
					?>
					<div style="clear:both"></div>
					</div>
					<div style="display:box">
						<p>
						<?php esc_html_e( 'User Agent (Regular Expressions are Possible)', 'boxers-and-swipers' ); ?>
						</p>
						<p>
						<textarea id="boxersandswipers_useragent_tb" name="boxersandswipers_useragent_tb" rows="5" style="width: 100%;"><?php echo esc_textarea( $boxersandswipers_useragent['tb'] ); ?></textarea>
						</p>
					</div>
					<div style="clear:both"></div>
				</div>

				<div style="margin:20px 0; padding:10px; border:#CCC 2px solid">
					<div style="display:block"><b>Smartphone</b></div>
					<div style="display:block;margin:20px 0">
					<?php $target_effect_sp = $boxersandswipers_effect['sp']; ?>
					<select id="boxersandswipers_effect_sp" name="boxersandswipers_effect_sp">
						<option value='colorbox' 
						<?php
						if ( 'colorbox' == $target_effect_sp ) {
							echo 'selected="selected"';}
						?>
						>Colorbox</option>
						<option value='slimbox' 
						<?php
						if ( 'slimbox' == $target_effect_sp ) {
							echo 'selected="selected"';}
						?>
						>Slimbox</option>
						<option value='nivolightbox' 
						<?php
						if ( 'nivolightbox' == $target_effect_sp ) {
							echo 'selected="selected"';}
						?>
						>Nivo Lightbox</option>
						<option value='imagelightbox' 
						<?php
						if ( 'imagelightbox' == $target_effect_sp ) {
							echo 'selected="selected"';}
						?>
						>Image Lightbox</option>
						<option value='photoswipe' 
						<?php
						if ( 'photoswipe' == $target_effect_sp ) {
							echo 'selected="selected"';}
						?>
						>PhotoSwipe</option>
						<option value='swipebox' 
						<?php
						if ( 'swipebox' == $target_effect_sp ) {
							echo 'selected="selected"';}
						?>
						>Swipebox</option>
					</select>
					</div>
					<div style="padding:0 0 20px">
					<?php
					foreach ( $applytypes as $key => $value ) {
						?>
						<div style="float:left;margin:7px">
						<input name="boxersandswipers_apply_sp[<?php echo esc_attr( $key ); ?>]" type="checkbox" value="1" <?php checked( '1', $boxersandswipers_apply[ $key ]['sp'] ); ?>><?php echo wp_kses_post( $value ); ?></div>&nbsp;&nbsp;
						<?php
					}
					?>
					<div style="clear:both"></div>
					</div>
					<div style="display:block">
						<p>
						<?php esc_html_e( 'User Agent (Regular Expressions are Possible)', 'boxers-and-swipers' ); ?>
						</p>
						<p>
						<textarea id="boxersandswipers_useragent_sp" name="boxersandswipers_useragent_sp" rows="5" style="width: 100%;"><?php echo esc_textarea( $boxersandswipers_useragent['sp'] ); ?></textarea>
						</p>
					</div>
					<div style="clear:both"></div>
				</div>

			</div>
			<div style="clear:both"></div>

			<input type="hidden" name="boxersandswipers_admin_tabs" value="1" />
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', true ); ?>

			</form>

			<div align="right"><a href="http://a4jp.com" target="_blank">Mr. Glen Charles Rowell. Thank you for a nice design.</a></div>

		</div>
	  </div>

	  <div id="boxersandswipers_admin_tabs-2">
		<div class="wrap">
			<h2>Colorbox <?php esc_html_e( 'Settings' ); ?> (<a href="http://www.jacklmoore.com/colorbox/" target="_blank"><font color="red">Colorbox <?php esc_html_e( 'Website' ); ?></font></a>)</h2>	

			<form method="post" action="<?php echo esc_url( $scriptname ) . '#boxersandswipers_admin_tabs-2'; ?>">
			<?php wp_nonce_field( 'bxsw_settings2', 'boxersandswipers_tabs2' ); ?>

			<p class="submit">
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', false ); ?>
			<?php submit_button( __( 'Default' ), 'large', 'Default', false ); ?>
			</p>

			<div id="container-colorbox">

				<div class="item-boxersandswipers-settings">
					<div>transition</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(elastic)</div>
					<div>
					<?php $target_colorbox_transition = $boxersandswipers_colorbox['transition']; ?>
					<select id="boxersandswipers_colorbox_transition" name="boxersandswipers_colorbox_transition">
						<option 
						<?php
						if ( 'elastic' == $target_colorbox_transition ) {
							echo 'selected="selected"';}
						?>
						>elastic</option>
						<option 
						<?php
						if ( 'fade' == $target_colorbox_transition ) {
							echo 'selected="selected"';}
						?>
						>fade</option>
						<option 
						<?php
						if ( 'none' == $target_colorbox_transition ) {
							echo 'selected="selected"';}
						?>
						>none</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>speed</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(350)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_speed" name="boxersandswipers_colorbox_speed" value="<?php echo esc_attr( $boxersandswipers_colorbox['speed'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>title</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_title" name="boxersandswipers_colorbox_title" value="<?php echo esc_attr( $boxersandswipers_colorbox['title'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>scalePhotos</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_colorbox_scalephotos = $boxersandswipers_colorbox['scalePhotos']; ?>
					<select id="boxersandswipers_colorbox_scalePhotos" name="boxersandswipers_colorbox_scalePhotos">
						<option 
						<?php
						if ( 'true' == $target_colorbox_scalephotos ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_scalephotos ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>scrolling</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_colorbox_scrolling = $boxersandswipers_colorbox['scrolling']; ?>
					<select id="boxersandswipers_colorbox_scrolling" name="boxersandswipers_colorbox_scrolling">
						<option 
						<?php
						if ( 'true' == $target_colorbox_scrolling ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_scrolling ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>opacity</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(0.85)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_opacity" name="boxersandswipers_colorbox_opacity" value="<?php echo esc_attr( $boxersandswipers_colorbox['opacity'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>open</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
					<?php $target_colorbox_open = $boxersandswipers_colorbox['open']; ?>
					<select id="boxersandswipers_colorbox_open" name="boxersandswipers_colorbox_open">
						<option 
						<?php
						if ( 'true' == $target_colorbox_open ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_open ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>returnFocus</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_colorbox_returnfocus = $boxersandswipers_colorbox['returnFocus']; ?>
					<select id="boxersandswipers_colorbox_returnFocus" name="boxersandswipers_colorbox_returnFocus">
						<option 
						<?php
						if ( 'true' == $target_colorbox_returnfocus ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_returnfocus ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>trapFocus</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_colorbox_trapfocus = $boxersandswipers_colorbox['trapFocus']; ?>
					<select id="boxersandswipers_colorbox_trapFocus" name="boxersandswipers_colorbox_trapFocus">
						<option 
						<?php
						if ( 'true' == $target_colorbox_trapfocus ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_trapfocus ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>fastIframe</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_colorbox_fastiframe = $boxersandswipers_colorbox['fastIframe']; ?>
					<select id="boxersandswipers_colorbox_fastIframe" name="boxersandswipers_colorbox_fastIframe">
						<option 
						<?php
						if ( 'true' == $target_colorbox_fastiframe ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_fastiframe ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>preloading</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_colorbox_preloading = $boxersandswipers_colorbox['preloading']; ?>
					<select id="boxersandswipers_colorbox_preloading" name="boxersandswipers_colorbox_preloading">
						<option 
						<?php
						if ( 'true' == $target_colorbox_preloading ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_preloading ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>overlayClose</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_colorbox_overlayclose = $boxersandswipers_colorbox['overlayClose']; ?>
					<select id="boxersandswipers_colorbox_overlayClose" name="boxersandswipers_colorbox_overlayClose">
						<option 
						<?php
						if ( 'true' == $target_colorbox_overlayclose ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_overlayclose ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>escKey</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_colorbox_esckey = $boxersandswipers_colorbox['escKey']; ?>
					<select id="boxersandswipers_colorbox_escKey" name="boxersandswipers_colorbox_escKey">
						<option 
						<?php
						if ( 'true' == $target_colorbox_esckey ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_esckey ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>arrowKey</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_colorbox_arrowkey = $boxersandswipers_colorbox['arrowKey']; ?>
					<select id="boxersandswipers_colorbox_arrowKey" name="boxersandswipers_colorbox_arrowKey">
						<option 
						<?php
						if ( 'true' == $target_colorbox_arrowkey ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_arrowkey ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>loop</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_colorbox_loop = $boxersandswipers_colorbox['loop']; ?>
					<select id="boxersandswipers_colorbox_loop" name="boxersandswipers_colorbox_loop">
						<option 
						<?php
						if ( 'true' == $target_colorbox_loop ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_loop ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>fadeOut</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(300)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_fadeOut" name="boxersandswipers_colorbox_fadeOut" value="<?php echo esc_attr( $boxersandswipers_colorbox['fadeOut'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>closeButton</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_colorbox_closebutton = $boxersandswipers_colorbox['closeButton']; ?>
					<select id="boxersandswipers_colorbox_closeButton" name="boxersandswipers_colorbox_closeButton">
						<option 
						<?php
						if ( 'true' == $target_colorbox_closebutton ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_closebutton ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>current</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(image {current} of {total})</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_current" name="boxersandswipers_colorbox_current" value="<?php echo esc_attr( $boxersandswipers_colorbox['current'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>previous</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(previous)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_previous" name="boxersandswipers_colorbox_previous" value="<?php echo esc_attr( $boxersandswipers_colorbox['previous'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>next</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(next)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_next" name="boxersandswipers_colorbox_next" value="<?php echo esc_attr( $boxersandswipers_colorbox['next'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>close</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(close)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_close" name="boxersandswipers_colorbox_close" value="<?php echo esc_attr( $boxersandswipers_colorbox['close'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>width</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_width" name="boxersandswipers_colorbox_width" value="<?php echo esc_attr( $boxersandswipers_colorbox['width'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>height</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_height" name="boxersandswipers_colorbox_height" value="<?php echo esc_attr( $boxersandswipers_colorbox['height'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>innerWidth</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_innerWidth" name="boxersandswipers_colorbox_innerWidth" value="<?php echo esc_attr( $boxersandswipers_colorbox['innerWidth'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>innerHeight</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_innerHeight" name="boxersandswipers_colorbox_innerHeight" value="<?php echo esc_attr( $boxersandswipers_colorbox['innerHeight'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>initialWidth</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(300)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_initialWidth" name="boxersandswipers_colorbox_initialWidth" value="<?php echo esc_attr( $boxersandswipers_colorbox['initialWidth'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>initialHeight</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(100)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_initialHeight" name="boxersandswipers_colorbox_initialHeight" value="<?php echo esc_attr( $boxersandswipers_colorbox['initialHeight'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>maxWidth</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_maxWidth" name="boxersandswipers_colorbox_maxWidth" value="<?php echo esc_attr( $boxersandswipers_colorbox['maxWidth'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>maxHeight</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_maxHeight" name="boxersandswipers_colorbox_maxHeight" value="<?php echo esc_attr( $boxersandswipers_colorbox['maxHeight'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>slideshow</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_colorbox_slideshow = $boxersandswipers_colorbox['slideshow']; ?>
					<select id="boxersandswipers_colorbox_slideshow" name="boxersandswipers_colorbox_slideshow">
						<option 
						<?php
						if ( 'true' == $target_colorbox_slideshow ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_slideshow ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>slideshowSpeed</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(2500)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_slideshowSpeed" name="boxersandswipers_colorbox_slideshowSpeed" value="<?php echo esc_attr( $boxersandswipers_colorbox['slideshowSpeed'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>slideshowAuto</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
					<?php $target_colorbox_slideshowauto = $boxersandswipers_colorbox['slideshowAuto']; ?>
					<select id="boxersandswipers_colorbox_slideshowAuto" name="boxersandswipers_colorbox_slideshowAuto">
						<option 
						<?php
						if ( 'true' == $target_colorbox_slideshowauto ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_slideshowauto ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>slideshowStart</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(start slideshow)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_slideshowStart" name="boxersandswipers_colorbox_slideshowStart" value="<?php echo esc_attr( $boxersandswipers_colorbox['slideshowStart'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>slideshowStop</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(stop slideshow)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_slideshowStop" name="boxersandswipers_colorbox_slideshowStop" value="<?php echo esc_attr( $boxersandswipers_colorbox['slideshowStop'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>fixed</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
					<?php $target_colorbox_fixed = $boxersandswipers_colorbox['fixed']; ?>
					<select id="boxersandswipers_colorbox_fixed" name="boxersandswipers_colorbox_fixed">
						<option 
						<?php
						if ( 'true' == $target_colorbox_fixed ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_fixed ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>top</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_top" name="boxersandswipers_colorbox_top" value="<?php echo esc_attr( $boxersandswipers_colorbox['top'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>bottom</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_bottom" name="boxersandswipers_colorbox_bottom" value="<?php echo esc_attr( $boxersandswipers_colorbox['bottom'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>left</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_left" name="boxersandswipers_colorbox_left" value="<?php echo esc_attr( $boxersandswipers_colorbox['left'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>right</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
						<input type="text" id="boxersandswipers_colorbox_right" name="boxersandswipers_colorbox_right" value="<?php echo esc_attr( $boxersandswipers_colorbox['right'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>reposition</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_colorbox_reposition = $boxersandswipers_colorbox['reposition']; ?>
					<select id="boxersandswipers_colorbox_reposition" name="boxersandswipers_colorbox_reposition">
						<option 
						<?php
						if ( 'true' == $target_colorbox_reposition ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_reposition ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>retinaImage</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
					<?php $target_colorbox_retinaimage = $boxersandswipers_colorbox['retinaImage']; ?>
					<select id="boxersandswipers_colorbox_retinaImage" name="boxersandswipers_colorbox_retinaImage">
						<option 
						<?php
						if ( 'true' == $target_colorbox_retinaimage ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_colorbox_retinaimage ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>

			</div>
			<div style="clear:both"></div>

			<input type="hidden" name="boxersandswipers_admin_tabs" value="2" />
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', true ); ?>

			</form>

		</div>
	  </div>

	  <div id="boxersandswipers_admin_tabs-3">
		<div class="wrap">
			<h2>Slimbox <?php esc_html_e( 'Settings' ); ?> (<a href="http://www.digitalia.be/software/slimbox2" target="_blank"><font color="red">Slimbox <?php esc_html_e( 'Website' ); ?></font></a>)</h2>	

			<form method="post" action="<?php echo esc_url( $scriptname ) . '#boxersandswipers_admin_tabs-3'; ?>">
			<?php wp_nonce_field( 'bxsw_settings3', 'boxersandswipers_tabs3' ); ?>

			<p class="submit">
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', false ); ?>
			<?php submit_button( __( 'Default' ), 'large', 'Default', false ); ?>
			</p>

			<div id="container-slimbox">

				<div class="item-boxersandswipers-settings">
					<div>loop</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
					<?php $target_slimbox_loop = $boxersandswipers_slimbox['loop']; ?>
					<select id="boxersandswipers_slimbox_loop" name="boxersandswipers_slimbox_loop">
						<option 
						<?php
						if ( 'true' == $target_slimbox_loop ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_slimbox_loop ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>overlayOpacity</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(0.8)</div>
					<div>
						<input type="text" id="boxersandswipers_slimbox_overlayOpacity" name="boxersandswipers_slimbox_overlayOpacity" value="<?php echo esc_attr( $boxersandswipers_slimbox['overlayOpacity'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>overlayFadeDuration</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(400)</div>
					<div>
						<input type="text" id="boxersandswipers_slimbox_overlayFadeDuration" name="boxersandswipers_slimbox_overlayFadeDuration" value="<?php echo esc_attr( $boxersandswipers_slimbox['overlayFadeDuration'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>resizeDuration</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(400)</div>
					<div>
						<input type="text" id="boxersandswipers_slimbox_resizeDuration" name="boxersandswipers_slimbox_resizeDuration" value="<?php echo esc_attr( $boxersandswipers_slimbox['resizeDuration'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>resizeEasing</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(swing)</div>
					<div>
					<?php $target_slimbox_resizeeasing = $boxersandswipers_slimbox['resizeEasing']; ?>
					<select id="boxersandswipers_slimbox_resizeEasing" name="boxersandswipers_slimbox_resizeEasing">
						<option 
						<?php
						if ( 'swing' == $target_slimbox_resizeeasing ) {
							echo 'selected="selected"';}
						?>
						>swing</option>
						<option 
						<?php
						if ( 'linear' == $target_slimbox_resizeeasing ) {
							echo 'selected="selected"';}
						?>
						>linear</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>initialWidth</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(250)</div>
					<div>
						<input type="text" id="boxersandswipers_slimbox_initialWidth" name="boxersandswipers_slimbox_initialWidth" value="<?php echo esc_attr( $boxersandswipers_slimbox['initialWidth'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>initialHeight</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(250)</div>
					<div>
						<input type="text" id="boxersandswipers_slimbox_initialHeight" name="boxersandswipers_slimbox_initialHeight" value="<?php echo esc_attr( $boxersandswipers_slimbox['initialHeight'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>imageFadeDuration</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(400)</div>
					<div>
						<input type="text" id="boxersandswipers_slimbox_imageFadeDuration" name="boxersandswipers_slimbox_imageFadeDuration" value="<?php echo esc_attr( $boxersandswipers_slimbox['imageFadeDuration'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>captionAnimationDuration</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(400)</div>
					<div>
						<input type="text" id="boxersandswipers_slimbox_captionAnimationDuration" name="boxersandswipers_slimbox_captionAnimationDuration" value="<?php echo esc_attr( $boxersandswipers_slimbox['captionAnimationDuration'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>counterText</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(Image {x} of {y})</div>
					<div>
						<input type="text" id="boxersandswipers_slimbox_counterText" name="boxersandswipers_slimbox_counterText" value="<?php echo esc_attr( $boxersandswipers_slimbox['counterText'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>closeKeys</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp([27, 88, 67])</div>
					<div>
						<input type="text" id="boxersandswipers_slimbox_closeKeys" name="boxersandswipers_slimbox_closeKeys" value="<?php echo esc_attr( $boxersandswipers_slimbox['closeKeys'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>previousKeys</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp([37, 80])</div>
					<div>
						<input type="text" id="boxersandswipers_slimbox_previousKeys" name="boxersandswipers_slimbox_previousKeys" value="<?php echo esc_attr( $boxersandswipers_slimbox['previousKeys'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>nextKeys</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp([39, 78])</div>
					<div>
						<input type="text" id="boxersandswipers_slimbox_nextKeys" name="boxersandswipers_slimbox_nextKeys" value="<?php echo esc_attr( $boxersandswipers_slimbox['nextKeys'] ); ?>" />
					</div>
				</div>

			</div>
			<div style="clear:both"></div>

			<input type="hidden" name="boxersandswipers_admin_tabs" value="3" />
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', true ); ?>

			</form>

		</div>
	  </div>
	  <div id="boxersandswipers_admin_tabs-4">
		<div class="wrap">
			<h2>Nivo Lightbox <?php esc_html_e( 'Settings' ); ?> (<a href="https://github.com/Codeinwp/Nivo-Lightbox-jQuery" target="_blank"><font color="red">Nivo Lightbox <?php esc_html_e( 'Website' ); ?></font></a>)</h2>	

			<form method="post" action="<?php echo esc_url( $scriptname ) . '#boxersandswipers_admin_tabs-4'; ?>">
			<?php wp_nonce_field( 'bxsw_settings4', 'boxersandswipers_tabs4' ); ?>

			<p class="submit">
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', false ); ?>
			<?php submit_button( __( 'Default' ), 'large', 'Default', false ); ?>
			</p>

			<div id="container-nivolightbox">

				<div class="item-boxersandswipers-settings">
					<div>effect</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(fade)</div>
					<div>
					<?php $target_nivolightbox_effect = $boxersandswipers_nivolightbox['effect']; ?>
					<select id="boxersandswipers_nivolightbox_effect" name="boxersandswipers_nivolightbox_effect">
						<option 
						<?php
						if ( 'fade' == $target_nivolightbox_effect ) {
							echo 'selected="selected"';}
						?>
						>fade</option>
						<option 
						<?php
						if ( 'fadeScale' == $target_nivolightbox_effect ) {
							echo 'selected="selected"';}
						?>
						>fadeScale</option>
						<option 
						<?php
						if ( 'slideLeft' == $target_nivolightbox_effect ) {
							echo 'selected="selected"';}
						?>
						>slideLeft</option>
						<option 
						<?php
						if ( 'slideRight' == $target_nivolightbox_effect ) {
							echo 'selected="selected"';}
						?>
						>slideRight</option>
						<option 
						<?php
						if ( 'slideUp' == $target_nivolightbox_effect ) {
							echo 'selected="selected"';}
						?>
						>slideUp</option>
						<option 
						<?php
						if ( 'slideDown' == $target_nivolightbox_effect ) {
							echo 'selected="selected"';}
						?>
						>slideDown</option>
						<option 
						<?php
						if ( 'fall' == $target_nivolightbox_effect ) {
							echo 'selected="selected"';}
						?>
						>fall</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>keyboardNav</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_nivolightbox_keyboardnav = $boxersandswipers_nivolightbox['keyboardNav']; ?>
					<select id="boxersandswipers_nivolightbox_keyboardNav" name="boxersandswipers_nivolightbox_keyboardNav">
						<option 
						<?php
						if ( 'true' == $target_nivolightbox_keyboardnav ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_nivolightbox_keyboardnav ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>clickOverlayToClose</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_nivolightbox_clickoverlaytoclose = $boxersandswipers_nivolightbox['clickOverlayToClose']; ?>
					<select id="boxersandswipers_nivolightbox_clickOverlayToClose" name="boxersandswipers_nivolightbox_clickOverlayToClose">
						<option 
						<?php
						if ( 'true' == $target_nivolightbox_clickoverlaytoclose ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_nivolightbox_clickoverlaytoclose ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>

			</div>
			<div style="clear:both"></div>

			<input type="hidden" name="boxersandswipers_admin_tabs" value="4" />
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', true ); ?>

			</form>

		</div>
	  </div>
	  <div id="boxersandswipers_admin_tabs-5">
		<div class="wrap">
			<h2>Image Lightbox <?php esc_html_e( 'Settings' ); ?> (<a href="http://osvaldas.info/image-lightbox-responsive-touch-friendly" target="_blank"><font color="red">Image Lightbox <?php esc_html_e( 'Website' ); ?></font></a>)</h2>	

			<form method="post" action="<?php echo esc_url( $scriptname ) . '#boxersandswipers_admin_tabs-5'; ?>">
			<?php wp_nonce_field( 'bxsw_settings5', 'boxersandswipers_tabs5' ); ?>

			<p class="submit">
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', false ); ?>
			<?php submit_button( __( 'Default' ), 'large', 'Default', false ); ?>
			</p>

			<div id="container-imagelightbox">

				<div class="item-boxersandswipers-settings">
					<div>animationSpeed</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(250)</div>
					<div>
						<input type="text" id="boxersandswipers_imagelightbox_animationSpeed" name="boxersandswipers_imagelightbox_animationSpeed" value="<?php echo esc_attr( $boxersandswipers_imagelightbox['animationSpeed'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>preloadNext</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_imagelightbox_preloadnext = $boxersandswipers_imagelightbox['preloadNext']; ?>
					<select id="boxersandswipers_imagelightbox_preloadNext" name="boxersandswipers_imagelightbox_preloadNext">
						<option 
						<?php
						if ( 'true' == $target_imagelightbox_preloadnext ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_imagelightbox_preloadnext ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>enableKeyboard</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_imagelightbox_enablekeyboard = $boxersandswipers_imagelightbox['enableKeyboard']; ?>
					<select id="boxersandswipers_imagelightbox_enableKeyboard" name="boxersandswipers_imagelightbox_enableKeyboard">
						<option 
						<?php
						if ( 'true' == $target_imagelightbox_enablekeyboard ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_imagelightbox_enablekeyboard ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>quitOnEnd</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
					<?php $target_imagelightbox_quitonend = $boxersandswipers_imagelightbox['quitOnEnd']; ?>
					<select id="boxersandswipers_imagelightbox_quitOnEnd" name="boxersandswipers_imagelightbox_quitOnEnd">
						<option 
						<?php
						if ( 'true' == $target_imagelightbox_quitonend ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_imagelightbox_quitonend ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>quitOnImgClick</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
					<?php $target_imagelightbox_quitonimgclick = $boxersandswipers_imagelightbox['quitOnImgClick']; ?>
					<select id="boxersandswipers_imagelightbox_quitOnImgClick" name="boxersandswipers_imagelightbox_quitOnImgClick">
						<option 
						<?php
						if ( 'true' == $target_imagelightbox_quitonimgclick ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_imagelightbox_quitonimgclick ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>quitOnDocClick</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
					<?php $target_imagelightbox_quitondocclick = $boxersandswipers_imagelightbox['quitOnDocClick']; ?>
					<select id="boxersandswipers_imagelightbox_quitOnDocClick" name="boxersandswipers_imagelightbox_quitOnDocClick">
						<option 
						<?php
						if ( 'true' == $target_imagelightbox_quitondocclick ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_imagelightbox_quitondocclick ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>

			</div>
			<div style="clear:both"></div>

			<input type="hidden" name="boxersandswipers_admin_tabs" value="5" />
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', true ); ?>

			</form>

		</div>
	  </div>
	  <div id="boxersandswipers_admin_tabs-6">
		<div class="wrap">
			<h2>PhotoSwipe <?php esc_html_e( 'Settings' ); ?> (<a href="http://photoswipe.com/" target="_blank"><font color="red">PhotoSwipe <?php esc_html_e( 'Website' ); ?></font></a>)</h2>	

			<form method="post" action="<?php echo esc_url( $scriptname ) . '#boxersandswipers_admin_tabs-6'; ?>">
			<?php wp_nonce_field( 'bxsw_settings6', 'boxersandswipers_tabs6' ); ?>

			<p class="submit">
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', false ); ?>
			<?php submit_button( __( 'Default' ), 'large', 'Default', false ); ?>
			</p>

			<div id="container-photoswipe">
				<div class="item-boxersandswipers-settings">
					<div>bgOpacity(0-1)</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(1)</div>
					<div>
						<input type="text" id="boxersandswipers_photoswipe_bgOpacity" name="boxersandswipers_photoswipe_bgOpacity" value="<?php echo esc_attr( $boxersandswipers_photoswipe['bgOpacity'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>captionEl(captionArea)</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<?php $target_photoswipe_captionarea = $boxersandswipers_photoswipe['captionArea']; ?>
					<div>
					<select id="boxersandswipers_photoswipe_captionArea" name="boxersandswipers_photoswipe_captionArea">
						<option 
						<?php
						if ( 'true' == $target_photoswipe_captionarea ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_photoswipe_captionarea ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>shareEl(shareButton)</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_photoswipe_sharebutton = $boxersandswipers_photoswipe['shareButton']; ?>
					<select id="boxersandswipers_photoswipe_shareButton" name="boxersandswipers_photoswipe_shareButton">
						<option 
						<?php
						if ( 'true' == $target_photoswipe_sharebutton ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_photoswipe_sharebutton ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>fullscreenEl(fullScreenButton)</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_photoswipe_fullscreenbutton = $boxersandswipers_photoswipe['fullScreenButton']; ?>
					<select id="boxersandswipers_photoswipe_fullScreenButton" name="boxersandswipers_photoswipe_fullScreenButton">
						<option 
						<?php
						if ( 'true' == $target_photoswipe_fullscreenbutton ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_photoswipe_fullscreenbutton ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>zoomEl(zoomButton)</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_photoswipe_zoombutton = $boxersandswipers_photoswipe['zoomButton']; ?>
					<select id="boxersandswipers_photoswipe_zoomButton" name="boxersandswipers_photoswipe_zoomButton">
						<option 
						<?php
						if ( 'true' == $target_photoswipe_zoombutton ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_photoswipe_zoombutton ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>preloaderEl(preloaderButton)</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_photoswipe_preloaderbutton = $boxersandswipers_photoswipe['preloaderButton']; ?>
					<select id="boxersandswipers_photoswipe_preloaderButton" name="boxersandswipers_photoswipe_preloaderButton">
						<option 
						<?php
						if ( 'true' == $target_photoswipe_preloaderbutton ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_photoswipe_preloaderbutton ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>tapToClose</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
					<?php $target_photoswipe_taptoclose = $boxersandswipers_photoswipe['tapToClose']; ?>
					<select id="boxersandswipers_photoswipe_tapToClose" name="boxersandswipers_photoswipe_tapToClose">
						<option 
						<?php
						if ( 'true' == $target_photoswipe_taptoclose ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_photoswipe_taptoclose ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>tapToToggleControls</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_photoswipe_taptotogglecontrols = $boxersandswipers_photoswipe['tapToToggleControls']; ?>
					<select id="boxersandswipers_photoswipe_tapToToggleControls" name="boxersandswipers_photoswipe_tapToToggleControls">
						<option 
						<?php
						if ( 'true' == $target_photoswipe_taptotogglecontrols ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_photoswipe_taptotogglecontrols ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>animationDuration</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(333)</div>
					<div>
						<input type="text" id="boxersandswipers_photoswipe_animationDuration" name="boxersandswipers_photoswipe_animationDuration" value="<?php echo esc_attr( $boxersandswipers_photoswipe['animationDuration'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>maxSpreadZoom</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(2)</div>
					<div>
						<input type="text" id="boxersandswipers_photoswipe_maxSpreadZoom" name="boxersandswipers_photoswipe_maxSpreadZoom" value="<?php echo esc_attr( $boxersandswipers_photoswipe['maxSpreadZoom'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>history</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(true)</div>
					<div>
					<?php $target_photoswipe_history = $boxersandswipers_photoswipe['history']; ?>
					<select id="boxersandswipers_photoswipe_history" name="boxersandswipers_photoswipe_history">
						<option 
						<?php
						if ( 'true' == $target_photoswipe_history ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_photoswipe_history ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>
			</div>
			<div style="clear:both"></div>

			<input type="hidden" name="boxersandswipers_admin_tabs" value="6" />
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', true ); ?>

			</form>

		</div>
	  </div>
	  <div id="boxersandswipers_admin_tabs-7">
		<div class="wrap">
			<h2>Swipebox <?php esc_html_e( 'Settings' ); ?> (<a href="http://brutaldesign.github.io/swipebox/" target="_blank"><font color="red">Swipebox <?php esc_html_e( 'Website' ); ?></font></a>)</h2>	

			<form method="post" action="<?php echo esc_url( $scriptname ) . '#boxersandswipers_admin_tabs-7'; ?>">
			<?php wp_nonce_field( 'bxsw_settings7', 'boxersandswipers_tabs7' ); ?>

			<p class="submit">
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', false ); ?>
			<?php submit_button( __( 'Default' ), 'large', 'Default', false ); ?>
			</p>

			<div id="container-swipebox">

				<div class="item-boxersandswipers-settings">
					<div>hideBarsDelay</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(3000)</div>
					<div>
						<input type="text" id="boxersandswipers_swipebox_hideBarsDelay" name="boxersandswipers_swipebox_hideBarsDelay" value="<?php echo esc_attr( $boxersandswipers_swipebox['hideBarsDelay'] ); ?>" />
					</div>
				</div>
				<div class="item-boxersandswipers-settings">
					<div>loopAtEnd</div>
					<div><?php esc_html_e( 'Default' ); ?>&nbsp(false)</div>
					<div>
					<?php $target_swipebox_loop_at_end = $boxersandswipers_swipebox['loopAtEnd']; ?>
					<select id="boxersandswipers_swipebox_loopAtEnd" name="boxersandswipers_swipebox_loopAtEnd">
						<option 
						<?php
						if ( 'true' == $target_swipebox_loop_at_end ) {
							echo 'selected="selected"';}
						?>
						>true</option>
						<option value="" 
						<?php
						if ( ! $target_swipebox_loop_at_end ) {
							echo 'selected="selected"';}
						?>
						>false</option>
					</select>
					</div>
				</div>

			</div>
			<div style="clear:both"></div>

			<input type="hidden" name="boxersandswipers_admin_tabs" value="7" />
			<?php submit_button( __( 'Save Changes' ), 'large', 'Submit', true ); ?>

			</form>

		</div>
	  </div>

	  <div id="boxersandswipers_admin_tabs-8">
		<div class="wrap">
		<h2><?php esc_html_e( 'Exclude', 'boxers-and-swipers' ); ?></h2>

				<div style="margin:20px 0; padding:10px; border:#CCC 2px solid">
					<?php esc_html_e( 'You can disable this plugin on each page or post as you like, by editing the page or post and then selecting the option on that page meta box of Boxers And Swipers. And Quick Edit too. If you can not see the options anywhere make sure the Screen Options check box is on. Click Screen Options &gt; Show on screen &gt; Boxers And Swipers at the top right of your screen.', 'boxers-and-swipers' ); ?>

					<div style="clear:both"></div>
				</div>

		</div>
	  </div>

		<div id="boxersandswipers_admin_tabs-9">
			<div class="wrap">
			<?php $this->credit(); ?>
			</div>
		</div>

	<!--
	  <div id="boxersandswipers_admin_tabs-10">
		<div class="wrap">
		<h2>FAQ</h2>

		</div>
	  </div>
	-->

	</div>

		</div>
		<?php
	}

	/** ==================================================
	 * Credit
	 *
	 * @since 1.00
	 */
	private function credit() {

		$plugin_name    = null;
		$plugin_ver_num = null;
		$plugin_path    = plugin_dir_path( __DIR__ );
		$plugin_dir     = untrailingslashit( $plugin_path );
		$slugs          = explode( '/', $plugin_dir );
		$slug           = end( $slugs );
		$files          = scandir( $plugin_dir );
		foreach ( $files as $file ) {
			if ( '.' === $file || '..' === $file || is_dir( $plugin_path . $file ) ) {
				continue;
			} else {
				$exts = explode( '.', $file );
				$ext  = strtolower( end( $exts ) );
				if ( 'php' === $ext ) {
					$plugin_datas = get_file_data(
						$plugin_path . $file,
						array(
							'name'    => 'Plugin Name',
							'version' => 'Version',
						)
					);
					if ( array_key_exists( 'name', $plugin_datas ) && ! empty( $plugin_datas['name'] ) && array_key_exists( 'version', $plugin_datas ) && ! empty( $plugin_datas['version'] ) ) {
						$plugin_name    = $plugin_datas['name'];
						$plugin_ver_num = $plugin_datas['version'];
						break;
					}
				}
			}
		}
		$plugin_version = __( 'Version:' ) . ' ' . $plugin_ver_num;
		/* translators: FAQ Link & Slug */
		$faq       = sprintf( esc_html__( 'https://wordpress.org/plugins/%s/faq', '%s' ), $slug );
		$support   = 'https://wordpress.org/support/plugin/' . $slug;
		$review    = 'https://wordpress.org/support/view/plugin-reviews/' . $slug;
		$translate = 'https://translate.wordpress.org/projects/wp-plugins/' . $slug;
		$facebook  = 'https://www.facebook.com/katsushikawamori/';
		$twitter   = 'https://twitter.com/dodesyo312';
		$youtube   = 'https://www.youtube.com/channel/UC5zTLeyROkvZm86OgNRcb_w';
		$donate    = sprintf( esc_html__( 'https://shop.riverforest-wp.info/donate/', '%s' ), $slug );

		?>
			<span style="font-weight: bold;">
			<div>
		<?php echo esc_html( $plugin_version ); ?> | 
			<a style="text-decoration: none;" href="<?php echo esc_url( $faq ); ?>" target="_blank"><?php esc_html_e( 'FAQ' ); ?></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $support ); ?>" target="_blank"><?php esc_html_e( 'Support Forums' ); ?></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $review ); ?>" target="_blank"><?php sprintf( esc_html_e( 'Reviews', '%s' ), $slug ); ?></a>
			</div>
			<div>
			<a style="text-decoration: none;" href="<?php echo esc_url( $translate ); ?>" target="_blank">
			<?php
			/* translators: Plugin translation link */
			echo sprintf( esc_html__( 'Translations for %s' ), esc_html( $plugin_name ) );
			?>
			</a> | <a style="text-decoration: none;" href="<?php echo esc_url( $facebook ); ?>" target="_blank"><span class="dashicons dashicons-facebook"></span></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $twitter ); ?>" target="_blank"><span class="dashicons dashicons-twitter"></span></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $youtube ); ?>" target="_blank"><span class="dashicons dashicons-video-alt3"></span></a>
			</div>
			</span>

			<div style="width: 250px; height: 180px; margin: 5px; padding: 5px; border: #CCC 2px solid;">
			<h3><?php sprintf( esc_html_e( 'Please make a donation if you like my work or would like to further the development of this plugin.', '%s' ), $slug ); ?></h3>
			<div style="text-align: right; margin: 5px; padding: 5px;"><span style="padding: 3px; color: #ffffff; background-color: #008000">Plugin Author</span> <span style="font-weight: bold;">Katsushi Kawamori</span></div>
			<button type="button" style="margin: 5px; padding: 5px;" onclick="window.open('<?php echo esc_url( $donate ); ?>')"><?php esc_html_e( 'Donate to this plugin &#187;' ); ?></button>
			</div>

			<?php

	}

	/** ==================================================
	 * Update wp_options table.
	 *
	 * @since 1.0
	 */
	private function options_updated() {

		if ( isset( $_POST['boxersandswipers_admin_tabs'] ) && ! empty( $_POST['boxersandswipers_admin_tabs'] ) ) {
			$tabs = intval( $_POST['boxersandswipers_admin_tabs'] );
			$post_nonce_field = 'boxersandswipers_tabs' . $tabs;
			if ( isset( $_POST[ $post_nonce_field ] ) && ! empty( $_POST[ $post_nonce_field ] ) ) {
				if ( check_admin_referer( 'bxsw_settings' . $tabs, $post_nonce_field ) ) {
					switch ( $tabs ) {
						case 1:
							$applytypes = $this->apply_type();
							$apply_tbl = array();
							if ( ! empty( $_POST['Default'] ) ) {
								foreach ( $applytypes as $key => $value ) {
									$apply_tbl[ $key ]['pc'] = null;
									$apply_tbl[ $key ]['tb'] = null;
									$apply_tbl[ $key ]['sp'] = null;
								}
								unset( $applytypes[ $key ] );
								$effect_tbl = array(
									'pc' => 'colorbox',
									'tb' => 'nivolightbox',
									'sp' => 'photoswipe',
								);
								$useragent_tbl = array(
									'tb' => 'iPad|^.*Android.*Nexus(((?:(?!Mobile))|(?:(\s(7|10).+))).)*$|Kindle|Silk.*Accelerated|Sony.*Tablet|Xperia Tablet|Sony Tablet S|SAMSUNG.*Tablet|Galaxy.*Tab|SC-01C|SC-01D|SC-01E|SC-02D',
									'sp' => 'iPhone|iPod|Android.*Mobile|BlackBerry|IEMobile',
								);
							} else {
								$apply_tbl     = get_option( 'boxersandswipers_apply' );
								$effect_tbl    = get_option( 'boxersandswipers_effect' );
								$useragent_tbl = get_option( 'boxersandswipers_useragent' );
								foreach ( $applytypes as $key => $value ) {
									if ( ! empty( $_POST['boxersandswipers_apply_pc'][ $key ] ) ) {
										$apply_tbl[ $key ]['pc'] = true;
									} else {
										$apply_tbl[ $key ]['pc'] = false;
									}
									if ( ! empty( $_POST['boxersandswipers_apply_tb'][ $key ] ) ) {
										$apply_tbl[ $key ]['tb'] = true;
									} else {
										$apply_tbl[ $key ]['tb'] = false;
									}
									if ( ! empty( $_POST['boxersandswipers_apply_sp'][ $key ] ) ) {
										$apply_tbl[ $key ]['sp'] = true;
									} else {
										$apply_tbl[ $key ]['sp'] = false;
									}
								}
								unset( $applytypes[ $key ] );
								if ( ! empty( $_POST['boxersandswipers_effect_pc'] ) ) {
									$effect_tbl['pc'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_effect_pc'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_effect_tb'] ) ) {
									$effect_tbl['tb'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_effect_tb'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_effect_sp'] ) ) {
									$effect_tbl['sp'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_effect_sp'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_useragent_tb'] ) ) {
									$useragent_tbl['tb'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_useragent_tb'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_useragent_sp'] ) ) {
									$useragent_tbl['sp'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_useragent_sp'] ) );
								}
							}
							update_option( 'boxersandswipers_apply', $apply_tbl );
							update_option( 'boxersandswipers_effect', $effect_tbl );
							update_option( 'boxersandswipers_useragent', $useragent_tbl );
							echo '<div class="notice notice-success is-dismissible"><ul><li>' . esc_html( __( 'Device Settings', 'boxers-and-swipers' ) . ' --> ' . __( 'Settings saved.' ) ) . '</li></ul></div>';
							break;
						case 2:
							if ( ! empty( $_POST['Default'] ) ) {
								$colorbox_tbl = array(
									'rel' => 'boxersandswipers',
									'transition' => 'elastic',
									'speed' => 350,
									'title' => null,
									'scalePhotos' => 'true',
									'scrolling' => 'true',
									'opacity' => 0.85,
									'open' => null,
									'returnFocus' => 'true',
									'trapFocus' => 'true',
									'fastIframe' => 'true',
									'preloading' => 'true',
									'overlayClose' => 'true',
									'escKey' => 'true',
									'arrowKey' => 'true',
									'loop' => 'true',
									'fadeOut' => 300,
									'closeButton' => 'true',
									'current' => 'image {current} of {total}',
									'previous' => 'previous',
									'next' => 'next',
									'close' => 'close',
									'width' => null,
									'height' => null,
									'innerWidth' => null,
									'innerHeight' => null,
									'initialWidth' => 300,
									'initialHeight' => 100,
									'maxWidth' => null,
									'maxHeight' => null,
									'slideshow' => 'true',
									'slideshowSpeed' => 2500,
									'slideshowAuto' => null,
									'slideshowStart' => 'start slideshow',
									'slideshowStop' => 'stop slideshow',
									'fixed' => null,
									'top' => null,
									'bottom' => null,
									'left' => null,
									'right' => null,
									'reposition' => 'true',
									'retinaImage' => null,
								);
							} else {
								$colorbox_tbl = get_option( 'boxersandswipers_colorbox' );
								if ( ! empty( $_POST['boxersandswipers_colorbox_transition'] ) ) {
									$colorbox_tbl['transition'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_transition'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_speed'] ) ) {
									$colorbox_tbl['speed'] = intval( $_POST['boxersandswipers_colorbox_speed'] );
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_title'] ) ) {
									$colorbox_tbl['title'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_title'] ) );
								} else {
									$colorbox_tbl['title'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_scalePhotos'] ) ) {
									$colorbox_tbl['scalePhotos'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_scalePhotos'] ) );
								} else {
									$colorbox_tbl['scalePhotos'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_scrolling'] ) ) {
									$colorbox_tbl['scrolling'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_scrolling'] ) );
								} else {
									$colorbox_tbl['scrolling'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_opacity'] ) ) {
									$colorbox_tbl['opacity'] = floatval( $_POST['boxersandswipers_colorbox_opacity'] );
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_open'] ) ) {
									$colorbox_tbl['open'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_open'] ) );
								} else {
									$colorbox_tbl['open'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_returnFocus'] ) ) {
									$colorbox_tbl['returnFocus'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_returnFocus'] ) );
								} else {
									$colorbox_tbl['returnFocus'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_trapFocus'] ) ) {
									$colorbox_tbl['trapFocus'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_trapFocus'] ) );
								} else {
									$colorbox_tbl['trapFocus'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_fastIframe'] ) ) {
									$colorbox_tbl['fastIframe'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_fastIframe'] ) );
								} else {
									$colorbox_tbl['fastIframe'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_preloading'] ) ) {
									$colorbox_tbl['preloading'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_preloading'] ) );
								} else {
									$colorbox_tbl['preloading'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_overlayClose'] ) ) {
									$colorbox_tbl['overlayClose'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_overlayClose'] ) );
								} else {
									$colorbox_tbl['overlayClose'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_escKey'] ) ) {
									$colorbox_tbl['escKey'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_escKey'] ) );
								} else {
									$colorbox_tbl['escKey'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_arrowKey'] ) ) {
									$colorbox_tbl['arrowKey'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_arrowKey'] ) );
								} else {
									$colorbox_tbl['arrowKey'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_loop'] ) ) {
									$colorbox_tbl['loop'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_loop'] ) );
								} else {
									$colorbox_tbl['loop'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_fadeOut'] ) ) {
									$colorbox_tbl['fadeOut'] = sanitize_text_field( intval( $_POST['boxersandswipers_colorbox_fadeOut'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_closeButton'] ) ) {
									$colorbox_tbl['closeButton'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_closeButton'] ) );
								} else {
									$colorbox_tbl['closeButton'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_current'] ) ) {
									$colorbox_tbl['current'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_current'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_previous'] ) ) {
									$colorbox_tbl['previous'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_previous'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_next'] ) ) {
									$colorbox_tbl['next'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_next'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_close'] ) ) {
									$colorbox_tbl['close'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_close'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_width'] ) ) {
									$colorbox_tbl['width'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_width'] ) );
								} else {
									$colorbox_tbl['width'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_height'] ) ) {
									$colorbox_tbl['height'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_height'] ) );
								} else {
									$colorbox_tbl['height'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_innerWidth'] ) ) {
									$colorbox_tbl['innerWidth'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_innerWidth'] ) );
								} else {
									$colorbox_tbl['innerWidth'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_innerHeight'] ) ) {
									$colorbox_tbl['innerHeight'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_innerHeight'] ) );
								} else {
									$colorbox_tbl['innerHeight'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_initialWidth'] ) ) {
									$colorbox_tbl['initialWidth'] = intval( $_POST['boxersandswipers_colorbox_initialWidth'] );
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_initialHeight'] ) ) {
									$colorbox_tbl['initialHeight'] = intval( $_POST['boxersandswipers_colorbox_initialHeight'] );
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_maxWidth'] ) ) {
									$colorbox_tbl['maxWidth'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_maxWidth'] ) );
								} else {
									$colorbox_tbl['maxWidth'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_maxHeight'] ) ) {
									$colorbox_tbl['maxHeight'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_maxHeight'] ) );
								} else {
									$colorbox_tbl['maxHeight'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_slideshow'] ) ) {
									$colorbox_tbl['slideshow'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_slideshow'] ) );
								} else {
									$colorbox_tbl['slideshow'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_slideshowSpeed'] ) ) {
									$colorbox_tbl['slideshowSpeed'] = intval( $_POST['boxersandswipers_colorbox_slideshowSpeed'] );
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_slideshowAuto'] ) ) {
									$colorbox_tbl['slideshowAuto'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_slideshowAuto'] ) );
								} else {
									$colorbox_tbl['slideshowAuto'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_slideshowStart'] ) ) {
									$colorbox_tbl['slideshowStart'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_slideshowStart'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_slideshowStop'] ) ) {
									$colorbox_tbl['slideshowStop'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_slideshowStop'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_fixed'] ) ) {
									$colorbox_tbl['fixed'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_fixed'] ) );
								} else {
									$colorbox_tbl['fixed'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_top'] ) ) {
									$colorbox_tbl['top'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_top'] ) );
								} else {
									$colorbox_tbl['top'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_bottom'] ) ) {
									$colorbox_tbl['bottom'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_bottom'] ) );
								} else {
									$colorbox_tbl['bottom'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_left'] ) ) {
									$colorbox_tbl['left'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_left'] ) );
								} else {
									$colorbox_tbl['left'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_right'] ) ) {
									$colorbox_tbl['right'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_right'] ) );
								} else {
									$colorbox_tbl['right'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_reposition'] ) ) {
									$colorbox_tbl['reposition'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_reposition'] ) );
								} else {
									$colorbox_tbl['reposition'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_colorbox_retinaImage'] ) ) {
									$colorbox_tbl['retinaImage'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_colorbox_retinaImage'] ) );
								} else {
									$colorbox_tbl['retinaImage'] = null;
								}
							}
							update_option( 'boxersandswipers_colorbox', $colorbox_tbl );
							echo '<div class="notice notice-success is-dismissible"><ul><li>Colorbox --> ' . esc_html__( 'Settings saved.' ) . '</li></ul></div>';
							break;
						case 3:
							if ( ! empty( $_POST['Default'] ) ) {
								$slimbox_tbl = array(
									'loop' => null,
									'overlayOpacity' => 0.8,
									'overlayFadeDuration' => 400,
									'resizeDuration' => 400,
									'resizeEasing' => 'swing',
									'initialWidth' => 250,
									'initialHeight' => 250,
									'imageFadeDuration' => 400,
									'captionAnimationDuration' => 400,
									'counterText' => 'Image {x} of {y}',
									'closeKeys' => '[27, 88, 67]',
									'previousKeys' => '[37, 80]',
									'nextKeys' => '[39, 78]',
								);
							} else {
								$slimbox_tbl = get_option( 'boxersandswipers_slimbox' );
								if ( ! empty( $_POST['boxersandswipers_slimbox_loop'] ) ) {
									$slimbox_tbl['loop'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_slimbox_loop'] ) );
								} else {
									$slimbox_tbl['loop'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_slimbox_overlayOpacity'] ) ) {
									$slimbox_tbl['overlayOpacity'] = floatval( $_POST['boxersandswipers_slimbox_overlayOpacity'] );
								}
								if ( ! empty( $_POST['boxersandswipers_slimbox_overlayFadeDuration'] ) ) {
									$slimbox_tbl['overlayFadeDuration'] = intval( $_POST['boxersandswipers_slimbox_overlayFadeDuration'] );
								}
								if ( ! empty( $_POST['boxersandswipers_slimbox_resizeDuration'] ) ) {
									$slimbox_tbl['resizeDuration'] = intval( $_POST['boxersandswipers_slimbox_resizeDuration'] );
								}
								if ( ! empty( $_POST['boxersandswipers_slimbox_resizeEasing'] ) ) {
									$slimbox_tbl['resizeEasing'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_slimbox_resizeEasing'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_slimbox_initialWidth'] ) ) {
									$slimbox_tbl['initialWidth'] = intval( $_POST['boxersandswipers_slimbox_initialWidth'] );
								}
								if ( ! empty( $_POST['boxersandswipers_slimbox_initialHeight'] ) ) {
									$slimbox_tbl['initialHeight'] = intval( $_POST['boxersandswipers_slimbox_initialHeight'] );
								}
								if ( ! empty( $_POST['boxersandswipers_slimbox_imageFadeDuration'] ) ) {
									$slimbox_tbl['imageFadeDuration'] = intval( $_POST['boxersandswipers_slimbox_imageFadeDuration'] );
								}
								if ( ! empty( $_POST['boxersandswipers_slimbox_captionAnimationDuration'] ) ) {
									$slimbox_tbl['captionAnimationDuration'] = intval( $_POST['boxersandswipers_slimbox_captionAnimationDuration'] );
								}
								if ( ! empty( $_POST['boxersandswipers_slimbox_counterText'] ) ) {
									$slimbox_tbl['counterText'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_slimbox_counterText'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_slimbox_closeKeys'] ) ) {
									$slimbox_tbl['closeKeys'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_slimbox_closeKeys'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_slimbox_previousKeys'] ) ) {
									$slimbox_tbl['previousKeys'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_slimbox_previousKeys'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_slimbox_nextKeys'] ) ) {
									$slimbox_tbl['nextKeys'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_slimbox_nextKeys'] ) );
								}
							}
							update_option( 'boxersandswipers_slimbox', $slimbox_tbl );
							echo '<div class="notice notice-success is-dismissible"><ul><li>Slimbox --> ' . esc_html__( 'Settings saved.' ) . '</li></ul></div>';
							break;
						case 4:
							if ( ! empty( $_POST['Default'] ) ) {
								$nivolightbox_tbl = array(
									'effect' => 'fade',
									'keyboardNav' => 'true',
									'clickOverlayToClose' => 'true',
								);
							} else {
								$nivolightbox_tbl = get_option( 'boxersandswipers_nivolightbox' );
								if ( ! empty( $_POST['boxersandswipers_nivolightbox_effect'] ) ) {
									$nivolightbox_tbl['effect'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_nivolightbox_effect'] ) );
								}
								if ( ! empty( $_POST['boxersandswipers_nivolightbox_keyboardNav'] ) ) {
									$nivolightbox_tbl['keyboardNav'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_nivolightbox_keyboardNav'] ) );
								} else {
									$nivolightbox_tbl['keyboardNav'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_nivolightbox_clickOverlayToClose'] ) ) {
									$nivolightbox_tbl['clickOverlayToClose'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_nivolightbox_clickOverlayToClose'] ) );
								} else {
									$nivolightbox_tbl['clickOverlayToClose'] = null;
								}
							}
							update_option( 'boxersandswipers_nivolightbox', $nivolightbox_tbl );
							echo '<div class="notice notice-success is-dismissible"><ul><li>Nivo Lightbox --> ' . esc_html__( 'Settings saved.' ) . '</li></ul></div>';
							break;
						case 5:
							if ( ! empty( $_POST['Default'] ) ) {
								$imagelightbox_tbl = array(
									'animationSpeed' => 250,
									'preloadNext' => 'true',
									'enableKeyboard' => 'true',
									'quitOnEnd' => null,
									'quitOnImgClick' => null,
									'quitOnDocClick' => null,
								);
							} else {
								$imagelightbox_tbl = get_option( 'boxersandswipers_imagelightbox' );
								if ( ! empty( $_POST['boxersandswipers_imagelightbox_animationSpeed'] ) ) {
									$imagelightbox_tbl['animationSpeed'] = intval( $_POST['boxersandswipers_imagelightbox_animationSpeed'] );
								}
								if ( ! empty( $_POST['boxersandswipers_imagelightbox_preloadNext'] ) ) {
									$imagelightbox_tbl['preloadNext'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_imagelightbox_preloadNext'] ) );
								} else {
									$imagelightbox_tbl['preloadNext'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_imagelightbox_enableKeyboard'] ) ) {
									$imagelightbox_tbl['enableKeyboard'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_imagelightbox_enableKeyboard'] ) );
								} else {
									$imagelightbox_tbl['enableKeyboard'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_imagelightbox_quitOnEnd'] ) ) {
									$imagelightbox_tbl['quitOnEnd'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_imagelightbox_quitOnEnd'] ) );
								} else {
									$imagelightbox_tbl['quitOnEnd'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_imagelightbox_quitOnImgClick'] ) ) {
									$imagelightbox_tbl['quitOnImgClick'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_imagelightbox_quitOnImgClick'] ) );
								} else {
									$imagelightbox_tbl['quitOnImgClick'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_imagelightbox_quitOnDocClick'] ) ) {
									$imagelightbox_tbl['quitOnDocClick'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_imagelightbox_quitOnDocClick'] ) );
								} else {
									$imagelightbox_tbl['quitOnDocClick'] = null;
								}
							}
							update_option( 'boxersandswipers_imagelightbox', $imagelightbox_tbl );
							echo '<div class="notice notice-success is-dismissible"><ul><li>Image Lightbox --> ' . esc_html__( 'Settings saved.' ) . '</li></ul></div>';
							break;
						case 6:
							if ( ! empty( $_POST['Default'] ) ) {
								$photoswipe_tbl = array(
									'bgOpacity' => 1,
									'captionArea' => 'true',
									'shareButton' => 'true',
									'fullScreenButton' => 'true',
									'zoomButton' => 'true',
									'preloaderButton' => 'true',
									'tapToClose' => null,
									'tapToToggleControls' => 'true',
									'animationDuration' => 333,
									'maxSpreadZoom' => 2,
									'history' => 'true',
								);
							} else {
								$photoswipe_tbl = get_option( 'boxersandswipers_photoswipe' );
								if ( ! empty( $_POST['boxersandswipers_photoswipe_bgOpacity'] ) ) {
									$photoswipe_tbl['bgOpacity'] = floatval( $_POST['boxersandswipers_photoswipe_bgOpacity'] );
								}
								if ( ! empty( $_POST['boxersandswipers_photoswipe_captionArea'] ) ) {
									$photoswipe_tbl['captionArea'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_photoswipe_captionArea'] ) );
								} else {
									$photoswipe_tbl['captionArea'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_photoswipe_shareButton'] ) ) {
									$photoswipe_tbl['shareButton'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_photoswipe_shareButton'] ) );
								} else {
									$photoswipe_tbl['shareButton'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_photoswipe_fullScreenButton'] ) ) {
									$photoswipe_tbl['fullScreenButton'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_photoswipe_fullScreenButton'] ) );
								} else {
									$photoswipe_tbl['fullScreenButton'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_photoswipe_zoomButton'] ) ) {
									$photoswipe_tbl['zoomButton'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_photoswipe_zoomButton'] ) );
								} else {
									$photoswipe_tbl['zoomButton'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_photoswipe_preloaderButton'] ) ) {
									$photoswipe_tbl['preloaderButton'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_photoswipe_preloaderButton'] ) );
								} else {
									$photoswipe_tbl['preloaderButton'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_photoswipe_tapToClose'] ) ) {
									$photoswipe_tbl['tapToClose'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_photoswipe_tapToClose'] ) );
								} else {
									$photoswipe_tbl['tapToClose'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_photoswipe_tapToToggleControls'] ) ) {
									$photoswipe_tbl['tapToToggleControls'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_photoswipe_tapToToggleControls'] ) );
								} else {
									$photoswipe_tbl['tapToToggleControls'] = null;
								}
								if ( ! empty( $_POST['boxersandswipers_photoswipe_animationDuration'] ) ) {
									$photoswipe_tbl['animationDuration'] = intval( $_POST['boxersandswipers_photoswipe_animationDuration'] );
								}
								if ( ! empty( $_POST['boxersandswipers_photoswipe_maxSpreadZoom'] ) ) {
									$photoswipe_tbl['maxSpreadZoom'] = intval( $_POST['boxersandswipers_photoswipe_maxSpreadZoom'] );
								}
								if ( ! empty( $_POST['boxersandswipers_photoswipe_history'] ) ) {
									$photoswipe_tbl['history'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_photoswipe_history'] ) );
								} else {
									$photoswipe_tbl['history'] = null;
								}
							}
							update_option( 'boxersandswipers_photoswipe', $photoswipe_tbl );
							echo '<div class="notice notice-success is-dismissible"><ul><li>PhotoSwipe --> ' . esc_html__( 'Settings saved.' ) . '</li></ul></div>';
							break;
						case 7:
							if ( ! empty( $_POST['Default'] ) ) {
								$swipebox_tbl = array(
									'hideBarsDelay' => 3000,
									'loopAtEnd' => null,
								);
							} else {
								$swipebox_tbl = get_option( 'boxersandswipers_swipebox' );
								if ( ! empty( $_POST['boxersandswipers_swipebox_hideBarsDelay'] ) ) {
									$swipebox_tbl['hideBarsDelay'] = intval( $_POST['boxersandswipers_swipebox_hideBarsDelay'] );
								}
								if ( ! empty( $_POST['boxersandswipers_swipebox_loopAtEnd'] ) ) {
									$swipebox_tbl['loopAtEnd'] = sanitize_text_field( wp_unslash( $_POST['boxersandswipers_swipebox_loopAtEnd'] ) );
								} else {
									$swipebox_tbl['loopAtEnd'] = null;
								}
							}
							update_option( 'boxersandswipers_swipebox', $swipebox_tbl );
							echo '<div class="notice notice-success is-dismissible"><ul><li>Swipebox --> ' . esc_html__( 'Settings saved.' ) . '</li></ul></div>';
							break;
					}
				}
			}
		}

	}

	/** ==================================================
	 * Apply type.
	 *
	 * @since 3.00
	 */
	private function apply_type() {

		$plugin_name1 = 'YITH Infinite Scrolling';
		$plugin_name2 = 'Infinite All Images';
		$install_url1 = 'plugin-install.php?tab=plugin-information&plugin=yith-infinite-scrolling';
		$install_url2 = 'plugin-install.php?tab=plugin-information&plugin=infinite-all-images';

		if ( is_multisite() ) {
			$infinitescroll_install_url1 = esc_url( network_admin_url( $install_url1 ) );
			$infinitescroll_install_url2 = esc_url( network_admin_url( $install_url2 ) );
		} else {
			$infinitescroll_install_url1 = esc_url( admin_url( $install_url1 ) );
			$infinitescroll_install_url2 = esc_url( admin_url( $install_url2 ) );
		}
		$infinitescroll_install_html = '<a href="' . $infinitescroll_install_url1 . '" style="text-decoration: none; word-break: break-all;" title="' . __( 'Works with Infinite Scroll.', 'boxers-and-swipers' ) . '">' . $plugin_name1 . '</a>,<a href="' . $infinitescroll_install_url2 . '" style="text-decoration: none; word-break: break-all;" title="' . __( 'Works with Infinite Scroll.', 'boxers-and-swipers' ) . '">' . $plugin_name2 . '</a>';

		$applytypes['postthumbnails'] = __( 'Featured Images' );
		$applytypes['infinitescroll'] = $infinitescroll_install_html;

		return $applytypes;

	}

	/** ==================================================
	 * Add custom box.
	 *
	 * @since 2.0
	 */
	public function add_exclude_boxersandswipers_custom_box() {
		add_meta_box( 'boxersandswipers_exclude', 'Boxers And Swipers', array( $this, 'exclude_boxersandswipers_custom_box' ), 'page', 'side', 'high' );
		add_meta_box( 'boxersandswipers_exclude', 'Boxers And Swipers', array( $this, 'exclude_boxersandswipers_custom_box' ), 'post', 'side', 'high' );

		$args = array(
			'public'   => true,
			'_builtin' => false,
		);
		$custom_post_types = get_post_types( $args, 'objects', 'and' );
		foreach ( $custom_post_types as $post_type ) {
			add_meta_box( 'boxersandswipers_exclude', 'Boxers And Swipers', array( $this, 'exclude_boxersandswipers_custom_box' ), $post_type->name, 'side', 'high' );
		}

	}

	/** ==================================================
	 * Custom box.
	 *
	 * @since 2.0
	 */
	public function exclude_boxersandswipers_custom_box() {

		if ( isset( $_GET['post'] ) && ! empty( $_GET['post'] ) ) {
			$get_post = intval( $_GET['post'] );
		} else {
			$get_post = null;
		}

		static $print_nonce = true;
		if ( $print_nonce ) {
			$print_nonce = false;
			wp_nonce_field( plugin_basename( __FILE__ ), 'boxersandswipers_edit_nonce' );
		}

		$boxersandswipers_exclude = get_post_meta( $get_post, 'boxersandswipers_exclude' );

		?>
		<table>
		<tbody>
			<tr>
				<td>
					<div>
						<?php
						if ( ! empty( $boxersandswipers_exclude ) ) {
							?>
							<input type="checkbox" name="boxersandswipers_exclude" value="1">
							<?php
						} else {
							?>
							<input type="checkbox" name="boxersandswipers_exclude" value="1" checked>
							<?php
						}
						esc_html_e( 'Apply', 'boxers-and-swipers' );
						?>
					</div>
				</td>
			</tr>
		</tbody>
		</table>
		<?php

	}

	/** ==================================================
	 * Update wp_postmeta table.
	 *
	 * @param int $post_id  post_id.
	 * @since 2.0
	 */
	public function save_exclude_boxersandswipers_postdata( $post_id ) {

		$slug = 'boxersandswipers';

		if ( ! current_user_can( 'edit_post', intval( $post_id ) ) ) {
			return;
		}
		$_POST += array( "{$slug}_edit_nonce" => '' );
		if ( isset( $_POST[ "{$slug}_edit_nonce" ] ) && ! empty( $_POST[ "{$slug}_edit_nonce" ] ) ) {
			$edit_nonce = wp_strip_all_tags( wp_unslash( $_POST[ "{$slug}_edit_nonce" ] ) );
			if ( ! wp_verify_nonce( $edit_nonce, plugin_basename( __FILE__ ) ) ) {
				return;
			}
		}

		if ( isset( $_REQUEST['boxersandswipers_exclude'] ) ) {
			delete_post_meta( intval( $post_id ), 'boxersandswipers_exclude' );
		} else {
			add_post_meta( intval( $post_id ), 'boxersandswipers_exclude', 1, true );
		}

	}

	/** ==================================================
	 * Posts columns menu
	 *
	 * @param array $columns  columns.
	 * @since 2.0
	 */
	public function posts_columns_boxersandswipers( $columns ) {
		$columns['column_boxersandswipers_exclude'] = __( 'Boxers And Swipers' );
		return $columns;
	}

	/** ==================================================
	 * Posts columns
	 *
	 * @param string $column_name  column_name.
	 * @param int    $post_id  post_id.
	 * @since 2.0
	 */
	public function posts_custom_columns_boxersandswipers( $column_name, $post_id ) {
		if ( 'column_boxersandswipers_exclude' === $column_name ) {
			$boxersandswipers_exclude = get_post_meta( $post_id, 'boxersandswipers_exclude' );
			if ( ! empty( $boxersandswipers_exclude ) ) {
				if ( $boxersandswipers_exclude[0] ) {
					?>
					<div><span class="column-boxersandswipers_exclude" style="display: none;">1</span>
					<?php esc_html_e( 'Exclude', 'boxers-and-swipers' ); ?></div>
					<?php
				} else {
					esc_html_e( 'Apply' );
				}
			} else {
				esc_html_e( 'Apply' );
			}
		}
	}

	/** ==================================================
	 * Pages columns menu
	 *
	 * @param array $columns  columns.
	 * @since 2.0
	 */
	public function pages_columns_boxersandswipers( $columns ) {
		$columns['column_boxersandswipers_exclude'] = __( 'Boxers And Swipers' );
		return $columns;
	}

	/** ==================================================
	 * Pages columns
	 *
	 * @param string $column_name  column_name.
	 * @param int    $post_id  post_id.
	 * @since 2.0
	 */
	public function pages_custom_columns_boxersandswipers( $column_name, $post_id ) {
		if ( 'column_boxersandswipers_exclude' === $column_name ) {
			$boxersandswipers_exclude = get_post_meta( $post_id, 'boxersandswipers_exclude' );
			if ( ! empty( $boxersandswipers_exclude ) ) {
				if ( $boxersandswipers_exclude[0] ) {
					?>
					<div><span class="column-boxersandswipers_exclude" style="display: none;">1</span>
					<?php esc_html_e( 'Exclude', 'boxers-and-swipers' ); ?></div>
					<?php
				} else {
					esc_html_e( 'Apply' );
				}
			} else {
				esc_html_e( 'Apply' );
			}
		}
	}

	/** ==================================================
	 * Quick Edit Form
	 *
	 * @param string $column_name  column_name.
	 * @param string $post_type  post_type.
	 * @since 2.38
	 */
	public function display_custom_quickedit_boxersandswipers( $column_name, $post_type ) {

		static $print_nonce = true;
		if ( $print_nonce ) {
			$print_nonce = false;
			wp_nonce_field( plugin_basename( __FILE__ ), 'boxersandswipers_edit_nonce' );
		}

		?>
		<fieldset class="inline-edit-col-right inline-edit-<?php echo esc_attr( $column_name ); ?>">
			<div class="inline-edit-col <?php echo esc_attr( $column_name ); ?>">
				<label class="inline-edit-group">
				<?php
				if ( 'column_boxersandswipers_exclude' === $column_name ) {
					?>
					<span class="title">Boxers and Swipers</span>
					<div>
					<span style="margin-right: 1em;"></span>
					<input type="checkbox" name="boxersandswipers_exclude" value="1" />
					<span class="checkbox-title"><?php esc_html_e( 'Apply' ); ?></span>
					</div>
					<?php
				}
				?>
				</label>
			</div>
		</fieldset>
		<?php

	}

	/** ==================================================
	 * Load Quick Edit Script
	 *
	 * @param string $hook  hook.
	 * @since 2.38
	 */
	public function wp_boxersandswipers_admin_enqueue_scripts( $hook ) {
		wp_enqueue_script( 'boxersandswipers_custom_script', $this->plugin_base_url . 'js/admin_edit.js', array( 'jquery', 'inline-edit-post' ), '1.00', false );
	}

}

