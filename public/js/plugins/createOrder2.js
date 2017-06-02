// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {
	
	var CreateOrder2 = {
		init: function ( options, elem ) {
			var self = this;
			self.$elem = $(elem);

			self.$elem.find('.table-order2-form').height( $(window).height() - 180 );
			self.order = {
				date: new Date(),
				items: []
			};

			self.date = new Date(); //self.$elem.find('[name=date]').val() || 

			self.$ordermanu = self.$elem.find('[ref=ordermanu]');

			self.$elem.find('.ul-package-manu [data-type=package]').click( function () {
				self.chooseMenu( $(this).data('id') )
			} );

			self.$ordermanu.delegate('[data-action=remove]', 'click', function () {
				
				var data = $(this).closest('[data-key]').data();

				self.order.items[ data.KEY ].$elem.remove();
				delete self.order.items[ data.KEY ];

				console.log( data, self.order );
			});

			self.$ordermanu.delegate('[data-action=qty]', 'click', function () {
				
				var parent = $(this).closest('[data-key]');
				var KEY = parent.data('key');
				var qty = parseInt( parent.find(':input[data-name=qty]').val() );
				
				qty += $(this).data('type')=='plus' ? 1:-1;
				parent.find(':input[data-name=qty]').val( qty );
				self.order.items[ KEY ].qty = qty;

				self.updateItemOrder( self.order.items[ KEY ] );
			});

			self.$ordermanu.delegate(':input[data-name=qty]', 'change', function () {
				var parent = $(this).closest('[data-key]');
				var KEY = parent.data('key');
				var qty = parseInt( parent.find(':input[data-name=qty]').val() );

				self.order.items[ KEY ].qty = parseInt( parent.find(':input[data-name=qty]').val() );
				self.updateItemOrder( self.order.items[ KEY ] );
			});
		},

		chooseMenu: function ( id ) {
			var self = this;

			var data = { type: 'package', id: id, date: PHP.dateJStoPHP( self.date ) };

			$.get(Event.URL + 'orders/menu/', data, function (res) {
				self.loadMenu( res );
			}, 'json');
		},
		loadMenu: function ( data ) {
			var self = this;

			var KEY = data.id;
			data.has_masseuse = parseInt(data.has_masseuse);

			if( !self.order.items[ KEY ] ){

				var fdata = {
					KEY: KEY,
					has_masseuse: data.has_masseuse,
					id: data.id,
					name: data.name,
					qty: 0,
					unit: data.unit,
					time: data.qty,
					
					price: parseInt( data.price ),
					discount: 0,

					detail: [],

					status: 'order',

					start_date: new Date(),
				};

				fdata.total = fdata.price;

				self.order.items[ KEY ] = fdata;

				self.newItemOrder(fdata);

				var length = 0;
			}
			else{
				var length = self.order.items[ KEY ].detail.length - 1;
			}

			self.order.items[ KEY ].qty++;

			var Detail = {
				parent_KEY: KEY,
				has_masseuse: data.has_masseuse,
				
				time: data.qty,
				unit: data.unit,

				price: parseInt( data.price ),
				discount: 0,

				status: 'order',

				start_date: new Date(),
				masseuse: {},
			};

			Detail.total = Detail.price;
			Detail.balance = Detail.total - Detail.discount;

			if( data.has_masseuse==1 && data.masseuse ){

				Detail.masseuse[data.masseuse.id] = data.masseuse;
			}

			// 
			self.order.items[ KEY ].detail.push( Detail );

			// check masseuse for load
			if( data.has_masseuse==1 && !data.masseuse ){

				self.loadMasseuse( {
					fail: function () {},
					done: function ( data ) {
						self.order.items[ KEY ].detail[length].masseuse[data.id] = data;
						self.updateItemOrder( self.order.items[ KEY ] );
					}
				} );
			}

			self.updateItemOrder( self.order.items[ KEY ] );

			console.log( data );
		},

		newItemOrder: function (data) {
			var self = this;

			self.order.items[ data.KEY ].$elem = self.setItemOrder( data );
			self.$ordermanu.append( data.$elem );
		},
		updateItemOrder: function (data) {
			var self = this;

			var $elem = self.order.items[ data.KEY ].$elem;

			$elem.find(':input.inputqty').val( data.qty );

			var masseuse = {};
			$.each( data.detail, function (i, obj) {
				for (var i in obj.masseuse) {
					var mas = obj.masseuse[i];

					masseuse[mas.id] = mas;
				}
			} );

			var $masseuse = $('<ul>', {class:'ui-list-masseuse'});
			for (var i in masseuse) {
				$masseuse.append( self.setElemMasseuse( data.KEY, masseuse[i] ) );
			}

			$elem.find('[role=masseuse]').html( $masseuse );

			// console.log( 'updateItemOrder', data );
		},

		setElemMasseuse: function (key, data) {
			var self = this;

			console.log( 'setElemMasseuse', data );
			var $li = $('<li>', {class: 'clearfix'});

			$li.append( $('<div>', {class: ''}).html( '<span class="code mrs">'+ data.icon_text +'</span><span>'+ data.text +'</span>' ) );
			$li.append( $('<div>', {class: 'actions'}).html( '<span class="gbtn"><a class="btn btn-no-padding" data-control="change" data-type="masseuse" data-id="129"><i class="icon-retweet"></i></a></span><span class="gbtn"><a class="btn btn-no-padding" data-control="change" data-type="plus_masseuse"><i class="icon-plus"></i></a></span><span class="gbtn"><a class="btn btn-no-padding" data-control="change" data-type="remove_masseuse" data-id="129"><i class="icon-remove"></i></a></span>' ) );
			
			$li.append( $('<input>', { type: 'hidden', name: 'items['+key+'][masseuse][]', value: data.id }) );

			return $li;
		},
		setItemOrder: function ( data ) {
			var self = this;

			var $inputqty = $('<input>', {
				type: 'text',
				name: 'items['+data.KEY+'][qty][]',
				value: data.qty,
				class: 'inputtext inputqty',
				'data-name':'qty'
			});

			$tr = $('<tr>', {class: '', 'data-key': data.KEY});

			// qty
			$tr.append( $('<td>', {class: 'qty'}).append(
				$('<div>', {class: 'minusplus-btn'}).append(
					  $('<button>', {class: 'btn-icon', type: 'button', 'data-action':'qty', 'data-type': 'minus'}).html( $('<i>', {class:'icon-minus'}) )
					, $inputqty
					, $('<button>', {class: 'btn-icon', type: 'button', 'data-action':'qty', 'data-type': 'plus'}).html( $('<i>', {class:'icon-plus'}) )
					, $('<input>', {
						type: 'hidden',
						name: 'items['+data.KEY+'][id][]',
						value: data.id
					})
				),

				$('<a>', {'data-action':'remove'}).text( 'ลบ' )
			) );

			// name
			$tr.append( $('<td>', {class: 'name'}).append(
				  $('<div>', {class: 'fwb'}).text( data.name )
				, $('<div>', {class: '', 'role': 'masseuse'})
			) );


			// time
			// $tr.append( $('<td>', {class: 'time'}).text( data.time ) );


			// unit
			// $tr.append( $('<td>', {class: 'unit'}).text( data.unit ) );

			$tr.data( data );

			return $tr;
		},

		loadMasseuse: function ( on ) {
			var self = this;

	    	Dialog.load( Event.URL + 'orders/set_bill', {
	    		type: 'masseuse',
	    		date: PHP.dateJStoPHP( self.order.date ) 
	    	}, {
	    		onClose: on.fail,
	    		onSubmit: function ( $el ) {

	    			var id = $el.$pop.find('form').find('[ref=tokenbox]>[data-id]').data('id');

					if( id ){ 			
	    				$.get( Event.URL + 'masseuse/get/'+id, function( res ) {
	    					
							self.currMasseuse = res;

	    					on.done( res );
	    					Dialog.close();
	    				}, 'json');
	    			}
	    		}
	    	} );
		},
	}
	$.fn.createOrder2 = function( options ) {
		return this.each(function() {
			var $this = Object.create( CreateOrder2 );
			$this.init( options, this );
			$.data( this, 'createOrder2', $this );
		});
	};
	$.fn.createOrder2.options = {
		lang: 'en',
	};

})( jQuery, window, document );