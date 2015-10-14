(function($) {

	function get_adjacent_page_number( element ) {
		return element.parent('li').attr('data-page-number');
	}

	$(document).on( 'click', '.ajax-nav a', function( event ) {
		event.preventDefault();
		var curArticle = $('article'),
			nextPageUrl = $(this).attr('href');

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