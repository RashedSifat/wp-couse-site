<?php
/**
 * Boxers and Swipers
 *
 * @package    Boxers and Swipers
 * @subpackage BoxersAndSwipers Main Functions
/*
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

$boxersandswipers = new BoxersAndSwipers();
add_action( 'wp_enqueue_scripts', array( $boxersandswipers, 'load_frontend_scripts' ) );
add_action( 'wp_enqueue_scripts', array( $boxersandswipers, 'load_frontend_styles' ) );

/** ==================================================
 * Main Functions
 */
class BoxersAndSwipers {

	/** ==================================================
	 * Effect
	 *
	 * @var $effect  effect.
	 */
	private $effect;

	/** ==================================================
	 * Construct
	 *
	 * @since 3.05
	 */
	public function __construct() {

		$device = $this->agent_check();
		$boxersandswipers_effect = get_option( 'boxersandswipers_effect' );
		$this->effect = $boxersandswipers_effect[ $device ];

		add_filter( 'the_content', array( $this, 'add_anchor_tag' ) );
		add_filter( 'post_infiniteallimages', array( $this, 'add_anchor_tag' ) );
		add_filter( 'post_thumbnail_html', array( $this, 'add_post_thumbnail_tag' ), 10, 5 );

	}

	/** ==================================================
	 * Add anchor tag
	 *
	 * @param string $link  link.
	 * @return string $link
	 * @since 1.0
	 */
	public function add_anchor_tag( $link ) {

		$boxersandswipers_exclude = get_post_meta( get_the_ID(), 'boxersandswipers_exclude' );
		$simplemasonry_apply = get_post_meta( get_the_ID(), 'simplemasonry_apply' );
		$simplenivoslider_apply = get_post_meta( get_the_ID(), 'simplenivoslider_apply' );

		if ( ! empty( $boxersandswipers_exclude ) && $boxersandswipers_exclude[0] ) {
			/* Through */
			$dummy = 0;
		} else if ( class_exists( 'SimpleMasonry' ) && get_post_gallery( get_the_ID() ) && ! empty( $simplemasonry_apply ) && $simplemasonry_apply[0] ) {
			/* Simple Masonry Gallery https://wordpress.org/plugins/simple-masonry-gallery/ for Gallery */
			add_filter( 'post_gallery', array( $this, 'gallery_filter' ) );
			$link = $this->add_anchor_tag_content( $link );
		} else if ( class_exists( 'SimpleNivoSlider' ) && ! empty( $simplenivoslider_apply ) && $simplenivoslider_apply[0] ) {
			/* for Simple Nivo Slider https://wordpress.org/plugins/simple-nivoslider/ */
			$dummy = 0;
		} else {
			if ( ! is_attachment() ) {
				/* for Gallery */
				add_shortcode( 'gallery', array( $this, 'file_gallery_shortcode' ) );
				add_filter( 'post_gallery', array( $this, 'gallery_filter' ) );
				/* for Insert Attachement */
				$link = $this->add_anchor_tag_content( $link );
			}
		}

		return $link;

	}

	/** ==================================================
	 * Add anchor tag content
	 *
	 * @param string $link  link.
	 * @return $link
	 * @since 1.0
	 */
	private function add_anchor_tag_content( $link ) {

		if ( preg_match_all( "/\s+href\s*=\s*([\"\']?)([^\s\"\'>]+)(\\1)/ims", $link, $result ) !== false ) {
			global $post;
			$attachments = get_children(
				array(
					'post_parent' => $post->ID,
					'post_type' => 'attachment',
					'post_status' => 'any',
					'post_mime_type' => 'image',
				)
			);
			foreach ( $result[0] as $value ) {
				$exts = explode( '.', substr( $value, 0, -1 ) );
				$ext = end( $exts );
				$ext2type = wp_ext2type( $ext );
				if ( 'image' === $ext2type ) {
					if ( 'colorbox' === $this->effect ) {
						/* colorbox */
						$class_name = ' class="boxersandswipers"';
						$titlename = null;
						foreach ( $attachments as $attachment ) {
							if ( strpos( $value, get_post_meta( $attachment->ID, '_wp_attached_file', true ) ) ) {
								$titlename = ' title="' . $attachment->post_title . '"';
							}
						}
						$link = str_replace( $value, $class_name . $titlename . $value, $link );
					} else if ( 'slimbox' === $this->effect ) {
						/* slimbox */
						$rel_name = ' rel="boxersandswipers"';
						$titlename = null;
						foreach ( $attachments as $attachment ) {
							if ( strpos( $value, get_post_meta( $attachment->ID, '_wp_attached_file', true ) ) ) {
								$titlename = ' title="' . $attachment->post_title . '"';
							}
						}
						$link = str_replace( $value, $rel_name . $titlename . $value, $link );
					} else if ( 'nivolightbox' === $this->effect ) {
						/* nivolightbox */
						$rel_name = ' data-lightbox-gallery="boxersandswipers"';
						$titlename = null;
						foreach ( $attachments as $attachment ) {
							if ( strpos( $value, get_post_meta( $attachment->ID, '_wp_attached_file', true ) ) ) {
								$titlename = ' title="' . $attachment->post_title . '"';
							}
						}
						$link = str_replace( $value, $rel_name . $titlename . $value, $link );
					} else if ( 'imagelightbox' === $this->effect ) {
						/* imagelightbox */
						$rel_name = ' data-imagelightbox="boxersandswipers"';
						$titlename = null;
						foreach ( $attachments as $attachment ) {
							if ( strpos( $value, get_post_meta( $attachment->ID, '_wp_attached_file', true ) ) ) {
								$titlename = ' title="' . $attachment->post_title . '"';
							}
						}
						$link = str_replace( $value, $rel_name . $titlename . $value, $link );
					} else if ( 'photoswipe' === $this->effect || 'swipebox' === $this->effect ) {
						/* photoswipe || swipebox  */
						$rel_name = ' rel="boxers-and-swipers"';
						$class_name = ' class="boxersandswipers"';
						$titlename = null;
						foreach ( $attachments as $attachment ) {
							if ( strpos( $value, get_post_meta( $attachment->ID, '_wp_attached_file', true ) ) ) {
								$titlename = ' title="' . $attachment->post_title . '"';
							}
						}
						$link = str_replace( $value, $rel_name . $class_name . $titlename . $value, $link );
					}
				}
			}
		}
		if ( preg_match_all( '/<img(.+?)>/i', $link, $result ) !== false ) {
			foreach ( $result[1] as $value ) {
				preg_match( '/src=\"(.[^\"]*)\"/', $value, $src );
				if ( isset( $src[1] ) ) {
					$explode = explode( '/', $src[1] );
					$file_name = $explode[ count( $explode ) - 1 ];
					$alt_name = preg_replace( '/(.+)(\.[^.]+$)/', '$1', $file_name );
					if ( ! strpos( $value, 'alt=' ) ) {
						$alt_name = ' alt="' . $alt_name . '" ';
						$link = str_replace( $value, $alt_name . $value, $link );
					}
				}
			}
		}

		return $link;

	}

	/** ==================================================
	 * Gallery filter
	 *
	 * @param string $link  link.
	 * @since 1.0
	 */
	public function gallery_filter( $link ) {
		add_filter( 'wp_get_attachment_link', array( $this, 'add_anchor_tag_gallery' ), 10, 6 );
	}

	/** ==================================================
	 * Add anchor tag gallery
	 *
	 * @param string $link  link.
	 * @param string $id  id.
	 * @param string $size  size.
	 * @param string $permalink  permalink.
	 * @param string $icon  icon.
	 * @param string $text  text.
	 * @return string $link
	 * @since 1.0
	 */
	public function add_anchor_tag_gallery( $link, $id, $size, $permalink, $icon, $text ) {

		if ( preg_match_all( "/\s+href\s*=\s*([\"\']?)([^\s\"\'>]+)(\\1)/ims", $link, $result ) !== false ) {
			foreach ( $result[0] as $value ) {
				$exts = explode( '.', substr( $value, 0, -1 ) );
				$ext = end( $exts );
				$ext2type = wp_ext2type( $ext );
				if ( 'image' === $ext2type ) {
					$titlename = ' title="' . get_the_title( $id ) . '"';
					if ( 'colorbox' === $this->effect ) {
						/* colorbox  */
						$class_name = 'class="boxersandswipers"';
						$link = str_replace( '<a', '<a ' . $class_name . $titlename, $link );
					} else if ( 'slimbox' === $this->effect ) {
						/* slimbox */
						$rel_name = 'rel="boxersandswipers"';
						$link = str_replace( '<a', '<a ' . $rel_name . $titlename, $link );
					} else if ( 'nivolightbox' === $this->effect ) {
						/* nivolightbox */
						$rel_name = 'data-lightbox-gallery="boxersandswipers"';
						$link = str_replace( '<a', '<a ' . $rel_name . $titlename, $link );
					} else if ( 'imagelightbox' === $this->effect ) {
						/* imagelightbox */
						$rel_name = 'data-imagelightbox="boxersandswipers"';
						$link = str_replace( '<a', '<a ' . $rel_name . $titlename, $link );
					} else if ( 'photoswipe' === $this->effect ) {
						/* photoswipe */
						$rel_name = 'rel="boxers-and-swipers"';
						$class_name = ' class="boxersandswipers" ';
						$link = str_replace( '<a', '<a ' . $rel_name . $class_name, $link );
					} else if ( 'swipebox' === $this->effect ) {
						/* swipebox */
						$rel_name = 'rel="boxers-and-swipers"';
						$class_name = ' class="boxersandswipers"';
						$link = str_replace( '<a', '<a ' . $rel_name . $class_name . $titlename, $link );
					}
				}
			}
		}

		return $link;

	}

	/** ==================================================
	 * Load Script
	 *
	 * @since 3.00
	 */
	public function load_frontend_scripts() {

		$boxersandswipers_plugin_url = plugin_dir_url( __DIR__ );
		$boxersandswipers_apply = get_option( 'boxersandswipers_apply' );
		$device = $this->agent_check();
		$add_apply_set = array( 'infinitescroll' => $boxersandswipers_apply['infinitescroll'][ $device ] );

		wp_enqueue_script( 'jquery' );

		if ( 'colorbox' === $this->effect ) {
			/* for COLORBOX */
			wp_enqueue_script( 'colorbox', $boxersandswipers_plugin_url . 'colorbox/jquery.colorbox-min.js', null, '1.4.37' );
			wp_enqueue_script( 'colorbox-jquery', $boxersandswipers_plugin_url . 'js/jquery.boxersandswipers.colorbox.js', array( 'jquery' ), '1.00' );
			$settings_tbl = get_option( 'boxersandswipers_colorbox' );
			$settings_tbl = array_merge( $settings_tbl, $add_apply_set );
			wp_localize_script( 'colorbox-jquery', 'colorbox_settings', $settings_tbl );
		} else if ( 'slimbox' === $this->effect ) {
			/* for slimbox */
			wp_enqueue_script( 'slimbox', $boxersandswipers_plugin_url . 'slimbox/js/slimbox2.js', null, '2.05' );
			wp_enqueue_script( 'slimbox-jquery', $boxersandswipers_plugin_url . 'js/jquery.boxersandswipers.slimbox.js', array( 'jquery' ), '1.00' );
			$settings_tbl = get_option( 'boxersandswipers_slimbox' );
			$settings_tbl = array_merge( $settings_tbl, $add_apply_set );
			wp_localize_script( 'slimbox-jquery', 'slimbox_settings', $settings_tbl );
		} else if ( 'nivolightbox' === $this->effect ) {
			/* for nivolightbox */
			wp_enqueue_script( 'nivolightbox', $boxersandswipers_plugin_url . 'nivolightbox/nivo-lightbox.min.js', null, '1.2.0' );
			wp_enqueue_script( 'nivolightbox-jquery', $boxersandswipers_plugin_url . 'js/jquery.boxersandswipers.nivolightbox.js', array( 'jquery' ), '1.00' );
			$settings_tbl = get_option( 'boxersandswipers_nivolightbox' );
			$settings_tbl = array_merge( $settings_tbl, $add_apply_set );
			wp_localize_script( 'nivolightbox-jquery', 'nivolightbox_settings', $settings_tbl );
		} else if ( 'imagelightbox' === $this->effect ) {
			/* for imagelightbox */
			wp_enqueue_script( 'imagelightbox', $boxersandswipers_plugin_url . 'imagelightbox/imagelightbox.min.js', null, '1.0.0' );
			wp_enqueue_script( 'imagelightbox-jquery', $boxersandswipers_plugin_url . 'js/jquery.boxersandswipers.imagelightbox.js', array( 'jquery' ), '1.00' );
			$settings_tbl = get_option( 'boxersandswipers_imagelightbox' );
			$settings_tbl = array_merge( $settings_tbl, $add_apply_set );
			wp_localize_script( 'imagelightbox-jquery', 'imagelightbox_settings', $settings_tbl );
		} else if ( 'photoswipe' === $this->effect ) {
			/* for PhotoSwipe */
			wp_enqueue_script( 'photoswipe', $boxersandswipers_plugin_url . 'photoswipe/jquery.photoswipe.js', null, '4.1.1' );
			wp_enqueue_script( 'photoswipe-jquery', $boxersandswipers_plugin_url . 'js/jquery.boxersandswipers.photoswipe.js', array( 'jquery' ), '1.00' );
			$settings_tbl = get_option( 'boxersandswipers_photoswipe' );
			$settings_tbl = array_merge( $settings_tbl, $add_apply_set );
			wp_localize_script( 'photoswipe-jquery', 'photoswipe_settings', $settings_tbl );
		} else if ( 'swipebox' === $this->effect ) {
			/* for Swipebox */
			wp_enqueue_script( 'swipebox', $boxersandswipers_plugin_url . 'swipebox/js/jquery.swipebox.min.js', null, '1.3.0.1' );
			wp_enqueue_script( 'swipebox-jquery', $boxersandswipers_plugin_url . 'js/jquery.boxersandswipers.swipebox.js', array( 'jquery' ), '1.00' );
			$settings_tbl = get_option( 'boxersandswipers_swipebox' );
			$settings_tbl = array_merge( $settings_tbl, $add_apply_set );
			wp_localize_script( 'swipebox-jquery', 'swipebox_settings', $settings_tbl );
		}

	}

	/** ==================================================
	 * Load CSS
	 *
	 * @since 3.00
	 */
	public function load_frontend_styles() {

		$boxersandswipers_plugin_url = plugin_dir_url( __DIR__ );

		if ( 'colorbox' === $this->effect ) {
			/* for COLORBOX */
			wp_enqueue_style( 'colorbox', $boxersandswipers_plugin_url . 'colorbox/colorbox.css', array(), '1.4.37' );
		} else if ( 'slimbox' === $this->effect ) {
			/* for slimbox */
			wp_enqueue_style( 'slimbox', $boxersandswipers_plugin_url . 'slimbox/css/slimbox2.css', array(), '2.05' );
		} else if ( 'nivolightbox' === $this->effect ) {
			/* for nivolightbox */
			wp_enqueue_style( 'nivolightbox', $boxersandswipers_plugin_url . 'nivolightbox/nivo-lightbox.css', array(), '1.2.0' );
			wp_enqueue_style( 'nivolightbox-themes', $boxersandswipers_plugin_url . 'nivolightbox/themes/default/default.css', array(), '1.2.0' );
		} else if ( 'imagelightbox' === $this->effect ) {
			/* for imagelightbox */
			wp_enqueue_style( 'imagelightbox', $boxersandswipers_plugin_url . 'imagelightbox/imagelightbox.css', array(), '1.0.0' );
		} else if ( 'photoswipe' === $this->effect ) {
			/* for PhotoSwipe */
			wp_enqueue_style( 'photoswipe', $boxersandswipers_plugin_url . 'photoswipe/photoswipe.css', array(), '4.1.1' );
		} else if ( 'swipebox' === $this->effect ) {
			/* for Swipebox */
			wp_enqueue_style( 'swipebox', $boxersandswipers_plugin_url . 'swipebox/css/swipebox.min.css', array(), '1.3.0.1' );
		}

	}

	/** ==================================================
	 * User agent check
	 *
	 * @return string $device
	 * @since 1.0
	 */
	private function agent_check() {

		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ! empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$user_agent = sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) );
		} else {
			return 'pc';
		}

		$boxersandswipers_useragent = get_option( 'boxersandswipers_useragent' );

		if ( preg_match( '{' . $boxersandswipers_useragent['tb'] . '}', $user_agent ) ) {
			/* Tablet */
			$device = 'tb';
		} else if ( preg_match( '{' . $boxersandswipers_useragent['sp'] . '}', $user_agent ) ) {
			/* Smartphone */
			$device = 'sp';
		} else {
			$device = 'pc';
		}

		return $device;

	}

	/** ==================================================
	 * File galley shortcode
	 *
	 * @param array $atts  atts.
	 * @return array $atts
	 * @since 1.5
	 */
	public function file_gallery_shortcode( $atts ) {

		if ( empty( $atts['link'] ) ) {
			$atts['link'] = 'file';
		} else if ( 'none' === $atts['link'] ) {
			$atts['link'] = 'none';
		} else {
			$atts['link'] = 'file';
		}

		return gallery_shortcode( $atts );

	}

	/** ==================================================
	 * Add post thumbnail tag
	 *
	 * @param string $html  html.
	 * @param int    $post_id  post_id.
	 * @param string $post_thumbnail_id  post_thumbnail_id.
	 * @param string $size  size.
	 * @param array  $attr  attr.
	 * @return string $html
	 * @since 2.40
	 */
	public function add_post_thumbnail_tag( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
		$device = $this->agent_check();
		$boxersandswipers_apply = get_option( 'boxersandswipers_apply' );
		if ( has_post_thumbnail() && $boxersandswipers_apply['postthumbnails'][ $device ] ) {
			$large_image_url = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );
			$link = ' href="' . $large_image_url[0];

			if ( 'colorbox' === $this->effect ) {
				/*  colorbox */
				$class_name = ' class="boxersandswipers" title="' . get_the_title( $post_thumbnail_id ) . '"';
			} else if ( 'slimbox' === $this->effect ) {
				/* slimbox */
				$class_name = ' rel="boxersandswipers" title="' . get_the_title( $post_thumbnail_id ) . '"';
			} else if ( 'nivolightbox' === $this->effect ) {
				/* nivolightbox */
				$class_name = ' data-lightbox-gallery="boxersandswipers" title="' . get_the_title( $post_thumbnail_id ) . '"';
			} else if ( 'imagelightbox' === $this->effect ) {
				/* imagelightbox */
				$class_name = ' data-imagelightbox="boxersandswipers" title="' . get_the_title( $post_thumbnail_id ) . '"';
			} else if ( 'photoswipe' === $this->effect || 'swipebox' === $this->effect ) {
				/* photoswipe || swipebox */
				$class_name = ' rel="boxers-and-swipers" class="boxersandswipers" title="' . get_the_title( $post_thumbnail_id ) . '"';
			}

			$html2 = '<a ' . $class_name . $link . '">';
			$html2 .= $html;
			$html2 .= '</a>';
			return $html2;
		} else {
			return $html;
		}
	}

}


