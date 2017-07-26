// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var SummaryOfDaily = {
		init: function(options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.summaryOfDaily.options, options );

			self.url = Event.URL + 'reports/SummaryOfDaily/';

			self.$elem.find('[plugin=datepicker]').datepicker({
				onComplete: function ( res ) {
					self.refresh( res );
				},
				onChange: function ( res) {
					self.refresh( res );
				}
			});

		},

		refresh: function ( date ) {
			var self = this;

			self.dataPost = {date: PHP.dateJStoPHP(date)}
			setTimeout(function () {

				self.fetch().done(function ( data ) {
					self.buildFrag( data );
					self.display();
				});

			}, 1);
			

		},
		fetch: function () {
			var self = this;

			return $.ajax({
				url: self.url,
				data: self.dataPost,
				dataType: 'json'
			}).fail(function() {
				
			}).always(function() {
							
			});
		},
		buildFrag: function( results ) {
			var self = this;
			self.total = 0;
			var sequence = 0;
			self.$items = $.map(results, function ( obj ) {
				sequence++;
				$tr = $('<tr>', {class: 'price'});

				var amount = parseInt( obj.amount ) || 0;

				self.total += amount;

				return $tr.append( 
					  $('<td>', {class: 'ID'}).text( sequence + '. ' )
					, $('<td>', {class: 'name'}).text( obj.name )
					, $('<td>', {class: 'price'}).text( amount==0? '-': PHP.number_format( obj.amount ) )
				)
			});
		},

		display: function () {
			var self = this;

			self.$elem.find('[data-ref=listbox]').html( self.$items );
			self.$elem.find('[data-ref=total]').text( self.total==0? '-':PHP.number_format( self.total ) );
		}
	};

	$.fn.summaryOfDaily = function( options ) {
		return this.each(function() {
			var $this = Object.create( SummaryOfDaily );
			$this.init( options, this );
			$.data( this, 'summaryOfDaily', $this );
		});
	};

	$.fn.summaryOfDaily.options = {
		date: new Date()
	};
	
})( jQuery, window, document );