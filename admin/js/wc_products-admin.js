(function( $ ) {
	'use strict';

	$(window).load(function(){
		
		$("#wc_products_diffbot").click(function(data) {
			
			// clear any previous status alert
			wc_updateStatus('clear');
			
			// disable Diffbot button
			wc_diffbotButtonDisable(true);
			
			// get the input we need to consume the Diffbot API
			var productUrl 	= $('#wc_products_pageUrl_input').val();
			var token 		= encodeURIComponent($('#wc_products_token').val());
			
			var request = $.ajax({
				url: "http://api.diffbot.com/v3/product",
				method: "GET",
				data: {
					token: token,
					url: productUrl
				},
				dataType: "json",
				contentType: "text/plain"
			})
			.done(function(data){
				if(data.hasOwnProperty('objects') && data.objects[0].resolvedPageUrl != 'http://www.diffbot.com/'){
					
					// making an assumption here and only grabing the first product object returned
					wc_displayProductInfo(data.objects[0]);
				} else {
					wc_updateStatus(data.errorCode, data.error);
				}
			})
			.fail(function(){
				wc_updateStatus('fail');
			})
			.always(function(){
				wc_diffbotButtonDisable(false);
			});
			
		});
		
	});
	
	/**
	 *  Handles the Diffbot button toggle so users can't keep clicking it ad nauseum  
	 */
	function wc_diffbotButtonDisable(val){
		if(val){
			$( '#wc_products_api_results .spinner' ).addClass( 'is-active' );
			$( '#wc_products_diffbot' ).prop('disabled', true);
		} else{
			$( '#wc_products_api_results .spinner' ).removeClass( 'is-active' );
			$( '#wc_products_diffbot' ).prop('disabled', false);
		}
	}
	
	/**
	 * Update the inputs with the values from Diffbot
	 */
	function wc_displayProductInfo(obj){
		
		wc_updateStatus('success');
		
		// remove the WP placeholder text & update the Product Title 
		$("form #title-prompt-text").addClass('screen-reader-text');
		$("form #title").val(obj.title);
		
		// These may not be returned in response object so we need to do some basic checking
		tinymce.activeEditor.setContent( (!obj.hasOwnProperty('text')) ? "" : obj.text );
		$("#wc_products_regularPrice_input").val( (!obj.hasOwnProperty('regularPrice')) ? "" : obj.regularPrice );
		
		// These will always be returned
		$("#wc_products_pageUrl_input").val(obj.pageUrl);
		$("#wc_products_offerPrice_input").val(obj.offerPrice);
		
	}
	
	/**
	 * Updates a small div with the status from the Diffbot API results
	 */
	function wc_updateStatus(status, error){
		
		var text = '';
		var style = '';
		
		switch(status){
			case 'retrieving':
				text = 'Please wait while we retrieve the product information';
				style = 'primary';
				break;
			case 'success':
				text = 'Diffbot was successful! <br>Please make certain the product information is correct, then be sure to save the product. ';
				style = 'updated';
				break;
			case 'fail':
				text = 'Unable to connect to Diffbot.';
				style = 'error';
				break;
			case 404:
			case 405:
			case 457:
			case 500:
				text = error;
				style = 'error';
				break;
			case 'clear':
				text = '';
				style = '';
				break;
			default:
				text = 'Uncaught Error';
				style = 'error';
		}
		
		if(text == '')
			$('#wc_products_api_status').html('');
		else 
			$('#wc_products_api_status').html('<div class="'+ style +' notice"><p>'+text+'</p></div>');
			
	}
	

	
	
})( jQuery );