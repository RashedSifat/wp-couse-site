/**
 * Boxers and Swipers
 *
 * @package    Boxers and Swipers
 * @subpackage jquery.boxersandswipers.nivolightbox.js
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
		var nivolightbox_options = {	effect: nivolightbox_settings.effect,
			keyboardNav: ! ! nivolightbox_settings.keyboardNav,
			clickOverlayToClose: ! ! nivolightbox_settings.clickOverlayToClose
		};
		if ( nivolightbox_settings.infinitescroll ) {
			jQuery( 'a[data-lightbox-gallery*="boxersandswipers"]' ).live(
				'click',
				function(e){
					e.preventDefault();
					jQuery( 'a[data-lightbox-gallery*="boxersandswipers"]' ).nivoLightbox( nivolightbox_options );
				}
			);
		} else {
			jQuery( 'a[data-lightbox-gallery*="boxersandswipers"]' ).nivoLightbox( nivolightbox_options );
		}
	}
);
