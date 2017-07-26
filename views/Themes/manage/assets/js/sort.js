// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var sort = {
		init: function(options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.sort.options, options );

			self.$elem.sortable({
				start: function(event, ui) {
		            /*var start_pos = ui.item.index();
		            ui.item.data('start_pos', start_pos);*/

		            console.log('start');
		        },
		        change: function(event, ui) {
		            /*var start_pos = ui.item.data('start_pos');
		            var index = ui.placeholder.index();
		            if (start_pos < index) {
		                $('#sortable li:nth-child(' + index + ')').addClass('highlights');
		            } else {
		                $('#sortable li:eq(' + (index + 1) + ')').addClass('highlights');
		            }*/
		            console.log('changes');
		            
		        },
		        update: function(event, ui) {

		        	console.log('update');
		            // $('#sortable li').removeClass('highlights');
		        }
			});


			// self.$elem.disableSelection();
		},
	};

	$.fn.sort = function( options ) {
		return this.each(function() {
			var $this = Object.create( sort );
			$this.init( options, this );
			$.data( this, 'sort', $this );
		});
	};

	$.fn.sort.options = {
		
	};
	
})( jQuery, window, document );