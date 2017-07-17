window.onbeforeunload = function (e) {
  var e = e || window.event;

  /*
  //IE & Firefox
  if (e) {
    e.returnValue = 'Are you sure?';
  }

  // For Safari
  return 'Are you sure?';*/
};


// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var addorder = {
		init: function(options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.addorder.options, options );
			self.setElem();

			console.log( self.options );

			var res = self.options.date.split("-");
			self.options._date = new Date(parseInt(res[0]), parseInt(res[1])+1,parseInt(res[2]));

			self.data = self.options.data;
			self.queue = [];
			self._queue = 0;

			self.getLastNumber( function () {
				
				self.setData();
				self.displayData();

			});

			/*window.addEventListener("beforeunload", function (e) {
			  var confirmationMessage = "\o/";

			  (e || window.event).returnValue = confirmationMessage; //Gecko + IE
			  return confirmationMessage;                            //Webkit, Safari, Chrome
			});
			*/

			

			self.Events();

			self.display();
		},
		setElem: function () {
			var self = this;

			self.$elem.find('[data-ref=list]').empty();

			$.each( self.$elem.find('[data-ref=summary] [data-summary]'), function() {
				self.options.summary[ $(this).data('summary') ] = parseInt( $(this).text() );
			});

		},
		setData: function () {
			var self = this;

			var data = [];
			for (var i = 0; i < self.options.actions.qty; i++) {

				data[i] = self.data[ i ]
					? self.data[ i ]
					: {
						active: true,

						options: {
							number: self.lastNumber + i,

							member_id: '',
							member_name: '',
							member_discount_value: 0,
							member_discount_type: '',
							member_level_id: '',

							drink: 0,
							total: 0,

							status: '',
							status_str: '',
						},

						items: {} 
					};
			}

			self.data = data;
		},
		displayData: function () {
			var self = this;

			var $zone = self.$elem.find('[data-section=zone]').empty();
			self.$elem.find('[data-ref=list]').empty();

			$.each(self.data, function(i, obj) {
				// console.log( i, obj );
				// set list
				var $item = self.setElemList( obj );
				self.$elem.find('[data-ref=list]').append( $item );


				self.updateList( i );
				if( obj.items.length > 0 ){

				}
				else{
					var $tr = $('<tr>').html( $('<td>', {colspan: 5, class: 'has-empty'}).html( $('<div>', {class: 'empty', text: 'เลือก Package'}) ) );
					$item.find( '.table-order3-tbody' ).html( $tr );
				}


				// set zone
				$zone.append( $('<li>').html( $('<a>').text( obj.options.number ? self.txtNumber( obj.options.number ): '_' ) ));


			});
		},
		
		setElemList: function ( data ) {
			
			var $stap = $('<ul>', {class: 'stap-order3 clearfix'});

			$stap.append(
				  $('<li>', {class: 'check-box'}).html( $('<label>', {class: 'checkbox'}).append( 
				  	$('<input>', {
					  	type: 'checkbox',
					  	'data-setlist': 'checkbox',
					  	checked: data.active
					  }) 
				  ))
				, $('<li>', {'data-setlist': 'number'}).append(
					  $('<strong>').text( 'ลำดับ' )
					, $('<span>', {class: 'text'})
				)
				, $('<li>', {'data-setlist': 'member_name'}).append(
					  $('<strong>').text( 'สมาชิก' )
					, $('<span>', {class: 'text'})
				)
				, $('<li>', {'data-setlist': 'drink'}).append(
					  $('<strong>').text( 'Drink' )
					, $('<span>', {class: 'text'})
				)
				/*, $('<li>', {'data-setlist': 'total'}).append(
					  $('<strong>').text( 'รวม' )
					, $('<span>').text( data.total == 0 ? '-':data.drink )
				)*/
			);

			var $table = $('<table>', {class: 'table-order3'});

			var $thead = $('<thead>', {class: 'table-order3-thead'});

			$thead.html( $('<tr>').append(

				  $('<th>', {class: 'name'}).append('รายการ')
				, $('<th>', {class: 'masseuse'}).append('พนง.ผู้บริการ')
				, $('<th>', {class: 'time'}).append('เวลา')
				, $('<th>', {class: 'total price'}).append('ราคา')
				, $('<th>', {class: 'actions'})

			));

			$tbody = $('<thead>', {class: 'table-order3-tbody'});

			$table.append( $thead, $tbody );

			var $inner = $('<div>', {class: 'table-order3-inner'});
			$inner.append( $stap, $table );

			var $wrap = $('<div>', {class: 'table-order3-wrap', 'data-order': ''});
			$wrap.html( $inner );
			$wrap.data( data );

			return $wrap;
		},
		updateList: function ( index ) {
			var self = this;

			var $box = self.$elem.find('[data-order]').eq(index);
			var data = $box.data();
			if( !data ) return false;

			// 
			$.each( data.options, function(key, val) {
				if( key=='number' ){
					val = self.txtNumber( val );
				}
				$box.find('[data-setlist='+ key +'] .text').html( val == 0 ? '-' : val );
			});

		},

		setItemListMenu: function ( data ) {

			var name = $('<td>', {class: 'name'}).append(
				  $('<div>', {class: 'rfloat'}).html('<span class="ui-status">สั่ง</span>')
				, $('<div>', {class: 'lfloat'}).html('<strong>นวดเท้า</strong>')
			);

			var masseuse = $('<td>', {class: 'masseuse'}).append(
				  $('<ul>', {class: 'ui-list-masseuse'}).html('')
			);
			/*<li><a class="control" data-control="change" data-type="masseuse" data-id="198"><span class="ui-status lfloat mrm">110</span><div class="avatar lfloat mrs"><img src="http://arima.vm101.net/public/uploads/1/87d2c0e7_2a15e949a7eed35ab76874ef19541574_a.jpg"></div><span class="">นก</span></a></li>*/

			var time = $('<td>', {class: 'time'}).append(
				  $('<strong>').html('2 Hour')
				, $('<span>').html('10.00 - 12.00')
			);

			var total = $('<td>', {class: 'total price'}).append(
				  $('<div>', {class: 'cost'}).text( 0 )
				, $('<div>', {class: 'discount'}).text( 0 )
				, $('<div>', {class: 'box-total'}).append(
					  $('<span>', {class: 'ui-status coupon mrs'}).text('C')
					, $('<span>', {class: 'total'}).text( 0 )
				)
			);

			var actions = $('<td>', {class: 'actions'}).append(
				  $('<a>', {class: 'btn btn-large'}).html( '<i class="icon-ellipsis-v"></i>' )
			);

			var $tr = $('<tr>').append(name, masseuse, time, total, actions);
			return $tr;
		},

		Events: function () {
			var self = this;

			self.$elem.find('[data-action]').click(function () {
				self.setAction[ $(this).data('action') ]( self );
			});

			self.$elem.delegate('[data-setlist]', 'click', function () {

				if( typeof self.setList[ $(this).data('setlist') ]==='function' ){
					self.setList[ $(this).data('setlist') ]( self, $(this).closest('[data-order]') );
				}
				
			});

			self.$elem.find('[data-ref=menu]').delegate('[data-id]', 'click', function () {

				self.queue.push({
					id: $(this).data('id'),
					date: self.options.date ,
					type: $(this).data('type'),
					cus_qty: self.options.actions.qty
				});
				self.chooseMenu();
			});
			
		},

		setAction : {
			qty: function ( self ) {

				Dialog.load( Event.URL + 'orders/setBill/', {
					type: 'cus_qty', 
					value: self.options.actions.qty
				}, {
					onClose: function () {
					},
					onSubmit: function ($d) {

						var val = parseInt($d.$pop.find(':input[name=cus_qty]').val()) || 1;
						self.options.actions.qty = val < 1 ? 1 :val;
						self.display();

						self.setData();
						self.displayData();

						Dialog.close();
					}
				});
			},
			room_name: function ( self ) {
				
				Dialog.load( Event.URL + 'orders/setBill/', {
					type: 'room', 
					room_name: self.options.actions.room_name,
					room_price: self.options.summary.room_price,
				}, {
					onClose: function () {
					},
					onSubmit: function ($d) {

						self.options.actions.room_name = $.trim( $d.$pop.find(':input[data-name=room]').val() );
						self.options.summary.room_price = parseInt( $d.$pop.find(':input[data-name=price]').val() ) || 0;

						self.display();
						Dialog.close();
					},
					onCancel: function () {
						
						self.options.actions.room_name = '';
						self.options.summary.room_price = 0;

						self.display();
						Dialog.close();
					}
				});
			}
		},

		setList: {
			member_name: function (self, $el) {
				var data = $el.data();

				function set_member( data ){

					self.data[ $el.index() ].options.member_id = data.id || '';

					var name = '';
					if( data.text ){
						name = data.text;
						if( data.category ){
							name += '<span class="ui-status mls">' + data.category + '</span>';
						}
					}
					self.data[ $el.index() ].options.member_name = name;
					self.data[ $el.index() ].options.member_discount_value = parseInt(data.discount_value) || 0;
					self.data[ $el.index() ].options.member_discount_type = data.discount_type || '';
					self.data[ $el.index() ].options.member_level_id = data.level_id || '';
					self.updateList( $el.index() );

					self.display();
					Dialog.close();
				}

				Dialog.load( Event.URL + 'orders/setBill/', {
					type: 'member', 
					id: data.options.member_id,
					level: data.options.member_level_id,
				}, {
					onClose: function () {},
					onSubmit: function ($d) {

						var id = $d.$pop.find('form').find('[ref=tokenbox]>[data-id]').data('id');

						if( id ){
	    					$.get( Event.URL + 'customers/get/' + id,{view:'bucketed',status:'run'}, set_member, 'json');					
	    				}
	    				else{
	    					set_member();
	    				}

					},
					onCancel: set_member
				});
			},

			drink: function (self, $el) {
				var data = $el.data();
				
				Dialog.load( Event.URL + 'orders/setBill/', {
					type: 'drink', 
					drink: data.options.drink,
				}, {
					onClose: function () {},
					onSubmit: function ($d) {

						var drink = parseInt($d.$pop.find(':input[name=drink]').val()) || 0;
						self.data[ $el.index() ].options.drink = drink < 0 ? 0:drink;
						self.updateList( $el.index() );

						self.display();
						Dialog.close();
					}
				});
			},
		},

		chooseMenu: function () {
			var self = this;

			self.getMenu( self.queue[ self._queue ]  ).done(function (res) {
					
				self.setMenu(res);

				self._queue++;
				if( self.queue[ self._queue ] ){
					self.chooseMenu();
				}
			});
		},
		getMenu: function ( data ) {
			var self = this;

			return $.ajax({
				url:  Event.URL + 'orders/menu/',
				type: 'GET',
				dataType: 'json',
				data: data,
			})
			.fail(function() {
				// console.log("error");
			})
			.always(function() {
				// console.log("complete");
			});
		},
		setMenu: function ( data ) {
			var self = this;

			console.log( data );
			/*if( !self.data.items[ data.id ] ){

				self.data.items[ data.id ] = {
					id: data.id,
					name: data.name,
					time: parseInt( data.qty ),
					unit: data.unit,

					price: parseInt( data.price ),
					qty: 0,
					discount: 0,

					status: 'order',

					has_masseuse: data.has_masseuse,

					cus: {}
				};

				for (var i = 0; i < self.data.cus_qty; i++) {

				 	self.data.items[ data.id ].cus[ i ] = {
				 		qty: 0,
				 		price: parseInt( data.price ),
						qty: 0,
						discount: 0,
				 	}
				}	
			}

			for (var i = 0; i < self.data.cus_qty; i++) {
			 	self.data.items[ data.id ].cus[ i ].qty++;
			}*/

		},

		display: function () {
			var self = this;

			self.sum();

			$.each(self.options.actions, function(key, val) {
				self.$elem.find('[data-action='+ key +']').toggleClass('has-count', val!='').find('.countValue').text(val);
			});

			self.$elem.toggleClass('has-zone', self.options.actions.qty > 1);
			
			$.each(self.options.summary, function(key, val) {
				self.$elem.find('[data-summary='+ key +']').text(val);
			});
		},

		sum: function () {
			var self = this;

			var drink = 0;
			$.each(self.data, function(i, obj) {

				drink += obj.options.drink;
			});

			self.options.summary.drink = drink;
		},

		getLastNumber: function ( call ) {
			var self = this;
			$.get( Event.URL + 'orders/lastNumber', {date: self.options.date}, function (res) {
				self.lastNumber = parseInt(res);

				if(typeof call === 'function' ){
					call();
				}
			});
		},
		txtNumber: function (txt) {
			
			if( txt < 10 ){
				txt = "00"+txt;
			}
			else if( txt < 100 ){
				txt = "0"+txt;
			}

			return txt;
		}
	};

	$.fn.addorder = function( options ) {
		return this.each(function() {
			var $this = Object.create( addorder );
			$this.init( options, this );
			$.data( this, 'addorder', $this );
		});
	};

	$.fn.addorder.options = {
		data: [],
		date: PHP.dateJStoPHP(new Date()),
		actions: {
			qty: 1
		},
		summary: {
			total: 0,
			discount_member: 0,
			discount: 0,
			drink: 0,
			room_price: 0,
			balance: 0
		}
	};
	
})( jQuery, window, document );