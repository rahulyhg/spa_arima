// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var Orders = {
		init: function ( options, elem ) {
			var self = this;
			self.elem = elem;
			self.$elem = $( elem );

			self.options = $.extend( {}, $.fn.orders.options, options );

			// set Elem
			self.$listsbox = self.$elem.find('[role=listsbox]');
			self.$profile = self.$elem.find('[role=profile]');
			self.$content = self.$elem.find('.datalist-content');

			self.$profile.css({
				opacity: 0,
				left: '20%'
			});

			self.orders = [];
			self.data = {
				start: null,
				end: null,
				q: '',
			};
			if( self.options.from ){
				self.data.from = self.options.from;
			}

			self.$elem.find('.js-setDate').closedate({
				lang: 'en',
				options: [
					{
						text: 'Last',
						value: 'last',
					},
					{
						text: 'Today',
						value: 'daily',
					},
					{
						text: 'Yesterday',
						value: 'yesterday',
					},
					{
						text: 'This week',
						value: 'weekly',
					},
					{
						text: 'Last week',
						value: 'last1week',
					},
					{
						text: 'This month',
						value: 'monthly', 
					},
					{
						text: 'Last 7 days',
						value: 'last7days', // weekly
					},
					{
						text: 'Last 14 days',
						value: 'last14days',
					},
					{
						text: 'Last 28 days28',
						value: 'last28days',
					},
					{
						text: 'Last 90 days',
						value: 'last90days',
					},
					{
						text: 'Custom',
						value: 'custom',
					}
				],

				onChange: function (date) {
					
					self.data.start = date.startDateStr + ' 00:00:00';
					self.data.end = date.endDateStr + ' 23:59:59';

					if( date.activeIndex == 0 ){
						self.data.start = null;
						self.data.end = null;
					}

					self.refresh( 1 );
				}
			});

			self.$elem.find('.js-new').click(function () {

				if( $(this).hasClass('disabled') ){

					return false;
				}

				self.hide();
				self.$listsbox.find('li.active').removeClass('active');
				$(this).addClass('disabled');
				self.setNew();
			});
			
			$('body').find('.navigation-trigger').click(function(){
				self.reset();
			});

			$('body').find('select[role=selection]').change(function(){
				
				self.data[ $(this).attr('name') ] = $(this).val();
				self.refresh( 1 );
			});


			$('body').find('input[role=search]').keydown(function(e){
				var keyCode = e.which;

				var val = $.trim($(this).val());

				if( keyCode==13 && self.data.q!=val && val!='' ){

					$(this).val(val);
					self.data.q = val;
					self.refresh( 1 );
				}
			}).keyup(function(e){
				var val = $.trim($(this).val());

				if( self.data.q!=val && val=='' ){

					self.data.q = '';
					self.refresh( 1 );
				}
			});


			self.$listsbox.delegate('li', 'click', function() {
				self.active($(this));
			});


			self.setDate();
		},

		active: function ( $el ) {
			var self = this;

			if( $el.hasClass('head') || $el.hasClass('active') ){
				return false;
			}

			var data = $el.data();
			$el.addClass('active').siblings().removeClass('active');
			
			self.hide(function () {
			});
			
			var t = setTimeout(function () {
				self.$content.addClass('has-loading');
			}, 800);

			$.get( Event.URL + 'orders/profile/' + data.id,function ( elem ) {
				clearTimeout( t );
				self.$content.removeClass('has-loading');

				self.displayProfile( elem );
				self.$elem.find('.js-new').removeClass('disabled');
				
			});
		},

		hide: function ( callback ) {
			var self = this;

			self.$profile.stop().animate({
				left: '20%',
				opacity: 0
			}, 200, callback||function () {});
		},
		show: function ( callback ) {
			var self = this;

			self.$profile.stop().animate({
				left: 0,
				opacity: 1
			}, 200, callback||function () {});
			
		},

		displayProfile: function( el ) {
			var self = this;

			self.$profile.html( $(el) ).removeClass('hidden_elem');
			self.show(function () {
				
				self.$profile.find('.datalist-main-content').css({
					paddingTop: self.$profile.find('.datalist-main-header').outerHeight()
				}).removeClass('hidden_elem');
			});
		
		},
		reset: function(){
			var self = this;

			var offset = self.$profile.offset();
			self.$profile.find('.slipPaper-header').css('left', offset.left);
		},

		refresh: function (length) {
			var self = this;

			setTimeout(function () {
				self.fetch().done(function( results ) {

					self.data = $.extend( {}, self.data, results.options );

					// reset 
					self.orders = [];
					self.$listsbox.empty();
					self.$profile.addClass('hidden_elem');

					var total = results.total;
					// self.$elem.find('[view-text=total]').text( total ).closest('li').toggleClass('hidden_elem', total==0);
					self.$elem.find('[view-text=total]').text( total );


					if( results.total==0 ){
						return false;
					}
					self.buildFrag( results.lists );
					
					self.resize();
				});
				
			}, length || 1);
		},

		fetch: function(){
			var self = this;

			if( !self.data ) self.data = {};

			return $.ajax({
				url: Event.URL + 'orders/lists/',
				data: self.data,
				dataType: 'json'
			}).always(function() {

			}).fail(function() {

			});
		},

		buildFrag: function ( results ) {
			var self = this;

			$.each(results, function (i, obj) {
				
				self.displayItem( obj );
			});

			if( self.$listsbox.find('li.active').length==0 && self.$listsbox.find('li').not('.head').first().length==1 ){

				self.active( self.$listsbox.find('li').not('.head').first() );
			}
		},
		setItem: function (data) {
			var self = this;

			var date = new Date( data.created );
			var minute = date.getMinutes();
			minute = minute < 10? '0'+minute:minute;

			$li = $('<li>').html(
				$('<a>', {class: 'clearfix'}).append(
					  $('<div>', {class: 'rfloat time'}).html( date.getHours() + ':' + minute )

					, $('<div>', {class: ''}).append(

						  $('<strong>', {class: 'code'}).text( '#' + data.code )
						, $('<div>', {class: 'group-name'}).append( 
							  // $('<strong>', {class: 'mrs'}).text( 'Sender:' )
							$('<span>',{class: ''}).text( data.cus.name+'('+data.cus.phone_number_str+')' )
						) 
						/*, $('<div>', {class: 'group-name'}).append( 
							  $('<strong>').text( 'Receiver:' )
							, $('<span>',{class: 'mls'}).text( data.receiver.name+'('+data.receiver.phone_number_str+')' )
						) */
						, $('<div>', {class: 'desc'}).append( 
							  $('<div>', {class: 'rfloat'}).append( 
							  	  $('<span>', {class: 'status'}).append(
							  	  	  $('<i>', {class: 'icon-cubes mrs'})
							  	  	, $('<span>').text( data.total_qty )
							  	  	, '/'
							  	  	, $('<span>').text( '฿'+PHP.number_format( data.total_price ) )
							  	)
							)
							, $('<div>', {class: 'text'}).append( 
								  $('<span>').text( data.from.code )
								, $('<i>', {class: 'icon-long-arrow-right mhs'})
								, $('<span>').text( data.to.code )
							)
						) 
					)
				)
			);

			$li.data( data );
			return $li;	
		},
		displayItem: function ( data, before ) {
			var self = this;

			var res = data.created.split(' ');

			if( !self.orders[res[0]] ){

				var li = $('<li>', {class: 'head'});
				var date = new Date( data.created );

				var m = Datelang.month(date.getMonth(), 'normal', 'en');
				var day = Datelang.day(date.getDay(), 'normal', 'en');
				li.text( day +', '+  date.getDate() + ' ' + m + ' ' + date.getFullYear() );

				if( before && self.$listsbox.find('li').length>0){
					self.$listsbox.find('li').first().before( li );
				}
				else{
					self.$listsbox.append( li );
				}
				
				
				self.orders[res[0]] = [];
			} 

			if( before ){
				self.$listsbox.find('li.head').first().after( self.setItem( data ) );
			}
			else{
				self.$listsbox.append( self.setItem( data ) );
			}
			
			self.orders[res[0]].push( data );
		},

		setNew: function() {
			var self = this;

			var t = setTimeout(function () {
				self.$content.addClass('has-loading');
			}, 800);
			
			$.get(Event.URL+ 'orders/create/', function( body ) {
				clearTimeout( t );
				self.$content.removeClass('has-loading');
				
				// var $body = $(body);
				self._setNew.init( {}, body, self );
			});
		},
		_setNew: {
			init: function( options, elem, parent ) {
				var self = this;

				self.parent = parent;
				self.options = options;
				self.$elem = $(elem);

				// set elem
				self.parent.$profile.html( self.$elem ).removeClass('hidden_elem');

				// .addClass('effect')

				self.is_keycodes = [37,38,39,40,13];
				self.has_load = false;
				self._otext = '';
				self.is_focus = false;

				// customer
				self.$cus = self.$elem.find('input#order_cus_name');
				self.$cus.wrap( '<div class="ui-search"></div>' );

				self.$cus.parent().append( 
					  $('<div>', {class: 'loader loader-spin-wrap'}).html( $('<div>', {class: 'loader-spin'}) )
					, $('<div>', {class: 'overlay'})
				);
				// .find('.loader-spin-wrap').addClass('has-load');
				self.setMenuCus();

				// receiver
				self.$rec = self.$elem.find('input#receiver_name');
				self.$rec.wrap( '<div class="ui-search"></div>' );
				self.$rec.parent().append( 
					  $('<div>', {class: 'loader loader-spin-wrap'}).html( $('<div>', {class: 'loader-spin'}) )
					, $('<div>', {class: 'overlay'})
				);
				self.setMenuRec();

				// show 
				self.parent.show();
				

				// event 
				self.$elem.find('.js-cancel').click(function () {
					self.close();
	
				});

				self.$elem.find('.js-add-item').click(function(){
					self.addItem();
				});

				var v;
				self.$cus.keyup(function (e) {
					var $this = $(this);
					var value = $.trim($this.val());

					if( self.is_keycodes.indexOf( e.which )==-1 && !self.has_load ){
						
						self.$cus.parent().addClass('has-load');
						self.hideCus();
						clearTimeout( v );

						if(value==''){

							self.$cus.parent().removeClass('has-load');
							return false;
						}

						v = setTimeout(function(argument) {

							self.has_load = true;
							self.search( value );
						}, 500);
						
					}
				}).keydown(function (e) {
					var keyCode = e.which;

					if( keyCode==40 || keyCode==38 ){

						self.changeUpDownCus( keyCode==40 ? 'donw':'up' );
						e.preventDefault();
					}

					if( keyCode==13 && self.$menuCus.find('li.selected').length==1 ){

						self.activeCus(self.$menuCus.find('li.selected').data());
					}
				}).click(function (e) {
					var value = $.trim($(this).val());

					if(value!=''){

						if( self._otext==value ){
							self.displayCus();
						}
						else{

							self.$cus.parent().addClass('has-load');
							self.hideCus();
							clearTimeout( v );

							self.has_load = true;
							self.search( value );
						}
					}

					e.stopPropagation();
				}).blur(function () {
					
					if( !self.is_focus ){
						self.hideCus();
					}
				});

				self.$menuCus.delegate('li', 'mouseenter', function() {
					$(this).addClass('selected').siblings().removeClass('selected');
				});
				self.$menuCus.delegate('li', 'click', function(e) {
					$(this).addClass('selected').siblings().removeClass('selected');
					self.activeCus($(this).data());

					// e.stopPropagation();
				});
				self.$menuCus.mouseenter(function() {
					self.is_focus = true;
			  	}).mouseleave(function() { 
			  		self.is_focus = false;
			  	});

			    self.$rec.keyup(function (e) {
			    	var value = $.trim($(this).val());

			    	if(value==''){
			    		self.displayRec();
			    	}
			    	else{
			    		self.hideRec();
			    	}
			    }).keydown(function (e) {
			    	var keyCode = e.which;

					if( keyCode==40 || keyCode==38 ){

						self.changeUpDownRec( keyCode==40 ? 'donw':'up' );
						e.preventDefault();
					}

					if( keyCode==13 && self.$menuRec.find('li.selected').length==1 ){

						self.activeRec(self.$menuRec.find('li.selected').data());
					}
			    }).click(function (e) {
			    	var value = $.trim($(this).val());

					if(value==''){
						self.displayRec();
					}

					e.stopPropagation();
			    }).blur(function () {
			    	if( !self.is_focus ){
						self.hideRec();
					}
			    });

			    self.$menuRec.delegate('li', 'mouseenter', function() {
					$(this).addClass('selected').siblings().removeClass('selected');
				});
				self.$menuRec.delegate('li', 'click', function(e) {
					$(this).addClass('selected').siblings().removeClass('selected');
					self.activeRec($(this).data());
				});
				self.$menuRec.mouseenter(function() {
					self.is_focus = true;
			  	}).mouseleave(function() { 
			  		self.is_focus = false;
			  	});
			  	

			  	$('html').on('click', function() {
					self.hideCus();
					self.hideRec();
				});

				// item 
				self.$listsbox = self.$elem.find('[role=listsitem]');
				self.addItem();
				self.$listsbox.delegate('tr:last :input', 'keyup', function () {
					self.changeItemLast();
				});

				self.$elem.submit(function (e) {
					e.preventDefault();
				});

				self.$elem.find('.js-done').click(function () {
					self.submit();
				});

			},

			close: function () {
				var self = this;	

				self.parent.hide(function () {
					self.parent.$profile.empty();
					self.parent.$elem.find('.js-new').removeClass('disabled');
				});
			},
			search: function ( text ) {
				var self = this;

				var data = {
					q: text,
					limit: 5
				};
				self.$menuCus.empty();

				$.ajax({
					url: Event.URL + "customers/lists/",
					data: data,
					dataType: 'json'
				}).done(function( results ) {

					if( results.total==0 ){
						return false;
					}

					self.buildFrag( results.lists );
					self.displayCus();

				}).fail(function() {
					
				}).always(function() {

					self._otext = text;
					self.has_load = false;
					self.$cus.parent().removeClass('has-load');
				});
			},
			buildFrag: function( results ) {
				var self = this;

				$.each(results, function (i, obj) {
					var li = $('<li/>', {class:'picThumb'} ).html( $('<a>').append( 
							  $('<div/>', {class:'avatar'}).html( $('<img/>', {calss: 'img', src: obj.image_url}) )
							, $('<span/>', {class: 'text', text: obj.name}) 
							, $('<span/>', {class: 'subtext', text: obj.code})
							, $('<span/>', {class: 'category', text: obj.phone_number_str})
						) 
					);

					li.data(obj);
					self.$menuCus.append( li );
				});	
			},
			setMenuCus: function () {
				var self = this;

				var $box = $('<div/>', {class: 'uiTypeaheadView selectbox-selectview'});
				self.$menuCus = $('<ul/>', {class: 'search has-loading', role: "listbox"});

				$box.html( $('<div/>', {class: 'bucketed'}).append( self.$menuCus ) );
				// bucketed

				var settings = self.$cus.offset();
				settings.top += self.$cus.outerHeight();

				uiLayer.get(settings, $box);
				self.$layerCus = self.$menuCus.parents('.uiLayer');
				self.$layerCus.addClass('hidden_elem');

				// event
				self.$menuCus.mouseenter(function () {
					self.is_focus = true;
				}).mouseleave(function () {
					self.is_focus = false;
				});

				self.resizeMenuCus();
				$( window ).resize(function () {
					self.resizeMenuCus();
				});
			},
			resizeMenuCus: function() {
				var self = this;

				self.$menuCus.width( self.$cus.outerWidth()-2 );
				var settings = self.$cus.offset();
				settings.top += self.$cus.outerHeight();
				settings.top -= 1;
				// settings.left += 3;

				self.$menuCus.css({
					overflowY: 'auto',
					overflowX: 'hidden',
					maxHeight: $( window ).height()-settings.top
				});

				self.$menuCus.parents('.uiContextualLayerPositioner').css( settings );
			},
			displayCus: function () {
				var self = this;

				if( self.$menuCus.find('li').length == 0 ){
					return false;
				}

				if( self.$menuCus.find('li.selected').length==0 ){
					self.$menuCus.find('li').first().addClass('selected');
				}

				self.resizeMenuCus();
				self.$layerCus.removeClass('hidden_elem');
			},
			hideCus: function() {
				this.$layerCus.addClass('hidden_elem');
			},
			changeUpDownCus: function( active ) {
				var self = this;

				var length = self.$menuCus.find('li').length;
				var index = self.$menuCus.find('li.selected').index();

				if( active=='up' ) index--;
				else index++;

				if( index < 0) index=0;
				if( index >= length) index=length-1;

				self.$menuCus.find('li').eq( index ).addClass('selected').siblings().removeClass('selected');
			},
			activeCus: function ( data ) {
				var self = this;

				$remove = $('<button>', {type: 'button', class: 'remove'}).html( $('<i>', {class: 'icon-remove'}) );
				self.$cus.prop('disabled', true).val('').parent().addClass('active').find('.overlay').empty().append(
					  $remove
					, $('<div>', { class: 'text'}).text( data.name )
					, $('<input>', { type: 'hidden', class: 'hiddenInput', value:data.id, autocomplete:'off', name: 'order_cus_id' })
				);

				self.$elem.find('input#cus_phone_number').val( data.phone_number_str ).addClass('disabled').prop('disabled', true);;

				if( data.image_url ){

					self.$elem.find('.ProfileImageComponent_image').html( $('<img>', {src: data.image_url}) );
				}

				$.each(data.receiver, function (i, obj) {
					var li = $('<li/>' ).html( $('<a>').append( 
							  $('<span/>', {class: 'text', text: obj.receiver_name}) 
							// , $('<span/>', {class: 'subtext', text: obj.code})
							, $('<span/>', {class: 'category', text: obj.receiver_phone_number})
						) 
					);

					li.data(obj);
					self.$menuRec.append( li );
				});

				if( data.receiver.length>0 ){
					self.$rec.focus();
				}

				self.hideCus();
				$remove.click(function() {
					
					self.$menuRec.empty();
					self.$elem.find('.ProfileImageComponent_image').empty();
					self.$elem.find('input#cus_phone_number').val( '' ).removeClass('disabled').prop('disabled', false);;
					self.$cus.prop('disabled', false).focus().parent().removeClass('active').find('.overlay').empty();

					self.removeRec();
				});
			},

			setMenuRec: function () {
				var self = this;

				var $box = $('<div/>', {class: 'uiTypeaheadView selectbox-selectview'});
				self.$menuRec = $('<ul/>', {class: 'search has-loading', role: "listbox"});

				$box.html( $('<div/>', {class: 'bucketed'}).append( self.$menuRec ) );
				// bucketed

				var settings = self.$rec.offset();
				settings.top += self.$rec.outerHeight();

				uiLayer.get(settings, $box);
				self.$layerRec = self.$menuRec.parents('.uiLayer');
				self.$layerRec.addClass('hidden_elem');

				// event
				self.$menuRec.mouseenter(function () {
					self.is_focus = true;
				}).mouseleave(function () {
					self.is_focus = false;
				});

				self.resizeMenuRec();
				$( window ).resize(function () {
					self.resizeMenuRec();
				});
			},
			resizeMenuRec: function() {
				var self = this;

				self.$menuRec.width( self.$rec.outerWidth()-2 );
				var settings = self.$rec.offset();
				settings.top += self.$rec.outerHeight();
				settings.top -= 1;
				// settings.left += 3;

				self.$menuRec.css({
					overflowY: 'auto',
					overflowX: 'hidden',
					maxHeight: $( window ).height()-settings.top
				});

				self.$menuRec.parents('.uiContextualLayerPositioner').css( settings );
			},
			displayRec: function () {
				var self = this;

				if( self.$menuRec.find('li').length == 0 ){
					return false;
				}

				if( self.$menuRec.find('li.selected').length==0 ){
					self.$menuRec.find('li').first().addClass('selected');
				}

				self.resizeMenuRec();
				self.$layerRec.removeClass('hidden_elem');
			},
			hideRec: function() {
				this.$layerRec.addClass('hidden_elem');
			},
			changeUpDownRec: function (active) {
				var self = this;

				var length = self.$menuRec.find('li').length;
				var index = self.$menuRec.find('li.selected').index();

				if( active=='up' ) index--;
				else index++;

				if( index < 0) index=0;
				if( index >= length) index=length-1;

				self.$menuRec.find('li').eq( index ).addClass('selected').siblings().removeClass('selected');
			},
			activeRec: function (data) {
				var self = this;

				$remove = $('<button>', {type: 'button', class: 'remove'}).html( $('<i>', {class: 'icon-remove'}) );
				self.$rec.val('').prop('disabled', true).parent().addClass('active').find('.overlay').empty().append(
					  $remove
					, $('<div>', { class: 'text'}).text( data.receiver_name )
					, $('<input>', { type: 'hidden', class: 'hiddenInput', value:data.receiver_id, autocomplete:'off', name: 'receiver_id' })
				);

				self.$elem.find('input#receiver_phone_number').val( data.receiver_phone_number ).addClass('disabled').prop('disabled', true);
				self.$elem.find('input#receiver_address').val( data.receiver_address ).addClass('disabled').prop('disabled', true);
				self.$elem.find('input#receiver_zip').val( data.receiver_zip ).addClass('disabled').prop('disabled', true);

				self.$elem.find(':input#order_to_id').val( data.station_id ); //.addClass('disabled').prop('disabled', true);

				self.hideRec();
				$remove.click(function() {
					self.removeRec();
				});
			},
			removeRec: function () {
				var self = this;
				
				self.$rec.prop('disabled', false).focus().parent().removeClass('active').find('.overlay').empty();
				self.$elem.find(':input#receiver_phone_number').val('').removeClass('disabled').prop('disabled', false);
				self.$elem.find(':input#receiver_address').val('').removeClass('disabled').prop('disabled', false);
				self.$elem.find(':input#receiver_zip').val('').removeClass('disabled').prop('disabled', false);
				self.$elem.find(':input#order_to_id').val(''); //.removeClass('disabled').prop('disabled', false);
			},

			// add Item
			addItem: function (data) {
				var self = this;
				var data = data || {};

				$item = self.setItem( data );
				self.$listsbox.append( $item );

				var typeofgoods = [];

				$.each(self.parent.options.typeofgoods, function(i, obj){

					typeofgoods.push({
						text:  obj.text||obj.name,
						value: obj.value||obj.id,
						checked: false
					});
				});


				/* Type Of Goods */
				$selectbox = $('<select>', {name: 'items[type][]', class:'inputtext js-select-type'});
				$.each(typeofgoods, function (i, obj) {
					$selectbox.append( $('<option>', {value: obj.value, text: obj.text}) );
				});

				$selectbox.append( $('<option>', {value: '', text: '+ Add New'}) );

				var lastSel = $selectbox.find("option:selected");

				$selectbox.change( function (ev) {

					if( $(this).val()=='' ){

						lastSel.prop("selected", true);

						Dialog.load( Event.URL+'type_of_goods/add/',{
							callback: true
						}, {
							onSubmit: function(d) {
								
								var $form = d.$pop.find('form');
								Event.inlineSubmit( $form ).done(function( result ) {

									result.url = "";
									result.message = "";
									Event.processForm($form, result);

									if( result.data ){

										var data = {
											text: result.data.name,
											value: result.data.id
										};

										if( !result.error ){

											$.each( $('select.js-select-type'), function () {
												
												$(this).find('option').last().before( $('<option>', {value: data.value, text: data.text}) );
											} );
											

											self.parent.options.typeofgoods.push({
												id: data.value,
												name: data.text
											});

										}


										$selectbox.find('option[value='+ data.value +']').prop("selected", true);

										Dialog.close();
									}
									
								});
							}
						} );
					}

				}).click(function () {
					lastSel = $selectbox.find("option:selected");
				});

				$item.find('div.js-type').html( $selectbox );




				// console.log( typeofgoods );
				/*$item.find('div.js-type').selectbox2({
					name: 'items[type][]',
					options: typeofgoods,
					insert_url: ,
					// _name: 'items[type][]',
					onChange: function( e ) {

						if( this.settings.options.length>self.parent.options.typeofgoods.length ){							
							self.parent.options.typeofgoods = this.settings.options;
						}
						
						self.changeItemLast();
					}
				});*/


				$item.find(':input.js-price').keyup( function(){
					self.summary();
				} ).change(function() {
					var val = parseInt( $(this).val() );
					$(this).val( isNaN(val)? 0: val );
					self.summary();
				});

				$item.find(':input.js-qty').change(function() {
					var val = parseInt( $(this).val() );
					$(this).val( isNaN(val)? 0: val );
				});

				$item.find(':input.js-pay').change( function(){

					$(this).closest('.pay').find(':input.js-pay-val').val( $(this).prop('checked') ? 1:0 );
				} );

				var date = new Date();
				if( self.parent.options.outHours!=null ){
					if( date.getHours() > self.parent.options.outHours ){
						date.setDate( date.getDate() + 1 );
					}
				}
				
				var d = date.getDate();
				d = d < 10 ? '0'+d:d;

				var m = date.getMonth()
				m = m < 10 ? '0'+m:m;

				$item.find('.date :input').val( date.getFullYear() + '-' + m + '-' +  d).change(function(){

					self.changeItemLast();
				});

				self.sortItem();
			},
			setItem: function (data) {
				var self = this, 
					$tr = $('<tr>', {class: 'item'});

				// $('<input>', {type:"text", class: 'inputtext', name: 'items[type][]'})
				var $remove = $('<button>', {class: 'btn btn-no-padding ', type:"button"}).html( $('<i>', {class: 'icon-remove'}) );

				$tr.append( 
					  $('<td>', {class: 'no'})
					, $('<td>', {class: 'type'}).html(
						$('<div>', {class: 'js-type'})
					)
					/*, $('<td>', {class: 'date'}).html(
						$('<input>', {type:"date", class: 'inputtext', name: 'items[date][]'})
					)*/
					, $('<td>', {class: 'qty'}).append(
						 /* $('<span>', {class: 'but-qty gbtn', type:"minus"}).html(
							$('<button>', {class: 'btn', type:"button"}).html( $('<i>', {class: 'icon-minus'}) )
						)*/
						$('<input>', {type:"text", class: 'inputtext js-qty', name: 'items[qty][]'})
						/*, $('<span>', {class: 'but-qty gbtn', type:"plus"}).html(
							$('<button>', {class: 'btn', type:"button"}).html( $('<i>', {class: 'icon-plus'}) )
						)*/
					)
					, $('<td>', {class: 'unit'}).html(
						$('<input>', {type:"text", class: 'inputtext', name: 'items[unit][]'})
					)
					, $('<td>', {class: 'price'}).append(
						  $('<input>', {type:"text", class: 'inputtext js-price', name: 'items[price][]'})
					)
					, $('<td>', {class: 'pay'}).append(
						  $('<label>', {type:"text", class: 'checkbox'}).html( $('<input>', {type:"checkbox", checked: '1', class: 'js-pay'}) )
						, $('<input>', {type:"hidden", class: 'inputtext js-pay-val', name: 'items[pay][]', value: 1})
					)
					, $('<td>', {class: 'actions'}).html( $('<span>', {class:'gbtn'}).html( $remove ))
				);
				
				$tr.data(data);

				$remove.click(function(){

					if( self.$listsbox.find('tr').length==1 ){

					}
					else{
						$tr.remove();
						self.sortItem();
						self.summary();
					}

				});

				return $tr;
			},
			sortItem: function() {
				var self = this;

				var c = 0;
				$.each(self.$listsbox.find('tr'), function() {
					var $item = $(this);
					c++;

					$item.find('.no').text( c+'.' );
				});
			},
			changeItemLast: function(){
				var self = this;

				var c = ["items[type][]", "items[qty][]"];
				var l = 0;
				$.each( self.$listsbox.find('tr:last :input'), function( i, obj ) {
					var val = $(obj).val();

					if( !$(obj).hasClass('disabled') && c.indexOf($(obj).attr('name'))>=0 &&  val!=''){
						l++;
					}
					
				});

				if( c.length==l ){
					self.addItem();
				}		
			},
			summary: function(){
				var self = this;

				var total = 0;
				$.each( self.$listsbox.find('tr :input.js-price'), function( i, obj ) {

					total+= parseInt( $(obj).val() ) || 0;
				});

				self.parent.$elem.find('[summary=total]').text(  PHP.number_format(total) );
			},

			submit: function () {

				var self = this;
				var $form = self.$elem;

				Event.inlineSubmit( $form ).done(function( result ) {

					result.url = '';
					Event.processForm($form, result);

					if( result.error ){
						return false;
					}

					self.close();

				 	self.parent.displayItem( result.data, true );
				 	self.parent.active( self.parent.$listsbox.find('li').not('.head').first() );

				 	self.parent.options.count.today = parseInt(self.parent.options.count.today);
				 	self.parent.options.count.today++;
				 	self.parent.setDate();
					

					$button = $('<button>', {
						class: 'btn btn-primary',
						text: 'Print',
						type: 'button'
					});

					Dialog.open({
						title: '<i class="icon-print mrs"></i>Print!',
						body: 'Auto print Invoice?',
						button: $button[0],
						bottom_msg: '<a class="btn" role="dialog-close"><span class="btn-text">Close</span></a>',
					});

					$button.click(function () {
						
						// window.open(URL+'p/sticker/' + result.data.id , '_blank');
						Dialog.close();
						Event.hideMsg();

						setTimeout(function () {
							
							window.open(Event.URL+'p/invoice/' + result.data.id , '_blank');
						}, 300);
					});
					
				});
			}
		},


		setDate: function() {
			var self = this;

			var a = ['count-today', 'count-yesterday', 'count-total'];

			$.each(a, function (i, key) {
				
				var res = key.split('-');

				var text = '';
				if( self.options[res[0]] ){
					text = self.options[res[0]][res[1]];
				}
				
				self.$elem.find('[view-text='+key+']').text( text );
			});
		},

		resize: function () {
			var self = this;

			self.$elem.find('[role=leftContent]').css({
				height: $(window).height() - self.$elem.find('[role=leftHeader]').outerHeight()
			});
			
		}

	};

	$.fn.orders = function( options ) {
		return this.each(function() {
			var $this = Object.create( Orders );
			$this.init( options, this );
			$.data( this, 'orders', $this );
		});
	};

	$.fn.orders.options = {
		onOpen: function() {},
		onClose: function() {},
		typeofgoods: [],
		outHours: 14, 
	};
	
})( jQuery, window, document );