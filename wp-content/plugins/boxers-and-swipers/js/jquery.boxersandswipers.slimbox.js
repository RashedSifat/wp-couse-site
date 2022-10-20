/**
 * Boxers and Swipers
 *
 * @package    Boxers and Swipers
 * @subpackage jquery.boxersandswipers.slimbox.js
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
		var slimbox_options = {		loop: slimbox_settings.loop,
			overlayOpacity: parseFloat( slimbox_settings.overlayOpacity ),
			overlayFadeDuration: parseInt( slimbox_settings.overlayFadeDuration ),
			resizeDuration: parseInt( slimbox_settings.resizeDuration ),
			resizeEasing: slimbox_settings.resizeEasing,
			initialWidth: parseInt( slimbox_settings.initialWidth ),
			initialHeight: parseInt( slimbox_settings.initialHeight ),
			imageFadeDuration: parseInt( slimbox_settings.imageFadeDuration ),
			captionAnimationDuration: parseInt( slimbox_settings.captionAnimationDuration ),
			counterText: slimbox_settings.counterText,
			closeKeys: slimbox_settings.closeKeys,
			previousKeys: slimbox_settings.previousKeys,
			nextKeys: slimbox_settings.nextKeys
		};
		if ( slimbox_settings.infinitescroll ) {
			jQuery( "a[rel*=boxersandswipers]" ).live(
				'click',
				function(e){
					e.preventDefault();
					jQuery( "a[rel*=boxersandswipers]" ).slimbox( slimbox_options );
				}
			);
		} else {
			jQuery( "a[rel*=boxersandswipers]" ).slimbox( slimbox_options );
		}
	}
);
