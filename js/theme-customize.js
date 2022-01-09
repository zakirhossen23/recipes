/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

	// Update title background color in real time.
	wp.customize( 'color_title_background', function( value ) {
		value.bind( function( newval ) {
			$('.rcps-hero-overlay').css('background', newval);

			var color_contrast = mytheme_get_contrast( newval, 'dark', 'light' );

			if ( 'dark' == color_contrast ) {
				$('.rcps-hero-overlay').css('color', '#f8f8f8');
				$('.rcps-icon-on-hero').css('fill', '#f8f8f8');
			} else {
				$('.rcps-hero-overlay').css('color', '#333');
				$('.rcps-icon-on-hero').css('fill', '#333');
			}
		} );
	} );

	// Update favorite color.
	wp.customize( 'color_favorite', function( value ) {
		value.bind( function( newval ) {
			$('.rcps-icon-heart-favorited, .rcps-input-checkbox:checked + label .rcps-icon').css('fill', newval);
		} );
	} );

	// Update accent color.
	wp.customize( 'color_links', function( value ) {
		value.bind( function( newval ) {
			$('.rcps-tabs-nav-active a').css('border-bottom-color', newval);
			$('.rcps-title-header h1 a, .rcps-title-header a.rcps-h1, .rcps-nav-main-ul > li > a[aria-current="page"], .rcps-author-top a').css('text-decoration-color', newval);
		} );
	} );

	// Update rating stars color.
	wp.customize( 'color_star_rating', function( value ) {
		value.bind( function( newval ) {
			$('.rcps-rating-stars .rcps-icon').css('fill', newval);

			var color_contrast = mytheme_get_contrast( newval, 'dark', 'light' );

			if ( 'dark' == color_contrast ) {
				$('.rcps-item-rating').addClass('rcps-item-rating-light');
			} else {
				$('.rcps-item-rating').removeClass('rcps-item-rating-light');
			}
		} );
	} );

	// Update term background color.
	wp.customize( 'color_term_background', function( value ) {
		value.bind( function( newval ) {
			$('.rcps-item-tax a, .rcps-item-tax span').css('background', newval );

			var color_contrast = mytheme_get_contrast( newval, 'dark', 'light' );

			if ( 'dark' == color_contrast ) {
				$('.rcps-item-tax a, .rcps-item-tax span').css('color', '#f8f8f8');
			} else {
				$('.rcps-item-tax a, .rcps-item-tax span').css('color', '#333');
			}
		} );
	} );

	// Update theme.
	wp.customize( 'theme', function( value ) {
		value.bind( function( newval ) {
			$('body').removeClass('rcps-theme-light rcps-theme-dark');
			$('body').addClass('rcps-theme-'+newval);
		} );
	} );

} )( jQuery );

// Calculates color contrast.
function mytheme_get_contrast( hex, dark_return, light_return ) {

	var rgb = mytheme_hex2rgb( hex );
	var colors = rgb.split(',');
	var r = colors[0];
	var g = colors[1];
	var b = colors[2];

	var yiq = ((r*299)+(g*587)+(b*114))/1000;
	return (yiq >= 155) ? light_return : dark_return;
}

// Converts HEX color value to RGB.
function mytheme_hex2rgb( hex ) {

	hex = hex.replace('#', '');
	var r = parseInt(hex.substr(0,2),16);
	var g = parseInt(hex.substr(2,2),16);
	var b = parseInt(hex.substr(4,2),16);

	return r + ',' + g + ',' + b;
}
