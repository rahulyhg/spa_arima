// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var tableOrder = {
		init: function (options, elem) {
			var self = this;
			self.$elem = $(elem);
		},
	}
	$.fn.tableOrder = function( options ) {
		return this.each(function() {
			var $this = Object.create( tableOrder );
			$this.init( options, this );
			$.data( this, 'tableOrder', $this );
		});
	};
	$.fn.tableOrder.settings = {
		multiple: false,
	}
	
})( jQuery, window, document );