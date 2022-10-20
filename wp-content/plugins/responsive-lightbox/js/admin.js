( function ( $ ) {

    $( document ).ready( function () {
		$( '.responsive-lightbox-settings .color-picker' ).wpColorPicker();
		$( '.responsive-lightbox-settings' ).checkBo();

		$( '.responsive-lightbox-settings input.reset-configuration' ).on( 'click', function() {
			return confirm( rlArgsAdmin.resetScriptToDefaults );
		} );

		$( '.responsive-lightbox-settings input.reset-settings' ).on( 'click', function() {
			return confirm( rlArgsAdmin.resetSettingsToDefaults );
		} );

		$( '.responsive-lightbox-settings input.reset-gallery' ).on( 'click', function() {
			return confirm( rlArgsAdmin.resetGalleryToDefaults );
		} );

		// slide toggle media provider options
		$( '.rl-media-provider-expandable' ).on( 'change', function () {
			var active = $( this ),
				options = active.closest( 'td' ).find( '.rl-media-provider-options' );

			if ( active.is( ':checked' ) )
				options.slideDown( 'fast' );
			else
				options.slideUp( 'fast' );
		} );

		// load all previously used taxonomies
		$( document ).on( 'click', '#rl_folders_load_old_taxonomies', function () {
			var select = $( '#rl_media_taxonomy' ),
				spinner = select.parent().find( '.spinner' ),
				taxonomies = [];

			select.find( 'option' ).each( function ( i, item ) {
				taxonomies.push( $( item ).val() );
			} );

			// show spinner
			spinner.toggleClass( 'is-active', true );

			$.post( ajaxurl, {
				action: 'rl-folders-load-old-taxonomies',
				taxonomies: taxonomies,
				nonce: rlArgsAdmin.tax_nonce
			} ).done( function ( response ) {
				try {
					if ( response.success && response.data.taxonomies.length > 0 ) {
						$.each( response.data.taxonomies, function ( i, item ) {
							select.append( $( '<option></option>' ).attr( 'value', item ).text( item ) );
						} );
					} else {
						//@TODO
					}
				} catch ( e ) {
					//@TODO
				}
			} ).always( function () {
				// hide spinner
				spinner.toggleClass( 'is-active', false );
			} );

			return false;
		} );
    } );

} )( jQuery );

/*
 * checkBo lightweight jQuery plugin v0.1.4 by  @ElmahdiMahmoud
 * Licensed under the MIT license - https://github.com/elmahdim/checkbo/blob/master/LICENSE
 *
 * Custom checkbox and radio
 * Author URL: elmahdim.com
 */
!function(e){e.fn.checkBo=function(c){return c=e.extend({},{checkAllButton:null,checkAllTarget:null,checkAllTextDefault:null,checkAllTextToggle:null},c),this.each(function(){function t(e){this.input=e}function n(){var c=e(this).is(":checked");e(this).closest("label").toggleClass("checked",c)}function i(e,c,t){e.text(e.parent(a).hasClass("checked")?t:c)}function h(c){var t=c.attr("data-show");c=c.attr("data-hide"),e(t).removeClass("is-hidden"),e(c).addClass("is-hidden")}var l=e(this),a=l.find(".cb-checkbox"),d=l.find(".cb-radio"),o=l.find(".cb-switcher"),s=a.find("input:checkbox"),f=d.find("input:radio");s.wrap('<span class="cb-inner"><i></i></span>'),f.wrap('<span class="cb-inner"><i></i></span>');var k=new t("input:checkbox"),r=new t("input:radio");if(t.prototype.checkbox=function(e){var c=e.find(this.input).is(":checked");e.find(this.input).prop("checked",!c).trigger("change")},t.prototype.radiobtn=function(c,t){var n=e('input:radio[name="'+t+'"]');n.prop("checked",!1),n.closest(n.closest(d)).removeClass("checked"),c.addClass("checked"),c.find(this.input).get(0).checked=c.hasClass("checked"),c.find(this.input).change()},s.on("change",n),f.on("change",n),a.find("a").on("click",function(e){e.stopPropagation()}),a.on("click",function(c){c.preventDefault(),k.checkbox(e(this)),c=e(this).attr("data-toggle"),e(c).toggleClass("is-hidden"),h(e(this))}),d.on("click",function(c){c.preventDefault(),r.radiobtn(e(this),e(this).find("input:radio").attr("name")),h(e(this))}),e.fn.toggleCheckbox=function(){this.prop("checked",!this.is(":checked"))},e.fn.switcherChecker=function(){var c=e(this),t=c.find("input"),n=c.find(".cb-state");t.is(":checked")?(c.addClass("checked"),n.html(t.attr("data-state-on"))):(c.removeClass("checked"),n.html(t.attr("data-state-off")))},o.on("click",function(c){c.preventDefault(),c=e(this),c.find("input").toggleCheckbox(),c.switcherChecker(),e(c.attr("data-toggle")).toggleClass("is-hidden")}),o.each(function(){e(this).switcherChecker()}),c.checkAllButton&&c.checkAllTarget){var u=e(this);u.find(e(c.checkAllButton)).on("click",function(){u.find(c.checkAllTarget).find("input:checkbox").each(function(){u.find(e(c.checkAllButton)).hasClass("checked")?u.find(c.checkAllTarget).find("input:checkbox").prop("checked",!0).change():u.find(c.checkAllTarget).find("input:checkbox").prop("checked",!1).change()}),i(u.find(e(c.checkAllButton)).find(".toggle-text"),c.checkAllTextDefault,c.checkAllTextToggle)}),u.find(c.checkAllTarget).find(a).on("click",function(){u.find(c.checkAllButton).find("input:checkbox").prop("checked",!1).change().removeClass("checked"),i(u.find(e(c.checkAllButton)).find(".toggle-text"),c.checkAllTextDefault,c.checkAllTextToggle)})}l.find('[checked="checked"]').closest("label").addClass("checked"),l.find("input").is("input:disabled")&&l.find("input:disabled").closest("label").off().addClass("disabled")})}}(jQuery,window,document);