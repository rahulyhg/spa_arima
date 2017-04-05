// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var Reports = {
		init: function ( options, elem ) {
			var self = this;
			self.elem = elem;
			self.data = {};

			self.setElem();

			self.resize();
			$( window ).resize(function () {
				self.resize();
			});

		},

		setElem: function () {
			var self = this;
			self.$elem = $(self.elem);
			self.$elem.find('[role]').each(function () {
				if( $(this).attr('role') ){
					var role = "$" + $(this).attr('role');
					self[role] = $(this);
				}
			});

			if( self.$elem.find('[selector=type]').length==1 ){
				self.data.type = self.$elem.find('[selector=type]').val();
				self.$elem.find('[selector=type]').change(function() {
					self.data.type = $(this).val();
					self.refresh( 1 );
				});
			}

			var $closedate = self.$elem.find('[selector=closedate]');
			if( $closedate.length==1 ){

				var closedateOptions = [], activeIndex = 0;
				$.each( $closedate.find('option'), function (i) {

					if( $(this).prop('selected') ){
						activeIndex = i;
					}

					var attr = $(this).attr('divider');
					if( typeof attr !== typeof undefined && attr !== false ){
						closedateOptions.push({
							divider: true
						});
					}
					else{
						closedateOptions.push({
							value: $(this).attr('value')? $(this).attr('value'): $(this).text(), 
							text: $(this).text()
						});
					}
					
				} );

				$closedate.closedate({
					onComplete: function ( data ) {
						
						self.data.start = data.startDateStr;
						self.data.end = data.endDateStr;
						self.refresh( 1 );
					},

					onChange: function ( data ) {

						self.data.start = data.startDateStr;
						self.data.end = data.endDateStr;
						self.refresh( 1 );
					},
					options: closedateOptions,
					activeIndex: activeIndex
				});
			}
		},
		resize: function ( length ) {
		},

		refresh: function() {
			var self = this;

			self.$chart.addClass('has-loading');
			$.get( Event.URL+'reports/get', self.data, function( respond ) {
				
				self.display( respond );
			}, 'json');
			
		},

		display: function(data) {
			var self = this;
			
			if( data.subtotal ){
				self.$elem.find( '.subtotal-text' ).find('.value').html( data.subtotal );

				if( self.$elem.find( '.subtotal-text' ).hasClass('hidden_elem') ){
					self.$elem.find( '.subtotal-text' ).removeClass('hidden_elem');
				}
			}
			else{
				self.$elem.find( '.subtotal-text' ).addClass('hidden_elem');
			}

			if( data.total ){
				self.$elem.find( '.total-text' ).find('.value').html( data.total );

				if( self.$elem.find( '.total-text' ).hasClass('hidden_elem') ){
					self.$elem.find( '.total-text' ).removeClass('hidden_elem');
				}
			}
			else{
				self.$elem.find( '.total-text' ).addClass('hidden_elem');
			}

			if( data.chart ){
				if( typeof $.fn['charts'] === 'undefined' ){
	                Event.getPlugin('charts').done(function () {
	                    // self.loadData();
	                    
	                    self.displayChart(data.chart);

	                }).fail(function () {
	                    console.log( 'Is not connect plugin: Charts ' );
	                });
	            }
	            else{
	                self.displayChart(data.chart);
	            }
            }
            else{
            	self.$elem.find('[role=chart]').addClass('hidden_elem');
            }
            
            if( data.table ){

            	self.displayTable( data.table );
            }
            else{
            	self.$elem.find('[role=table]').addClass('hidden_elem');
            }
		},

		displayChart: function( data ) {
			var self = this;

			data.onOpen = function () {

				self.$chart.removeClass('has-loading');
			}

			if( self.$elem.find('[role=chart]').hasClass('hidden_elem') ){
				self.$elem.find('[role=chart]').removeClass('hidden_elem');
			}

			self.$elem.find('[role=chart-content]').charts(data);

		},

		displayTable: function( data ) {
			var self = this;

			$head = self.$elem.find('[role=table-head]').find('tr');
			$head.empty();
			$.each( data.head, function(i, obj) {
				$head.append( $('<th>', {class: obj.key, text: obj.label }) );
			} );

			$body = self.$elem.find('[role=table-body]');
			$body.empty();
			$.each( data.body, function(k, rows) {
				var $tr = $('<tr>');
				$.each(rows, function(name, val) {
					$tr.append( $('<td>', {class: name}).html( val ) );
				} );

				$body.append( $tr );
			} );

			if( self.$elem.find('[role=table]').hasClass('hidden_elem') ){
				self.$elem.find('[role=table]').removeClass('hidden_elem');
			}
		}
	}

	$.fn.reports = function( options ) {
		return this.each(function() {
			var $this = Object.create( Reports );
			$this.init( options, this );
			$.data( this, 'reports', $this );
		});
	};

	$.fn.reports.options = {
		onOpen: function() {},
		onClose: function() {}
	};
	
})( jQuery, window, document );