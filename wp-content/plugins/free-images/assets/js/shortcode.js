(function($) {

	FreeImages = {

		_ref: null,

		init: function()
		{
			this._masonaryInit();
			this._resetPagedCount();
			this._bind();
			this._loadImages();
		},

		/**
		 * Bind
		 */
		_bind: function()
		{
			$( window ).on('resize', 		FreeImages._masonaryInit );

			// Download image.
			$( document ).on('click', '#free-images .download', 		FreeImages._download );
			$( document ).on('click', '.mfp-title .download', 				FreeImages._download );
			$( document ).on('click', '.download-size', 				FreeImages._download );

			// Filter click, select or search image.
			$( document ).on('keyup input', '#search-image', 						FreeImages._search );
			$( document ).on('click', '#safesearch-input', 					FreeImages._loadImages );
			$( document ).on('click', '.filter-links a', 					FreeImages._filter_links );
			$( document ).on('change', '.filter-categories', 				FreeImages._filter_change );

			// Next/previous.
			$( document ).on('click', '.page-navigation .previous-page', 	FreeImages._previous_page );
			$( document ).on('click', '.page-navigation .next-page', 		FreeImages._next_page );
			$( document ).on('click', '.select-color-label, .selected-color', 		FreeImages._toggleColorFilters );
			$( document ).on('click', '.filter-color-name', 		FreeImages._setColorFilter );
		},

		_toggleColorFilters: function() {
			$('.filter-colors-wrap').slideToggle();
		},

		_setColorFilter: function() {
			var color_name = $( this ).attr( 'data-color-name' ) || '';
			$('.selected-color').attr( 'data-color-name', color_name ).removeClass().addClass( 'selected-color filter-color-' + color_name );
			$('.filter-colors-wrap').slideUp();
			FreeImages._loadImages();
		},

		/**
		 * Get API Params
		 * 
		 * @return object Params Object.
		 */
		_get_api_params: function()
		{
			var selectedColor = $('.selected-color').attr('data-color-name') || '';

			return {
				key        	   : '2364315-d08f2d5ef737190f955ae5c11',

				q              : $( '#search-image' ).val() || '', // str    A URL encoded search term. If omitted, all images are returned. This value may not exceed 100 characters. 
									 // Example: "yellow+flower"

				lang           : 'en', // str    Language code of the language to be searched in. 
									 // Accepted values: cs, da, de, en, es, fr, id, it, hu, nl, no, pl, pt, ro, sk, fi, sv, tr, vi, th, bg, ru, el, ja, ko, zh 
									 // Default: "en"

				image_type     : 'all', // str    Filter results by image type. 
									 // Accepted values: "all", "photo", "illustration", "vector" 
									 // Default: "all"

				orientation    : 'all', // str    Whether an image is wider than it is tall, or taller than it is wide. 
									 // Accepted values: "all", "horizontal", "vertical" 
									 // Default: "all"

				category       : $('.filter-categories option:selected').val() || '', // str    Filter results by category. 
									 // Accepted values: fashion, nature, backgrounds, science, education, people, feelings, religion, health, places, animals, industry, food, computer, sports, transportation, travel, buildings, business, music

				min_width      : 0, // int    Minimum image width. 
									 // Default: "0"

				min_height     : 0, // int    Minimum image height. 
									 // Default: "0"

				colors         : selectedColor, // str    Filter images by color properties. A comma separated list of values may be used to select multiple properties. 
									 // Accepted values: "grayscale", "transparent", "red", "orange", "yellow", "green", "turquoise", "blue", "lilac", "pink", "white", "gray", "black", "brown"

				editors_choice : false, // bool   Select images that have received an Editor's Choice award. 
									 // Accepted values: "true", "false" 
									 // Default: "false"

				safesearch     : $('#safesearch-input:checked').length ? true : false, // bool   A flag indicating that only images suitable for all ages should be returned. 
									 // Accepted values: "true", "false" 
									 // Default: "false"

				order          : $('.filter-links .current').data('slug') || 'popular', // str    How the results should be ordered. 
									 // Accepted values: "popular", "latest", (NEW) "ec"
									 // Default: "popular"

				page           : $('body').attr('data-page'), // int    Returned search results are paginated. Use this parameter to select the page number. 
									 // Default: 1

				per_page       : 30, // int    Determine the number of results per page. 
									 // Accepted values: 3 - 200 
									 // Default: 20

				callback       : '', // string JSONP callback function name

				pretty         : false, // bool   Indent JSON output. This option should not be used in production. 
									 // Accepted values: "true", "false" 
									 // Default: "false"
			};
		},

		/**
		 * Load Images
		 * 
		 * @return object Params Object.
		 */
		_loadImages: function()
		{
			$('#free-images').html( '<div class="loader"></div>' );

			var URL = 'https://pixabay.com/api/?' + $.param( FreeImages._get_api_params() );

			$.ajax({
				dataType : 'json',
				url      : URL
			})
			.done(function( data, status, XHR ) {

            	$('.page-navigation').html( '' );
            	$('#free-images').html( '' );
            	$('.found-images').remove();
            	$('.images-count').html( 0 );

                if ( parseInt( data.totalHits ) > 0 ) {

                	// Total found images count.
                	$('.images-count').html( data.total );
                	$('.page-navigation').html( wp.template( 'free-images-page-navigation' )( { total : data.total, page : $('body').attr('data-page') } ) );

                	$.each( data.hits, function(i, hit){
                    	$('#free-images').append( wp.template( 'free-images-list' )( hit ) );
                    });

                    $('#free-images').imagesLoaded()
                    .always( function( instance ) {
                    	var masonryObj = new Masonry( document.getElementById('free-images'), {
	                        itemSelector: '.image'
	                    });

                    	FreeImages._initLightbox();
        			})
					.progress( function( instance, image ) {
						var result = image.isLoaded ? 'loaded' : 'broken';
					});

					// Debugging Info.
					if( FreeImages._getParamFromURL( 'debug' ) ) {	
						$( '.debug-info').remove();
						var template = wp.template('free-images-debug-info');
						var debug_info = {
							total     : data.total,
							limit     : XHR.getResponseHeader('X-RateLimit-Limit') || '',
							reset     : XHR.getResponseHeader('X-RateLimit-Remaining') || '',
							remaining : XHR.getResponseHeader('X-RateLimit-Reset') || '',
						};
						$( '.wrap.free-images').append( template( debug_info ) );
					}

					var template = wp.template( 'free-images-found-images' );
					var search_term = $( '#search-image' ).val() || '';
					if( search_term ) {
						$('.wp-header').append( template( { search_term : search_term, total : data.total }) );
					}

                    FreeImages._initLightbox();
                }
            });
		},

		/**
		 * Init Lightbox
		 */
		_initLightbox: function()
		{
			$('#free-images').magnificPopup({
				delegate: '.lightbox',
				type: 'image',
				tLoading: 'Loading image #%curr%...',
				mainClass: 'free-images-lightbox mfp-img-mobile',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0,1], // Will preload 0 - before current, and 1 after the current image
					arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>', // markup of an arrow button
				},
				image: {
					tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
					titleSrc: function(item) {
						var preview_url = item.el.attr('data-preview-url') || '';

						var image_640_url      = preview_url.replace('_150.', '_640.'); // 'https://cdn.pixabay.com/photo/2019/09/13/14/31/elephant-4474027_640.jpg';
						var image_1280_url     = preview_url.replace('_150.', '_1280.'); // 'https://cdn.pixabay.com/photo/2019/09/13/14/31/elephant-4474027_1280.jpg';
						var image_1920_url     = preview_url.replace('_150.', '_1920.'); // 'https://cdn.pixabay.com/photo/2019/09/13/14/31/elephant-4474027_1920.jpg';
						var image_original_url = preview_url.replace('_150.', '.'); // 'https://cdn.pixabay.com/photo/2019/09/13/14/31/elephant-4474027.jpg';
						
						var markup = '';
						markup += '<div class="free-images-sizes">';
						markup += '    <h3>Other Image Sizes</h3>';
						markup += '    <ul>';
						markup += '		<li>';
						markup += '			<span>';
						markup += '				<span class="size">640xauto</span><span data-user-name="'+item.el.attr('data-user-name')+'" data-user-url="'+item.el.attr('data-user-url')+'" data-page-url="'+item.el.attr('data-page-url')+'" data-url="'+image_640_url+'" class="download-size">Download</span>';
						markup += '			</span>';
						markup += '		</li>';
						markup += '		<li>';
						markup += '			<span>';
						markup += '				<span class="size">1280xauto</span><span data-user-name="'+item.el.attr('data-user-name')+'" data-user-url="'+item.el.attr('data-user-url')+'" data-page-url="'+item.el.attr('data-page-url')+'" data-url="'+image_1280_url+'" class="download-size">Download</span>';
						markup += '			</span>';
						markup += '		</li>';
						// To get more HD images pixabay have the premium plan.
						// We need to contact them. We'll add this feature in future.
						// markup += '		<li>';
						// markup += '			<span>';
						// markup += '				<span class="size" data-url="'+image_1920_url+'" data-size="1920">1920xauto</span><span class="download-size">Download</span>';
						// markup += '			</span>';
						// markup += '		</li>';
						// markup += '		<li>';
						// markup += '			<span>';
						// markup += '				<span class="size" data-url="'+image_original_url+'" data-size="original">Original</span><span class="download-size">Download</span>';
						// markup += '			</span>';
						// markup += '		</li>';
						markup += '	</ul>';
						markup += '</div>';

						return markup + '<img style="width: 20px;" data-id="'+item.el.attr('data-id')+'" src="'+item.el.attr('data-user-image')+'" />' + '<small>by '+item.el.attr('data-user')+'</small><div data-url="'+item.el.attr('data-url')+'" class="download" data-user-name="'+item.el.attr('data-user-name')+'" data-user-url="'+item.el.attr('data-user-url')+'" data-page-url="'+item.el.attr('data-page-url')+'">Download</div>';
					}
				}
			});
		},

		/**
		 * Previous page
		 */
		_previous_page: function( event ) {
			var page = parseInt( $('body').attr('data-page' ) ) || 0;
			$('body').attr('data-page', (page-1) );
	        FreeImages._loadImages();
		},

		/**
		 * Next page
		 */
		_next_page: function( event ) {
			var page = parseInt( $('body').attr('data-page' ) ) || 0;
			$('body').attr('data-page', (page+1) );
	        FreeImages._loadImages();
		},

		/**
		 * Search
		 */
		_search: function( event ) {

			window.clearTimeout(FreeImages._ref);
			FreeImages._ref = window.setTimeout(function () {
				FreeImages._ref = null;

				FreeImages._loadImages();

			}, 500);
		},

		/**
		 * Filter Change
		 */
		_filter_change: function( event ) {
        	FreeImages._loadImages();
        },

        /**
		 * Filter Links
		 */
		_filter_links: function( event ) {
			$('.filter-links a').removeClass('current');
			$(this).addClass('current');
        	FreeImages._loadImages();
        },

        /**
         * Download
         */
		_download: function() {

            var button = $(this);
            var url = button.data('url');
            var user_name = button.data('user-name') || '';
            var user_url = button.data('user-url') || '';
            var page_url = button.data('page-url') || '';

            button.parents('.image').addClass('downloading');
            button.text('Downloading..');
            $.ajax({
                url: freeImages.ajaxurl,
                type: 'POST',
                data: {
                    action  : 'free_image_download',
                    url     : url,
                    user_name: user_name,
					user_url : user_url,
					page_url : page_url,
                },
            })
            .done(function( data ) {

            	if( data.success ) {
                	button.text('Downloaded Successfully..');
            	} else {
                	button.text( data.data.error );
            	}
            })
            .fail(function( message ) {
                button.text( message );
            })
            .always(function() {
            });

        },

        /**
		 * Init Masonry.
		 * 
		 * @see  /wp-includes/js/jquery/jquery.masonry.min.js (Source http://masonry.desandro.com).
		 */
		_masonaryInit: function()
		{
			$('#free-images').masonry({
                horizontalOrder : true,
                percentPosition: true,
            });
		},

		/**
		 * Reset Page Count.
		 */
		_resetPagedCount: function() {
			$('body').attr('data-page', 1);
		},

		/**
		 * Get URL param.
		 */
		_getParamFromURL: function(name, url)
		{
		    if (!url) url = window.location.href;
		    name = name.replace(/[\[\]]/g, "\\$&");
		    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
		        results = regex.exec(url);
		    if (!results) return null;
		    if (!results[2]) return '';
		    return decodeURIComponent(results[2].replace(/\+/g, " "));
		},

	};

	/**
	 * Initialize FreeImages
	 */
	$(function(){
		FreeImages.init();
	});

})(jQuery);