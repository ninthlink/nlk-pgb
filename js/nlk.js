/**
 * Ninthlink child Theme Custom JS
 *
 */

var slidePanel;

(function($){

	var slide;
	slide = slidePanel = {
		triggers   : undefined, // slidepanel triggers
		//containers : undefined, // slidepanel containers
		init : function() {
			slide.triggers   = $('a[data-action="slide"]');
			//slide.containers = $('div.slidepanel');
			slide.clickListener();
		},
		clickListener : function() {
			slide.triggers.each(function( i, el ){
				var t = $( el );
				var c = $( t.attr('data-target') );
				var b = $('body');
				t.bind('click', function( e ){
					e.preventDefault();
					slide.toggleslidepanel( t, c, b );
				});
			});
		},
		toggleslidepanel : function( t, c, b ) {
			c.toggleClass('slide');
		}
	}
	$(function(){ slidePanel.init(); });


})(jQuery);