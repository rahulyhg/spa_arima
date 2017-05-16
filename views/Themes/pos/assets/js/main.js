
// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {


	var Order = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.order.options, options );

			// set Elem
			self.$elem = $(elem);
			self.setElem();

			// set data 
			self._queueMenu = [];
			self.currOrder = self.setOrderDefault();

			self.Events();

			self.active( 'bill' );
			// self.active( 'detail' );
		},
		setElem: function () {
			var self = this;

			$.each( self.$elem.find('[data-global]'), function () {
				self[ '$e_'+ $(this).attr('data-global') ] = $(this);
			} );			
		},

		Events: function() {
			var self = this;

			/*self.$e_lists.delegate('[data-id]', 'click', function () {
				
				$(this).addClass('active').siblings().removeClass('active');

				self.active( 'invoice' );
			});*/

			self.$elem.delegate('[data-global-action]', 'click', function () {
				self.active( $(this).attr('data-global-action') );
			});

			// lists
			self.$elem.find('[data-global=lists]').find('.js-datepicker').datepicker({
					onChange: function () {

						console.log( this );
						self.data.date = new Date( this.selectedDate );
					}
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

					if( self.currOrder.id ){
						console.log( 'delete', self.order );
					}
					else{
						self.active( 'lists' );
						self.active( 'summary' );
					}

				}
			});


			/* Detail */
			self.$elem.find('[data-global=detail]').find('.js-add-time').click(function () {
				
				self.chooseMenu( 'package', self.currMenu.id, function () {
					
					self.setDetail( self.currMenu );

					self.$elem.find('[data-global=bill]').find('[role=orderlists] > tr[data-id='+ self.currMenu.id +']').addClass('active');
				} );
			});
			/*self.$elem.find('[data-global=detail]').delegate('.js-remove-time', 'click', function () {
				console.log( 1 );
			});*/
			self.$elem.find('[data-global=detail]').delegate('[data-control]', 'click', function () {

				var box = $(this).closest('[data-item]');
				var index = box.index();
				var fdata = box.data();

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

				Dialog.load( Event.URL + 'orders/set_bill', data, {
		    		onSubmit: function ( $el ) {
		    			
		    			var $form = $el.$pop.find('form');
		    			if( type=='masseuse' ){
		    				var id = $form.find('[ref=tokenbox]>[data-id]').data('id');

		    				if(id){
		    					$.get( Event.URL + 'masseuse/get/'+id, function( res ) {
	    							
		    						fdata.masseuse = res;
	    							self.currOrder.items[fdata.parent_KEY].detail[index]=fdata;

	    							self.refreshItemDetail( index, fdata );
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


		    				self.currOrder.items[fdata.parent_KEY].detail[index]=fdata;

		    				self.refreshItemDetail( index, fdata );
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

		saveBill: function ( a ) {
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
							};

							if(detail.masseuse){
								d.masseuse_id = detail.masseuse.id;
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
			$.post( Event.URL + 'orders/save', dataPost, function (res) {
				
				/*self.currOrder.id = res.id;
				self.currOrder.status = res.status;*/
				console.log( res );
			}, 'json');	
		},

		active: function ( val ) {
			var self = this;

			var el = self.$elem.find('[data-global='+ val +']');
			if( el.hasClass('active') ) return false;

			el.addClass('active').siblings().removeClass('active');
			self[ val ].init( self.options, el, self, function () {
				
			} );
		},

		chooseMenu: function ( type, id, callback) {
			var self = this;

			$.get(Event.URL + 'orders/menu/', { type: type, id: id }, function (res) {

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

			var KEY = data.id;
			data.has_masseuse = parseInt(data.has_masseuse);

			if( !self.currOrder.items[ KEY ] ){

				var fdata = {
					KEY: KEY,
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

				self.currOrder.items[ KEY ] = fdata;

				self.newItemBill(fdata);
			}
			else{

				if( self.currOrder.items[ KEY ].detail[0].masseuse ){
					data.masseuse = self.currOrder.items[ KEY ].detail[0].masseuse;
				}

				if( self.currOrder.items[ KEY ].detail[0].floor ){
					data.floor = self.currOrder.items[ KEY ].detail[0].floor;
				}
				
				if( self.currOrder.items[ KEY ].detail[0].room ){
					data.room = self.currOrder.items[ KEY ].detail[0].room;
				}

				if( self.currOrder.items[ KEY ].detail[0].bed ){
					data.bed = self.currOrder.items[ KEY ].detail[0].bed;
				}
			}

			self.currOrder.items[ KEY ].qty++;

			var length = self.currOrder.items[ KEY ].detail.length;
			var Detail = {
				parent_KEY: KEY,
				has_masseuse: data.has_masseuse,
				
				unit: data.unit,

				total: parseInt( data.price ),
				discount: 0,
				balance: 0,

				status: 'order',

				start_date: new Date(),
			};

			if( data.has_masseuse==1 && data.masseuse ){
				Detail.masseuse = data.masseuse;
			}

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

						self.currOrder.items[ KEY ].detail[length].masseuse = data;
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

			// self.setChange( res );
			// console.log( self.currOrder );
			self.checkPromotion();
			self.resizeBill();

			self.summaryPrice(); 
			self.summaryDisplay();
		},

		checkPromotion: function () {
			var self = this;

			// console.log( self.currOrder.items );
			var qty = 0;
			for (var obj in self.currOrder.items) {

				var data = self.currOrder.items[obj];

				// if( data.price==350 ){
				qty += data.qty;
				// }
			}

			
			for (var obj in self.currOrder.items) {

				var data = self.currOrder.items[obj];
				var deduct = 0;

				// 1. ราคาสินราคา 350 ลด 50 หากซื้อมากว่า 1 รายการ 
				if( data.total==350 && qty>1 ){
					deduct = 50;
				}

				var discount = data.qty*deduct;
				self.currOrder.items[obj].discount = discount;
				self.currOrder.items[obj].balance = (data.total*qty) - discount;

				$.each( self.currOrder.items[obj].detail, function (i) {
					self.currOrder.items[obj].detail[i].discount = deduct;
					self.currOrder.items[obj].detail[i].balance = data.total-deduct;
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

			// console.log( data );

			var cost = data.qty * data.total;
			var total = cost - data.discount;

			var $price = $('<td>', {class: 'price'}).append(
				  $('<div>', {class: 'cost'}).text( PHP.number_format( cost ) )
				, $('<div>', {class: 'discount'}).append( '-', PHP.number_format(data.discount) )
				, $('<div>', {class: 'total'}).text( PHP.number_format( total ) )
			);

			$price.toggleClass('has-discount', data.discount>0);
			
			var $meta = $('<div>', {class: 'order-title fsm'});

			if( data.masseuse_name ){
				$meta.append( $('<label>', {text: 'Masseuse:'}), data.masseuse_name );
			}

			if( data.room_name ){
				$meta.append( $('<label>', {text: 'Room:'}), data.room_name );
			}

			if( data.bed_name ){
				$meta.append( $('<label>', {text: 'Bed:'}), data.bed_name );
			}

			$status = $('<div>', {class: 'ui-status', 'data-status': data.status, text: data.status});

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

			var $date = $('<div>', {class: 'date'}).append(
				  $('<div>', {class: 'number'}).text( data.no )
				, $('<div>', {class: 'text-date'}).append(
					  ''
					, $('<span>', {class: ''}).text( '1 '+ data.unit)
					, $('<span>', {class: 'ui-status'}).text( data.status )
					, $('<span>', {class: 'gbtn'}).append(
						$('<a>', {
							class: 'btn',
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
			$masseuse.append( $('<td>', {class: 'label'}).text('Masseuse') );

			if( data.has_masseuse==0 ){
			}else if( data.masseuse ){

				var img = '';
				if( data.masseuse.image_url ){
					img = $('<div>', {class: 'avatar lfloat mrs'}).html( $('<img>', {  src: data.masseuse.image_url }) );
				}

				console.log( data );

				masseuse_data = $('<a>', {
					class: 'control', 
					'data-control':'change', 
					'data-type':'masseuse'
				}).append( 
					
					$('<span>', { class: 'ui-status lfloat mrm', text: data.masseuse.icon_text }), 
					img , 
					$('<span>', { class: '', text: data.masseuse.text }) 
				);
			}
			else{
				masseuse_data = $('<a>', {
					class: 'control', 
					'data-control':'change', 
					'data-type':'masseuse'
				}).html( '+ Choose Masseuse' );
			}

			$masseuse.append( $('<td>', {class: 'data'}).html( masseuse_data ) );

			// Room 
			var $room = $('<tr>', {class: 'room'});
			var room_data = '';
			$room.append( $('<td>', {class: 'label'}).text('Room') );

			if( data.has_masseuse==0 ){
			}else if( data.room ){

				room_data = $('<a>', {
					class: 'control', 
					'data-control':'change', 
					'data-type':'masseuse'
				}).append( 
					  $('<span>', {class: ''}).text( 'Fl:'+ data.floor.name )
					, $('<span>', {class: ''}).text( ' / R:'+ data.room.name )
					, $('<span>', {class: ''}).text( ' / B:'+ data.bed.name )
					, $('<i>', {class: 'icon-pencil'})
				);
			}
			else{
				room_data = $('<a>', {
					class: 'control', 
					'data-control':'change', 
					'data-type':'room'
				}).html( '+ Choose Room' );
			}
			$room.append( $('<td>', {class: 'data'}).append( room_data ) );

			// Price
			var cost = data.price;
			var total = cost - data.discount;

			var $price = $('<tr>', {class: 'price'})
			$price.append( $('<td>', {class: 'label'}).text('Price') );

			$price.append( $('<td>', {class: 'data price'})
				.toggleClass('has-discount',  data.discount > 0)
				.html( $('<a>', {class: 'control'}).append(

					  $('<span>', {class: 'cost'}).text( PHP.number_format( cost ) )
					, $('<span>', {class: 'discount'}).append( '-', PHP.number_format(data.discount) )
					, $('<span>', {class: 'total'}).text( PHP.number_format( total ) )

					, $('<i>', {class: 'icon-pencil'})

				) )
			);

			// Time
			var $time ='';

			/*var $time = $('<tr>', {class: 'time'})
			$time.append( $('<td>', {class: 'label'}).text('Time') );
			$time.append( $('<td>', {class: 'data'})
				.append( 1, $('<span>', {class: 'mls'}).text(data.unit) )
			);*/

			// Status
			/*var $status = $('<tr>', {class: 'status'})
			$status.append( $('<td>', {class: 'label'}).text('Status') );
			$status.append( $('<td>', {class: 'data'})
				.append( $('<span>', {class: 'ui-status'}).text( data.status ) )
			);*/

			var $box = $('<li>', {'data-id': data.id, 'data-item': 1 }).append(
				$date, $wrap.html( $table.append( $masseuse, $room, $time, $price ) )
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

			self.currOrder.summary.balance = (a[0] + self.currOrder.summary.drink) - a[1];
		},
		summaryDisplay: function () {
			var self = this;
			
			// 
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
	    					
	    					on.done( res );
	    					Dialog.close();
	    				}, 'json');
	    			}
	    		}
	    	} );
		},

		lists: {
			init: function (options, elem, then, callback ) {
				var self = this;

				self.$elem = $elem;
				self.then = then;

				self.options = options;

				// set Data
				self.data = {
					date: self.options.date
				};


				self.setElem();
				// self.then.active( 'invoice' );

				self.refresh();
			},
			setElem: function () {
				var self = this;

				self.$listsbox = self.$elem.find('.ui-list-orders');
				self.$listsbox.empty();	
			},

			refresh: function () {
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

				/*$.get( Event.URL + 'orders/lists', {}, function (res) {
					
					$.each( res.lists, function (i, obj) {
						self.$listsbox.append( self.setItem( obj ) );
					} );
				}, 'json');*/
			},
			fetch: function(){
				var self = this;

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

					var time = new Date(  );

					self.display( obj );
				});


				/*if( self.$listsbox.find('li.active').length==0 && self.$listsbox.find('li').not('.head').first().length==1 ){
					self.active( self.$listsbox.find('li').not('.head').first() );
				}*/
			},
			display: function ( data ) {
				var self = this;

				var item = self.setItem( data );

				self.$listsbox.append( item );
			},

			setItem: function (data) {
				var self = this;

				$li = $('<li>');

				$('<li>', {class: "ui-item"}).append( ''+ 
				'<div class="ui-item-inner clearfix">'+
					'<div class="rfloat"><abbr class="timestamp fsm">9:25</abbr></div>'+
					
					'<div class="text">' +
						'<span><label>No.</label> <strong>1</strong></span>' +
						'<span><i class="icon-address-card-o"></i>ภุชงค์</span>' +
					'</div>' +
					
					'<div class="subtext clearfix">' +
						'<span><label>Package:</label> AKASURI, SAUNA</span>' +
						'<div class="rfloat"><span class="ui-status">RUN</span></div>' +
					'</div>' +

					'<div class="subtext clearfix">' +
						'<span><label>Total Time:</label> 10.00 - 11.00 PM</span>' +

					'</div>' +
				'</div>' );

				$li.data( data );
				return $li;
			}
		},

		invoice: {
			init: function (options, $elem, then, callback ) {
				var self = this;

				self.$elem = $elem;
				self.then = then;

				self.resize();
				$(window).resize(function () {
					self.resize();
				});
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
				},

				items: []
			};
		},

		bill: {
			init: function (options, $elem, then, callback ) {
				var self = this;
				self.then = then;

				// set Data
				self.then.currOrder = self.then.setOrderDefault();
				self.options = options;

				// set Elem 
				self.$elem = $elem;

				// get Data
				var $date = $('<input>', {type: 'date'}).val( PHP.dateJStoPHP(self.then.currOrder.date) );

				// Datelang.fulldate( self.then.currOrder.theDate, 'normal', self.options.lang )
				self.$elem.find('[data-bill=date]').html( $date );

				$date.datepicker({
					lang: self.options.lang,
					onSelected: function ( date ) {
						
						self.then.currOrder.date = new Date( date );
						self.getNumber();
					}
				});

				self.getNumber( function () {
					
					self.then.active( 'menu' );

					if( typeof callback === 'function' ){
						callback();
					}
				} );

				// 
				self.resize();
				$(window).resize(function () {
					self.resize();
				});
			},

			getNumber: function ( callback ) {
				var self = this;

				self.$elem.addClass('has-loading');

				$.get( Event.URL + 'orders/lastNumber', {date: PHP.dateJStoPHP( self.then.currOrder.date ) }, function (number) {
					self.then.currOrder.number = number;

					self.$elem.removeClass('has-loading');
					self.$elem.find('[data-bill=number]').text(number);

					if( typeof callback === 'function' ){
						callback();
					}

				}, 'json');
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
			}
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
		date: new Date(),
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

			var n = 0
			$.each(self.$listsbox.find('li'), function (i, obj) {
				n++;

				// $( obj ).find('.number').text( n )
			});
			
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


