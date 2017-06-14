// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var OrderLists = {
		init: function(options, elem) {
			var self = this;
			self.$elem = $(elem);
			self.options = options;

			console.log( self.options );

			self.setElem();
			self.resize();
		},

		setElem: function () {
			var self = this;

			$.each( self.$elem.find('[role]'), function () {
				self[ '$'+ $(this).attr('role') ] = $(this);
			});
		},

		resize: function () {
			var self = this;

			self.$tbody.children().css({
				paddingTop: self.$thead.height(),
				paddingBottom: self.$tfoot.height(),
			}); //

			var marginRight = self.$tfoot.children().width() - self.$tbody.children().width();
			self.$thead.children().css({
				marginRight: marginRight,
				// paddingBottom: 
			});

			self.$tfoot.children().css({
				marginRight: marginRight,
				// paddingBottom: 
			});

			var firstTD = self.$tbody.find('table tr:first>td');
			$.each(firstTD, function (i, obj) {
				var $td = $(obj);

				// var width = $this.outerWidth();
				var $th = self.$thead.find('[data-col='+ i +']');
				var $tf = self.$tfoot.find('[data-col='+ i +']');

				$td.attr('data-col', i);
				if( $td.hasClass('name') ) return;

				var outerW = $td.outerWidth()
				var width = $td.width();

				if( $th.width() > width){
					outerW = $th.outerWidth();
					width = $th.width();
				}
			
				
				$td.width( outerW );
				$th.width( outerW );
				$tf.width( outerW );

			});

			var wT = 0;
			wT += self.$tbody.find('table tr:first>td.amount').outerWidth();
			wT += self.$tbody.find('table tr:first>td.pay').outerWidth();


			self.$thead.find('.amount').width( wT - 5 );
			self.$tfoot.find('.amount').width( wT - 5 );


			self.$tfoot.find('[data-col=4]').width( (self.$tbody.find('table tr:first>td[data-col=3]').outerWidth()+self.$tbody.find('table tr:first>td[data-col=4]').outerWidth())-4 );

			self.$tfoot.find('[data-col=6]').width( (self.$tbody.find('table tr:first>td[data-col=5]').outerWidth()+self.$tbody.find('table tr:first>td[data-col=6]').outerWidth())-4 );

			self.$tfoot.find('[data-col=8]').width( (self.$tbody.find('table tr:first>td[data-col=7]').outerWidth()+self.$tbody.find('table tr:first>td[data-col=8]').outerWidth())-4 );

			self.$tfoot.find('[data-col=10]').width( (self.$tbody.find('table tr:first>td[data-col=9]').outerWidth()+self.$tbody.find('table tr:first>td[data-col=10]').outerWidth())-4 );

			self.$tfoot.find('[data-col=12]').width( (self.$tbody.find('table tr:first>td[data-col=11]').outerWidth()+self.$tbody.find('table tr:first>td[data-col=12]').outerWidth())-4 );

			self.$tfoot.find('[data-col=14]').width( (self.$tbody.find('table tr:first>td[data-col=13]').outerWidth()+self.$tbody.find('table tr:first>td[data-col=14]').outerWidth()) -4 );

			self.$tfoot.find('[data-col=16]').width( (self.$tbody.find('table tr:first>td[data-col=15]').outerWidth()+self.$tbody.find('table tr:first>td[data-col=16]').outerWidth())-4 );

			self.$tfoot.find('[data-col=18]').width( (self.$tbody.find('table tr:first>td[data-col=17]').outerWidth()+self.$tbody.find('table tr:first>td[data-col=18]').outerWidth()) - 4 );

			// self.$tfoot.find('[data-col=4], [data-col=6], [data-col=8], [data-col=10], [data-col=12], [data-col=14], [data-col=16], [data-col=18]').width( 78 );
			
		}

		
	};

	$.fn.orderlists = function( options ) {
		return this.each(function() {
			var $this = Object.create( OrderLists );
			$this.init( options, this );
			$.data( this, 'orderlists', $this );
		});
	};

	$.fn.orderlists.options = {
		onOpen: function() {},
		onClose: function() {}
	};
	
})( jQuery, window, document );