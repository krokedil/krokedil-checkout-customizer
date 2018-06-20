(function ($) {
    'use strict';

	//jQuery("form.checkout").on("change", "input.qty", function(){
	$(document).on('change', "form.checkout input.qty",  function () {
		
		$.ajax({
			type: 'POST',
			url: kcc_params.update_cart_url,
			data: {
				checkout: $('form.checkout').serialize(),
				nonce: kcc_params.checkout_nonce
			},
			dataType: 'json',
			success: function(data) {
			},
			error: function(data) {
			},
			complete: function(data) {
				console.log( data );
				$('body').trigger('update_checkout');
			}
		});
	});
	
}(jQuery));