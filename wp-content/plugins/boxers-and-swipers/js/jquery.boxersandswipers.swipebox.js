/**
 * Boxers and Swipers
 *
 * @package    Boxers and Swipers
 * @subpackage jquery.boxersandswipers.swipebox.js
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
		var swipebox_options = {	hideBarsDelay: parseInt( swipebox_settings.hideBarsDelay ),
			loopAtEnd: ! ! swipebox_settings.loopAtEnd
		};
		if ( swipebox_settings.infinitescroll ) {
			jQuery( ".boxersandswipers" ).live(
				'click',
				function(e){
					e.preventDefault();
					jQuery( ".boxersandswipers" ).swipebox( swipebox_options );
				}
			);
		} else {
			jQuery( ".boxersandswipers" ).swipebox( swipebox_options );
		}
	}
);
