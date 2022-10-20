/**
 * Boxers and Swipers
 *
 * @package    Boxers and Swipers
 * @subpackage admin_edit.js for Quick Edit
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

(function($) {

	var $wp_inline_edit = inlineEditPost.edit;
	inlineEditPost.edit = function(id){

		$wp_inline_edit.apply( this, arguments );

		var $post_id = 0;
		if ( typeof(id) == 'object') {
			$post_id = parseInt( this.getId( id ) );
		}

		if ( $post_id > 0 ) {

			var $edit_row = $( '#edit-' + $post_id );
			var $post_row = $( '#post-' + $post_id );

			var $boxersandswipers_exclude = $( '.column-boxersandswipers_exclude', $post_row ).text();

			if ( $boxersandswipers_exclude == '1') {
				$( ':input[name="boxersandswipers_exclude"]', $edit_row ).prop( 'checked', false );
			} else {
				$( ':input[name="boxersandswipers_exclude"]', $edit_row ).prop( 'checked', true );
			}

		}

	};

})( jQuery );
