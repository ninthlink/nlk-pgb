/**
 * Ninthlink child Theme Custom JS
 *
 */

var slidePanel;

(function($){

	var slide;
	slide = slidePanel = {
		triggers   : undefined, // slidepanel triggers
		containers : undefined, // slidepanel containers
		init : function() {
			slide.triggers   = $('a[data-action="slidepanel"]');
			slide.containers = $('div.slidepanel');
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
			slide.containers.not( c ).removeClass('open');
			slide.triggers.not( t ).each(function(){
				var origText = $(this).attr('data-text');
				$(this).removeClass('open').find(".menu-text").text( origText );
			});
			if ( c.hasClass('open') ) {
				b.removeClass('slide-open');
				t.removeClass('open').find(".menu-text").text( t.attr('data-text') );
				c.removeClass('open');
			} else {
				b.addClass('slide-open');
				t.addClass('open').find(".menu-text").text("close");
				c.addClass('open');
			}
		}
	}
	$(function(){ slidePanel.init(); });


})(jQuery);