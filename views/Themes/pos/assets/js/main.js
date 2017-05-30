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


	var InputDiscount = {
		init: function ( options, elem ) {
			var self = this;

			self.$elem = $(elem);

			var $discount = self.$elem.find('[id=discount]');
			var price = parseInt(self.$elem.find('[id=price]').val());

			var $total = self.$elem.find('[id=total]');
			var total = parseInt($total.val());

			function _change() {
				var val = parseInt( $discount.val() );
				$total.val( price - val );
			}

			$discount.keydown(function (e) {
				// Allow: backspace, delete, tab, escape, enter and .
		        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		             // Allow: Ctrl+A, Command+A
		            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
		             // Allow: home, end, left, right, down, up
		            (e.keyCode >= 35 && e.keyCode <= 40)) {
		                 // let it happen, don't do anything
		                 return;
		        }
		        // Ensure that it is a number and stop the keypress
		        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		            e.preventDefault();
		        }
			}).change(_change).keyup(_change);

		},
	}
	$.fn.inputDiscount = function( options ) {
		return this.each(function() {
			var $this = Object.create( InputDiscount );
			$this.init( options, this );
			$.data( this, 'inputDiscount', $this );
		});
	};
	$.fn.inputDiscount.options = {
		lang: 'en',
	};

	var Order = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.order.options, options );

			if( self.options.date ){
				var d = self.options.date.split("-");
			 	self.options.date = new Date( parseInt(d[0]), parseInt(d[1])-1, parseInt(d[2]) );
		 	}
		 	else{
		 		self.options.date = new Date();
		 	}

			// set Elem
			self.$elem = $(elem);
			self.setElem();

			self.resize();
			$( window ).resize(function() {			
				self.resize();
			});

			self.$elem.parent().addClass('on');

			// set data 
			self._queueMenu = [];
			self.currOrder = self.setOrderDefault();
			self.global = {};

			self.Events();

			self.active( 'lists' );
			// self.active( 'detail' );
		},
		setElem: function () {
			var self = this;

			$.each( self.$elem.find('[data-global]'), function () {
				self[ '$e_'+ $(this).attr('data-global') ] = $(this);
			} );

			self.$left = self.$elem.find('[role=left]');
			self.$content = self.$elem.find('[role=content]');
			self.$main = self.$elem.find('[role=main]');
		},

		resize: function(){
			var self = this;

			var outer = $( window );
			var offset = self.$elem.offset();
			var right = 0, leftw = 0;
			var fullw = outer.width() - (offset.left+right);
			var fullh = (outer.height() + outer.scrollTop()) - $('#header-primary').outerHeight();

			var leftw = (fullw*25) / 100;
			leftw = (fullw*parseInt( self.$left.attr('data-w-percent') )) / 100;

			self.$left.css({
				width: leftw,
				height: fullh,
				position: 'absolute',
				top: 0,
				left: 0
			});

			self.$content.css({
				marginLeft: leftw,
			});

			self.$main.css({
				height: fullh,
				overflowY: 'auto'
			});
		},

		Events: function() {
			var self = this;

			self.$elem.delegate('[data-global-action]', 'click', function () {
				if( self.currInvoice ){
					self.currInvoice = null;
				}
				self.active( $(this).attr('data-global-action') );
			});

			self.$elem.find('[data-global=menu]').delegate('.memu-table [data-id]', 'click', function () {

				self.chooseMenu( $(this).data('type'), $(this).data('id') );
			});

			self.$elem.find('[data-global=bill]').delegate('[role=orderlists] > tr', 'click', function () {
					
				var data = $(this).data();
				self.setDetail( data );

				$(this).addClass('active').siblings().removeClass('active');

				self.currMenu = data;
				self.active( 'detail' );
			});


			// 
			self.$elem.find('[data-global=bill]').find('[data-bill-action]').click( function () {
				var action = $(this).attr('data-bill-action');

				if( action == 'hold' ){

					self.saveBill( function () {
						
						self.active( 'lists' );
						self.active( 'summary' );
					} );
					
				}
				else if( action=='pay' ){

					self.active( 'pay' );
				}
				else if( action=='menu' ){
					self.active( 'menu' );
				}
				else if( action=='send' ){

					self.saveBill();

					// console.log('save', self.currOrder );
					// self.active( 'lists' );
				}else if( action=='remove_member' ){
					self.$elem.find('[data-bill=member]').addClass('hidden_elem');
    				if( self.currOrder.member ){
    					delete self.currOrder.member;
    				}

    				self.bill.resize();
				}
				else if( action=='cancel' ){

					// if( self.currOrder.id ){
					// 	console.log( 'delete', self.order );
					// }
					// else{
						
					// }
					self.active( 'lists' );
					self.active( 'summary' );
				}
			});


			/* Detail */
			self.$elem.find('[data-global=detail]').find('.js-add-time').click(function () {
				
				var length = self.currOrder.items[self.currMenu.KEY].detail.length;

				self.chooseMenu( 'package', self.currMenu.id, function () {

					self.currOrder.items[self.currMenu.KEY].detail[length].masseuse = self.currOrder.items[self.currMenu.KEY].detail[ length-1 ].masseuse;

					self.setDetail( self.currOrder.items[self.currMenu.KEY] );


					self.$elem.find('[data-global=bill]').find('[role=orderlists] > tr[data-id='+ self.currMenu.id +']').addClass('active');
				} );
			});
			self.$elem.find('[data-global=detail]').delegate('[data-control]', 'click', function () {

				var box = $(this).closest('[data-item]');
				var index = box.index();
				var fdata = box.data();
				var mdata = $(this).data();

				var type = $(this).data('type');

				var data = {
		    		type: type,
		    		date: PHP.dateJStoPHP( self.currOrder.date ) 
		    	}

		    	if( type=='remove_item' ){
		    		data.package = self.currOrder.items[fdata.parent_KEY].id;
		    		data.id = fdata.id;

		    		self.removeItemDetail( index, fdata );
		    		return false;
		    	}

		    	if( type=='masseuse' ){
		    		var has_remove = true;
		    		data.id = mdata.id;
		    	}

		    	if( type=='remove_masseuse' ){

		    		delete self.currOrder.items[fdata.parent_KEY].detail[index].masseuse[ mdata.id ];

		    		self.refreshItemDetail( index, self.currOrder.items[fdata.parent_KEY].detail[index] );
	    			self.updateItemBill( self.currOrder.items[fdata.parent_KEY] );
		    		return false;
		    	}

		    	if( type=='time' ){
		    		data.time = mdata.time;
		    		data.unit = mdata.unit;

		    		data.start = mdata.start;
		    		data.end = mdata.end;
		    	}

		    	if( type=='price' ){

		    		data.price = fdata.price;
		    		data.discount = fdata.discount;
		    		data.total = fdata.balance;
		    	}

		    	if( type=='note' ){
		    		data.note = fdata.note;
		    	}

				Dialog.load( Event.URL + 'orders/set_bill', data, {
		    		onSubmit: function ( $el ) {
		    			
		    			var $form = $el.$pop.find('form');
		    			if( type=='masseuse' ){
		    				var id = $form.find('[ref=tokenbox]>[data-id]').data('id');

		    				if(id){
		    					$.get( Event.URL + 'masseuse/get/'+id, function( res ) {
	    							
	    							if ( has_remove ){
	    								delete self.currOrder.items[fdata.parent_KEY].detail[index].masseuse[ mdata.id ];
	    							}
									// self.currMasseuse = res;
	    							self.currOrder.items[fdata.parent_KEY].detail[index].masseuse[ res.id ] = res;

	    							self.refreshItemDetail( index, self.currOrder.items[fdata.parent_KEY].detail[index] );
	    							self.updateItemBill( self.currOrder.items[fdata.parent_KEY] );

			    					Dialog.close();
			    				}, 'json');
		    				}
		    			}

		    			if( type=='plus_masseuse' ){
		    				var id = $form.find('[ref=tokenbox]>[data-id]').data('id');

		    				if(id){
		    					$.get( Event.URL + 'masseuse/get/'+id, {has_job: 1, date: PHP.dateJStoPHP(self.currOrder.date)}, function( res ) {

	    							self.currOrder.items[fdata.parent_KEY].detail[index].masseuse[ res.id ] = res;

	    							self.refreshItemDetail( index, self.currOrder.items[fdata.parent_KEY].detail[index] );
	    							self.updateItemBill( self.currOrder.items[fdata.parent_KEY] );

			    					Dialog.close();
			    				}, 'json');
		    				}
		    			}

		    			if( type=='room' ){

		    				fdata.floor = {
		    					id: $form.find(':input[data-name=floor]').val(),
		    					name: $form.find(':input[data-name=floor]').data('label')
		    				}

		    				fdata.room = {
		    					id: $form.find(':input[data-name=room]').val(),
		    					name: $form.find(':input[data-name=room]').data('label')
		    				}

		    				fdata.bed = {
		    					id: $form.find(':input[data-name=bed]').val(),
		    					name: $form.find(':input[data-name=bed]').data('label')
		    				}

		    				self.currOrder.items[fdata.parent_KEY].detail[index] = fdata;

		    				self.refreshItemDetail( index, fdata );
			    			Dialog.close();
		    			}

		    			if( type=='time' ){

		    				var start_date = $form.find(':input[name=start_date]').val();
		    				var res = start_date.split('-');
		    				var start_time_hour = parseInt( $form.find(':input[name=start_time_hour]').val() );
		    				var start_time_minute = parseInt( $form.find(':input[name=start_time_minute]').val() );

		    				fdata.start_date = new Date( parseInt(res[0]), parseInt(res[1]), parseInt(res[2]), start_time_hour, start_time_minute, 0 );

		    				var end_date = $form.find(':input[name=end_date]').val();
		    				var res = end_date.split('-');
		    				var end_time_hour = parseInt( $form.find(':input[name=end_time_hour]').val() );
		    				var end_time_minute = parseInt( $form.find(':input[name=end_time_minute]').val() );

		    				fdata.end_date = new Date( parseInt(res[0]), parseInt(res[1]), parseInt(res[2]), end_time_hour, end_time_minute, 0 );

		    				self.currOrder.items[fdata.parent_KEY].detail[index]=fdata;
		    				self.refreshItemDetail( index, fdata );
			    			Dialog.close();
		    			}

		    			if( type=='price' ){

		    				fdata.price = parseInt( $form.find(':input[name=price]').val() );
		    				fdata.discount = parseInt( $form.find(':input[name=discount]').val() );
		    				fdata.balance = parseInt( $form.find(':input[name=total]').val() );

		    				self.currOrder.items[fdata.parent_KEY].detail[index]=fdata;
		    				self.refreshItemDetail( index, fdata );
		    				self.summaryPriceDetail();
		    				self.updateItemBill( self.currOrder.items[fdata.parent_KEY] );
			    			Dialog.close();
		    			}
		    		}
		    	});
			});

			$(window).keydown(function (e) {

				if( !isNaN(e.key) ){
					// console.log( 'pay:', parseInt( e.key ) );
				}
		    });

		    self.$elem.find('[data-bill-set]').click( function () {
		    	var type = $(this).attr('data-bill-set');

		    	var data = {
		    		type: type,
		    		date: PHP.dateJStoPHP( self.currOrder.date ) 
		    	}

		    	if(  type=='drink' ){
		    		data.drink = self.currOrder.summary.drink;
		    	}

		    	if( type=='member' && self.currOrder.member ){
		    		data.id = self.currOrder.member.id;
		    	}

		    	var is_submit = false;
		    	Dialog.load( Event.URL + 'orders/set_bill', data, {
		    		onClose: function () {
		    			
		    		},
		    		onSubmit: function ( $el ) {
		    			var err = false;

		    			if(  type=='drink' ){
		    				self.currOrder.summary.drink = parseInt( $.trim($el.$pop.find('#drink').val()) );
			    			self.summaryPrice();
			    			self.summaryDisplay();

			    			Dialog.close();
		    			}

		    			if(  type=='vip' ){
		    				self.currOrder.summary.room_price = parseInt( $.trim($el.$pop.find('#room_price').val()) );
			    			self.summaryPrice();
			    			self.summaryDisplay();

			    			Dialog.close();
		    			}
		    			
		    			if( type=='member' ){

		    				is_submit = true;
		    				var id = $el.$pop.find('form').find('[ref=tokenbox]>[data-id]').data('id');

		    				if( id ){
		    					$.get( Event.URL + 'customers/_get/' + id, function (res) {
		    						self.currOrder.member = res;

		    						self.$elem.find('[data-bill=member]').removeClass('hidden_elem').find( '.text' ).text( res.fullname );

		    						Dialog.close();

		    						self.bill.resize();
		    					}, 'json');					
		    				}
		    				else if( self.currOrder.member ){
		    					self.$elem.find('[data-bill=member]').addClass('hidden_elem');
		    					delete self.currOrder.member;
		    				}
		    				
		    			}

		    			if( err ){
		    				return false;
		    			}
		 
		    		}
		    	} );
			} );
		},

		saveBill: function ( call ) {
			var self = this;
			var dataPost = {};

			$.each(self.currOrder, function(key, val) {
				if( key=='items' ){

					var items = [];
					for (var i in val) {
						var data = val[i];

						$.each( data.detail, function (j, detail) {

							var d = {
								pack_id: data.id,
								status: detail.status,
								total: detail.total,
								discount: detail.discount,
								balance: detail.balance,
								price: detail.price,

								masseuse: []
							};

							if( Object.keys( detail.masseuse ).length ){

								for (var index in detail.masseuse) {
									var ma = detail.masseuse[index];

									d.masseuse.push({
										id: ma.id,
										job: ma.job_id
									});
								}
								
							}

							if( detail.room ){
								d.room_id = detail.room.id;
								d.room_price = detail.room.price;
								d.bed_id = detail.bed.id;
							}
							
							items.push(d);
						} );
					}
					dataPost.items = items;
				}
				else{
					dataPost[key] = val;
				}
			});

			dataPost.date = PHP.dateJStoPHP( dataPost.date );

			// console.log( 'saveBill', dataPost );
			// return false;

			$.post( Event.URL + 'orders/save', dataPost, function (res) {
				
				console.log( 'saveBill', res );
				if( res.message ){
					Event.showMsg({text: res.message, load: 1, auto: 1});
				}

				if( res.error ){
					return false;
				}

				self.currOrder.id = res.id;
				self.currOrder.status = res.status;
				/*self.currOrder.items = [];
				self.currOrder._items = res.items;*/

				self.$elem.find('[data-global=bill]').find('[role=orderlists]').empty();
				self.$elem.find('[data-global=menu]').find('[role=menu] .active').removeClass('active');


				if( typeof call === 'function' ){
					call();
				}
				else{
					self.active('menu');
				}

				
				console.log( 'Save:', self.currOrder );
			}, 'json');	
		},

		active: function ( val ) {
			var self = this;

			if( val=='summary' || val=='invoice' ){
				self.$left.attr('data-w-percent', 40);
			}
			else{
				self.$left.attr('data-w-percent', 50);
			}
			self.resize();
			

			var el = self.$elem.find('[data-global='+ val +']');
			if( el.hasClass('active') && val!='invoice' ) return false;

			el.addClass('active').siblings().removeClass('active');

			if( !self.global[val] ){

				self[ val ].init( self.options, el, self, function ( res ) {

					if( res ){
						self.global[val] = res;
					}
				} );
			}
			else{

				if( val=='lists' || val=='bill' || val=='invoice' || val=='summary' ){
					self.global[val].reload();
				}

				// self.global[val].
			}
		},

		chooseMenu: function ( type, id, callback) {
			var self = this;

			var data = { type: type, id: id, date: PHP.dateJStoPHP( self.currOrder.date ) };

			$.get(Event.URL + 'orders/menu/', data, function (res) {

				if( type=='package' ){
					self.loadMenu( res );
					if( typeof callback === 'function' ){
						callback( res );
					}
				}

				if( type=='promotion' ){

					$.each( res, function (i, obj) {
						obj.active = false;
						self._queueMenu.push( obj );
						// 
					} );

					self.queueMenu();
				}

			}, 'json');
		},
		queueMenu: function () {
			var self = this;

			var has = true;
			for (var i = 0; i < self._queueMenu.length; i++) {
				
				var obj = self._queueMenu[i];
				if( obj.active==false && has ){
					self._queueMenu[i].active = true;

					self.loadMenu( obj, function () {
						
						self.queueMenu();
					} );

					has = false;
				}				
			}
		},
		loadMenu: function ( data, callback ) {
			var self = this;

			console.log( 'loadMenu', data );

			var KEY = data.id;
			data.has_masseuse = parseInt(data.has_masseuse);

			/*if( data.has_masseuse==1 && data.skill && self.currMasseuse ){

				$.each( self.currMasseuse.skill, function (i, obj) {
					
					$.each( data.skill, function (index, skill) {
						if( skill.id==obj.id ){
							data.masseuse = self.currMasseuse
						}
					} );
				} );
			}*/

			if( !self.currOrder.items[ KEY ] ){

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

				self.currOrder.items[ KEY ] = fdata;

				self.newItemBill(fdata);

				var length = 0;
			}
			else{

				var length = self.currOrder.items[ KEY ].detail.length;

				/*if( self.currOrder.items[ KEY ].detail[length-1].masseuse ){
					data.masseuse = self.currOrder.items[ KEY ].detail[length-1].masseuse;
				}*/

				if( self.currOrder.items[ KEY ].detail[length-1].floor ){
					data.floor = self.currOrder.items[ KEY ].detail[length-1].floor;
				}
				
				if( self.currOrder.items[ KEY ].detail[length-1].room ){
					data.room = self.currOrder.items[ KEY ].detail[length-1].room;
				}

				if( self.currOrder.items[ KEY ].detail[length-1].bed ){
					data.bed = self.currOrder.items[ KEY ].detail[length-1].bed;
				}
			}

			self.currOrder.items[ KEY ].qty++;

			var Detail = {
				parent_KEY: KEY,
				has_masseuse: data.has_masseuse,
				
				time: data.qty,
				unit: data.unit,

				price: parseInt( data.price ),
				discount: 0,

				status: 'order',

				start_date: new Date(),
				masseuse: {}
			};

			Detail.total = Detail.price;
			Detail.balance = Detail.total - Detail.discount;

			if( data.has_masseuse==1 && data.masseuse ){

				if( data.masseuse.id ){
					Detail.masseuse[data.masseuse.id] = data.masseuse;
				}
				else{
					$.each(data.masseuse, function (i, mas) {
						console.log(i, mas);
						Detail.masseuse[mas.id] = mas;
					});
				}
				
			}

			// 
			self.currOrder.items[ KEY ].detail.push( Detail );

			// check masseuse
			if( data.has_masseuse==1 && !data.masseuse ){

				self.setMasseuse( {
					fail: function () {

						if( typeof callback === 'function' ){
							callback();
						}
					},
					done: function ( data ) {

						self.currOrder.items[ KEY ].detail[length].masseuse[data.id] = data;
						self.updateItemBill( self.currOrder.items[ KEY ] );
						if( typeof callback === 'function' ){
							callback();
						}
					}
				} );
			}
			else if( typeof callback === 'function' ){
				callback();
			}

			self.updateItemBill( self.currOrder.items[ KEY ] );

			self.checkPromotion();
			self.resizeBill();

			self.summaryPrice(); 
			self.summaryDisplay();
		},

		checkPromotion: function () {
			var self = this;
			console.log('this checkPromotion');
			var qty = 0;
			for (var obj in self.currOrder.items) {

				var data = self.currOrder.items[obj];

				if( data.has_masseuse==1 ){
					qty += data.qty;
				}
			}
			
			for (var obj in self.currOrder.items) {

				var data = self.currOrder.items[obj];
				var deduct = 0;

				// 1. ราคาสินราคา 350 ลด 50 หากซื้อมากว่า 1 รายการ 
				if( data.price==350 && qty>1 ){
					deduct = 50;
				}

				var discount = data.qty*deduct;
				self.currOrder.items[obj].discount = discount;
				self.currOrder.items[obj].balance = (data.total*qty) - discount;

				$.each( self.currOrder.items[obj].detail, function (i) {
					self.currOrder.items[obj].detail[i].discount = deduct;
					self.currOrder.items[obj].detail[i].balance = data.price-deduct;
				} );

				self.updateItemBill( data );
			}
		},


		newItemBill: function(data) {
			var self = this;

			data.no = self.$elem.find('[data-global=bill]').find('[role=orderlists]>tr').length + 1;

			var $item = self.setItemBill( data );
			self.$elem.find('[data-global=bill]').find('[role=orderlists]').append( $item );
		},
		setItemBill: function (data) {
			var self = this;

			// console.log('this setItemBill', data);

			var cost = data.qty * data.price;
			var total = cost - data.discount;

			var $price = $('<td>', {class: 'price'}).append(
				  $('<div>', {class: 'cost'}).text( PHP.number_format( cost ) )
				, $('<div>', {class: 'discount'}).append( '-', PHP.number_format(data.discount) )
				, $('<div>', {class: 'total'}).text( PHP.number_format( total ) )
			);

			$price.toggleClass('has-discount', data.discount>0);
			
			var $meta = $('<div>', {class: 'order-title fsm'});

			var masseuse = {};
			// console.log( 'set bill', data.detail.length );
			for (var i in data.detail) {
				var detail = data.detail[i];

				if( Object.keys(detail.masseuse).length > 0 ){
					for (var mas in detail.masseuse) {
						var d = detail.masseuse[mas];
						masseuse[d.id] = d;
					}
				}
			}

			if( Object.keys(masseuse).length ){

				var $masseuse = $('<ul>');
				for (var i in masseuse) {
					var obj = masseuse[i];
						$masseuse.append( $( '<li>' ).append(
							$('<span>', {class: 'ui-status mrs'}).text( obj.icon_text ), obj.text 
						) );
				};

				$meta.append( $masseuse );
			}

			$status = $('<div>', {class: 'ui-status', 'data-status': data.status, text: data.status}); //self.then.setStatus( data.status ); // 


			var qty = data.time*data.qty, unit = data.unit;
			if( unit=='minute' && qty >=60 ){
				unit = 'hour';

				var hour = parseInt( qty / 60);
				var minute = qty - (hour*60);
				qty = minute>0
					? hour + '.' + minute
					: hour;
			}

			var $tr = $('<tr>', {'data-id': data.id}).append( 

				  $('<td>', {class: 'no'}).text( data.no+'.' )
				, $('<td>', {class: 'name'}).append( 
					  $('<div>', {class: 'title fwb'}).text( data.name )
					, $meta
				)
				, $('<td>', {class: 'status'}).html( $status )
				, $('<td>', {class: 'qty'}).text( qty )
				, $('<td>', {class: 'unit'}).text( unit )
				, $price

			);

			$tr.data( data );
			return $tr;
		},
		updateItemBill: function (data) {
			var self = this;

			console.log('this updateItemBill');

			var $item = self.setItemBill( data );
			var $box = self.$elem.find('[data-global=bill]').find('[role=orderlists]').find( '[data-id='+ data.id +']' );

			$box.replaceWith( $item );

			self.$elem.find('[data-global=menu]').find('[data-memu=package]').find('[data-id='+ data.id + ']').addClass('active').find('.countVal').text( data.qty );
		},
		removeItemBill: function ( key ) {
			var self = this;

			var $box = self.$elem.find('[data-global=bill]').find('[role=orderlists]');

			var data = self.currOrder.items[ key ];

			delete self.currOrder.items[ key ];
			self.active( 'menu' );

			$box.find('[data-id='+data.id+']').remove();

			var $memu = self.$elem.find('[data-global=menu] [data-memu=package]'); 
			var $item = $memu.find('[data-id='+data.id+']');
			var countVal = parseInt($item.find('.countVal').text())-1;

			$item.toggleClass('active', countVal>0).find('.countVal').text( countVal );
		},
		resizeBill: function () {
			var self = this;

			$.each( self.$elem.find('[data-global=bill]').find('[role=orderlists]>tr').first().find('td'), function ( i ) {

				var td = $(this);
				var th = self.$elem.find('[data-global=bill] .slipPaper-bodyContent-header').find('table th').eq( i );

				if( td.hasClass('name') ) return

				var outerW = td.outerWidth()
				var width = td.width();

				if( th.width() > width){
					outerW = th.outerWidth();
					width = th.width();
				}
		
				td.width( width );
				th.width( width );
			});
		},

		setDetail: function (data) {
			var self = this;

			var $box = self.$elem.find('[data-global=detail]');
			$box.find('[data-text=title]').text( data.name );

			var $listsbox = $box.find('[role=listsbox]');
			$listsbox.empty();

			var no = 1;
			$.each( data.detail, function (i, obj) {
				obj.no = no++;

				$listsbox.append( self.itemDetail( obj ) );
			} );
		},
		itemDetail: function (data ) {
			var self = this;

			var datetxt = data.time + ' ' + data.unit;

			var $date = $('<div>', {class: 'date'}).append(
				  $('<div>', {class: 'number'}).text( data.no )
				, $('<div>', {class: 'text-date'}).append(
					  ''
					, $('<span>', {class: 'text-date-txt'}).text( datetxt )
					, $('<span>', {class: 'ui-status'}).text( data.status )
					, $('<span>', {class: 'gbtn'}).append(
						$('<a>', {
							class: 'btn btn-no-padding',
							'data-control': "click",
							'data-type': "remove_item"
						}).append( 
							$('<i>', {class: 'icon-remove'})
						)
						// 'Remove'
					)
				)
			);

			var $wrap = $('<div>', {class: 'wrap'});
			var $table = $('<table>', {class: ''});

			// Masseuse
			var $masseuse = $('<tr>', {class: 'masseuse'});
			var masseuse_data = '-';
			$masseuse.append( $('<td>', {class: 'label'}).text('พนง.ผู้บริการ') );

			if( data.has_masseuse==0 ){ }
			else if( Object.keys( data.masseuse ).length > 0 ){

				masseuse_data = $('<ul>', {class: 'ui-list-masseuse'});
				for (var i in data.masseuse) {
					var masseuse = data.masseuse[i];

					var img = '';
					if( masseuse.image_url ){
						img = $('<div>', {class: 'avatar lfloat mrs'}).html( $('<img>', {  src: masseuse.image_url }) );
					}

					masseuse_data.append( 
						$('<li>').append( 
							$('<a>', {
								class: 'control', 
								'data-control':'change', 
								'data-type':'masseuse',
								'data-id': masseuse.id,
							} ).append( 
								
								$('<span>', { class: 'ui-status lfloat mrm', text: masseuse.icon_text }), 
								img , 
								$('<span>', { class: '', text: masseuse.text }) 
							) 
							, $('<div>', {'class': 'actions'}).append( $('<span>', {class: 'gbtn'}).html(
									$('<a>', {
										'class': 'btn btn-no-padding',
										'data-control':'change', 
										'data-type':'masseuse',
										'data-id': masseuse.id,
									}).html( '<i class="icon-retweet"></i>' )
								)
								, $('<span>', {class: 'gbtn'}).html( 
									$('<a>', {
										'class': 'btn btn-no-padding',
										'data-control':'change', 
										'data-type':'plus_masseuse',
									}).html( '<i class="icon-plus"></i>' ) 
								)
								, $('<span>', {class: 'gbtn'}).html( 
									$('<a>', {
										'class': 'btn btn-no-padding',
										'data-control':'change', 
										'data-type':'remove_masseuse',
										'data-id': masseuse.id,
									}).html( '<i class="icon-remove"></i>' ) 
								)
							)

						) 
					);
				}
			}
			else{
				masseuse_data = $('<a>', {
					class: 'control', 
					'data-control':'change', 
					'data-type':'masseuse'
				}).html( '+ เพิ่ม' );
			}

			$masseuse.append( $('<td>', {class: 'data'}).html( masseuse_data ) );

			// Room 
			var $room = $('<tr>', {class: 'room'});
			var room_data = '';
			$room.append( $('<td>', {class: 'label'}).text('ห้อง') );

			if( data.has_masseuse==0 ){
			}else if( data.room ){

				room_data = $('<a>', {
					class: 'control', 
					'data-control':'change', 
					'data-type':'room'
				}).append( 
					  $('<span>', {class: ''}).text( 'ชั้น:'+ data.floor.name )
					, $('<span>', {class: ''}).text( ' / ห้อง:'+ data.room.name )
					, $('<span>', {class: ''}).text( ' / เตียง:'+ data.bed.name )
					, $('<i>', {class: 'icon-pencil'})
				);
			}
			else{
				room_data = $('<a>', {
					class: 'control', 
					'data-control':'change', 
					'data-type':'room'
				}).html( '+ เพิ่ม' );
			}
			$room.append( $('<td>', {class: 'data'}).append( room_data ) );

			// Price
			var cost = data.price;
			var total = cost - data.discount;

			var $price = $('<tr>', {class: 'price'})
			$price.append( $('<td>', {class: 'label'}).text('ราคารวม') );

			$price.append( $('<td>', {class: 'data price'})
				.toggleClass('has-discount',  data.discount > 0)
				.html( $('<a>', {class: 'control', 'data-control':'change', 'data-type':'price'}).append(

					  $('<span>', {class: 'cost'}).text( PHP.number_format( cost ) )
					, $('<span>', {class: 'discount'}).append( '-', PHP.number_format(data.discount) )
					, $('<span>', {class: 'total'}).text( PHP.number_format( total ) )

					, $('<i>', {class: 'icon-pencil'})

				) )
			);

			// Time
			var $time_str =$('<a>', {
				class: 'control',
				'data-control':'change', 
				'data-type':'time',
				'data-time': data.time,
				'data-unit': data.unit
			}).append( 
				  $('<span>').text( 'กำหนดเวลา' )  
				, $('<i>', {class: 'icon-pencil'})
			);

			if( data.start_date && data.end_date ){
				$time_str.empty();

				var startDate = data.start_date.getHours() + ':' + data.start_date.getMinutes();
				var endDate = data.end_date.getHours() + ':' + data.end_date.getMinutes();

				$time_str
					.attr('data-start', PHP.dateJStoPHP( data.start_date ) + ' ' + startDate +':00' )
					.attr('data-end', PHP.dateJStoPHP( data.end_date ) + ' ' + endDate +':00' )
					.append( $('<span>', {class: ''}).append( startDate, ' - ', endDate ) )
			}

			var $time = $('<tr>', {class: 'time'})
			$time.append( $('<td>', {class: 'label'}).text('เวลา') );
			$time.append( $('<td>', {class: 'data'}).html( $time_str ) );

			var $note = $('<tr>', {class: 'time'})
			$note.append( $('<td>', {class: 'label'}).text('หมายเหตุ') );

			$note.append( $('<td>', {class: 'data'})
				.append( $('<a>', {class: 'control' ,'data-control':'change', 'data-type':'note'}).append( 
					  $('<span>').text( '+ เพิ่ม ' )  
					, $('<i>', {class: 'icon-pencil'})
				) )
			);


			var $box = $('<li>', {'data-id': data.id, 'data-item': 1 }).append(
				$date, $wrap.html( $table.append( $masseuse, $room, $time, $price, $note ) )
				// $('<td>', {class: 'actions'}).html( '<span class="gbtn"><a class="btn btn-no-padding js-remove-time" data-control="click" data-type="remove_item"><i class="icon-remove"></i></a></span>' )
			);

			$box.data( data );
			return $box;
		},
		refreshItemDetail: function (index, data) {
			var self = this;

			var $box = self.$elem.find('[data-global=detail]');
			var $listsbox = $box.find('[role=listsbox]');

			$listsbox.find('[data-item]').eq( index ).replaceWith( self.itemDetail( data ) );
		},
		removeItemDetail: function (index, data) {
			var self = this;

			var $box = self.$elem.find('[data-global=detail]');
			var $listsbox = $box.find('[role=listsbox]');

			$listsbox.find('[data-item]').eq( index ).remove();

			var detail = [];
			$.each( self.currOrder.items[data.parent_KEY].detail, function (i, obj) {

				if( i!=index ){
					detail.push( obj );
				}
			} );

			self.currOrder.items[data.parent_KEY].detail = detail;
			if( self.currOrder.items[data.parent_KEY].detail.length==0 ){

				self.removeItemBill( data.parent_KEY );
			}
			else{
				self.currOrder.items[data.parent_KEY].qty -= 1;
				// self.updateItemBill( self.currOrder.items[data.parent_KEY] );
			}

			// console.log( self.currOrder.items[data.parent_KEY] );

			self.checkPromotion();
			self.resizeBill();

			self.summaryPrice(); 
			self.summaryDisplay();

			if( detail.length > 0 ){
				$.each( self.currOrder.items[data.parent_KEY].detail, function (i, obj) {
					self.refreshItemDetail( i, obj );
				});
			}
		},
		summaryPriceDetail: function () {
			var self = this;
			
			for (var key in self.currOrder.items) {
				var item = self.currOrder.items[key];

				var total = 0, discount = 0, balance = 0;

				$.each( item.detail, function (i, obj) {
					discount += obj.discount;
					total += obj.total;
					balance += obj.balance;
				} );

				self.currOrder.items[key].discount = discount;
				self.currOrder.items[key].total = total;
				self.currOrder.items[key].balance = balance;
			}
		},

		setAnchorMasseuse: function (data) {
			
			var $anchor = $('<div>', {class: 'anchor clearfix'});

			var $avatar = $('<div>', {class: 'avatar lfloat mrm'});

			if( data.image_url ){
				$avatar.html( $('<img>', {src: data.image_url}) );
			}else if( data.icon ){
				$avatar.addClass('no-avatar').html( $('<div>', {class: 'initials'}).html( $('<i>').addClass('icon-'+data.icon  ) ) );
			}else if( data.icon_text ){
				$avatar.addClass('no-avatar').html( $('<div>', {class: 'initials', text: data.icon_text}) );
			}

			$anchor.append(
				  $avatar
				, $('<div>', {class: 'content'}).append(
					  $('<div>', {class: 'spacer'})
					, $('<div>', {class: 'massages'}).append(
						  $('<div>', {class: 'text'}).html( data.text )
						, $('<div>', {class: 'category fsm fcg'}).html( data.category )
					)
				)
			);

			return $anchor;
			// '<div class="anchor clearfix"><div class="avatar lfloat mrm no-avatar">

			// <div class="initials">1</div></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname"></div><span class="subname fsm"></span></div></div></div>'
		},
		summaryPrice: function () {
			var self = this;

			var a = [0,0,0];
			for (var obj in self.currOrder.items) {
				var data = self.currOrder.items[obj];

				data.cost = data.qty*data.price;
				data.balance = data.cost - data.discount;

				a[0] += data.cost;
				a[1] += data.discount;
			}

			self.currOrder.summary.total = a[0];
			self.currOrder.summary.discount = a[1];

			self.currOrder.summary.balance = (a[0] + self.currOrder.summary.drink + self.currOrder.summary.room_price) - a[1];
		},
		summaryDisplay: function () {
			var self = this;
			
			$.each( self.currOrder.summary, function (key, val) {
				self.$elem.find('[summary='+ key +']').text( PHP.number_format(val) );
			} );			
		},
		setMasseuse: function ( on ) {
			var self = this;

			var id = '';

	    	Dialog.load( Event.URL + 'orders/set_bill', {
	    		type: 'masseuse',
	    		date: PHP.dateJStoPHP( self.currOrder.date ) 
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

		// 
		lists: {
			init: function (options, elem, then, callback ) {
				var self = this;

				self.$elem = $elem;
				self.then = then;

				self.options = options;

				self.data = {
					date: PHP.dateJStoPHP( self.options.date )
				}

				if( !self.then.currOrder.id ){
					self.then.active( 'summary' );
				}

				// set Data
				self.setElem();
				self.Events();
				// self.then.active( 'invoice' );

				self.reload();

				callback( self );
			},
			setElem: function () {
				var self = this;

				self.$listsbox = self.$elem.find('.ui-list-orders');
				self.$listsbox.empty();	
			},
			Events: function () {
				var self = this;

				// lists
				self.$elem.find('.js-datepicker').datepicker({
					selectedDate: new Date( self.then.options.date ),
					onSelected: function ( date ) {
						
						self.then.options.date = new Date( date );
						self.data.date = PHP.dateJStoPHP( self.then.options.date );
						self.data.pager = 1;
						self.$listsbox.empty();

						self.refresh(800);
					}
				});

				self.$listsbox.delegate('[data-id]', 'click', function () {
					
					$(this).addClass('active').siblings().removeClass('active');

					var data = $(this).data();
					self.then.currInvoice = data;
					self.then.active('invoice');
				});
			},

			reload: function () {
				var self = this;

				console.log('this lists');
				self.data.pager = 1;
				self.$listsbox.empty();
				self.refresh();
			},
			refresh: function (length) {
				var self = this;

				if( self.$listsbox.parent().hasClass('has-empty') ){
					self.$listsbox.parent().removeClass('has-empty');
				}
				self.$listsbox.parent().addClass('has-loading');

				setTimeout(function () {
					self.fetch().done(function( results ) {

						self.data = $.extend( {}, self.data, results.options );

						if( results.total==0 ){

							self.$listsbox.parent().addClass('has-empty');
							return false;
						}

						self.buildFrag( results.lists );
					});
				}, length || 1);
			},
			fetch: function(){
				var self = this;

				// console.log( 'dataLists', self.data );

				return $.ajax({
					url: Event.URL + 'orders/lists',
					data: self.data,
					dataType: 'json'
				}).always(function() {
					self.$listsbox.parent().removeClass('has-loading');
				}).fail(function() {
					self.$listsbox.parent().addClass('has-empty');
				});
			},
			buildFrag: function ( results ) {
				var self = this;

				var currTime = '';
				$.each(results, function (i, obj) {

					var time = new Date( obj.start_date );
					time_str = time.getHours();

					if( currTime != time_str ){
						currTime = time_str;
						// self.$listsbox.append( $('<li>', {class:'ui-item head', text: currTime + ':00'  }) );
					}

					self.display( obj );
				});
			},
			display: function ( data ) {
				var self = this;

				var item = self.setItem( data );
				self.$listsbox.append( item );
			},

			updateItem: function (data, active) {
				var self = this;

				var box = self.then.$elem.find('[data-global=lists]');
				

				box.find('[data-id='+ data.id +']').replaceWith( self.setItem(data) );

				if( active ){
					box.find('[data-id='+ data.id +']').addClass('active').siblings().removeClass('active');
				}

			},

			setItem: function (data) {
				var self = this;

				var date = new Date( data.start_date );
				var date_str = date.getHours() + ":" + date.getMinutes();

				var $inner = $('<div>', {class: "ui-item-inner clearfix"});
				var $li = $('<li>', {'data-id': data.id, class: "ui-item"}).append( $inner );

				var $avatar = $('<div>', {class: 'avatar lfloat mrm'});

				if( data.image_url ){
					$avatar.html( $('<img>', {src: data.image_url}) );
				}else if( data.icon ){
					$avatar.addClass('no-avatar').html( $('<div>', {class: 'initials'}).html( $('<i>').addClass('icon-'+data.icon  ) ) );
				}else if( data.icon_text ){
					$avatar.addClass('no-avatar').html( $('<div>', {class: 'initials', text: data.icon_text}) );
				}
				else{
					$avatar.addClass('no-avatar').html( $('<div>', {class: 'initials'}).html( $('<i>').addClass('icon-user'  ) ) );
				}


				var pack = {};
				$.each( data.items, function (i, item) {

					if( !pack[ item.pack.id ] ){
						pack[ item.pack.id ] = {
							name: item.pack.name,
							masseuse: item.masseuse,
							qty: 0,
							unit: item.unit,
							time: item.time
						};	
					}
					
					pack[ item.pack.id ].qty++;
				} );

				var $desc = $('<div>');
				var n = 0;
				for (var i in pack) {
					n++;
					var item = pack[i];

					var $masseuse = '';

					if( item.masseuse.length>0 ){
						$masseuse = $('<span>');
						$.each( item.masseuse, function (j, val) {
							$masseuse.append( $('<span>', {class: 'ui-status', text: val.icon_text}) );
						} );
					}

					if( n > 1 ){
						$desc.append( ', ' );
					}

					$desc.append( $('<span>').append($masseuse, $('<span>').text( item.name ) ) )
				}

				var $text = $('<div>', {class: 'text mbs fwb'});
				$text.append( $('<span>', {class: 'text'}).append(
					'ลำดับ', ' ', data.number_str
				) );

				$text.append( self.then.setStatus( data.status ) );

				$inner.append(

					''
					// , $avatar
					, $text
					, $desc

					// '<div class="rfloat">

					// <abbr class="timestamp fsm">'+date_str+'</abbr></div>'+
					
					// '<div class="text">' +
					// 	'<span><label>No.</label> <strong>' + data.number + '</strong></span>' +
					// 	// '<span><i class="icon-address-card-o"></i>ภุชงค์</span>' +
					// '</div>' +
					
					// '<div class="subtext clearfix">' +
					// 	// '<span><label>Package:</label> AKASURI, SAUNA</span>' +
						
					// '</div>' +

					// '<div class="subtext clearfix">' +
					// 	'<span><label>Time:</label> 10.00 - 11.00 PM</span>' +

					// 	'<div class="rfloat"><span class="ui-status">'+ data.status +'</span></div>' +
					// '</div>'

				);

				$li.data( data );
				return $li;
			},
		},

		invoice: {
			init: function (options, $elem, then, callback ) {
				var self = this;
				self.$elem = $elem;
				self.then = then;

				self.$listsbox = self.$elem.find('[role=orderlists]');

				self.resize();
				$(window).resize(function () {
					self.resize();
				});

				self.reload();
				self.Events();

				callback( self );
			},
			resize: function () {
				var self = this;

				var fw = $(window).width(),
					fh = $(window).height();

				// set Slip

				self.$elem.find('.slipPaper-main').css({
					bottom: self.$elem.find('.slipPaper-footer').outerHeight(),
				});

				self.$elem.find('.slipPaper-bodyContent').css({
					top: self.$elem.find('.slipPaper-bodyHeader').outerHeight() + 30,
					bottom: self.$elem.find('.slipPaper-bodyFooter').outerHeight(),
				});

				self.$elem.find('.slipPaper-bodyContent-body').css({
					top: self.$elem.find('.slipPaper-bodyContent-header').outerHeight()
				});
			},
			reload: function () {
				var self = this;

				self.refresh();
			},
			refresh: function () {
				var self = this;

				if( self.$elem.hasClass('has-empty') ){
					self.$elem.removeClass('has-empty');
				}
				self.$elem.addClass('has-loading');

				setTimeout(function () {
					self.fetch().done(function( results ) {
						self.display( results );
					});
				}, length || 1);	
			},
			fetch: function(){
				var self = this;

				return $.ajax({
					url: Event.URL + 'orders/get/' + self.then.currInvoice.id,
					data: {},
					dataType: 'json'
				}).always(function() {
					self.$elem.removeClass('has-loading');
				}).fail(function() {
					self.$elem.addClass('has-empty');
				});
			},
			display: function ( orderData ) {
				var self = this;

				self.data = {
					id: orderData.id,
					summary: {
						total: parseInt( orderData.total ),
						discount: parseInt( orderData.discount ),
						drink: parseInt( orderData.drink ),
						balance: parseInt( orderData.balance ),
						room_price: parseInt( orderData.room_price ),
					},

					number: orderData.number,
					status: orderData.status
				};

				$.each( self.data.summary, function (key, val) {
					self.$elem.find( '[summary='+ key +']' ).text( PHP.number_format( val ) );
				} );

				self.$elem.find( '[data-invoice=number]' ).text( orderData.number );
				self.$elem.find( '[data-invoice=status]' ).text( orderData.status );

				self.$listsbox.empty();
				self.data.items = {};
				self.sumItem( orderData.items );

				for (var i in self.data.items) {
					var obj = self.data.items[i];

					// console.log( obj );
					self.$listsbox.append( self.setItem( obj ) ); 
				}
			},

			sumItem: function ( fdata ) {
				var self = this;

				var no = 0;
				$.each( fdata, function (i, data) {
					no++;

					var KEY = data.id;

					if( !self.data.items[ KEY ] ){
						self.data.items[ KEY ] = {
							qty: 0,
							no: no,
							name: data.pack.name,
							time: data.pack.time,
							unit: data.pack.unit,
							status: data.status,
							has_masseuse: parseInt(data.pack.has_masseuse),

							masseuse: {},

							price: parseInt( data.price ),

							discount: 0,
							balance: 0,
							total: 0,

							detail: [],
						}
					}

					self.data.items[ KEY ].total += parseInt( data.total );
					self.data.items[ KEY ].discount += parseInt( data.discount );
					self.data.items[ KEY ].balance += parseInt( data.balance );
					self.data.items[ KEY ].qty ++;

					self.data.items[ KEY ].detail.push({
						unit: data.pack.unit,
						status: data.status,

						masseuse: data.masseuse,

						price: parseInt( data.price ),

						discount: parseInt( data.discount ),
						balance: parseInt( data.balance ),
						total: parseInt( data.total ),
					});

					if( data.masseuse ){

						$.each(data.masseuse, function (i, obj) {
							self.data.items[ KEY ].masseuse[obj.id] = obj;
						});
						
					}

				} );
			},
			setItem: function ( data ) {
				var self = this;

				var cost = data.qty * data.price;
				var total = cost - data.discount;

				var $price = $('<td>', {class: 'price'}).append(
					  $('<div>', {class: 'cost'}).text( PHP.number_format( cost ) )
					, $('<div>', {class: 'discount'}).append( '-', PHP.number_format(data.discount) )
					, $('<div>', {class: 'total'}).text( PHP.number_format( total ) )
				);

				$price.toggleClass('has-discount', data.discount>0);
				
				var $meta = $('<div>', {class: 'order-title fsm'});

				if( Object.keys(data.masseuse).length>0 && data.has_masseuse==1 ){

					var $masseuse = $('<ul>');
					for (var i in data.masseuse) {
						var obj = data.masseuse[i];

						// console.log( obj );

						$masseuse.append( $( '<li>' ).append(
							$('<span>', {class: 'ui-status mrs'}).text( obj.icon_text ), obj.text 
						) );
					};
					$meta.append( $masseuse );
				}

				$status = self.then.setStatus( data.status ); // $('<div>', {class: 'ui-status', 'data-status': data.status, text: data.status});

				var qty = data.time*data.qty, unit = data.unit;
				if( unit=='minute' && qty >=60 ){
					unit = 'hour';

					var hour = parseInt( qty / 60);
					var minute = qty - (hour*60);
					qty = minute>0
						? hour + '.' + minute
						: hour;
				}

				var $tr = $('<tr>', {'data-id': data.id}).append( 

					  $('<td>', {class: 'no'}).text( data.no+'.' )
					, $('<td>', {class: 'name'}).append( 
						  $('<div>', {class: 'title fwb'}).text( data.name )
						, $meta
					)
					, $('<td>', {class: 'status'}).html( $status )
					, $('<td>', {class: 'qty'}).text( qty )
					, $('<td>', {class: 'unit'}).text( unit )
					, $price
				);

				$tr.data( data );
				return $tr;
			},

			Events: function () {
				var self = this;

				self.$elem.find('[data-invoice-action]').click( function () {
					var type = $(this).attr('data-invoice-action');

					if(type == 'edit'){

						// self.thencurrOrder = self.then.currInvoice
						self.then.active( 'bill' );
					}
					else if( type == 'remove' ){
						self.remove();
					}
					else if( type == 'pay' ){
						self.pay();
					}

				} );
				
			},

			pay: function () {
				var self = this;

				Dialog.load( Event.URL+'orders/pay/'+ self.data.id, {}, {
					onOpen: function ($d) {

						var $form = $d.$pop.find('form');

						$form.submit( function (e) {
							
							e.preventDefault();

							self._submit( $form );
						} );
					},
					onSubmit: function ( $d ) {
						var $form = $d.$pop.find('form');

						self._submit( $form );				
					}

				} );
			},
			_submit: function ($form) {
				var self = this;

				Event.inlineSubmit( $form ).done(function( result ) {

					result.url = '';
					console.log( result );

					self.then.active('invoice');
					// self.then.active( 'summary' );
					// self.then
					
					Event.processForm($form, result);
						
					if( result.error ){
						return false;
					}

					Dialog.close();

					if( result.data ){
						self.then.global['lists'].updateItem( result.data, true );
					}
					
				});
			},
			
			remove: function () {
				var self = this;

				Dialog.load( Event.URL+'orders/del/'+ self.data.id, {}, {

					onSubmit: function ( $d ) {

						var $form = $d.$pop.find('form');
						// e.preventDefault();

						Event.inlineSubmit( $form ).done(function( result ) {

							result.url = '';

							self.then.active( 'summary' );
							// self.then
							
							Event.processForm($form, result);
							Dialog.close();

							self.then.$elem.find('[data-global=lists]').find('[data-id='+ self.data.id +']').remove();
							// self.then.active( 'lists' );
						});

						
					}
				} );
			}
		},

		setOrderDefault: function ( date ) {
			var self = this;

			self.$elem.find('[data-global=bill]').find('[role=orderlists]').empty();
			self.$elem.find('[data-global=menu]').find('[role=menu] .active').removeClass('active');
			
			return {
				date: date ? new Date(date): new Date(),
				summary: {
					tip: 0,
					total: 0,
					balance: 0,
					change: 0,
					drink: 0,
					discount: 0,
					pay: 0,
					room_price: 0,
				},

				items: [],
			};
		},

		setStatus: function ( status ) {
			
			var color = '';
			if( status=='run' || status=='order' ){
				status = 'กำลังบริการ';
				color = '#1a8aca';
			}

			if( status=='paid' ){
				status = 'ชำระแล้ว';
				color = '#7b2';
			}
			return $('<span>', {class: 'ui-status'}).css('background', color).text( status );		 	
		},

		bill: {
			init: function (options, $elem, then, callback ) {
				var self = this;
				self.then = then;

				console.log( 'this bill' );
				// set Data

				// console.log( self.then.currOrder );
				
				self.then.currMasseuse = null;
				self.options = options;

				// set Elem 
				self.$elem = $elem;

				// get Data
				self.reload();

				// 
				self.resize();
				$(window).resize(function () {
					self.resize();
				});

				callback( self );
			},

			reload: function () {
				var self = this;

				// console.log( 'currInvoice', self.then.currInvoice, self.then.currOrder );

				self.then.currOrder = self.then.setOrderDefault( self.then.options.date  );
				
				if( self.then.currInvoice ){
					self.then.currOrder.id = self.then.currInvoice.id;
					self.then.currOrder.number = parseInt(self.then.currInvoice.number);
					self.then.currOrder.status = self.then.currInvoice.status;
					self.setNumber( parseInt(self.then.currInvoice.number) );

					var res = self.then.currInvoice.date.split('-');
					self.then.currOrder.date = new Date( res[0], res[1]-1, res[2] );

					self.then.currOrder.summary.drink = parseInt(self.then.currInvoice.drink);
					self.then.currOrder.summary.pay = parseInt(self.then.currInvoice.pay );
					self.then.currOrder.summary.room_price = parseInt(self.then.currInvoice.room_price);
					self.then.currOrder.summary.tip =  parseInt(self.then.currInvoice.tip);

					$.each(self.then.currInvoice.items,function (i, data) {
						
						// console.log( '__loadMenu', data );
						self.then.loadMenu( {
							item_id: data.id,
							has_masseuse: data.pack.has_masseuse,						
							id: data.pack.id,
							time: data.pack.time,
							name: data.pack.name,
							unit: data.pack.unit,

							masseuse: data.masseuse,

							// qty: 1
							qty: parseInt( data.pack.time ),
							price:  parseInt( data.price),
							discount:  parseInt( data.discount),
							balance:  parseInt( data.discount),

							start_date: data.start_date,
							end_date: data.end_date,

							status: data.status
							// room_id
						}, true );
					} );
				}

				var $date = $('<input>', {type: 'date'}).val( PHP.dateJStoPHP(self.then.currOrder.date) );

				self.$elem.find('[data-bill=date]').html( $date );
				$date.datepicker({
					selectedDate: new Date( self.then.options.date ),
					lang: self.options.lang,
					onSelected: function ( date ) {
						
						self.then.currOrder.date = new Date( date );
						self.getNumber();
					}
				});

				if( self.then.currOrder.number ){
					self.then.active( 'menu' );
				}
				else{
					self.getNumber( function () {
						self.then.active( 'menu' );

						self.summaryPrice();
						self.summaryDisplay();
					} );
				}

			},

			getNumber: function ( callback ) {
				var self = this;

				self.$elem.addClass('has-loading');

				$.get( Event.URL + 'orders/lastNumber', {date: PHP.dateJStoPHP( self.then.currOrder.date ) }, function (number) {

					self.setNumber(parseInt( number ), callback);

				}, 'json');
			},
			setNumber: function (number, callback) {
				var self = this;

				if( number < 10 ){
					number = '00'+number;
				}else if( number < 100 ){
					number = '0'+number;
				}
				
				self.then.currOrder.number = number;

				self.$elem.removeClass('has-loading');
				self.$elem.find('[data-bill=number]').text( number );

				if( typeof callback === 'function' ){
					callback();
				}
			},
			resize: function () {
				var self = this;

				var fw = $(window).width(),
					fh = $(window).height();

				// set Slip

				self.$elem.find('.slipPaper-main').css({
					bottom: self.$elem.find('.slipPaper-footer').outerHeight(),
				});

				self.$elem.find('.slipPaper-bodyContent').css({
					top: self.$elem.find('.slipPaper-bodyHeader').outerHeight() + 30,
					bottom: self.$elem.find('.slipPaper-bodyFooter').outerHeight(),
				});


				self.$elem.find('.slipPaper-bodyContent-body').css({
					top: self.$elem.find('.slipPaper-bodyContent-header').outerHeight()
				});
			},

			summaryPrice: function () {
				var self = this;

				var a = [0,0,0];
				for (var obj in self.then.currOrder.items) {
					var data = self.then.currOrder.items[obj];

					data.cost = data.qty*data.price;
					data.balance = data.cost - data.discount;

					a[0] += data.cost;
					a[1] += data.discount;
				}

				self.then.currOrder.summary.total = a[0];
				self.then.currOrder.summary.discount = a[1];

				self.then.currOrder.summary.balance = (a[0] + self.then.currOrder.summary.drink) - a[1];
			},
			summaryDisplay: function () {
				var self = this;
				
				// 
				$.each( self.then.currOrder.summary, function (key, val) {
					self.$elem.find('[summary='+ key +']').text( PHP.number_format(val) );
				} );			
			},
		},

		menu: {
			init: function (options, $elem, then, callback ) {
				var self = this;

				console.log( 'This menu' );
				// set Elem 
				self.$elem = $elem;
				// self.$listsbox = self.$elem.find('[ref=listsbox]');

				self.data = {
					type: self.$elem.find('.memu-tab > a.active').data('type')
				};


				// 
				then.$elem.find('[data-global=bill]').find('[role=orderlists] > tr.active').removeClass('active');

				self.active();
				// self.refresh();

				// Event
				self.$elem.find('.memu-tab > a').click(function () {
					$(this).addClass('active').siblings().removeClass('active');

					self.data = {
						type: $(this).data('type')
					}

					self.active();
					// self.refresh( );
				});
				
			},
			active: function () {
				var self = this;

				var $el = self.$elem.find('[data-memu='+ self.data.type +']');

				$el.addClass('active').siblings().removeClass('active');

				$el.parent().scrollTop(0);
			},

			refresh: function (length) {
				var self = this;

				if( self.$listsbox.parent().hasClass('has-empty') ){
					self.$listsbox.parent().removeClass('has-empty');
				}
				self.$listsbox.parent().addClass('has-loading');

				setTimeout(function () {
					self.fetch().done(function( results ) {

						self.data = $.extend( {}, self.data, results.options );

						if( results.total==0 ){
							self.$listsbox.parent().addClass('has-empty');
							return false;
						}

						self.buildFrag( results.lists );
					});
				}, length || 1);
			},
			fetch: function(){
				var self = this;

				return $.ajax({
					url: Event.URL + 'orders/menu',
					data: self.data,
					dataType: 'json'
				}).always(function() {
					self.$listsbox.parent().removeClass('has-loading');
				}).fail(function() {
					self.$listsbox.parent().addClass('has-empty');
				});
			},
			buildFrag: function ( results ) {
				var self = this;

				$.each(results, function (i, obj) {
					self.display( obj );
				});
			},
			display: function ( data ) {
				var self = this;

				var item = self.setItem( data );

				self.$listsbox.append( item );
			},
			setItem: function () {	
			}
		},

		detail: {
			init: function (options, $elem, then, callback ) {
				var self = this;

				self.$elem = $elem;

			}
		},

		pay: {
			init: function (options, $elem, then, callback ) {
				var self = this;
				self.$elem = $elem;

				console.log( 'This Pay' );
			},
		},

		summary: {
			init: function (options, $elem, then, callback ) {
				var self = this;
				self.$elem = $elem;
				self.then = then;
				self.options = options;

				callback( self );

				self.setElem();
				// self.Events();

				self.reload();
			},

			reload: function () {
				var self = this;

				
				var $date = $('<input>', {type: 'date'});

				self.$elem.find('[data-summary=date]').html( $date );
				$date.datepicker({
					selectedDate: new Date( self.then.options.date ),
					lang: self.options.lang,
					onSelected: function ( date ) {

						self.then.options.date = new Date( date );
						self.reload();
					}
				});

				self.refresh();
			},

			setElem: function () {
				var self = this;

			},

			refresh: function () {
				var self = this;
				
				$.get( Event.URL + 'orders/summary', {date: PHP.dateJStoPHP(self.then.options.date)}, function (res) {
					
					self.$elem.find('[data-content=summary]').html( res );
				} );
			}
		}
	}

	$.fn.order = function( options ) {
		return this.each(function() {
			var $this = Object.create( Order );
			$this.init( options, this );
			$.data( this, 'order', $this );
		});
	};
	$.fn.order.options = {
		lang: 'en',
		// date: new Date(),
		promotions: []
	};

	/**/
	/* JopQueue */
	/**/
	var JopQueue = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $(elem);
			self.options = $.extend( {}, $.fn.jopQueue.options, options );

			self.$listsbox = self.$elem.find('[ref=listsbox]');

			self.$listsbox.sortable({
				stop: function (event, ui) {
					self.set_sequence();			
				}
			});
		},

		set_sequence: function () {
			var self = this;

			var n = 0;
			var items = [];
			$.each(self.$listsbox.find('li'), function (i, obj) {
				n++;

				items.push( $( this ).data('id') );
				// $( obj ).find('.number').text( n )
			});
			

			$.post( Event.URL + 'masseuse/sort_job', { items:items });
		}
	}
	$.fn.jopQueue = function( options ) {
		return this.each(function() {
			var $this = Object.create( JopQueue );
			$this.init( options, this );
			$.data( this, 'jopQueue', $this );
		});
	};
	$.fn.jopQueue.options = {
		lang: 'en'
	};


	/**/
	/* chooseRooms */
	/**/
	var ChooseRooms = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $(elem);

			self.$floor = self.$elem.find(':input[data-name=floor]');
			self.$room = self.$elem.find(':input[data-name=room]');
			self.$bed = self.$elem.find(':input[data-name=bed]');

			self.changeFloor( self.$floor.val() );
			self.$floor.change( function () {
				self.changeFloor( $(this).val() );
			} );
			
			self.$room.change( function () {
				self.changeRoom( $(this).val() );
			} );

			self.$bed.change( function () {
				self.changeBed( $(this).val() );
			} );
			
		},

		changeFloor: function (val) {
			var self = this;

			self.$floor.attr('data-label', self.$floor.find(':checked').text() );

			$.get( Event.URL + 'rooms/lists', {floor: val}, function (res) {

				self.$room.empty(); 
				$.each( res, function (i, obj) {
					self.$room.append( $('<option>', {value: obj.id, text: obj.name}) );
				} );

				self.changeRoom( self.$room.val() );
			}, 'json');
		},

		changeRoom: function (val) {
			var self = this;

			self.$room.attr('data-label', self.$room.find(':checked').text() );
			$.get( Event.URL + 'rooms/beds', {room: val}, function (res) {
				

				self.$bed.empty(); 
				$.each( res, function (i, obj) {
					self.$bed.append( $('<option>', {value: obj.id, text: obj.name}) );
				} );

				self.changeBed( self.$bed.val() );
			}, 'json');
		},
		changeBed: function () {
			var self = this;

			self.$bed.attr('data-label', self.$bed.find(':checked').text() );
		}
	}	
	$.fn.chooseRooms = function( options ) {
		return this.each(function() {
			var $this = Object.create( ChooseRooms );
			$this.init( options,this );
			$.data( this, 'chooseRooms', $this );
		});
	};
	

})( jQuery, window, document );


function RefClock($el, lang) {

	var self = this;
	var theDate = new Date();

	var ampm = 'AM';
	var hour = theDate.getHours();

	if( lang=='th' ){
		ampm = '';
	}else{
		if( hour > 12 ){
			hour -= 12;
			ampm = 'PM';
		}

		if( hour==0 ){
			hour = 12;
		}
	}

	var minute = theDate.getMinutes();
	minute = minute<10 ? '0'+minute:minute;

	var second = theDate.getSeconds();
	second = second<10 ? '0'+second:second;

	var time = $.trim( hour + ':' + minute + ':' + second + ' ' + ampm );
	var date = Datelang.day(theDate.getDay(),'normal',lang) +', '+ theDate.getDate()+' '+ Datelang.month( theDate.getMonth(),'normal',lang) + ', '+ theDate.getFullYear();

	$el.find('.time').html( time );
	$el.find('.date').html( date );

	// document.getElementById('clockTime').innerHTML = time; 
	// document.getElementById('clockDate').innerHTML = date; 

	var t = setTimeout(function () {
		RefClock($el, lang)
	}, 500);
}

$(function () {

	// var elem = $(window)[0]; // Make the body go full screen.
	// toggleFullScreen();

	$('.js-navigation-trigger').click(function () {

		var $page = $('#doc');

		if( !$('body').hasClass('is-pushed-left') ){

			var scroll = $(window).scrollTop()*-1;
			$page.addClass('fixed_elem').css('top', scroll);

			setTimeout(function () {
				$('body').addClass('is-pushed-left');
			},200);
		}
		else{
			
			var scroll = parseInt( $page.css("top"));
				scroll = scroll<0 ? scroll*-1:scroll;

			$('body').removeClass('is-pushed-left');

			$page.removeClass('fixed_elem').css('top', "");
			$(window).scrollTop( scroll );

		}
	});

	RefClock( $('.headerClock'), $('html').attr('lang') );
	// 

	$('.js-global-actions>[data-global-action]').click(function (e) {
		if( $(this).hasClass('active') && $(window).width() <= 1300 ){
			e.stopPropagation();
			e.preventDefault();
			$(this).parent().addClass('active');
		}
	});

	$(window).click(function () {
		if( $('.js-global-actions').hasClass('active') ){
			$('.js-global-actions').removeClass('active');
		}
	});

});


