/**
 * Boxers and Swipers
 *
 * @package    Boxers and Swipers
 * @subpackage jquery.boxersandswipers.imagelightbox.js
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

		var activityIndicatorOn = function()
	{
			jQuery( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo( 'body' );
		},
		activityIndicatorOff = function()
	{
			jQuery( '#imagelightbox-loading' ).remove();
		},
		overlayOn = function()
	{
			jQuery( '<div id="imagelightbox-overlay"></div>' ).appendTo( 'body' );
		},
		overlayOff = function()
	{
			jQuery( '#imagelightbox-overlay' ).remove();
		},
		closeButtonOn = function( instance )
	{
			jQuery( '<a href="#" id="imagelightbox-close">Close</a>' ).appendTo( 'body' ).on( 'click touchend', function(){ jQuery( this ).remove(); instance.quitImageLightbox(); return false; } );
		},
		closeButtonOff = function()
	{
			jQuery( '#imagelightbox-close' ).remove();
		},
		captionOn = function()
	{
			var description = jQuery( 'a[href="' + jQuery( '#imagelightbox' ).attr( 'src' ) + '"] img' ).attr( 'alt' );
			if ( description.length > 0 ) {
				jQuery( '<div id="imagelightbox-caption">' + description + '</div>' ).appendTo( 'body' );
			}
		},
		captionOff = function()
	{
			jQuery( '#imagelightbox-caption' ).remove();
		};

		var imagelightbox_options = { 	animationSpeed: parseInt( imagelightbox_settings.animationSpeed ),
			preloadNext: ! ! imagelightbox_settings.preloadNext,
			enableKeyboard: ! ! imagelightbox_settings.enableKeyboard,
			quitOnEnd: ! ! imagelightbox_settings.quitOnEnd,
			quitOnImgClick: ! ! imagelightbox_settings.quitOnImgClick,
			quitOnDocClick: ! ! imagelightbox_settings.quitOnDocClick,
			onStart: function() { overlayOn(); closeButtonOn( instanceBoxersAndSwipers );},onEnd: function() { overlayOff(); captionOff(); closeButtonOff(); activityIndicatorOff(); },onLoadStart: function() { captionOff(); activityIndicatorOn(); },onLoadEnd: function() { captionOn(); activityIndicatorOff(); }
		};
		if ( imagelightbox_settings.infinitescroll ) {
			var instanceBoxersAndSwipers = jQuery( 'a[data-imagelightbox="boxersandswipers"]' ).live(
				'click',
				function(e){
					e.preventDefault();
					var instanceBoxersAndSwipers = jQuery( 'a[data-imagelightbox="boxersandswipers"]' ).imageLightbox( imagelightbox_options );
				}
			);
		} else {
			var instanceBoxersAndSwipers = jQuery( 'a[data-imagelightbox="boxersandswipers"]' ).imageLightbox( imagelightbox_options );
		}

	}
);
