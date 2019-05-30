jQuery(function($) {

	//console.log('MBPL_AJAX');
	$('.mbpl-link').click(function(e){		
		//console.log(mbplAjax);
		var post_id = $(this).attr("data-mbpl-id");
		//console.log(post_id);
		$.ajax({
			type:'POST',
			url: mbplAjax.ajaxurl,
			data: {
				test: 'TEST AJAX SEND',
				nonce: mbplAjax.nonce,
				action: 'mbpl_ajax_link',
				postId: post_id,
				//needId: post_id
			},
			beforeSend: function(){
				
				$('[data-mbpl-id="'+post_id+'"]').fadeOut(200, function(){
				//console.log(post_id);	
				//$('.mbpl-link').fadeOut(200, function(){
					$(this).parent().find('.mbpl-hidden').fadeIn();
					//console.log($(this).find('.mbpl-hidden').fadeIn());
				});
				//console.log(this);
			},
			success: function(response){
				console.log(response);
				// $('.mbpl-hidden').fadeOut(200, function(){
				// 	$('.mbpl-link').fadeIn().html(response);
				// });
				$('[data-mbpl-id="'+post_id+'"]').parent().find('.mbpl-hidden').fadeOut(200, function(){
				 	$(this).fadeIn().html(response);
				})
				console.log(post_id);
			},
			error: function(){
				alert('ERROR AJAX');
			}
		});

		e.preventDefault();
	});

});

	


