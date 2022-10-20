/**
 * Boxers and Swipers
 *
 * @package    Boxers and Swipers
 * @subpackage jquery.boxersandswipers.colorbox.js
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

jQuery(
	function() {

		if ( ! colorbox_settings.title ) {
			colorbox_settings.title = ! ! colorbox_settings.title;
		}
		if ( ! colorbox_settings.width ) {
			colorbox_settings.width = ! ! colorbox_settings.width;
		}
		if ( ! colorbox_settings.height ) {
			colorbox_settings.height = ! ! colorbox_settings.height;
		}
		if ( ! colorbox_settings.innerWidth ) {
			colorbox_settings.innerWidth = ! ! colorbox_settings.innerWidth;
		}
		if ( ! colorbox_settings.innerHeight ) {
			colorbox_settings.innerHeight = ! ! colorbox_settings.innerHeight;
		}
		if ( ! colorbox_settings.maxWidth ) {
			colorbox_settings.maxWidth = ! ! colorbox_settings.maxWidth;
		}
		if ( ! colorbox_settings.maxHeight ) {
			colorbox_settings.maxHeight = ! ! colorbox_settings.maxHeight;
		}
		if ( ! colorbox_settings.top ) {
			colorbox_settings.top = ! ! colorbox_settings.top;
		}
		if ( ! colorbox_settings.bottom ) {
			colorbox_settings.bottom = ! ! colorbox_settings.bottom;
		}
		if ( ! colorbox_settings.left ) {
			colorbox_settings.left = ! ! colorbox_settings.left;
		}
		if ( ! colorbox_settings.right ) {
			colorbox_settings.right = ! ! colorbox_settings.right;
		}

		var colorbox_options = {	rel: colorbox_settings.rel,
			transition: colorbox_settings.transition,
			speed: parseInt( colorbox_settings.speed ),
			title: colorbox_settings.title,
			scalePhotos: ! ! colorbox_settings.scalePhotos,
			scrolling: ! ! colorbox_settings.scrolling,
			opacity: parseFloat( colorbox_settings.opacity ),
			open: ! ! colorbox_settings.open,
			returnFocus: ! ! colorbox_settings.returnFocus,
			trapFocus: ! ! colorbox_settings.trapFocus,
			fastIframe: ! ! colorbox_settings.fastIframe,
			preloading: ! ! colorbox_settings.preloading,
			overlayClose: ! ! colorbox_settings.overlayClose,
			escKey: ! ! colorbox_settings.escKey,
			arrowKey: ! ! colorbox_settings.arrowKey,
			loop: ! ! colorbox_settings.loop,
			fadeOut: parseInt( colorbox_settings.fadeOut ),
			closeButton: ! ! colorbox_settings.closeButton,
			current: colorbox_settings.current,
			previous: colorbox_settings.previous,
			next: colorbox_settings.next,
			close: colorbox_settings.close,
			width: colorbox_settings.width,
			height: colorbox_settings.height,
			innerWidth: colorbox_settings.innerWidth,
			innerHeight: colorbox_settings.innerHeight,
			initialWidth: parseInt( colorbox_settings.initialWidth ),
			initialHeight: parseInt( colorbox_settings.initialHeight ),
			maxWidth: colorbox_settings.maxWidth,
			maxHeight: colorbox_settings.maxHeight,
			slideshow: ! ! colorbox_settings.slideshow,
			slideshowSpeed: parseInt( colorbox_settings.slideshowSpeed ),
			slideshowAuto: ! ! colorbox_settings.slideshowAuto,
			slideshowStart: colorbox_settings.slideshowStart,
			slideshowStop: colorbox_settings.slideshowStop,
			fixed: ! ! colorbox_settings.fixed,
			top: colorbox_settings.top,
			bottom: colorbox_settings.bottom,
			left: colorbox_settings.left,
			right: colorbox_settings.right,
			reposition: ! ! colorbox_settings.reposition,
			retinaImage: ! ! colorbox_settings.retinaImage
		};
		if ( colorbox_settings.infinitescroll ) {
			jQuery( ".boxersandswipers" ).live(
				'click',
				function(e){
					e.preventDefault();
					jQuery( ".boxersandswipers" ).colorbox( colorbox_options );
				}
			);
		} else {
			jQuery( ".boxersandswipers" ).colorbox( colorbox_options );
		}

	}
);
