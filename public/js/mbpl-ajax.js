jQuery(function($) {

	//console.log('MBPL_AJAX');
	$('.mbpl-link').click(function(e){		
		//console.log(mbplAjax.postId);
		$.ajax({
			type:'POST',
			url: mbplAjax.ajaxurl,
			data: {
				test: 'TEST AJAX SEND',
				nonce: mbplAjax.nonce,
				action: 'mbpl_ajax_link',
				postId: mbplAjax.postId
			},
			beforeSend: function(){
				$('.mbpl-link').fadeOut(200, function(){
					$('.mbpl-hidden').fadeIn();
				});
			},
			success: function(response){
				console.log(response);
				$('.mbpl-hidden').fadeOut(200, function(){
					$('.mbpl-link').fadeIn().html(response);
				});
			},
			error: function(){
				alert('ERROR AJAX');
			}
		});

		e.preventDefault();
	});

});

	


