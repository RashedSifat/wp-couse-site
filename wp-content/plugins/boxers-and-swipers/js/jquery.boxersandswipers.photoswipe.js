/**
 * Boxers and Swipers
 *
 * @package    Boxers and Swipers
 * @subpackage jquery.boxersandswipers.photoswipe.js
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
	function(){
		var photoswipe_options = {	bgOpacity: parseFloat( photoswipe_settings.bgOpacity ),
			captionArea: ! ! photoswipe_settings.captionArea,
			shareButton: ! ! photoswipe_settings.shareButton,
			fullScreenButton: ! ! photoswipe_settings.fullScreenButton,
			zoomButton: ! ! photoswipe_settings.zoomButton,
			preloaderButton: ! ! photoswipe_settings.preloaderButton,
			tapToClose: ! ! photoswipe_settings.tapToClose,
			tapToToggleControls: ! ! photoswipe_settings.tapToToggleControls,
			animationDuration: parseInt( photoswipe_settings.animationDuration ),
			maxSpreadZoom: parseInt( photoswipe_settings.maxSpreadZoom ),
			history: ! ! photoswipe_settings.history
		};
		if ( photoswipe_settings.infinitescroll ) {
			jQuery( ".boxersandswipers" ).live(
				'click',
				function(e){
					e.preventDefault();
					jQuery( ".boxersandswipers" ).photoSwipe( photoswipe_options );
				}
			);
		} else {
			jQuery( ".boxersandswipers" ).photoSwipe( photoswipe_options );
		}
	}
);
