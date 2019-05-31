jQuery(function($) {	
	$('.mbpl-link').click(function(e){		
		//console.log(mbplAjax);
		var post_id = $(this).attr("data-mbpl-id");		
		var action = $(this).attr("data-mbpl-action");
		$.ajax({
			type:'POST',
			url: mbplAjax.ajaxurl,
			data: {
				test: 'TEST AJAX SEND',
				nonce: mbplAjax.nonce,
				action: 'mbpl_ajax_'+action,
				postId: post_id,				
			},
			beforeSend: function(){
				console.log(action);
				console.log(post_id);
				$('[data-mbpl-id="'+post_id+'"]').fadeOut(200, function(){				
					$(this).parent().find('.mbpl-hidden').fadeIn();					
				});
				//console.log(this);
			},
			success: function(response){
				//console.log(response);				
				$('[data-mbpl-id="'+post_id+'"]').parent().find('.mbpl-hidden').fadeOut(200, function(){
				 	$(this).fadeIn().html(response);
				})
				//console.log(post_id);
			},
			error: function(){
				alert('ERROR AJAX');
			}
		});
		e.preventDefault();
	});
});

	


