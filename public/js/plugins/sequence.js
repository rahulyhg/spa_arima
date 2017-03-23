// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var Sequence = {
		init: function ( options, elem ) {
			var self = this;

			self.$elem = $(elem);

			var item, is_run = false;
			Event.setPlugin( self.$elem, 'sortable', {
				onChange: function(){
					// self.top5Sort();
				}
			} );

			/*var $item;
			self.$elem.find('li').on("mousedown", function(e) {
				$item = $(this).clone();
			});*/

			/*self.$elem.on('dragenter', function(){
		        $(this).preventDefault();
		    });*/

			self.$elem.find('li').on("click", function(e) {
				e.preventDefault();  
				e.stopPropagation();

				// console.log( 'click' );
				// $(this).addClass('dragging');
			});

			self.$elem.find('li').on("dragover", function(e) {
				e.preventDefault();  
				e.stopPropagation();

				$(this).addClass('dragging');
			});

			self.$elem.find('li').on("dragleave", function(e) {
				e.preventDefault();  
				e.stopPropagation();

				console.log( 'dragging' );
				$(this).removeClass('dragging');
			});

			self.$elem.find('li').on("drop", function(e) {
				e.preventDefault();  
				e.stopPropagation();
				
				$(this).removeClass('dragging');

			});
		}
	}

	$.fn.sequence = function( options ) {
		return this.each(function() {
			var $this = Object.create( Sequence );
			$this.init( options, this );
			$.data( this, 'sequence', $this );
		});
	};
	
})( jQuery, window, document );