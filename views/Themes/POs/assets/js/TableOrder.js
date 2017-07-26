// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var TableOrder = {
		init: function(options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.TableOrder.options, options );

			self.settings = {};

			self.setElem();
			self.resize();
			$(window).resize(function() {
				self.resize();
			});

			var lastScrollLeft = 0;
			self.$elem.find('[data-table=overflowX],[data-table=body_middle]').scroll(function() {

				var left = $(this).scrollLeft()*-1;
				self.$elem.find('[data-table=body_middle] table, [data-table=head_middle] table, [data-table=foot_middle] table').css({
					left: left
				});

			});

			self.refresh();
			self.setPage();

			// Event
			self.$elem.find('[data-package]').click(function() {

				var index = $(this).closest('tr').index();
				var number = self.$elem.find('[data-table=body_left]').find('tr').eq( index ).data('number');

				if( $(this).hasClass('menu') ){

					self.chooseMenu({
						date: PHP.dateJStoPHP( theDate ),
						package: $(this).data('package'),
						index: index,
						number: number
					});
				}else if( $(this).data('package') == 'drink' ){
					self.drink({
						date: PHP.dateJStoPHP( theDate ),
						index: index,
						number: number
					});
				}
				
			});

			/*$('body').delegate('form.js-save-orderlist :input', 'keyup, keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) {
					
					self.saveOrderlist( $(this).closest('form') );

					e.preventDefault();
					return false;
				}
			});*/

			$('body').delegate('form.js-save-orderlist','submit',function(e){
				e.preventDefault();
				self.saveOrderlist( $(this) );
			});

		},
		saveOrderlist: function ( $form ) {
			var self = this;

			Event.inlineSubmit( $form ).done(function( result ) {

				result.url = '';
				Event.processForm($form, result);

				self.refresh( 300 );
			});
		},

		setElem: function () {
			var self = this;

		},

		resize: function () {
			var self = this;

			var paddingTop = self.$elem.find('.actions-wrap').outerHeight() + 30;
			self.$elem.find('[data-table=head_left], [data-table=head_middle], [data-table=head_right]').css({
				paddingTop: paddingTop,
			});

			paddingTop = self.$elem.find('[data-table=head_left]').outerHeight() - 20;
			self.$elem.find('[data-table=body_left], [data-table=body_middle], [data-table=body_right]').css({
				paddingTop: paddingTop,
			});

			var wLeft = self.$elem.find('[data-table=head_left]').outerWidth();
			self.$elem.find('[data-table=head_middle], [data-table=body_middle], [data-table=foot_middle], [data-table=overflowX]').css({
				left: wLeft + 20,
			});

			self.$elem.find('[data-table=foot_left] table').css({
				width: wLeft,
			});

			self.$elem.find('[data-table=body_right]').css({
				paddingBottom: self.$elem.find('[data-table=foot_left]').outerHeight(),
			});
			
			self.$elem.find('[data-table=head_right] th, [data-table=body_right] td').css({
				minWidth: $('[data-table=foot_right]').width() -2,
			});

			self.$elem.find('[data-table=head_middle], [data-table=foot_middle], [data-table=overflowX]').css({
				right: $('[data-table=foot_right]').outerWidth() + 30 
			});

			self.$elem.find('[data-table=body_middle]').css({
				right: $('[data-table=foot_right]').outerWidth() + 14
			});

			$.each(self.$elem.find('[data-table=body_middle] tr:first-child [data-col]'), function(index, el) {
				var col = $(this).data('col');

				var $h = self.$elem.find('[data-table=head_middle] [data-col='+ col +']');

				var w = $(this).outerWidth();

				if( $(this).hasClass('bl') ){
					w = w+2;
				}

				if( $h.width() > w ){
					w = $h.outerWidth();
				}

				$h.css({
					width: w,
					minWidth: w
				});

				$(this).css({
					width: w,
					minWidth: w
				});

				self.$elem.find('[data-table=overflowX] [data-col='+ col +']').css({
					width: w,
					minWidth: w
				});
				

				var $f = self.$elem.find('[data-table=foot_middle] [data-col='+ col +']');
				
				if( $f.length ==1 ){

					if( $f.hasClass('has_mas') ){
						w += self.$elem.find('[data-table=head_middle] [data-col='+ (col-1) +']').outerWidth();
					}

					$f.css({
						width: w,
						minWidth: w
					});
				}
				// body_middle 
			});

			// 
			var h = self.$elem.find('[data-table=body_middle] td:first-child').outerHeight();
			if( self.$elem.find('[data-table=body_right] td:first-child').outerHeight()>h){
				h = self.$elem.find('[data-table=body_right] td:first-child').outerHeight();
			}

			if( self.$elem.find('[data-table=body_left] td:first-child').outerHeight()>h){
				h = self.$elem.find('[data-table=body_left] td:first-child').outerHeight();
			}

			self.$elem.find('[data-table=body_right] td:first-child, [data-table=body_middle] td:first-child, [data-table=body_left] td:first-child').height(h);


			$.each(self.$elem.find('[data-table=head_left] [data-col]'), function () {
				var col = $(this).data('col');

				var $h = self.$elem.find('[data-table=body_left] tr:first-child td[data-col='+ col +']');
				var w = $(this).outerWidth();

				if( $h.width() > w ){
					w = $h.outerWidth();
				}

				$h.css({
					width: w,
					minWidth: w
				});

				$(this).css({
					width: w,
					minWidth: w
				});

			});
		},

		refresh: function () {
			var self = this;

			setTimeout(function () {

				self.fetch().done(function ( res ) {

					self.options = $.extend( {}, self.options, res.options );
					self.setPageBTN();

					self.buildFrag( res );
				});

			}, 1);

		},
		fetch: function () {
			var self = this;

			self.options.date = PHP.dateJStoPHP(theDate);

			return $.ajax({
				url: Event.URL + 'orders/lists/',
				data: self.options,
				dataType: 'json'
			}).fail(function() {
				
			}).always(function() {
							
			});
		},
		buildFrag: function ( results ) {
			var self = this;

			console.log( results );

			self.resetTable();

			var bodyLeftData = ['start_time'];
			$.each(results.lists, function(q, obj) {

				var box = self.$elem.find('[data-number='+ obj.number +']');
				var index = box.index();

				for (var i = bodyLeftData.length - 1; i >= 0; i--) {
					if( obj[ bodyLeftData[i] ] ){
						self.$elem.find('[data-table=body_left]').find('[data-key='+ bodyLeftData[i] +']').eq( index ).text( obj[ bodyLeftData[i] ] );
					}
				}

				$.each(obj.items, function(i, item) {

					self.$elem.find('[data-table=body_middle]').find('.menu[data-package='+item.pack.id +']').eq( index ).find('.inner').text( PHP.number_format(item.balance) );


					$.each(item.masseuse, function(q, mas) {
						self.$elem.find('[data-table=body_middle]').find('.mas[data-package='+item.pack.id +']').eq( index ).append('.inner').text( mas.code );

					});
					
				});

				self.$elem.find('[data-table=body_middle]').find('.menu[data-package=drink]').eq( index ).find('.inner').text( obj.drink ? PHP.number_format(obj.drink):' - ' );

			});

			self.resize();
		},
		resetTable: function () {
			var self = this;

			self.$elem.find('[data-table=body_middle]').find('.inner').text( '-' );
		},
		setItemTR: function ( data ) {
			var self = this;
		},

		setPage: function () {
			var self = this;

			var index = self.options.pages-1;

			self.$elem.find('[role=pages] .btn.active').removeClass('active').removeClass(' btn-blue');
			self.$elem.find('[role=pages] li').eq( index ).find('.btn').addClass('active btn-blue');

		},

		chooseMenu: function ( data ) {
			var self = this;
			Dialog.load( Event.URL + 'orders/_chooseMenu', data, {});
		},
		drink: function (data) {
			var self = this;
			Dialog.load( Event.URL + 'orders/_drink', data, {});
		},

		addMenu: function ( data ) {
			var self = this;

			// คำนวนราคา
			console.log( data );
		},

		setPageBTN: function () {
			
			var self = this;
			var box = self.$elem.find('[role=pages]');

			var pages = self.options.pages;
			for (var i = self.options.pages - box.find('li').length; i >= 0; i--) {

				pages ++;
				box.append( $('<li>', {'data-id': pages}).html( 
					$('<span>', {class: 'gbtn radius'}).html(
						$('<span>', {class: 'btn', text: pages})
					)
				) );

			}
		},

		
		
	};

	$.fn.TableOrder = function( options ) {
		return this.each(function() {
			var $this = Object.create( TableOrder );
			$this.init( options, this );
			$.data( this, 'TableOrder', $this );
		});
	};

	$.fn.TableOrder.options = {
		pages: 1,
		limit: 20,
		sort: 'number',
		dir: 'ASC'
	};
	
})( jQuery, window, document );