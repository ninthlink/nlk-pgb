(function($) {

	$(document).on( 'click', 'a[data-page="ajax"]', function( event ) {
		event.preventDefault();
		var curArticle = $('article'),
			nextPageUrl = $(this).attr('href'),
			nextPageId = $(this).attr('data-target-page-id'),
			nextMenuId = $(this).attr('data-menu-id');

		// Get the next...
		$.ajax({
			url: ajaxpagination.ajaxurl,
			type: 'post',
			data: {
				action: 'ajax_pagination',
				query_vars: ajaxpagination.query_vars,
				url: nextPageUrl
			},
			success: function( data ) {
				//console.log(data);
				var obj = JSON.parse(data);
				// Write the new page content to the DOM
				$('#content').find( 'article:last' ).after( obj.html );
				// Update menu current classes
				$('.ajax-nav .current-menu-item').each(function(){
					$(this).removeClass('current-menu-item current_page_item');
				});
				$('.ajax-nav .menu-item-' + nextMenuId).addClass('current-menu-item current_page_item');
				// If the Slide Menu is open, close it
				if ( $('#menu-slidepanel').hasClass('slide') ) {
					$('#menu-slidepanel').toggleClass('slide');
				}
				// Slide up the previous content then remove it from the DOM
				curArticle.slideUp( 350, function(){
					$(this).remove();
				});
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				console.log( XMLHttpRequest );
				console.log( textStatus );
				console.log( errorThrown );
			}
		});

	});

})(jQuery);