/**
 * Customizer JS
 *
 * Reloads changes on Theme Customizer Preview asynchronously for better usability
 *
 * @package Napoli Pro
 */

( function( $ ) {

	/* Header Search checkbox */
	wp.customize( 'napoli_theme_options[header_search]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				hideElement( '.primary-navigation .main-navigation li.header-search' );
			} else {
				showElement( '.primary-navigation .main-navigation li.header-search' );
			}
		} );
	} );

	/* Author Bio checkbox */
	wp.customize( 'napoli_theme_options[author_bio]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				hideElement( '.single-post .type-post .entry-author' );
			} else {
				showElement( '.single-post .type-post .entry-author' );
			}
		} );
	} );

	/* Header Color Option */
	wp.customize( 'napoli_theme_options[header_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.site-header' )
				.css( 'background', newval );

			var textcolor, hovercolor;

			if( isColorLight( newval ) ) {
				textcolor = '#111111';
				hovercolor = 'rgba(0,0,0,0.5)';
			} else {
				textcolor = '#ffffff';
				hovercolor = '#cccccc';
			}

			$( '.site-title, .site-title a, .main-navigation ul a, .header-social-icons .social-icons-menu li a' )
				.css( 'color', textcolor );
			$('.site-title, .site-title a, .main-navigation ul a, .header-social-icons .social-icons-menu li a')
				.hover( function() { $( this ).css( 'color', hovercolor ); },
						function() { $( this ).css( 'color', textcolor ); }
				);
			$( '.mobile-menu-toggle .icon, .main-navigation .dropdown-toggle .icon, .main-navigation ul .menu-item-has-children > a > .icon' )
				.css( 'fill', textcolor );
			$('.mobile-menu-toggle, .main-navigation .dropdown-toggle, .main-navigation ul .menu-item-has-children > a')
				.hover( function() { $( this ).css( 'fill', hovercolor ); },
						function() { $( this ).css( 'fill', textcolor ); }
				);
		} );
	} );

	/* Navigation Color Option */
	wp.customize( 'napoli_theme_options[navigation_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.secondary-navigation' )
				.css( 'background', newval );

			var textcolor, hovercolor;

			if( isColorDark( newval ) ) {
				textcolor = '#ffffff';
				hovercolor = 'rgba(255,255,255,0.5)';
			} else {
				textcolor = '#444444';
				hovercolor = '#999999';
			}

			$( '.header-navigation ul > li > a' )
				.css( 'color', textcolor );
			$('.header-navigation ul > li > a')
				.hover( function() { $( this ).css( 'color', hovercolor ); },
						function() { $( this ).css( 'color', textcolor ); }
				);
			$( '.header-navigation > ul > li > .dropdown-toggle .icon, .header-navigation > ul > .menu-item-has-children > a > .icon' )
				.css( 'fill', textcolor );
			$('.header-navigation > ul > li > .dropdown-toggle, .header-navigation > ul > .menu-item-has-children > a')
				.hover( function() { $( this ).css( 'fill', hovercolor ); },
						function() { $( this ).css( 'fill', textcolor ); }
				);
		} );
	} );

	/* Title Color Option */
	wp.customize( 'napoli_theme_options[title_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.page-title, .entry-title, .entry-title a' )
				.css( 'color', newval );
			$('.entry-title, .entry-title a')
				.hover( function() { $( this ).css( 'color', '#303030' ); },
						function() { $( this ).css( 'color', newval ); }
				);
		} );
	} );

	/* Widget Title Color Option */
	wp.customize( 'napoli_theme_options[widget_title_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.widget-title, .page-header .archive-title, .comments-header, .comment-reply-title, .related-posts-title' )
				.not( $('.footer-widgets .widget .widget-title') )
				.css( 'background', newval );

			var textcolor, hovercolor;

			if( isColorLight( newval ) ) {
				textcolor = '#111111';
				hovercolor = 'rgba(0,0,0,0.5)';
			} else {
				textcolor = '#ffffff';
				hovercolor = 'rgba(255,255,255,0.5)';
			}

			$( '.widget-title, .widget-title a, .page-header .archive-title, .comments-header .comments-title, .comment-reply-title, .related-posts-title' )
				.css( 'color', textcolor );
			$( '.widget-title a, .comment-reply-title' )
				.hover( function() { $( this ).css( 'color', hovercolor ); },
						function() { $( this ).css( 'color', textcolor ); }
				);
		} );
	} );

	/* Footer Color Option */
	wp.customize( 'napoli_theme_options[footer_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.footer-wrap, .footer-widgets-background' )
				.css( 'background', newval );

			var textcolor, hovercolor;

			if( isColorLight( newval ) ) {
				textcolor = '#111111';
				hovercolor = 'rgba(0,0,0,0.5)';
				bordercolor = 'rgba(0,0,0,0.1)';
			} else {
				textcolor = '#ffffff';
				hovercolor = '#cccccc';
				bordercolor = 'rgba(255,255,255,0.1)';
			}

			$( '.site-footer, .site-footer .site-info a, .footer-navigation-menu a, .footer-widgets .widget, .footer-widgets .widget-title, .footer-widgets .widget a' )
				.css( 'color', textcolor );
			$( '.footer-widgets-background, .footer-widgets .widget, .footer-widgets .widget-title' )
				.css( 'border-color', bordercolor );
			$( '.site-footer .site-info a, .footer-navigation-menu a, .footer-widgets .widget a' )
				.hover( function() { $( this ).css( 'color', hovercolor ); },
						function() { $( this ).css( 'color', textcolor ); }
				);
		} );
	} );

	/* Theme Fonts */
	wp.customize( 'napoli_theme_options[text_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='napoli-pro-custom-text-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#napoli-pro-custom-text-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#napoli-pro-custom-text-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set Font.
			var systemFont = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
			var newFont = newval === 'SystemFontStack' ? systemFont : newval;

			// Set CSS.
			$( 'body, button, input, select, textarea' )
				.css( 'font-family', newFont );

		} );
	} );

	wp.customize( 'napoli_theme_options[title_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='napoli-pro-custom-title-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#napoli-pro-custom-title-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#napoli-pro-custom-title-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set Font.
			var systemFont = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
			var newFont = newval === 'SystemFontStack' ? systemFont : newval;

			// Set CSS.
			$( '.site-title, .page-title, .entry-title' )
				.css( 'font-family', newFont );

		} );
	} );

	wp.customize( 'napoli_theme_options[navi_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='napoli-pro-custom-navi-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#napoli-pro-custom-navi-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#napoli-pro-custom-navi-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set Font.
			var systemFont = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
			var newFont = newval === 'SystemFontStack' ? systemFont : newval;

			// Set CSS.
			$( '.widget-title, .page-header .archive-title, .comments-header .comments-title, .comment-reply-title, .related-posts-title, .main-navigation ul, .primary-menu-toggle, .footer-navigation-menu a' )
				.css( 'font-family', newFont );

		} );
	} );

	function hideElement( element ) {
		$( element ).css({
			clip: 'rect(1px, 1px, 1px, 1px)',
			position: 'absolute',
			width: '1px',
			height: '1px',
			overflow: 'hidden'
		});
	}

	function showElement( element ) {
		$( element ).css({
			clip: 'auto',
			position: 'relative',
			width: 'auto',
			height: 'auto',
			overflow: 'visible'
		});
	}

	function hexdec( hexString ) {
		hexString = ( hexString + '' ).replace( /[^a-f0-9]/gi, '' );
		return parseInt( hexString, 16 );
	}

	function getColorBrightness( hexColor ) {

		// Remove # string.
		hexColor = hexColor.replace( '#', '' );

		// Convert into RGB.
		var r = hexdec( hexColor.substring( 0, 2 ) );
		var g = hexdec( hexColor.substring( 2, 4 ) );
		var b = hexdec( hexColor.substring( 4, 6 ) );

		return ( ( ( r * 299 ) + ( g * 587 ) + ( b * 114 ) ) / 1000 );
	}

	function isColorLight( hexColor ) {
		return ( getColorBrightness( hexColor ) > 130 );
	}

	function isColorDark( hexColor ) {
		return ( getColorBrightness( hexColor ) <= 130 );
	}

} )( jQuery );
