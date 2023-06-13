/**
 * File wp10.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function() {

	// Acf js hook version
	if ( typeof acf !== 'undefined' ) {
        console.log( 'ACF is defined', acf );

		acf.add_filter('select2_ajax_data', function( data, args, $input, field, instance ){

			if(args.field.data.name === 'writer') {
				//const el = acf.getField('key only');
				const el = acf.getFields({
					name: 'publish_company'
					//type: 'post_object'
				});

				data.company_id = el[0].val();
				console.log( args );
			}

			return data;

		});
	}

	// Cookie Version
	// const elem = document.querySelector('[data-name="publish_company"] select')

	// elem.onchange = function(){
	// 	//console.log(this.value)
	// 	document.cookie = 'company_id=' + this.value
	// }


	// wp.customize.bind( 'ready', function() {

	// 	// Only show the color hue control when there's a custom primary color.
	// 	wp.customize( 'primary_color', function( setting ) {
	// 		wp.customize.control( 'primary_color_hue', function( control ) {
	// 			var visibility = function() {
	// 				if ( 'custom' === setting.get() ) {
	// 					control.container.slideDown( 180 );
	// 				} else {
	// 					control.container.slideUp( 180 );
	// 				}
	// 			};

	// 			visibility();
	// 			setting.bind( visibility );
	// 		});
	// 	});
	// });

})();
