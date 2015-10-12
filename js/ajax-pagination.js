(function($) {

	function get_adjacent_page_number( element ) {
		return element.parent('li').attr('data-page-number');
	}

	function get_next_page_id( element ) {
		return element.attr('data-id');
	}

	$(document).on( 'click', '#top-nav a', function( event ) {
		event.preventDefault();
	});

	$(document).on( 'click', '.page-next a', function( event ) {
		event.preventDefault();
		
		pageID = get_next_page_id( $(this) );

		// Get the next...
		$.ajax({
			url: ajaxpagination.ajaxurl,
			type: 'post',
			data: {
				action: 'ajax_pagination',
				query_vars: ajaxpagination.query_vars,
				id: pageID
			},
			success: function( data ) {
				console.log(data);
				var obj = JSON.parse(data);
				console.log(obj);
				$('#content').find( 'article:last' ).after( obj.html );
				$('html, body').animate({
					scrollTop: $("#post-" + pageID).offset().top
				}, 1000);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				console.log( XMLHttpRequest );
				console.log( textStatus );
				console.log( errorThrown );
			}
		});

	});

})(jQuery);