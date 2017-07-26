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
			$(window).resize(function() {
				self.resize();
			});
		},

		setElem: function () {
			var self = this;

			$.each( self.$elem.find('[role]'), function () {
				self[ '$'+ $(this).attr('role') ] = $(this);
			});
		},

		resize: function () {
			var self = this;

			console.log( $(window).height() );
			self.$elem.find('.table-model-2-warp').css({
				minHeight: $(window).height()-(68+10+$('.actions-wrap').height())
			});

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


			$.each(self.$tfoot.find('[data-col]'), function(index, el) {

				var col = parseInt($(this).data('col'));
				var width = self.$thead.find('[data-col='+ col +']').outerWidth();

				if( col < 20 ){
					width += self.$thead.find('[data-col='+ (col-1) +']').outerWidth()-5;
					$(this).width( width );
				}
				
			});
				
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