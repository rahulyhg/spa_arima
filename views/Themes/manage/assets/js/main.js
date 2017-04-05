var __Elem = {
	anchorBucketed: function (data) {
		
		var anchor = $('<div>', {class: 'anchor ui-bucketed clearfix'});
		var avatar = $('<div>', {class: 'avatar lfloat no-avatar mrm'});
		var content = $('<div>', {class: 'content'});
		var icon = '';

		if( !data.image_url || data.image_url=='' ){

			icon = 'user';
			if( data.icon ){
				icon = data.icon;
			}
			icon = '<div class="initials"><i class="icon-'+icon+'"></i></div>';
		}
		else{
			icon = $('<img>', {
				class: 'img',
				src: data.image_url,
				alt: data.text
			});
		}

		avatar.append( icon );

		var massages = $('<div>', {class: 'massages'});

		if( data.text ){
			massages.append( $('<div>', {class: 'text fwb u-ellipsis'}).html( data.text ) );
		}

		if( data.category ){
			massages.append( $('<div>', {class: 'category'}).html( data.category ) );
		}
		
		if( data.subtext ){
			massages.append( $('<div>', {class: 'subtext'}).html( data.subtext ) );
		}

		content.append(
			  $('<div>', {class: 'spacer'})
			, massages
		);
		anchor.append( avatar, content );

        return anchor;
	},
	anchorFile: function ( data ) {
		
		if( data.type=='jpg' ){
			icon = '<div class="initials"><i class="icon-file-image-o"></i></div>';
		}
		else{
			icon = '<div class="initials"><i class="icon-file-text-o"></i></div>';
		}
		
		var anchor = $('<div>', {class: 'anchor clearfix'});
		var avatar = $('<div>', {class: 'avatar lfloat no-avatar mrm'});
		var content = $('<div>', {class: 'content'});
		var meta =  $('<div>', {class: 'subname fsm fcg'});

		if( data.emp ){
			meta.append( 'Added by ',$('<span>', {class: 'mrs'}).text( data.emp.fullname ) );
		}

		if( data.created ){
			var theDate = new Date( data.created );
			meta.append( 'on ', $('<span>', {class: 'mrs'}).text( theDate.getDate() + '/' + (theDate.getMonth()+1) + '/' + theDate.getFullYear() ) );
		}

		avatar.append( icon );

		content.append(
			  $('<div>', {class: 'spacer'})
			, $('<div>', {class: 'massages'}).append(
				  $('<div>', {class: 'fullname u-ellipsis'}).text( data.name )
				, meta
			)
		);
		anchor.append( avatar, content );

        return anchor;
	} 
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

	var ListsAccessory = {
		init: function ( options, elem ) {
			var self = this;

			self.$elem = $(elem);
			self.$listsbox = self.$elem.find('[rel=listsbox]');
			self.options = $.extend( {}, $.fn.listsaccessory.options, options );

			self.Events();
			if( self.options.lists.length==0 && self.options.model ){
				self.refresh();
			}
			else{
				self.buildFrag( self.options.lists );
				self.display();
			}
		},

		refresh: function () {
			var self = this;

			$.get(Event.URL + 'booking/get_accessory', {model: self.options.model }, function (res) {

				self.buildFrag( res );
				self.display();
			}, 'json');
		},

		buildFrag: function ( results ) {
			var self = this;

			self.$listsbox.find('li').not('.etc').remove();

			var no = 0;
			$.each( results, function (i, obj) {
				no++;

				var text = obj.name;

				var input = $('<input>', {type: 'checkbox', name: 'accessory[name][]', value: obj.id, class: 'js-checked-accessory', 'data-accessory': 'name' });
				var label = $('<label>', {class: 'checkbox'}).append( input );

				var inputName = $('<input>', {type:"text", class: 'inputtext' });
				inputName.addClass('disabled').prop('disabled', true);

				var inputValue = $('<input>', {
					type:"text", 
					class: 'inputtext js-change-accessory',
					name: 'accessory[value][]',
					'data-accessory': 'value'
				});
				inputValue.addClass('disabled').prop('disabled', true);

				var note = $('<div>', {class: 'fcg fsm tar'});
				note.append( 'ช่วงราคา ' + parseInt( obj.cost ) + '-' + parseInt( obj.price ) );

				var foc = $('<input>', {
					type: 'checkbox', 
					name: 'accessory[FOC][]', 
					value:'less',
					class: 'js-change-accessory',
					'data-accessory': 'FOC'
				});

				var tr = $('<tr>', {class: 'tr-box'});
				tr.append( 
					  $('<td>', {class: 'ID'}).html( label ) 
					, $('<td>', {class: 'name'}).html( inputName.val( text ) ) 
					, $('<td>', {class: 'price'}).append( 

						inputValue.val( parseInt( obj.price ) ) 

					) 
					, $('<td>', {class: 'actions'}).append( $('<label>', {class: 'checkbox'}).append(
						foc.addClass('disabled').prop('disabled', true)
					) ) 
				);

				var meta = $('<div>', {class: 'accessory-meta'});
				meta.append(
					  $('<input>', {
					  	type:"hidden", 
					  	name:'accessory[cost][]', 
					  	value: parseInt(obj.cost),
					  	'data-accessory': 'cost'
					  }).addClass('disabled').prop('disabled', true)
					, $('<input>', {
						type:"hidden", 
						name:'accessory[rate][]',
						value: parseInt( obj.price ),
						'data-accessory': 'rate'
					}).addClass('disabled').prop('disabled', true)
					, $('<input>', {
						type:"hidden", 
						name:'accessory[has_etc][]',
						value: 0,
						'data-accessory': 'has_etc'
					}).addClass('disabled').prop('disabled', true)
				);

				var li = $('<li>', {'data-id': obj.id}).append( 
					meta , $('<table>').append( 
						$('<tr>', {class: 'tr-label'}).append(
							$('<td>', {colspan: 3}).html( note ), 
							$('<td>', {class: 'actions'}).html( $('<label>', {text: 'แถม'}) )
						), 
						tr 
					)
				);

				if( text.length>=40 ) li.addClass( 'wfull' );
				li.data( obj );

				self.$listsbox.find('.etc').first().before( li );
			} );

			self.sort();
		},
		sort: function () {
			var self = this;

			var row = 0;
			$.each( self.$elem.find('.list-table-cell>li'), function () {

				$.each( $(this).find(':input[data-accessory]'), function () {
					$(this).attr('name', 'accessory['+ row +']['+ $(this).attr('data-accessory') +']');
				});

				row++;
			});
		},

		Events: function () {
			var self = this;

		    self.$elem.delegate(':input.js-change-accessory', 'change', function () {
		    	
		    	var $parent = $(this).closest('li');
		    	var data = $parent.data();

		    	var min = parseInt(data.cost) || 0,
		    		max = parseInt(data.price) || 0;

		    	var $input = $parent.find(':input[data-accessory=value]');
		    	var val = parseInt( $.trim( $input.val() ) ) || max;
		    	
		    	if( min!=0 && max!=0 ){
			    	if( val < parseInt(min) ){
			    		val = min;
			    	}
			    	else if( val > parseInt(max) ){
			    		val = max;
			    	}
		    	}

		    	$input.val( val );
		    });
		    self.$elem.delegate('.js-checked-accessory', 'change', function () {

				self.change( $(this).closest('li') );
			});	
			self.$elem.delegate('.js-plus-accessory','click', function () {
				self.clone( $(this).closest('li') );
			});
			self.$elem.delegate('.js-remove-accessory', 'click', function () {

				if( self.$listsbox.find('.etc').length == 1 ){
					$(this).closest( 'li' ).find(':input').val('');
					$(this).closest( 'li' ).find(':input').first().focus();
				}
				else{
					$(this).closest( 'li' ).remove();
					self.sort();
				}
			});
		},

		change: function ( $elem ) {
			var self = this;

			var input = $elem.find(':input[data-accessory]').not('.js-checked-accessory');
			var $checkbox = $elem.find('.js-checked-accessory');

			if( $checkbox.prop('checked') ){
				input.removeClass('disabled').prop('disabled', false);
			}
			else{
				input.addClass('disabled').prop('disabled', true);
			}
		},
		display: function () {
			var self = this;

			self.sort();

			$.each( self.options.data, function (i, obj) {
				
				if( parseInt( obj.has_etc )==0  ){

					var li = self.$listsbox.find('[data-id='+ obj.id +']');

					if( li.length==1 ){
						li.find(':input[data-accessory=name]').prop('checked', true);
						self.change( li );
					}

					if( parseInt(obj.FOC)==1){
						li.find(':input[data-accessory=FOC]').prop('checked', true);
					}
				}
				else{
					var li = self.$listsbox.find('[data-id=etc]').last();
					self.clone( li, obj );
				}

				
				
			} );
		},
		clone: function ( parent, data ) {
			var self = this;
			var input = parent.find(':input').first();

			if( input.val()!='' || data ){
				var clone = parent.clone();
				clone.find(':input').not('[data-accessory=has_etc], [data-accessory=FOC]').val('');

				if( data ){
					
					clone.find('[data-accessory=name]').val( data.name );
					clone.find('[data-accessory=value]').val( parseInt(data.value) );
					clone.find('[data-accessory=FOC]').prop('checked', parseInt(data.FOC)==1 );
					parent.before( clone );
				}
				else{

					var next = parent.next();
					if( next.length==1 ){
						input = next.find(':input').first();

						if( input.val() == '' ){
							input.focus();
							return false;
						}
						
					}
					parent.after( clone );
					clone.find(':input').first().focus();
				}
				
			}
			else{
				input.focus();
			}

			self.sort();
		}
	}
	$.fn.listsaccessory = function( options ) {
		return this.each(function() {
			var $this = Object.create( ListsAccessory );
			$this.init( options, this );
			$.data( this, 'accessory', $this );
		});
	};
	$.fn.listsaccessory.options = {
		lists: [],
		data: [],
		checked: {}
	};


	var ConditionPayment = {
		init: function ( options, elem ) {
			var self = this;

			self.$elem = $(elem);
			
			self.$listsbox = self.$elem.find('[rel=listsbox]');
			self.options = $.extend( {}, $.fn.conditionpayment.options, options );

			self.Events();
			self.summary();
		},

		Events: function () {
			var self = this;

		    self.$elem.delegate('.js-plus-list','click', function () {
				
				var parent = $(this).closest('tr');
				var input = parent.find(':input').first();

				if( input.val()=='' ){
					input.focus();
				}
				else{
					var $clone = parent.clone();
					$clone.find(':input').val('');

					parent.after( $clone );
					$clone.find(':input').first().focus();
				}

			});

			self.$elem.delegate('.js-remove-list','click', function () {

				var parent = $(this).closest('tr[data-id=etc]');

				if( parent.parent().find('[data-id=etc]').length==1 ){
					var input = parent.find(':input').first();

					input.val('').focus();
				}
				else{
					parent.remove();
				}
			});

			/**/
			/* Event input number */
			/**/
			self.$elem.delegate('.js-number', 'keyup', function (e) {
			});
			self.$elem.delegate('.js-number', 'keypress', function (e) {
				if (e.keyCode == 13) { 
					self.change_number($(this).data('name'), $(this).val() );
				};
			});
			self.$elem.delegate('.js-number', 'keydown', function (e) {
		        // Allow: backspace, delete, tab, escape, enter and .
		        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		             // Allow: Ctrl/cmd+A
		             (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: Ctrl/cmd+C
		             (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: Ctrl/cmd+X
		             (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: home, end, left, right
		             (e.keyCode >= 35 && e.keyCode <= 39)) {
		                 // let it happen, don't do anything
		             return;
		        }
		        // Ensure that it is a number and stop the keypress
		        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		        	e.preventDefault();
		        }
		    });
		    self.$elem.delegate('.js-number', 'change', function () {
		    	self.change_number($(this).data('name'), $(this).val() );		    	
		    })
		    self.$elem.delegate('.js-number', 'blur',function () {

		    	if( $(this).val()=='' ||  $(this).val()<0 ){
		    		$(this).val( 0 );
		    	}
		    });
		},

		change_number: function ( type, val ) {
			var self = this;

			self.$elem.find('[data-name='+ type +']').not('.not-clone').val( $.trim( val ) );
			self.summary();
		},
		
		summary: function () {
			
			var sub = 0, total = 0;
			var income = 0; 
			var less = 0;

			var $section = self.$elem;

			$.each( $section.find( '.js-number' ), function (i, obj) {
				
				var val = parseInt( $(this).val() || 0 );
				if( $(this).hasClass('is-lock')   ){
					val = 0;
				}

				if( $(this).data('type')=='income' ){
					income += val;
				}

				if( $(this).data('type')=='less' ){
					less += val;
				}

			} );

			$section.find('[summary=sub]').val( PHP.number_format(income, 0) );
			$section.find('[summary=total]').val( PHP.number_format(income-less, 0) );
		}
	}
	$.fn.conditionpayment = function( options ) {
		return this.each(function() {
			var $this = Object.create( ConditionPayment );
			$this.init( options, this );
			$.data( this, 'ConditionPayment', $this );
		});
	};
	$.fn.conditionpayment.options = {
		lists: [],
		data: []
	};

	var SelectorsStocks = {
		init: function(options, elem) {
			var self = this;

			self.$elem = $(elem);
			self.options = $.extend( {}, $.fn.selectors_stocks.options, options );

			self.$model = self.$elem.find(':input[data-name=model]');
			self.currModel = self.options.model || self.$model.val();

			self.$product = self.$elem.find(':input[data-name=product]');
			self.currProduct = self.options.product || self.$product.val();

			self.$color = self.$elem.find(':input[data-name=model_color]');
			self.currColor = self.options.color || self.$color.val();

			self.$price = self.$elem.find(':input[data-name=product_price]');
			
			self.changeModel();
			self.$model.change(function () {
				self.currModel = $(this).val();
				self.changeModel();
			});

			self.$product.change(function () {
				self.currProduct = $(this).val();
				self.changeProduct();
			});

			// self.options = $.extend( {}, $.fn.options.options, options );
		},

		changeModel: function ( callback ) {
			var self =  this;

			$.get(Event.URL + 'booking/get_product', {model: self.currModel }, function (res) {
				
				self.$product.empty();

				$.each( res, function (i, obj) {

					li = $('<option>', {value: obj.id, text: obj.name });
					if( self.currProduct == obj.id ){
						li.prop('selected', true);
					}

					li.data( obj );
					self.$product.append( li );

				} );

				self.changeProduct();

			}, 'json');


			$.get(Event.URL + 'booking/get_color', {model: self.currModel }, function (res) {
				self.$color.empty();
				$.each( res, function (i, obj) {

					li = $('<option>', {value: obj.id, text: obj.name });
					if( self.currColor == obj.id ){
						li.prop('selected', true);
					}

					self.$color.append( li );
				} );
			}, 'json');
		},

		changeProduct: function () {
			var self = this;

			var data = self.$product.find('option:selected').data(); 
			self.$price.val( parseInt(data.price) || 0 )
		},
	}
	$.fn.selectors_stocks = function( options ) {
		return this.each(function() {
			var $this = Object.create( SelectorsStocks );
			$this.init( options, this );
			$.data( this, 'selectors_stocks', $this );
		});
	};
	$.fn.selectors_stocks.options = {
		data: [],
		THBToUSD: 35.02,
	};


	var Rates = {
		init: function(options, elem) {
			var self = this;
			self.elem = elem;
			self.$elem = $(elem);
			self.options = $.extend( {}, $.fn.rates.options, options );

			if( self.options.data.length>0 ){
				$.each(self.options.data, function (i, obj) {
					self.addItem(obj);
				});
			}
			else{
				self.addItem();
			}

			// Event
			self.$elem.find( '.js-add-price' ).click(function () {
				self.addItem();
			});

			self.$elem.delegate( '.js-add-if', 'click', function () {
				self.addIfItem( $(this).closest('.ui-item') );
			});
			self.$elem.delegate( '.js-del-if', 'click', function () {
				var parent = $(this).closest('.ui-item');

				if( parent.find('.ifs').length==1 ){
					parent.find('.ifs').find(':input').val('');
				}
				else{
					$(this).closest('.ifs').remove();
					self.sort();
				}
			});

			self.$elem.delegate( '.js-clone-item', 'click', function () {

				var $item = $(this).closest('.ui-item');
				
				var $el = $item.clone();
				
				$item.after( $el );
				// $el.find(':input').val('');
				
				self.sort();
				
			});

			self.$elem.delegate( '.js-remove-item', 'click', function () {

				var $item = $(this).closest('.ui-item');

				if( self.$elem.find('[role=listbox]').find('.ui-item').length==1 ){
					self.$elem.find('[role=listbox]').find('.ui-item :input').val('');
				}
				else{
					$item.remove();
					self.sort();
				}
				
			});

			// 
			/*var ti;
			self.$elem.find('[role=listbox]').sortable({
				change: function (event, ui) {

					clearTimeout( ti );
					ti = setTimeout( function() {
						console.log( ti );
						// self.set_sequence();
					}, 800 );
					
				}
			});*/
		},
		addItem: function (data) {
			var self = this;

			self.$elem.find('[role=listbox]').append( self.getItem(data) );
			self.sort();
		},
		addIfItem: function ( $el ) {
			var self = this;

			$el.find('.js-add-if').before( self.setIfitem() );
			
			self.sort();
		},

		setIfitem: function ( data ) {
			var data = data||{};
			return $('<div>', {class: 'ifs clearfix'}).append(

				$('<div>', {class: 'control-group lfloat if prm'}).append(
					$('<label>', {class: 'control-label', text: 'จำนวนงวด'})
					, $('<div>', {class: 'controls'}).append(
						$('<input>', {type: 'text', class: 'inputtext', 'data-name': 'condition_name'}).val( data.name )
						)
					),
				$('<div>', {class: 'control-group price lfloat'}).append(
					$('<label>', {class: 'control-label', text: 'ราคาต่องวด'})
					, $('<div>', {class: 'controls'}).append(
						$('<input>', {type: 'text', class: 'inputtext', 'data-name': 'condition_value'}).val( data.value )
						)
					),
				$('<div>', {class: 'control-group actions lfloat'}).append(
					$('<a>', {class: 'control-group remove js-del-if'}).html( $('<i>', {class: 'icon-remove'}) )
					)
				);
		},

		getItem: function ( data ) {
			var self = this;
			var data = data || {};

			var $remove = $('<button>', {type: 'button', class: 'js-remove-item ui-item-remove'}).html( $('<i>', {class: 'icon-remove'}) );
			var $clone = $('<button>', {type: 'button', class: 'js-clone-item'}).html( $('<i>', {class: 'icon-clone'}) );

			var msg = '';

			if( data.plan_start_date ){
				var today = new Date();
				var date = new Date( data.plan_start_date );

				if( date < today){
					msg = $('<div>', {class: 'uiBoxRed pam mbm'}).text('หมดระยะเวลากำหนดการแล้ว');
				}
			}
			
			var $tr = $('<div>', {class: 'ui-item rates-lists-item uiBoxWhite pam clearfix mbm'}).append(
				$('<div>', {class: 'clearfix'}).append(

					msg,

					$('<div>', {class: 'control-group lfloat prm percent'}).append(
						$('<label>', {class: 'control-label', text: 'เปอร์เซ็น ดาวน์'})
						, $('<div>', {class: 'controls'}).append(

							$('<input>', {type: 'text', class: 'inputtext'})

							)
						),

					$('<div>', {class: 'control-group lfloat prm'}).append(
						$('<label>', {class: 'control-label', text: 'เงิน ดาวน์'})
						, $('<div>', {class: 'controls'}).append(

							$('<input>', {type: 'text', class: 'inputtext'})
							)
						),

					$('<div>', {class: 'control-group lfloat prl'}).append(
						$('<label>', {class: 'control-label', text: 'ราคาดอกเบี้ย'})
						, $('<div>', {class: 'controls'}).append(

							$('<input>', {type: 'text', class: 'inputtext'})
							)
						)
					),

				( data.condition 
					? self.getCondition( data.condition )
					: self.setIfitem().addClass('first')
					),
				

				$('<a>', {class: 'fsm js-add-if', text: '+ เพิ่มงวด'}),

				$('<div>', {class: 'ui-item-actions'}).append(
					$clone, $remove
					)
				

				);

			// $tr.find('[type=date]').datepicker();

			return $tr;
		},
		getCondition: function(data) {
			var self = this;
			if( data.length==0 ){
				return self.setIfitem().addClass('first');
			}
			else{
				return $.map(data, function (obj, i) {
					var item = self.setIfitem(obj);
					if( i==0) item.addClass('first');
					return item;
				});
			}
		},
		sort: function () {
			var self = this;

			var no = 0;
			$.each( self.$elem.find('[role=listbox]').find('.item'), function (i, obj) {
				
				$(obj).find('input.js-start-date').attr('name', 'plans['+ no +'][start_date]');
				$(obj).find('input.js-end-date').attr('name', 'plans['+ no +'][end_date]');
				$(obj).find('[data-name=airline]').attr('name', 'plans['+ no +'][airline]');

				$(obj).find('[data-name=condition_name]').attr('name', 'plans['+ no +'][condition_name][]');
				$(obj).find('[data-name=condition_value]').attr('name', 'plans['+ no +'][condition_value][]');				
				no++;
			});
		}
	};
	$.fn.rates = function( options ) {
		return this.each(function() {
			var $this = Object.create( Rates );
			$this.init( options, this );
			$.data( this, 'rates', $this );
		});
	};
	$.fn.rates.options = {
		data: [],
		THBToUSD: 35.02,
	};


	var CarItems = {
		init: function(options, elem) {
			var self = this;
			self.elem = elem;
			self.$elem = $(elem);
			self.options = $.extend( {}, $.fn.rates.options, options );

			if( self.options.data.length>0 ){
				$.each(self.options.data, function (i, obj) {
					self.addItem(obj);
				});
			}
			else{
				self.addItem();
			}

			// Event
			if( self.options.actions=='enable' ){
				self.$elem.find( '.js-add-price' ).click(function () {
					self.addItem();
				});

				self.$elem.delegate('.js-clone-item', 'click', function () {

					var $item = $(this).closest('.ui-item');
					
					var $el = $item.clone();
					
					$el.find('.uiBoxRed').remove();
					$item.after( $el );
					$el.find('.js-start-date, .js-end-date').val('');

					self.sort();
				});

				self.$elem.delegate( '.js-remove-item', 'click', function () {

					var $item = $(this).closest('.ui-item');

					if( self.$elem.find('[role=listbox]').find('.ui-item').length==1 ){
						self.$elem.find('[role=listbox]').find('.ui-item :input').val('');
					}
					else{
						$item.remove();
						self.sort();
					}
				});
			}


			var ti;
			self.$elem.find('[role=listbox]').sortable({
				start: function() {
					
				},
				stop: function () {
					self.sort();
				},
				update: function () {
					console.log('update');
				},
				sort: function( event, ui ) {
				},
				change: function (event, ui) {					
				}
			});
		},
		addItem: function (data) {
			var self = this;

			self.$elem.find('[role=listbox]').append( self.getItem(data) );
			self.sort();
		},
		addIfItem: function ( $el ) {
			var self = this;

			$el.find('.js-add-if').before( self.setIfitem() );
			
			self.sort();
		},

		setIfitem: function ( data ) {
			var data = data||{};
			return $('<div>', {class: 'ifs clearfix'}).append(

				$('<div>', {class: 'control-group lfloat if prm'}).append(
					$('<label>', {class: 'control-label', text: 'จำนวนงวด'})
					, $('<div>', {class: 'controls'}).append(
						$('<input>', {type: 'text', class: 'inputtext', 'data-name': 'condition_name'}).val( data.name )
						)
					),
				$('<div>', {class: 'control-group price lfloat'}).append(
					$('<label>', {class: 'control-label', text: 'ราคาต่องวด'})
					, $('<div>', {class: 'controls'}).append(
						$('<input>', {type: 'text', class: 'inputtext', 'data-name': 'condition_value'}).val( data.value )
						)
					),
				$('<div>', {class: 'control-group actions lfloat'}).append(
					$('<a>', {class: 'control-group remove js-del-if'}).html( $('<i>', {class: 'icon-remove'}) )
					)
				);
		},

		getItem: function ( data ) {
			var self = this;
			var data = data || {}, $remove, $clone;

			if( self.options.actions=='enable' ){
				$remove = $('<button>', {type: 'button', class: 'js-remove-item ui-item-remove'}).html( $('<i>', {class: 'icon-remove'}) );
				$clone = $('<button>', {type: 'button', class: 'js-clone-item'}).html( $('<i>', {class: 'icon-clone'}) );
			}

			var msg = '';

			if( data.plan_start_date ){
				var today = new Date();
				var date = new Date( data.plan_start_date );

			}
			
			var $tr = $('<div>', {class: 'ui-item rates-lists-item uiBoxWhite pam clearfix mbm'}).append(
				$('<div>', {class: 'clearfix'}).append(
					$('<div>', {class: 'control-group lfloat prm'}).append(
						$('<div>', {class: 'js-no'})
						),

					$('<div>', {class: 'control-group lfloat prm'}).append(
						$('<label>', {class: 'control-label', text: 'VIN(เลขตัวถัง)'})
						, $('<div>', {class: 'controls'}).append(

							$('<input>', {type: 'text', class: 'inputtext'})

							)
						),

					$('<div>', {class: 'control-group lfloat prm'}).append(
						$('<label>', {class: 'control-label', text: 'หมายเลขเครื่องยนต์'})
						, $('<div>', {class: 'controls'}).append(

							$('<input>', {type: 'text', class: 'inputtext'})
							)
						),

					$('<div>', {class: 'control-group lfloat prl'}).append(
						$('<label>', {class: 'control-label', text: 'สี'})
						, $('<div>', {class: 'controls'}).append(

							$('<input>', {type: 'text', class: 'inputtext'})
							)
						)
					),

				$('<div>', {class: 'ui-item-actions'}).append(
					$clone, $remove
					)
				);

			return $tr;
		},
		getCondition: function(data) {
			var self = this;
			if( data.length==0 ){
				return self.setIfitem().addClass('first');
			}
			else{
				return $.map(data, function (obj, i) {
					var item = self.setIfitem(obj);
					if( i==0) item.addClass('first');
					return item;
				});
			}
		},
		sort: function () {
			var self = this;

			var no = 0;
			$.each( self.$elem.find('[role=listbox]').find('.ui-item'), function (i, obj) {
				
				$(obj).find('.js-no').text( (no+1) + '.' );
				$(obj).find('input.js-start-date').attr('name', 'plans['+ no +'][start_date]');
				$(obj).find('input.js-end-date').attr('name', 'plans['+ no +'][end_date]');
				$(obj).find('[data-name=airline]').attr('name', 'plans['+ no +'][airline]');

				$(obj).find('[data-name=condition_name]').attr('name', 'plans['+ no +'][condition_name][]');
				$(obj).find('[data-name=condition_value]').attr('name', 'plans['+ no +'][condition_value][]');				
				no++;
			});
		}
	}
	$.fn.carItems = function( options ) {
		return this.each(function() {
			var $this = Object.create( CarItems );
			$this.init( options, this );
			$.data( this, 'carItems', $this );
		});
	};
	$.fn.carItems.options = {
		actions: 'enable'
	};


	var ProductsCreate = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $( elem );
			self.$elem.find('[data-action]').click(function () {

				$(this).addClass('active').siblings().removeClass('active');
				self.$elem.find('[data-section='+ $(this).data('action') +']').addClass('active').siblings().removeClass('active');
				
			});
		}
	}
	$.fn.products_create = function( options ) {
		return this.each(function() {
			var $this = Object.create( ProductsCreate );
			$this.init( options, this );
			$.data( this, 'products_create', $this );
		});
	};


	var CarCreate = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $( elem );
			self.$items = self.$elem.find('#car-items');
			self.$itemslist = self.$items.find('[role=listbox]'); 
			self.$countItem = self.$elem.find('.js-count-value');
			self.options = $.extend( {}, $.fn.carcreate.options, options );
			self.sort();
			// 
			self.$elem.delegate(':input', 'keypress', function (e) {
				if (e.keyCode == 13) {
					return false;
				}
			});

			self.$countItem.keypress(function (e) {
				if (e.keyCode == 13) { 
					self.changeItem( $(this).val() );
				};
			}).keydown(function (e) {
		        // Allow: backspace, delete, tab, escape, enter and .
		        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		             // Allow: Ctrl/cmd+A
		             (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: Ctrl/cmd+C
		             (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: Ctrl/cmd+X
		             (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: home, end, left, right
		             (e.keyCode >= 35 && e.keyCode <= 39)) {
		                 // let it happen, don't do anything
		             return;
		         }
		        // Ensure that it is a number and stop the keypress
		        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		        	e.preventDefault();
		        }
		    }).change(function () {

		    	self.changeItem( $(this).val() );
		    }).blur(function () {

		    	if( $(this).val()=='' ||  $(this).val()<0 ){
		    		$(this).val( 0 );
		    	}
		    });

		    self.$elem.find( '.js-add' ).click(function () {
		    	self.addItem();
		    });

		    self.$elem.delegate('.js-clone-item', 'click', function () {

		    	var $item = $(this).closest('.ui-item');
		    	var $el = $item.clone();
		    	$item.after( $el );

		    	$.each( $el.find('select'), function ( i ) {

		    		$(this).find('option[value='+ $item.find('select').eq(i).val() +']').prop('selected', true);

					// self.$elem.find( 'select.js-model' ).change(function () {
		    	} );

		    	self.sort();
		    });

		    self.$elem.delegate( '.js-remove-item', 'click', function () {

		    	var $item = $(this).closest('.ui-item');

		    	$item.remove();
		    	self.sort();
		    });

			// $box.css({ backgroundColor: color });

		    self.$elem.find( 'select.js-model' ).change(function () {

		    	$.get( Event.URL + 'products/get_modelcolor', {id: $(this).val() }, function (res) {

		    		if( res.error ) return false; 
		    		self.options.colors = res;
		    		self.setColors();
		    	}, 'json');
		    });

		    self.$elem.delegate( '.js-change-color', 'change', function () {

		    	var $this = $(this);
		    	var val = $this.val(), color = '', $box = $(this).closest('.ui-item').find('.ui-box-color');

		    	$.each(self.options.colors, function (i, obj) {
		    		if( obj.id==val ){
		    			color = obj.color;
		    			return false
		    		}
		    	});

		    	$box.css({ backgroundColor: color });
		    });

		    var model_id = self.$elem.find('.js-model-input').data('model');
		    if( model_id != ''){
		    	$.get( Event.URL + 'products/get_modelcolor', {id: model_id }, function (res) {

		    		if( res.error ) return false; 
		    		self.options.colors = res;
		    		self.setColors();
		    	}, 'json');
		    }

		},
		changeItem: function ( length ) {
			var self = this;

			var cost = 0;
			$.each( self.$itemslist.find('.ui-item'), function (i, obj) {
				
				var viy = false;
				$.each( $(obj).find(':input'), function () {
					if( $(this).val()!='' ){
						viy = true;
						return false;
					}
				});

				if(viy){ cost++; }
				else{
					$(obj).remove();
				}
			});
			
			var count = length - cost;	
			if( count<0 ){

				for (var i=cost - 1, c=1; i >= 0; i--, c++) {
					self.$itemslist.find('.ui-item').eq( i ).remove();
					if( c==(count*-1) ) break;
				}
			} 

			for (var i = 0; i < count; i++) {
				self.$itemslist.append( self.getItem() );
			}
			
			// self.$countItem.val( cost+count );
			self.sort();
		},
		
		getItem: function ( data ) {
			var self = this;
			var data = data || {}, $remove, $clone;
			
			$remove = $('<button>', {type: 'button', class: 'js-remove-item ui-item-remove'}).html( $('<i>', {class: 'icon-remove'}) );
			$clone = $('<button>', {type: 'button', class: 'js-clone-item'}).html( $('<i>', {class: 'icon-clone'}) );

			var $colors = $('<select>', {class: 'inputtext js-change-color', name: 'items[color][]'});
			$colors.append( $('<option>', {value: '', text: '-'}) );
			$.each( self.options.colors, function (i, obj) {
				$colors.append( $('<option>', {value: obj.id, text: obj.name}) );
			} );


			var $tr = $('<div>', {class: 'ui-item uiBoxWhite pam clearfix mbm'}).append(
				$('<div>', {class: 'clearfix'}).append(
					$('<div>', {class: 'control-group lfloat prm'}).append(
						$('<div>', {class: 'js-no'})
						),

					$('<div>', {class: 'control-group lfloat prm'}).append(
						$('<label>', {class: 'control-label', text: 'VIN(เลขตัวถัง)'})
						, $('<div>', {class: 'controls'}).append(
							$('<input>', {type: 'text', class: 'inputtext', name: 'items[vin][]'})

							)
						),

					$('<div>', {class: 'control-group lfloat prm'}).append(
						$('<label>', {class: 'control-label', text: 'หมายเลขเครื่องยนต์'})
						, $('<div>', {class: 'controls'}).append(
							$('<input>', {type: 'text', class: 'inputtext', name: 'items[engine][]'})
							)
						),

					$('<div>', {class: 'control-group lfloat'}).append(
						$('<label>', {class: 'control-label', text: 'สี'})
						, $('<div>', {class: 'controls u-table'}).append(
							$('<div>', {class: 'u-table-row'}).append(
								$('<div>', {class: 'u-table-cell ui-box-color'})
								, $('<div>', {class: 'u-table-cell'}).html( $colors ) 
								)
							)
						)
					),

				$('<div>', {class: 'ui-item-actions'}).append(
					$clone, $remove
					)
				);


			return $tr;
		},
		setColors: function () {
			var self = this;

			$.each( self.$itemslist.find('.ui-item'), function (i, obj) {

				var $colors = $('<select>', {class: 'inputtext js-change-color', name: 'items[color][]'});
				$colors.append( $('<option>', {value: '', text: '-'}) );
				$.each( self.options.colors, function (i, obj) {
					$colors.append( $('<option>', {value: obj.id, text: obj.name}) );
				} );

				$(this).find('.js-change-color').parent().html( $colors );
				$(this).find('.ui-box-color').removeAttr('style');
			});
		},

		sort: function () {
			var self = this;

			self.$countItem.val( self.$itemslist.find('.ui-item').length );
			var no = 0;
			$.each( self.$itemslist.find('.ui-item'), function (i, obj) {
				
				$(obj).find('.js-no').text( (no+1) + '.' );		
				no++;

				$(obj).attr('id', 'items_' + no + '_fieldset');
			});

			self.$items.toggleClass('has-empty', self.$itemslist.find('.ui-item').length==0);
		}
	}
	$.fn.carcreate = function( options ) {
		return this.each(function() {
			var $this = Object.create( CarCreate );
			$this.init( options, this );
			$.data( this, 'car_create', $this );
		});
	};
	$.fn.carcreate.options = {
		colors: []
	}

	var ModelColor = {
		init: function (options, elem) {
			
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.modelcolor.options, options );

			self.$ul = $('<ul>', {class: ''});
			self.$add = $('<a>', {class: 'fcg mts fsm', text: '+ add'});

			self.$elem.addClass('model-color');

			self.$elem.append( self.$ul, self.$add );
			
			self.$add.click(function () {
				self.new();
			});

			if( self.options.lists.length>0 ){
				$.each( self.options.lists, function (i, obj) {
					self.new( obj );
				} );
			}
			else{
				self.new();
			}

			self.$ul.delegate('.js-remove', 'click', function () {
				if( self.$ul.find('li').length==1 ){

					self.$ul.find('li').first().find(":input").val('');
					return false;
				}
				$(this).closest('li').remove();
			});
		},

		new: function ( data ) {
			var self = this;

			self.$ul.append( self.setItem( data ) );
		},

		setItem: function ( data ) {
			var self = this;
			var li = $('<li>');

			var data = data || {};

			var color = $('<input>', {
				class: 'input-color',
				name: 'colors[primary][]',
				placeholder: "color...",
				type: 'hidden',
				value: data.primary || '#fff'
			});
			var $color = $('<div>', {class: 'btn btn-color input-group'});
			$color.append( color, '<span class=" input-group-addon"><i class="color-box"></i><span class="icon-caret-down mls"></span></span>');

			var label = $('<input>', {
				class: 'inputtext input-label',
				name: 'colors[name][]',
				placeholder: "label...",
				value: data.name || '',
				autocomplete: "off"
			});

			$color.colorpicker().on('changeColor', function(e) {
				/*label.css({
					backgroundColor: e.color.toHex(),
					color: '#fff'
				});*/
			});

			return li.append( 
				label, $color
				, $('<a>', {class: 'js-remove'}).html( $('<i>', {class: 'icon-remove'}) ) 

				);
		},
	};
	$.fn.modelcolor = function( options ) {
		return this.each(function() {
			var $this = Object.create( ModelColor );
			$this.init( options, this );
			$.data( this, 'model_color', $this );
		});
	};
	$.fn.modelcolor.options = {
		lists: []
	}

	/**/
	/* Booking */
	/**/
	var BookingForm = {
		init: function (options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = options;
			self.data = {};

			// setElem
			// self.$elem.find(':input[summary=accessory], :input[summary=insurance], :input[summary=paydown], :input[summary=deposit]').addClass('disabled').prop('disabled', true);

			// Event 
			self.Events();
		},
		Events: function () {
			var self = this;

			self.$elem.delegate(':input', 'keypress', function (e) {
				if (e.keyCode == 13) return false;
			});

		    /* Event Model */
			self.data.model = self.$elem.find('[selector=model]').val();
			self.changeModel();
			self.$elem.find('[selector=model]').change(function () {
				self.data.model = $(this).val();
				self.changeModel();
			});

		    /* Event Aaccessory */
		    var $accessory = self.$elem.find('[data-section=accessory]');
			var $listsbox_accessory = $accessory.find('[rel=listsbox]');
		    self.$elem.delegate(':input.js-change-accessory', 'change', function () {
		    	
		    	var $parent = $(this).closest('li');
		    	var data = $parent.data();

		    	var min = parseInt(data.cost) || 0,
		    		max = parseInt(data.price) || 0;

		    	var $input = $parent.find(':input[accessory=value]');
		    	var val = parseInt( $.trim( $input.val() ) ) || max;
		    	
		    	if( min!=0 && max!=0 ){
			    	if( val < parseInt(min) ){
			    		val = min;
			    	}
			    	else if( val > parseInt(max) ){
			    		val = max;
			    	}
		    	}

		    	$input.val( val );
		    	
		    	self.sumAccessory();
		    });
		    self.$elem.delegate('.js-checked-accessory', 'change', function () {

				var input = $(this).closest('li').find(':input[accessory]').not('.js-checked-accessory');

				if( $(this).prop('checked') ){
					input.removeClass('disabled').prop('disabled', false);
				}
				else{
					input.addClass('disabled').prop('disabled', true);
				}

				self.sumAccessory();
			});	
			self.$elem.delegate('.js-plus-accessory','click', function () {
				var empty = false;
				var parent = $(this).closest('li');
				var input = parent.find(':input').first();

				if( input.val()=='' ){
					input.focus();
				}
				else{
					var clone = parent.clone();
					clone.find(':input').val('');

					parent.after( clone );
					clone.find(':input').first().focus();
				}

				self.sortAccessory();
			});
			self.$elem.delegate('.js-remove-accessory', 'click', function () {

				if( $listsbox_accessory.find('.etc').length == 1 ){
					$(this).closest( 'li' ).find(':input').val('');
					$(this).closest( 'li' ).find(':input').first().focus();
				}
				else{
					$(this).closest( 'li' ).remove();
					self.sortAccessory();
				}
			});

			// change Deposit Type
			self.$form_bookType = self.$elem.find('.form_depositType');
			self.changeDepositType( self.$form_bookType.find('[type=radio]:checked') );
			self.$form_bookType.find('[type=radio]').change(function () {
				self.changeDepositType( $(this) );
			});

			// change Payment
			self.changePayment();

			/* Event Insurance */
			self.$elem.delegate(':input.js-change-insurence', 'change', function () {
				self.$elem.find(':input[summary=insurance]').val( parseInt( $(this).val()) || 0 );
				self.summary();
			});
			self.$elem.find('.js-change-insurenceSure').click(function () {
				var val = $(this).closest('tr').siblings().find('.inputtext').val() || '';

				$(this).closest('tr').find('.inputtext').val(val).removeClass('disabled').prop('disabled', false).focus();
				$(this).closest('tr').siblings().find('.inputtext').val('').addClass('disabled').prop('disabled', true);

				self.summary();
			});

			// change conditions
			self.changeConditions();
			
			/**/
			/* Event input number */
			/**/
			self.$elem.delegate('.js-number', 'keyup', function (e) {
			});
			self.$elem.delegate('.js-number', 'keypress', function (e) {
				if (e.keyCode == 13) { 
					self.change_number($(this).data('name'), $(this).val() );
				};
			});
			self.$elem.delegate('.js-number', 'keydown', function (e) {
		        // Allow: backspace, delete, tab, escape, enter and .
		        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		             // Allow: Ctrl/cmd+A
		             (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: Ctrl/cmd+C
		             (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: Ctrl/cmd+X
		             (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: home, end, left, right
		             (e.keyCode >= 35 && e.keyCode <= 39)) {
		                 // let it happen, don't do anything
		             return;
		        }
		        // Ensure that it is a number and stop the keypress
		        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		        	e.preventDefault();
		        }
		    });
		    self.$elem.delegate('.js-number', 'change', function () {
		    	self.change_number($(this).data('name'), $(this).val() );		    	
		    })
		    self.$elem.delegate('.js-number', 'blur',function () {

		    	if( $(this).val()=='' ||  $(this).val()<0 ){
		    		$(this).val( 0 );
		    	}
		    });

		    var $cus = self.$elem.find('[data-section=customers]');
			var $inputCus = self.$elem.find('#cus_first_name');
			$inputCus.focus();
			$inputCus.searchcustomer({
				onSelected: function ( data, then ) {

					$.get( Event.URL + 'customers/_get/' + data.id, function (result) {
						if( result.error ) return false;
						self.setDataCus( result );
					}, 'json');
					
					// 
					var $parent = then.$elem.parent();
					var $overlay = $parent.find('.overlay');

					var $edit = $('<a>', {type: 'button', class: 'remove'}).append( $('<i>', {class: 'icon-pencil'}) );
					var $remove = $('<a>', {type: 'button', class: 'remove'}).append( $('<i>', {class: 'icon-remove'}) );
					
					$parent.addClass('active'); 
					$overlay.append(
						$('<input>', {class: 'inputHidden', type: 'hidden', name: 'cus[id]', id: 'cus_id', value: data.id }),
						$remove,
						$edit
					);

					self.$elem.find(':input[id=book_cus_refer]').val( 5 );
					$cus.find(':input').not('[id=book_cus_refer],[id=cus_id]').addClass('disabled').prop('disabled', true);

					$remove.click(function () {

						$parent.removeClass('active'); 
						$overlay.empty();

						$cus.find(':input').removeClass('disabled').prop('disabled', false).val('');

						$.each( $cus.find('select'), function () {
							$(this).val( $(this).find('option').first().val() );	
						});

						then.$elem.focus();

						$cus.removeClass('is-token');

						$.each($cus.find('.form-field'), function(){
							$.each( $(this).find('.control-group'), function (i) {
								if( i>0 ) $(this).remove();
							} );
						});
					});

					$edit.click(function () {
						
						Dialog.load( Event.URL + 'customers/edit/' + data.id, {callback: true}, {
							onClose: function () {},
							onSubmit: function ( el ) {
								
								$form = el.$pop.find('form');

								Event.inlineSubmit( $form ).done(function( result ) {

									result.onDialog = true;
									result.url = '';
									Event.processForm($form, result);

									if( result.error ){
										return false;
									}
									
									self.setDataCus( result.data );
									Dialog.close();
								});
								
							}
						});		
					});
				}
			});
		},

		setDataCus: function (data) {
			var self = this;
			var $cus = self.$elem.find('[data-section=customers]');

			$cus.addClass('is-token');
			$.each( data||{}, function(name, val){

				if( name=='options' ){
					$.each( val, function(key, items){

						var $field = $cus.find('.form-field-'+key);

						var $control = $field.find('.control-group').first().clone();
						$control.find(':input').not('select').val('');
						$field.empty();

						$.each( items, function(i, value){

							var bx = $control.clone();
							bx.find('.labelselect').val( value.name );
							bx.find('.js-input').val( value.value );
							
							$field.append( bx );
						});
					});
				}else if( name=='birthday' ){
					var birthday = new Date( val );

					var d = birthday.getDate();
					d = d < 10 ? '0'+d:d;

					var m = birthday.getMonth();
					m = m < 10 ? '0'+m:m;

					$cus.find(':input[id=cus_birthday_date]').val( d );
					$cus.find(':input[id=cus_birthday_month]').val( m );
					$cus.find(':input[id=cus_birthday_year]').val( birthday.getFullYear() );
				}else if( name=='address' ){
					$.each( val, function(key, d){
						input = $cus.find(':input[id=address_'+ key +']');
						if( input.length==1 ) input.val( d );
					});
				}
				else{
					input = $cus.find(':input[id=cus_'+ name +']');
					if( input.length==1 ) input.val( val );
				}
			});
		},

		change_number: function ( type, val ) {
			var self = this;

			self.$elem.find('[data-name='+ type +']').not('.not-clone').val( $.trim( val ) );
			self.summary();
		},

		changeModel: function () {
			var self = this;

			// load product item for model
			var $item = self.$elem.find('select#book_pro_id');
			$.get(Event.URL + 'booking/get_product', {model: self.data.model }, function (res) {

				$item.empty();
				$.each( res, function (i, obj) {
					$item.append( $('<option>', {value: obj.id, text: obj.name, 'data-price': parseInt( obj.price ) }) );
				} );

				self.payment();
			}, 'json');

			$item.change(function () {
				self.payment();
			});

			// load color for model
			var $color = self.$elem.find('select#book_color');
			$.get(Event.URL + 'booking/get_color', {model: self.data.model }, function (res) {

				$color.empty();

				$.each( res, function (i, obj) {
					$color.append( $('<option>', {value: obj.id, text: obj.name, 'data-code': obj.code }) );
				} );
			}, 'json');

			// get Accessory for model3
			var $accessory = self.$elem.find('[data-section=accessory]');
			var $listsbox_accessory = $accessory.find('[rel=listsbox]');

			$.get(Event.URL + 'booking/get_accessory', {model: self.data.model }, function (res) {

				$listsbox_accessory.find('li').not('.etc').remove();

				var no = 0;
				$.each( res, function (i, obj) {
					no++;

					var text = obj.name; // + ' ราคา '+ PHP.number_format(obj.price) +' บาท/baht';

					var input = $('<input>', {type: 'checkbox', name: 'accessory[name][]', value: obj.id, class: 'js-checked-accessory', accessory: 'name' });
					var label = $('<label>', {class: 'checkbox'}).append( input );

					var inputName = $('<input>', {type:"text", class: 'inputtext' });
					inputName.addClass('disabled').prop('disabled', true);

					var inputValue = $('<input>', {
						type:"text", 
						class: 'inputtext js-change-accessory',
						name: 'accessory[value][]',
						accessory: 'value'
					});
					inputValue.addClass('disabled').prop('disabled', true);

					var note = $('<div>', {class: 'fcg fsm tar'});
					note.append( 'ช่วงราคา ' + parseInt( obj.cost ) + '-' + parseInt( obj.price ) );

					var tr = $('<tr>', {class: 'tr-box'});
					tr.append( 
						  $('<td>', {class: 'ID'}).html( label ) 
						, $('<td>', {class: 'name'}).html( inputName.val( text ) ) 
						, $('<td>', {class: 'price'}).append( 

							inputValue.val( parseInt( obj.price ) ) 

						) 
						, $('<td>', {class: 'actions'}).append( $('<label>', {class: 'checkbox'}).append(
							$('<input>', {
								type: 'checkbox', 
								name: 'accessory[foc][]', 
								value:'less',
								class: 'js-change-accessory',
								accessory: 'foc'
							}).addClass('disabled').prop('disabled', true)
						) ) 
					);


					var meta = $('<div>', {class: 'accessory-meta'});
					meta.append(
						  $('<input>', {
						  	type:"hidden", 
						  	name:'accessory[cost][]', 
						  	value: parseInt(obj.cost),
						  	accessory: 'cost'
						  }).addClass('disabled').prop('disabled', true)
						, $('<input>', {
							type:"hidden", 
							name:'accessory[rate][]',
							value: parseInt( obj.price ),
							accessory: 'rate'
						}).addClass('disabled').prop('disabled', true)
						, $('<input>', {
							type:"hidden", 
							name:'accessory[has_etc][]',
							value: 0,
							accessory: 'has_etc'
						}).addClass('disabled').prop('disabled', true)
					);

					var li = $('<li>', {'data-id': obj.id}).append( 
						meta , $('<table>').append( 
							$('<tr>', {class: 'tr-label'}).append(
								$('<td>', {colspan: 3}).html( note ), 
								$('<td>', {class: 'actions'}).html( $('<label>', {text: 'แถม'}) )
							), 
							tr 
						)
					);

					if( text.length>=40 ) li.addClass( 'wfull' );

					li.data( obj );

					$listsbox_accessory.find('.etc').first().before( li );
				} );

				self.sortAccessory();
			}, 'json');
		},

		changeDepositType: function ( $el ) {
			var self = this;

			self.$form_bookType.find(':input').not('[type=radio]').addClass('disabled').prop('disabled', true);

			$el.closest('li').find(':input').not('[type=radio]').removeClass('disabled').prop('disabled', false)
		},
		changeConditions: function () {
			var self = this;

			var $form = self.$elem.find('.form_conditions');
			$form.delegate('.js-plus-list','click', function () {
				
				var parent = $(this).closest('tr');
				var input = parent.find(':input').first();
				

				if( input.val()=='' ){
					input.focus();
				}
				else{
					var $clone = parent.clone();
					$clone.find(':input').val('');

					parent.after( $clone );
				}

			});

			$form.delegate('.js-remove-list','click', function () {

				var parent = $(this).closest('tr[data-id=etc]');

				if( parent.parent().find('[data-id=etc]').length==1 ){
					var input = parent.find(':input').first();

					input.val('').focus();
				}
				else{
					parent.remove();
				}
			});
		},

		changePayment: function () {
			var self = this;

			var $form = self.$elem.find('.form_payment');

			$form.find('[action-set]').change(function () {
				_action( $(this).val()=='hier' ? true: false )
			}); 

			_action( $form.find('[action-set]:checked').val()=='hier' ? true: false );

			function _action( active ) {

				if( active ){
					$form.find('[action-type=paytype]').find(':input').removeClass('disabled').prop('disabled', false);
				}
				else{
					self.$elem.find('[data-name=paydown]').val(0);
					$form.find('[action-type=paytype]').find(':input').addClass('disabled').prop('disabled', true);
				}

				self.summary();
			}
		},
		payment: function () {
			var self = this;

			var $input = self.$elem.find(':input[data-name=carprice]');
			var val = $input.val() || 0;

			$input.val( self.$elem.find('select[product=item]>option:checked').data('price') );

			self.summary();
		},

		sumAccessory: function () {
			var self = this;

			var $accessory = self.$elem.find('[data-section=accessory]');
			var total = 0;

			$.each( $accessory.find('.list-table-cell>li'), function () {
				
				var $this = $(this);
				var price = $this.find(':input[accessory=value]').not('.disabled').val() || 0;

				if( $this.find(':input[accessory=type]').prop('checked') ){
					price = 0;
				}

				total += parseInt( price );
				
			});

			self.$elem.find(':input[summary=accessory]').val( total );
			self.summary();
		},
		sortAccessory: function () {
			var self = this;

			var $accessory = self.$elem.find('[data-section=accessory]');
			var row = 0;
			$.each( $accessory.find('.list-table-cell>li'), function () {

				$.each( $(this).find(':input[accessory]'), function () {
					$(this).attr('name', 'accessory['+ row +']['+ $(this).attr('accessory') +']');
				});

				row++;
			});
		},

		summary: function () {
			var self = this;

			var sub = 0, total = 0;
			var income = 0; 
			var less = 0;

			var $section = self.$elem.find('[data-section=conditions]');

			$.each( $section.find( '.js-number' ), function (i, obj) {
				
				var val = parseInt( $(this).val() || 0 );
				if( $(this).hasClass('is-lock')  ){
					val = 0;
				}

				if( $(this).data('type')=='income' ){
					income += val;
				}

				if( $(this).data('type')=='less' ){
					less += val;
				}

			} );

			$section.find('[summary=sub]').val( PHP.number_format(income, 2) );
			$section.find('[summary=total]').val( PHP.number_format(income-less, 2) );
		},
	}
	$.fn.bookingform = function( options ) {
		return this.each(function() {
			var $this = Object.create( BookingForm );
			$this.init( options, this );
			$.data( this, 'bookingform', $this );
		});
	};


	/**/
	/* Datalist */
	/**/
	var Datalist = {
		init: function (options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.datalist.options, options );

			// set Data
			self.orders = [];
			self.data = {
				start: null,
				end: null,
				q: '',
			};

			// set Elem
			self.setElem();
			self.Events();
			self.setCountHeader();
		},

		setElem: function () {
			var self = this;

			self.$listsbox = self.$elem.find('[role=listsbox]');
			self.$profile = self.$elem.find('[role=profile]');
			self.$content = self.$elem.find('.datalist-content');

			self.$profile.css({
				opacity: 0,
				left: '20%'
			});

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
				}],

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
		},
		Events: function () {
			var self = this;

			self.$elem.find('.js-new').click(function () {

				if( $(this).hasClass('disabled') ){
					return false;
				}

				self.hide();
				self.$listsbox.find('li.active').removeClass('active');
				$(this).addClass('disabled');
				self.newOrder();

				self.setLocation( self.options.URL + 'create', 'Create - Booking' );
			});


			/*$('body').find('.navigation-trigger').click(function(){
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

			*/

			self.$listsbox.delegate('li', 'click', function() {
				if( $(this).hasClass('head') || $(this).hasClass('active') ) return false;
				self.active( $(this) );
			});

			self.$profile.delegate('.js-cancel', 'click', function() {
				self.hide( function() {
					self.$profile.empty();

					if( self.$elem.find('.js-new').hasClass('disabled')  ){
						self.$elem.find('.js-new').removeClass('disabled');
					}
				});

				self.$listsbox.find('li.active').removeClass('active');
			});
		},
		setCountHeader: function() {
			var self = this;

			var a = ['count-today', 'count-yesterday', 'count-total'];

			$.each(a, function (i, key) {
				
				var res = key.split('-');

				var text = '';
				if( self.options[res[0]] ){
					text = self.options[res[0]][res[1]];
				}
				self.$elem.find('[view-text='+key+']').text( text || '-' );
			});
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

					// reset 
					self.orders = [];
					self.$listsbox.empty();
					self.$profile.addClass('hidden_elem');

					var total = results.total;
					self.$elem.find('[view-text=total]').text( total );

					if( results.total==0 ){

						self.$listsbox.parent().addClass('has-empty');
						return false;
					}
					self.buildFrag( results.lists );
					
					// self.resize();
				});
				
			}, length || 1);
		},
		fetch: function(){
			var self = this;

			if( !self.data ) self.data = {};

			return $.ajax({
				url: self.options.load_orders_url,
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
				
				self.displayItem( obj );
			});

			if( self.$listsbox.find('li.active').length==0 && self.$listsbox.find('li').not('.head').first().length==1 ){

				self.active( self.$listsbox.find('li').not('.head').first() );
			}
		},
		setItem: function (data, options) {
			var self = this;

			var date = new Date( data.created );
			var minute = date.getMinutes();
			minute = minute < 10? '0'+minute:minute;

			var options = options || data.options || {};

			// set Elem
			var li = $('<li/>');
			var inner = $( data.url ? '<a>': '<div>', {
				class: 'inner'
			});


			// avatar
			if( data.image_url ){
				inner.append( $('<div/>', {class:'avatar'}).html( $('<img/>', {calss: 'img', src: data.image_url}) ) );
				li.addClass('picThumb');
			}

			// time
			if( options.time === 'disabled' ){
				li.addClass( 'hide_time' );
			}
			else{
				inner.append( $('<div/>', {class: 'time', text: date.getHours() + ":" + minute }) );
			}

			// text
			if( data.text ){
				inner.append( $('<div/>', {class: 'text', text: data.text}) );
			}

			// subtext
			if( data.subtext ){
				inner.append( $('<div/>', {class: 'subtext', text: data.subtext}) );
			}

			// category
			if( data.category ){
				inner.append( $('<div/>', {class: 'category', text: data.category}) );
			}

			// status
			if( data.status ){
				if( typeof data.status === 'object' ){
					inner.append( $('<div/>', {class: 'status', text: data.status.name}).css('background-color', data.status.color ) );
				}
				else{
					inner.append( $('<div/>', {class: 'status', text: data.status}) );
				}
			}
			
			li.html( inner );
			li.data( data );
			return li;	
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

		show: function ( callback ) {
			var self = this;

			if( self.is_show ){

				self.hide( function () {

					setTimeout(function () {
						self._show(callback);
					}, 200)
					
				} );
			}
			else{
				self._show(callback);
			}
		},
		_show: function ( callback ) {
			var self = this;

			self.is_show = true;
			self.$profile.stop().animate({
				left: 0,
				opacity: 1
			}, 200, callback||function () {});
		},
		hide: function ( callback ) {
			var self = this;

			self.is_show = false;
			self.$profile.stop().animate({
				left: '20%',
				opacity: 0
			}, 200, callback||function () {});
		},
		active: function ( $el ) {
			var self = this;

			if( self.$elem.find('.js-new').hasClass('disabled')  ){
				self.$elem.find('.js-new').removeClass('disabled');
			}

			var data = $el.data();
			$el.addClass('active').siblings().removeClass('active');

			var t = setTimeout(function () {
				self.$content.addClass('has-loading');
			}, 800);

			$.get( self.options.load_profile_url, {id: data.id}, function( body ) {
				clearTimeout( t );

				self.$content.removeClass('has-loading');
				self._profile.init( {}, body, self );

				self.current = data;
				self.setLocation( self.options.URL + data.id, data.text + ' - Booking' );
			});
		},
		setLocation: function (href, title) {
			
			var returnLocation = history.location || document.location;

			var title = title || document.title;

			history.pushState('', title, href);
			document.title = title;
		},
		_profile: {
			init: function (options, elem, parent) {
				var self = this;

				self.parent = parent;
				self.options = options;
				self.$elem = $(elem);

				// set elem
				self.parent.$profile.html( self.$elem ).removeClass('hidden_elem');

				Event.plugins( self.$elem.parent() );
				self.resize();

				self.setData();

				// show 
				self.parent.show();

				self.Events();
				
			},

			resize: function ( ) {
				var self = this, top = 20, bottom = 20;
				var w = self.parent.$profile.outerWidth();

				if( self.$elem.find('.datalist-main-header').length==1 ){
					top = self.$elem.find('.datalist-main-header').outerHeight();
					self.$elem.find('.datalist-main-header').css( 'max-width', w );
				}

				if( self.$elem.find('.datalist-main-footer').length==1 ){
					bottom = self.$elem.find('.datalist-main-footer').outerHeight();
					self.$elem.find('.datalist-main-footer').css( 'max-width', w );
				}

				self.$elem.find('.datalist-main-content').css({
					paddingTop: top,
					paddingBottom: bottom
				});
			},

			Events: function () {
				var self = this;

				self.$elem.find('.settingsLabel, .js-settings-cancel').click( function () {

					var $elem = $(this).closest('.settingsForm');
					var section = $elem.data('section');
					var is = $elem.hasClass('is-active');
					var q = '';

					if( !is ){

						q = section;
						$elem.addClass('is-active').siblings().removeClass('is-active');
					}
					else{
						$elem.removeClass('is-active');
					}

					if( q!='' ) q = '/' + q;
					self.parent.setLocation( self.parent.options.URL+self.parent.current.id + q );

					self.setData();
				});

			},

			setData: function () {
				var self = this;

				$.each(self.$elem.find('.settingsForm'), function () {
					
					var $form = $(this);

					var data = '';
					var cell = 0;
					$.each($form.find('.js-data'), function(i, obj) {
						cell++;

						// tap = 
						var str = '';
						if( $(obj).data('type')=='BR' || $(obj).context.nodeName=='BR' ){
							str = '<br>';
							cell = 0;
						}else if( $(obj).context.nodeName == 'SELECT' ){
							str = $.trim( $(obj).find(':selected').text() );
						}
						else if( $(obj).context.nodeName == 'SPAN' ){
							str = $(obj).html();
						}
						else{
							str = $.trim( $(obj).val() );
						}
			
						data+= cell<=1 ?'':', ';
						data+= str;

					});

					$form.find('.settingsLabel .settingsLabelTable .data-wrap').html( data );   
				});
				
				// js-data
			}
		},

		newOrder: function () {
			
			var self = this;

			var t = setTimeout(function () {
				self.$content.addClass('has-loading');
			}, 800);
			
			$.get( self.options.load_create_url, function( body ) {
				clearTimeout( t );

				self.$content.removeClass('has-loading');
				self._newOrder.init( {}, body, self );
			});
		},
		_newOrder: {
			init: function (options, elem, parent) {
				var self = this;

				self.parent = parent;
				self.options = options;
				self.$elem = $(elem);

				// set elem
				self.parent.$profile.html( self.$elem ).removeClass('hidden_elem');

				Event.plugins( self.$elem.parent() );
				self.resize();
				// show 
				self.parent.show();
			},

			resize: function ( ) {
				var self = this, top = 20, bottom = 20;
				var w = self.parent.$profile.outerWidth();

				if( self.$elem.find('.datalist-main-header').length==1 ){
					top = self.$elem.find('.datalist-main-header').outerHeight();
					self.$elem.find('.datalist-main-header').css( 'max-width', w );
				}

				if( self.$elem.find('.datalist-main-footer').length==1 ){
					bottom = self.$elem.find('.datalist-main-footer').outerHeight();
					self.$elem.find('.datalist-main-footer').css( 'max-width', w );
				}

				self.$elem.find('.datalist-main-content').css({
					paddingTop: top,
					paddingBottom: bottom
				});
			}
		},
	};
	$.fn.datalist = function( options ) {
		return this.each(function() {
			var $this = Object.create( Datalist );
			$this.init( options, this );
			$.data( this, 'datalist', $this );
		});
	};
	$.fn.datalist.options = {}

	/**/
	/* checklist */
	/**/
	var Checklist = {
		init: function (options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.checklist.options, options );;
			self.lists = [];

			$.each( self.$elem.find('.checklist-item.checked'), function () {
				
				self.checked( $(this) );
			});
			
			// Event
			self.$elem.delegate('.checklist-item', 'click', function () {
				self.change( $(this) );
			});
		},

		change: function ( $el ) {
			var self = this;

			var checkbox = $el.find('input[type=checkbox]');
			
			if( checkbox.length==0 ) return false;

			var checked = checkbox.prop('checked');
			checkbox.prop('checked', !checked);
			$el.toggleClass( 'checked', !checked);

			if( checked==false ){
				self.checked( $el );
			}
			else{

				var lists = [];
				$.each(self.lists, function (i, obj) {
					if( obj.id != checkbox.val() ){
						lists.push( obj );
					}
				});

				self.lists = lists;
				self.summary();
			}
		},
		checked: function ( $el ) {
			var self = this;

			var checkbox = $el.find('input[type=checkbox]');

			self.lists.push({
				id: checkbox.val(),
				$elem: $el
			});

			if( self.lists.length>self.options.limit ){

				var lists = [];
				$.each(self.lists, function (i, obj) {
					if( i > (self.options.limit-1)  ){
						lists.push( obj );
					}
					else{
						obj.$elem.removeClass('checked').find('input[type=checkbox]').prop('checked', false);
					}
				});

				self.lists = lists;
			}

			self.summary();
		},

		summary: function () {
			var self = this;
			var total = self.lists.length;

			// console.log( total, self.lists );
		}
	};
	$.fn.checklist = function( options ) {
		return this.each(function() {
			var $this = Object.create( Checklist );
			$this.init( options, this );
			$.data( this, 'checklist', $this );
		});
	};
	$.fn.checklist.options = {
		limit: 1
	}


	var EmpPosition = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $( elem );
			self.options = $.extend( {}, $.fn.empposition.options, options );
			// 
			var $position = self.$elem.find('.js-change-position');
			var $department = self.$elem.find('select.js-position');
			var pos_id = $position.data('pos_id');

			$department.change(function () {

				$.get( Event.URL + 'employees/get_position', {id: $(this).val() }, function (res) {
					if( res.error ) return false;
					$position.empty(); 
					self.options.positions = res;
					self.setPositions();
				}, 'json');
			});

			if( $department.val() != '' ){

				var $dep_id = $department.val();

				$.get( Event.URL + 'employees/get_position', {id: $dep_id }, function (res) {
					if( res.error ) return false;
					$position.empty(); 
					self.options.positions = res;
					self.setPositions( pos_id );
				}, 'json');
			}
		},
		setPositions: function ( pos_id=null ) {
			var self = this;

			var $positions = $('<select>', {class: 'inputtext js-change-position', name: 'emp_pos_id'});
			$positions.append( $('<option>', {value: '', text: '-'}) );
			$.each( self.options.positions, function (i, obj) {
				if( pos_id == obj.id ){
					$positions.append( $('<option>', {value: obj.id, text: obj.name, selected: true}) );
				}else{
					$positions.append( $('<option>', {value: obj.id, text: obj.name}) );
				}
			} );

			$('.form-insert').find('.js-change-position').parent().html( $positions );
		},
	}
	$.fn.empposition = function( options ) {
		return this.each(function() {
			var $this = Object.create( EmpPosition );
			$this.init( options, this );
			$.data( this, 'emp_position', $this );
		});
	};
	$.fn.empposition.options = {
		positions: []
	}


	var AddProductItem = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $( elem );
			self.$listbox = self.$elem.find( '[rel=listbox]' );
			self.$number = self.$elem.find( '.js-number' );
			self.options = $.extend( {}, $.fn.addPDItem.options, options );

			self.$listbox.append( self.getItem() );
			self.sort();

			// Event
			self.Events();
		},
		getItem: function ( data ) {
			var self = this;

			var data = data || {}, $remove, $clone;
			
			$remove = $('<button>', {type: 'button', class: 'js-remove-item ui-item-remove'}).html( $('<i>', {class: 'icon-remove'}) );
			$clone = $('<button>', {type: 'button', class: 'js-clone-item'}).html( $('<i>', {class: 'icon-clone'}) );

			var $colors = $('<select>', {class: 'inputtext js-change-color', name: 'items[color][]'});
			$colors.append( $('<option>', {value: '', text: '-'}) );
			$.each( self.options.colors, function (i, obj) {
				$colors.append( $('<option>', {value: obj.id, text: obj.name}) );
			} );

			var $tr = $('<div>', {class: 'ui-item uiBoxWhite pam clearfix mbm'}).append(
				$('<div>', {class: 'clearfix'}).append(
					$('<div>', {class: 'control-group lfloat prm'}).append(
						$('<div>', {class: 'js-no'})
						),

					$('<div>', {class: 'control-group lfloat prm'}).append(
						$('<label>', {class: 'control-label', text: 'VIN(เลขตัวถัง)'})
						, $('<div>', {class: 'controls'}).append(
							$('<input>', {type: 'text', class: 'inputtext', name: 'items[vin][]'})

							)
						),

					$('<div>', {class: 'control-group lfloat prm'}).append(
						$('<label>', {class: 'control-label', text: 'หมายเลขเครื่องยนต์'})
						, $('<div>', {class: 'controls'}).append(
							$('<input>', {type: 'text', class: 'inputtext', name: 'items[engine][]'})
							)
						),

					$('<div>', {class: 'control-group lfloat'}).append(
						$('<label>', {class: 'control-label', text: 'สี'})
						, $('<div>', {class: 'controls u-table'}).append(
							$('<div>', {class: 'u-table-row'}).append(
								$('<div>', {class: 'u-table-cell ui-box-color'})
								, $('<div>', {class: 'u-table-cell'}).html( $colors ) 
								)
							)
						)
					),

				$('<div>', {class: 'ui-item-actions'}).append(
					$clone, $remove
					)
				);


			return $tr;
		},
		Events: function () {
			var self = this;

			self.$elem.delegate( '.js-clone-item', 'click', function () {
				var $item = $(this).closest('.ui-item');
				var $el = $item.clone();
				$item.after( $el );
				self.sort();
			});

			self.$elem.delegate( '.js-remove-item', 'click', function () {

				var $item = $(this).closest('.ui-item');

				if( self.$elem.find('[role=listbox]').find('.ui-item').length==1 ){
					self.$elem.find('[role=listbox]').find('.ui-item :input').val('');
				}
				else{
					$item.remove();
					self.sort();
				}
				
			});

			self.$elem.delegate( '.js-change-color', 'change', function () {

		    	var $this = $(this);
		    	var val = $this.val(), color = '', $box = $(this).closest('.ui-item').find('.ui-box-color');

		    	$.each(self.options.colors, function (i, obj) {
		    		if( obj.id==val ){
		    			color = obj.color;
		    			return false
		    		}
		    	});

		    	$box.css({ backgroundColor: color });
		    });

		    self.$number.keypress(function (e) {
				if (e.keyCode == 13) { 
					self.changeItem( $(this).val() );
				};
			}).keydown(function (e) {
		        // Allow: backspace, delete, tab, escape, enter and .
		        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		             // Allow: Ctrl/cmd+A
		             (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: Ctrl/cmd+C
		             (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: Ctrl/cmd+X
		             (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: home, end, left, right
		             (e.keyCode >= 35 && e.keyCode <= 39)) {
		                 // let it happen, don't do anything
		             return;
		         }
		        // Ensure that it is a number and stop the keypress
		        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		        	e.preventDefault();
		        }
		    }).change(function () {

		    	self.changeItem( $(this).val() );
		    }).blur(function () {

		    	if( $(this).val()=='' ||  $(this).val()<0 ){
		    		$(this).val( 0 );
		    	}
		    });
		},
		changeItem: function ( length ) {
			var self = this;

			var cost = 0;
			$.each( self.$listbox.find('.ui-item'), function (i, obj) {
				
				var viy = false;
				$.each( $(obj).find(':input'), function () {
					if( $(this).val()!='' ){
						viy = true;
						return false;
					}
				});

				if(viy){ cost++; }
				else{
					$(obj).remove();
				}
			});
			
			var count = length - cost;	
			if( count<0 ){

				for (var i=cost - 1, c=1; i >= 0; i--, c++) {
					self.$listbox.find('.ui-item').eq( i ).remove();
					if( c==(count*-1) ) break;
				}
			} 

			for (var i = 0; i < count; i++) {
				self.$listbox.append( self.getItem() );
			}
			
			// self.$countItem.val( cost+count );
			self.sort();
		},
		sort: function () {
			var self = this;

			self.$number.val( self.$elem.find('.ui-item').length );
			var no = 0;
			$.each( self.$listbox.find('.ui-item'), function (i, obj) {
				
				$(obj).find('.js-no').text( (no+1) + '.' );		
				no++;

				$(obj).attr('id', 'items_' + no + '_fieldset');
			});

			// self.$items.toggleClass('has-empty', self.$itemslist.find('.ui-item').length==0);
		}
	}
	$.fn.addPDItem = function( options ) {
		return this.each(function() {
			var $this = Object.create( AddProductItem );
			$this.init( options, this );
			$.data( this, 'addPDItem', $this );
		});
	};
	$.fn.addPDItem.options = {
		colors: []
	}


	var ServiceForm = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $( elem );
			self.options = $.extend( {}, $.fn.serviceform.options, options );			

			self.setElem();

			self.changeStep( 0 );

			self.checkCar();

			self.Events();
		},
		setElem: function () {
			var self = this;

			self.is_keycodes = [37,38,39,40,13];
			self.has_load = false;
			self.is_newcus = false;

			// set item
			self.$listsitem = self.$elem.find('[role=listsitem]');
			if( self.options.items.length==0 ){
				self.getItem();
			}else{
				$.each( self.options.items, function (i, obj) {
					self.getItem(obj);
				} );
			}

			/*
			self.$inputCar = self.$elem.find('.js-search-car');
			self.$inputCar
				.parent()
				.addClass('ui-search')
				.append( 
					  $('<div>', {class: 'loader loader-spin-wrap'}).html( $('<div>', {class: 'loader-spin'}) )
					, $('<div>', {class: 'overlay'}) 
			);*/

			self.$searchWrap = self.$elem.find('.newOrder_search');
		},

		Events: function () {
			var self = this;

			self.$elem.delegate(':input', 'keypress', function (e) {
				if (e.keyCode == 13) {
					return false;
				}
			});

			//  
			self.$elem.find('.settingsLabel').click( function () {

				var open = $(this).parent().hasClass('is-active');
				$(this).parent().toggleClass('is-active', !open);
			});
			/*self.$elem.find(':input').click( function () {

				var open = $(this).parent().hasClass('is-active');
				$(this).parent().toggleClass('is-active', !open);
			});*/

			// item 
			self.$elem.delegate('.js-add-item', 'click', function () {
				var box = $(this).closest('tr');

				if( box.find(':input').first().val()=='' ){
					box.find(':input').first().focus();
					return false;
				}

				var setItem = self.setItem({});
				box.after( setItem );
				setItem.find(':input').first().focus();

				self.sortItem();
			});

			self.$elem.delegate('.js-remove-item', 'click', function () {
				var box = $(this).closest('tr');

				if( self.$listsitem.find('tr').length==1 ){
					box.find(':input').val('');
					box.find(':input').first().focus();
				}
				else{
					box.remove();
				}

				self.sortItem();
			});
			
			
			// sender
			self.changeSender( self.$elem.find('.js-senderIsOwner:checked').val() );
			self.$elem.find('.js-senderIsOwner').change( function () {
				
				self.changeSender( parseInt($(this).val()) );
			} );
			
			// top Search
			self.$inputCus = self.$elem.find('#cus_first_name');
			self.$inputCus.searchcustomer({
				url: Event.URL + 'customers/search',
				onSelected: function ( data, then ) {
					self.getCus( data.id );		
				}
			});

			self.$inputSearch = self.$elem.find('.js-search');
			self.$inputSearch.focus();
			self.$inputSearch.searchcustomer({
				url: Event.URL + 'cars/search',
				onSelected: function ( result, then ) {

					self.getCus( result.data.cus.id, function () {

						self.$elem.find('[role=search]').addClass('hidden_elem');

						self.$elem.find('[role=steplist]').find( '[data-id=sender], [data-id=owner], [data-id=car]' ).addClass('is_success');

						var $car = self.$elem.find('[data-section=car]');
						$car.find(':input').not('.has-edit').addClass('disabled').prop('disabled', true);

						// set id 
						self.$elem.find(':input[data-name=car_id]').val( result.id ).removeClass('disabled').prop('disabled', false);

						self.changeModel( result.data.model.id, function () {
							
							self.$inputCarID = $('<input>', {type: 'hidden', name:'car[id]', value: result.data.id });

							$.each( result.data||{}, function(name, val){
								
								if( typeof val === 'object' ){

									if( name=='model' || name=='pro' || name=='color' ){

										input = $car.find(':input[id=car_'+ name +'_id]');
										if( input.length==1 ) input.val( val.id );
									}

								}
								else{
									input = $car.find(':input[id=car_'+ name +']');
									if( input.length==1 ) input.val( val );
								}
							});

							var next = self.$elem.find('[role=steplist]').find('[data-id=car]').index();
							self.changeStep( next );
						} );

					} );

					
				}
			});

			self.$elem.find('.js-new-cus').click(function(e) {
				e.preventDefault();

				self.is_newcus = true;
				self.checkCar();
				self.$inputCus.focus();
			});

			self.$elem.find('.js-next').click(function(e) {

				var li = self.$elem.find('.uiStepSelected');
		
				if( li.next().length==1 ){
					type = li.data('id');
				}
				else{
					type = 'save';
				}

				self.submit( type );
				// 
				e.preventDefault();
			});

			self.$elem.find('.js-prev').click(function(e) {

				var li = self.$elem.find('.uiStepSelected');
				if( li.prev().length == 1 ){
					self.changeStep('prev');
					self.setPrev();
				}
				
				e.preventDefault();
			});

			self.$elem.find('.uiStep').click(function(e) {

				var li = $(this);
				var index = $(this).index();

				if( li.hasClass('uiStepSelected') ){
					return false;
				}

				if( index == (self.changeStepSelected()+1) ){

					self.submit( self.$elem.find('.uiStepSelected').data('id') );
					return false;
				}

				if( index < self.changeStepSelected() || li.hasClass('is_success') ){
					self.changeStep(index);
				}

				if( li.prev().length ){
					if( li.prev().hasClass('is_success') ){
						self.changeStep(index);
					}
				}

				e.preventDefault();
			});
			
			self.$elem.submit(function (e) {
				e.preventDefault();

				self.submit('save');
			});

			self.changeModel( self.$elem.find('[selector=model]').val() );
			self.$elem.find('[selector=model]').change(function () {
				self.changeModel( $(this).val() );
			});

			self.$elem.find('[selector=product]').change(function () {
				self.changeProduct( $(this).val() );
			});


			self.$elem.delegate('.js-change-item', 'change', function () {
				self.summaryItem();
			});
			self.$elem.delegate('.js-change-item', 'keyup', function () {
				self.summaryItem();
			});
			

			self.setPrev();
		},

		getCus: function ( id, callback ) {
			var self = this;
			var $cus = self.$elem.find('[data-section=owner]');

			$.get( Event.URL + 'customers/_get/' + id, function (result) {
				if( typeof callback === 'function' ){
					callback( result );
				}

				if( result.error ) return false;
				self.setCus( result );

				$cus.find(':input').addClass('disabled').prop('disabled', true);
				var $parent = self.$inputCus.parent();
				var $overlay = $parent.find('.overlay');

				var $edit = $('<a>', {type: 'button', class: 'remove'}).append( $('<i>', {class: 'icon-pencil'}) );
				var $remove = $('<a>', {type: 'button', class: 'remove'}).append( $('<i>', {class: 'icon-remove'}) );
				
				$parent.addClass('active'); 
				$overlay.append(
					$('<input>', {class: 'inputHidden', type: 'hidden', name: 'cus[id]', id: 'cus_id', value: id }),
					$remove, $edit
				);

				$remove.click(function () {

					$parent.removeClass('active'); 
					$overlay.empty();

					$cus.find(':input').removeClass('disabled').prop('disabled', false).val('');

					$.each( $cus.find('select'), function () {
						$(this).val( $(this).find('option').first().val() );	
					});

					self.$inputCus.focus();

					$cus.removeClass('is-token');

					$.each($cus.find('.form-field'), function(){
						$.each( $(this).find('.control-group'), function (i) {
							if( i>0 ) $(this).remove();
						} );
					});

					self.clearCar();
				});

				$edit.click(function () {
					
					Dialog.load( Event.URL + 'customers/edit/' + id, {callback: true}, {
						onClose: function () {
						},
						onSubmit: function ( el ) {
							
							$form = el.$pop.find('form');

							Event.inlineSubmit( $form ).done(function( result ) {

								result.url = '';
								Event.processForm($form, result);

								if( result.error ){
									return false;
								}

								self.setCus( result.data );
							});	
						}
					});	
				});
			}, 'json');
		},
		setCus: function ( data ) {
			var self = this;
			var $cus = self.$elem.find('[data-section=owner]');

			$cus.addClass('is-token');
			$.each( data||{}, function(name, val){

				if( name=='options' ){
					$.each( val, function(key, items){

						var $field = $cus.find('.form-field-'+key);

						var $control = $field.find('.control-group').first().clone();
						$control.find(':input').not('select').val('');
						$field.empty();

						$.each( items, function(i, value){

							var bx = $control.clone();
							bx.find('.labelselect').val( value.name );
							bx.find('.js-input').val( value.value );
							
							$field.append( bx );
						});
					});
				}else if( name=='birthday' ){
					var birthday = new Date( val );

					var d = birthday.getDate();
					d = d < 10 ? '0'+d:d;

					var m = birthday.getMonth();
					m = m < 10 ? '0'+m:m;

					$cus.find(':input[id=cus_birthday_date]').val( d );
					$cus.find(':input[id=cus_birthday_month]').val( m );
					$cus.find(':input[id=cus_birthday_year]').val( birthday.getFullYear() );
				}else if( name=='address' ){
					if( val ){
						$.each( val, function(key, d){
							input = $cus.find(':input[id=address_'+ key +']');
							if( input.length==1 ) input.val( d );
						});
					}
				}
				else{
					input = $cus.find(':input[id=cus_'+ name +']');
					if( input.length==1 ) input.val( val );
				}
			});

		},

		checkCar: function () {
			var self = this;

			var has = false;
			if( self.options.steps.owner.data || self.is_newcus ){
				has = true;
			}

			self.$searchWrap.toggleClass('hidden_elem', has);
		},
		clearCar: function () {
			var self = this;

			var $car = self.$elem.find('[data-section=car]');
			
			$car.find(':input').not('.has-edit').removeClass('disabled').prop('disabled', false).val('');

			var $model = $car.find('[selector=model]');
			$model.find('option').first().prop('selected', true);
			self.changeModel( $model.val() );

			self.$elem.find(':input[data-name=car_id]').val('').addClass('disabled').prop('disabled', true);
		},

		changeSender: function ( checked ) {
			var self = this;

			var $section = self.$elem.find('[data-section=sender]');
			
			if( checked ){
				$section
					.find('.control-group')
					.not('#sender_is_owner_fieldset')
						.addClass('hidden_elem')
						.find(':input')
							.addClass('disabled')
							.prop('disabled', true);
			}
			else{

				$section
					.find('.control-group')
					.not('#sender_is_owner_fieldset')
						.removeClass('hidden_elem')
						.find(':input')
							.removeClass('disabled')
							.prop('disabled', false);
			}
		},
		changeModel: function ( val, callback ) {
			var self = this;

			var $item = self.$elem.find('[selector=product]');
			$.get(Event.URL + 'booking/get_product', {model: val }, function (res) {

				$item.empty();
				$.each( res, function (i, obj) {
					$item.append( $('<option>', {value: obj.id, text: obj.name, 'data-price': parseInt( obj.price ) }) );
				} );

				if( typeof callback === 'function' ){
					callback();
				}
				else{
					self.changeProduct( self.$elem.find('[selector=model]').val() );
				}
	
			}, 'json');
		},
		changeProduct: function ( val, callback ) {
			var self = this;

			var $color = self.$elem.find('[selector=colorcar]');
			$.get(Event.URL + 'products/get_modelcolor', {id: val}, function (res) {

				$color.empty();
				$.each( res, function (i, obj) {
					$color.append( $('<option>', {value: obj.id, text: obj.name, 'data-code': obj.code }) );
				} );

				if( typeof callback === 'function' ){
					callback();
				}
			}, 'json');			
		},

		getItem: function (data) {
			var self = this;

			self.$listsitem.append( self.setItem( data || {} ) );
			self.sortItem();
		},
		setItem: function ( data ) {
			var self = this;
			
			$tr = $('<tr>');
			$tr.append(
				  $('<td>', {class: "no"})
				, $('<td>', {class: 'type'}).append( 
					$('<input>', {
					  	type:"text",
					  	name:"items[name][]",
					  	class:"inputtext",
					  	autocomplete:"off"
					}).val( data.name ) 
				)
				, $('<td>', {class: 'price'}).append( 
					$('<input>', {
					  	type:"text",
					  	name:"items[value][]",
					  	class:"inputtext js-change-item input-price",
					  	autocomplete:"off"
					}).val( data.value ) 
				)
				, $('<td>', {class: 'actions'}).append( 
					$('<button>', {
					  	type:"button",
					  	class:"i-btn-a1 js-add-item",
					}).html( $('<i>', {class: 'icon-plus'}) ), 
					$('<button>', {
					  	type:"button",
					  	class:"i-btn-a1 js-remove-item",
					}).html( $('<i>', {class: 'icon-remove'}) )
				)
			);

			return $tr;
		},
		sortItem: function () {
			var self = this;

			var no = 0, total_price = 0;
			$.each(self.$listsitem.find('tr'), function (i, obj) {
				no++;

				$(this).find('.no').text( no );

				total_price+=parseInt( $(this).find('.js-price').val() || 0 );
			});

			self.$elem.find('[summary=total-price]').text( total_price );
		},

		changeStepSelected: function () {
			var self = this;

			var $step = self.$elem.find('.newOrder_inputs-header').find('.uiStepSelected');
			return $step.index();
		},
		changeStep: function ( type, index ) {
			var self = this;

			if( type=='next' || type=='prev' ){
				var index = self.changeStepSelected();

				if( type=='next' ){
					index++; 
				}
				else if( type=='prev' ){
					index--;
				}
			}else index = type;

			self.$elem.find('.newOrder_inputs-header').find('.uiStep').eq(index).addClass('uiStepSelected').siblings().removeClass('uiStepSelected');
			self.$elem.find('.newOrder_inputs-section').eq( index ).removeClass('hidden_elem').siblings().addClass('hidden_elem');
		},
		setPrev: function () {
			var self = this;
			var index = self.changeStepSelected();

			self.$elem.find('.js-prev').toggleClass('hidden_elem', index==0);

			var $step = self.$elem.find('.uiStepSelected');
			self.$elem.find('.js-next').text( $step.next().length==0 ? 'บันทึก':'ต่อไป');
		},

		summaryItem: function () {
			var self = this;

			var total = 0;
			var $listsitem = self.$elem.find('[role="listsitems"]');
			$.each(  $listsitem.find(':input.input-price'), function (i, obj) {

				var input = $(obj);
				var val = parseInt( input.val() ) || 0;

				total += val
				input.val( val );
			});

			$listsitem.find('[summary=total]').text( PHP.number_format( total ) );
		},

		submit: function ( type ) {
			var self = this;


			var $form = self.$elem;
			var url = $form.attr('action');
			var $btn = self.$elem.find('.js-next');
			$btn.addClass('disabled is-loader').prop('disabled', true);

			$form.find('[name=type_form]').val( type );

			var formData = Event.formData($form);

			$.ajax({
				type: 'POST',
				url: url,
				data: formData,
				dataType: 'json'
			}).done(function( results ) {

				results.onDialog = true;
				Event.processForm($form, results);

				if( results.error ){
					return false;
				}

				if( type!='save' && !results.error ){

					self.$elem.find('.uiStep[data-id='+ type +']').addClass('is_success');
					self.changeStep( 'next' );
					self.setPrev();
					

					return false;
				}
				// console.log( 'done', results );
			}).fail(function() {
				
				Event.showMsg({'text': 'การเชื่อมต่อผิดผลาด', load: true, auto: true});
				$btn.removeClass('disabled').prop('disabled', false);
				// console.log( 'fail' );
			}).always(function() {

				$btn.removeClass('disabled').prop('disabled', false);
				// console.log( 'always' );
			});
		}
	}
	$.fn.serviceform = function( options ) {
		return this.each(function() {
			var $this = Object.create( ServiceForm );
			$this.init( options, this );
			$.data( this, 'serviceform', $this );
		});
	};
	$.fn.serviceform.options = {
		items: [],
		steps: []
	}

	var SearchCustomer = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $( elem );
			self.data = $.extend( {}, $.fn.searchcustomer.options, options );

			self.url = self.data.url || Event.URL + "customers/search/";

			self.$elem
				.parent()
				.addClass('ui-search')
				.append( 
					  $('<div>', {class: 'loader loader-spin-wrap'}).html( $('<div>', {class: 'loader-spin'}) )
					, $('<div>', {class: 'overlay'}) 
			);


			self.is_focus = false;
			self.is_keycodes = [37,38,39,40,13];
			self.load = false;
			self.is_focus2 = false;

			// Event
			var v;
			self.$elem.keyup(function (e) {
				var $this = $(this);
				var value = $.trim( $this.val() );

				self.is_focus2 = true;

				if( self.is_keycodes.indexOf( e.which )==-1 && !self.has_load ){

					self.$elem.parent().addClass('has-load');
					self.hide();

					clearTimeout( v );

					if(value==''){
						self.$elem.parent().removeClass('has-load');
						return false;
					}

					v = setTimeout(function(argument) {
						self.load = true;
						self.data.options.q = $.trim($this.val());
						self.search();
					}, 500);

				}
			}).keydown(function (e) {
				var keyCode = e.which;

				if( keyCode==40 || keyCode==38 ){

					self.changeUpDown( keyCode==40 ? 'donw':'up' );
					e.preventDefault();
				}

				if( self.$menu ){
					if( keyCode==13 && self.$menu.find('li.selected').length==1 ){
						self.active(self.$menu.find('li.selected').data());
					}
				}
			}).click(function (e) {
				var value = $.trim($(this).val());

				if(value!=''){

					if( self.data.options.q==value ){
						self.setMenu();
					}
					else{

						self.$elem.parent().addClass('has-load');
						self.hide();
						clearTimeout( v );

						self.load = true;
						self.data.options.q = value;
						self.search();
					}
				}

				e.stopPropagation();
			}).blur(function () {
				
				if( !self.is_focus ){
					self.hide();
				}

				self.is_focus2 = false;

			}).focus(function () {
				self.is_focus2 = true;
			});
		},

		search: function () {
			var self = this;

			$.ajax({
				url: self.url,
				data: self.data.options,
				dataType: 'json'
			}).done(function( results ) {

				self.data = $.extend( {}, self.data, results );
				if( results.total==0 || results.error || self.is_focus2==false ){
					return false;
				}

				self.setMenu();

			}).fail(function() {

				self.has_load = false;
				self.$elem.parent().removeClass('has-load');
				
			}).always(function() {

				self.has_load = false;
				self.$elem.parent().removeClass('has-load');
			});
		},

		hide: function () {
			var self = this;

			if( self.$layer ){
				self.$layer.addClass('hidden_elem');
			}
		},

		changeUpDown: function ( active ) {
			var self = this;
			var length = self.$menu.find('li').length;
			var index = self.$menu.find('li.selected').index();

			if( active=='up' ) index--;
			else index++;

			if( index < 0) index=0;
			if( index >= length) index=length-1;

			self.$menu.find('li').eq( index ).addClass('selected').siblings().removeClass('selected');
		},

		setMenu: function () {
			var self = this;

			var $box = $('<div/>', {class: 'uiTypeaheadView selectbox-selectview'});
			self.$menu = $('<ul/>', {class: 'search has-loading', role: "listbox"});

			$box.html( $('<div/>', {class: 'bucketed'}).append( self.$menu ) );

			var settings = self.$elem.offset();
			settings.parent = self.data.parent;
			if( settings.parent ){

				var parentoffset = $(settings.parent).offset();
				settings.left-=parentoffset.left;
				settings.top+=$(settings.parent).parent().scrollTop();
			}

			settings.top += self.$elem.outerHeight();
			settings.$elem = self.$elem;

			uiLayer.get(settings, $box );
			self.$layer = self.$menu.parents('.uiLayer');
			self.$layer.addClass('hidden_elem');

			self.buildFrag( self.data.lists );
			self.display();
		},
		buildFrag: function ( results ) {
			var self = this;

			$.each(results, function (i, obj) {

				var item = $('<a>');
				var li = $('<li/>');


				if( obj.image_url ){

					item.append( $('<div/>', {class:'avatar'}).html( $('<img/>', {calss: 'img', src: obj.image_url}) ) );

					li.addClass('picThumb');
				}

				if( obj.text ){
					item.append( $('<span/>', {class: 'text', text: obj.text}) );
				}

				if( obj.subtext ){
					item.append( $('<span/>', {class: 'subtext', text: obj.subtext}) );
				}

				if( obj.category ){
					item.append( $('<span/>', {class: 'category', text: obj.category}) );
				}

				li.html( item );

				li.data(obj);
				self.$menu.append( li );
			});
		},
		display: function () {
			var self = this;

			if( self.$menu.find('li').length == 0 ){
				return false;
			}

			if( self.$menu.find('li.selected').length==0 ){
				self.$menu.find('li').first().addClass('selected');
			}

			self.$layer.removeClass('hidden_elem');

			self.$menu.delegate('li', 'mouseenter', function() {
				$(this).addClass('selected').siblings().removeClass('selected');
			});
			self.$menu.delegate('li', 'click', function(e) {
				$(this).addClass('selected').siblings().removeClass('selected');
				self.active($(this).data());
				// e.stopPropagation();
			});

			self.$menu.mouseenter(function() {
				self.is_focus = true;
		  	}).mouseleave(function() { 
		  		self.is_focus = false;
		  	});
		},

		active: function ( data ) {
			var self = this;

			if( typeof self.data.onSelected === 'function' ){
				self.data.onSelected( data, self );
			}

			self.hide();
		},
	}
	$.fn.searchcustomer = function( options ) {
		return this.each(function() {
			var $this = Object.create( SearchCustomer );
			$this.init( options, this );
			$.data( this, 'searchcustomer', $this );
		});
	};
	$.fn.searchcustomer.options = {
		options: { q: '', limit: 5, view_stype: 'bucketed' },
		onSelected: function () {},
		parent: ''
	};

	var StepsForm = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $( elem );
			self.options = $.extend( {}, $.fn.stepsform.options, options );

			self.setElem();
			self.changeStep( self.options.index );
			self.setPrev();

			self.Events();
		},
		setElem: function () {
			var self = this;

			self.$prev = self.$elem.find('.js-prev');
			self.$next = self.$elem.find('.js-next');

			self.$nav = self.$elem.find('[steps-nav]');
			self.$content = self.$elem.find('[steps-content]');
		},
		Events: function () {
			var self = this;

			self.$next.click(function(e) {

				var li = self.$elem.find('.uiStepSelected');

				self.submit( li.next().length==1 ? li.data('id'): 'save' );
				e.preventDefault();
			});

			self.$prev.click(function(e) {

				var li = self.$elem.find('.uiStepSelected');
				if( li.prev().length == 1 ){
					self.changeStep('prev');
					self.setPrev();
				}
				
				e.preventDefault();
			});

			self.$nav.find('.uiStep').click(function(e) {

				var li = $(this);
				var index = $(this).index();

				if( li.hasClass('uiStepSelected') ){
					return false;
				}

				if( index == (self.indexStepSelected()+1) ){

					self.submit( self.$elem.find('.uiStepSelected').data('id') );
					return false;
				}

				if( index < self.indexStepSelected() || li.hasClass('is_success') ){
					self.changeStep(index);
				}

				if( li.prev().length ){
					if( li.prev().hasClass('is_success') ){
						self.changeStep(index);

					}
				}

				e.preventDefault();
			});
		},
		indexStepSelected: function () {
			var self = this;
			return self.$nav.find('.uiStepSelected').index();
		},

		changeStep: function ( type, index ) {
			var self = this;

			if( type=='next' || type=='prev' ){
				var index = self.indexStepSelected();

				if( type=='next' ){
					index++; 
				}
				else if( type=='prev' ){
					index--;
				}
			}else index = type;

			self.$nav.find('.uiStep').eq(index).addClass('uiStepSelected').siblings().removeClass('uiStepSelected');
			self.$content.eq( index ).removeClass('hidden_elem').siblings().addClass('hidden_elem');

			self.setPrev();
		},
		setPrev: function () {
			var self = this;

			self.$prev.toggleClass('hidden_elem', self.indexStepSelected()==0);
			self.$next.find('.btn-text').text( self.$nav.find('.uiStepSelected').next().length==0 ? 'บันทึก':'ต่อไป');
		},
		submit: function ( type ) {
			var self = this;

			var $form = self.$elem;
			var url = $form.attr('action');

			$form.find('[name=type_form]').val( type );
			if( self.$next.hasClass('btn-error') ){
				self.$next.removeClass('btn-error');
			}

			self.$next.addClass('disabled').addClass('is-loader').prop('disabled', true);

			var formData = Event.formData($form);

			$.ajax({
				type: 'POST',
				url: url,
				data: formData,
				dataType: 'json'
			}).done(function( results ) {

				results.onDialog = true;
				Event.processForm($form, results);

				if( results.error ){

					self.$next.addClass('btn-error');
					return false;
				}

				$form.find('.newOrder_inputs-main').scrollTop( 0 );

				if( type!='save' && !results.error ){

					self.$elem.find('.uiStep[data-id='+ type +']').addClass('is_success');
					self.changeStep( 'next' );
					self.setPrev();
					
					return false;
				}
			}).fail(function() {
				
				Event.showMsg({text: 'การเชื่อมต่อผิดผลาด', auto: true, load: true})
				self.$next.removeClass('disabled').removeClass('is-loader').prop('disabled', false);
			}).always(function() {

				self.$next.removeClass('disabled').removeClass('is-loader').prop('disabled', false);

			});
		}
	}
	$.fn.stepsform = function( options ) {
		return this.each(function() {
			var $this = Object.create( StepsForm );
			$this.init( options, this );
			$.data( this, 'stepsform', $this );
		});
	};
	$.fn.stepsform.options = {
		items: [],
		steps: [],
		index: 0
	}

	var ActionsListHiden = {
		init: function ( options, elem ) {
			var self = this;

			self.$elem = $( elem );
			self.options = $.extend( {}, $.fn.actionsListHiden.options, options );

			self.$elem.find('[data-actions]').change(function () {
				
				var action = $(this).data('actions');
				var $box = self.$elem.find('[data-active='+ action +']');

				self.$elem.find(':input').not('[data-actions]').addClass('disabled').prop('disabled', true);


				// $.each( )
				$box.find(':input').not('[data-actions]').removeClass('disabled').prop('disabled', false);

			});
		}
	}
	$.fn.actionsListHiden = function( options ) {
		return this.each(function() {
			var $this = Object.create( ActionsListHiden );
			$this.init( options, this );
			$.data( this, 'actionsListHiden', $this );
		});
	};
	$.fn.actionsListHiden.options = {}


	/**/
	/* RUpload */
	/**/
	var RUpload = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $(elem);
			self.$listsbox = self.$elem.find('[rel=listsbox]');
			self.$add = self.$elem.find('[rel=add]');
			self.data = $.extend( {}, $.fn.rupload.options, options );
			self.up_length = 0;

			self.refresh( 1 );
			self.Events();
		},

		Events: function () {
			var self = this;

			self.$elem.find('.js-upload').click(function (e) {
				e.preventDefault();

				self.change();
			});

			self.$elem.delegate('.js-remove', 'click', function (e) {

				self.loadRemove( $(this).closest('li').data() );
				e.preventDefault();
			});
			// has-loading
		},
		change: function () {
			var self = this;

			var $input = $('<input/>', { type: 'file', accept: "image/*"});
			if( self.data.multiple ){
				$input.attr('multiple', 1);
			}
			$input.trigger('click');

			$input.change(function(){

				self.$add.addClass('disabled').addClass('is-loader').prop('disabled', true);
				
				self.files = this.files;
				
				self.setFile();
			});
		},
		loadRemove: function (data) {
			var self = this;

			Dialog.load( self.data.remove_url, {id: data.id, callback: 1}, {
				onSubmit: function (el) {
					
					$form = el.$pop.find('form');
					Event.inlineSubmit( $form ).done(function( result ) {

						result.onDialog = true;
						result.url = '';
						Event.processForm($form, result);

						if( result.error ){
							return false;
						}
						
						self.$elem.find('[data-id='+ data.id +']').remove();
						self.sort();
						Dialog.close();

					});
				}
			} );
		},

		setFile: function () {
			var self = this;

			$.each( self.files, function (i, file) {
				self.up_length++;
				self.displayFile( file );

				self.sort();
			} );	
		},
		displayFile: function ( file ) {
			var self = this;

			var item = $('<li>', {class: 'has-upload' }).append( __Elem.anchorFile( file ) );
			item.append( self.setBTNRemove() );


			var progress = $('<div>', {class:'progress-bar medium mts'});
			var bar = $('<span>', {class:'blue'});

			progress.append( bar );

			item.find('.massages').append( progress );

			if( self.$listsbox.find('li').length==0 ){
				self.$listsbox.append( item );
			}
			else{
				self.$listsbox.find('li').first().before( item );
			}

			var formData = new FormData();
			formData.append( self.data.name, file);

			$.ajax({
			    type: 'POST',
			    dataType: 'json',
			    url: self.data.upload_url,
			    data: formData,
			    cache: false,
			    processData: false,
			    contentType: false,
			    error: function (xhr, ajaxOptions, thrownError) {

			        /*alert(xhr.responseText);
			        alert(thrownError);*/
			        Event.showMsg({text: 'อัพโหลดไฟล์ไม่ได้', auto: true, load: true, bg: 'red'});
			        item.remove();
			    },

			    xhr: function () {
			        var xhr = new window.XMLHttpRequest();
			        //Download progress
			        xhr.addEventListener("progress", function (evt) {
			            if (evt.lengthComputable) {
			                var percentComplete = evt.loaded / evt.total;
			                bar.css('width', Math.round(percentComplete * 100));
			                // progressElem.html(  + "%");
			            }
			        }, false);
			        return xhr;
			    },
			    beforeSend: function () {
			        // $('#loading').show();
			    },
			    complete: function () {

			    	self.up_length--;
			    	if( self.up_length==0 ){
			    		self.$add.removeClass('disabled').removeClass('is-loader').prop('disabled', false);
			    	}
			        // $("#loading").hide();
			    },
			    success: function (json) {

			    	if( json.error ){

			    		return false;
			    	}

			    	item.attr('data-id', json.id);
			    	item.data( json )
			    	progress.remove();
			    }
			});
		},

		refresh: function ( length ) {
			var self = this;

			if( self.is_loading ) clearTimeout( self.is_loading ); 

			if ( self.$elem.hasClass('has-error') ){
				self.$elem.removeClass('has-error')
			}

			if ( self.$elem.hasClass('has-empty') ){
				self.$elem.removeClass('has-empty')
			}

			self.$elem.addClass('has-loading');

			self.is_loading = setTimeout(function () {

				self.fetch().done(function( results ) {

					self.data = $.extend( {}, self.data, results );

					if( results.error ){

						if( results.message ){
							self.$elem.find('.js-message').text( results.message );
							self.$elem.addClass('has-error');
						}
						return false;
					}

					self.$elem.toggleClass( 'has-empty', parseInt(self.data.total)==0 );

					$.each( results.lists, function (i, obj) {
						self.display( obj );
					} );
				});
			}, length || 1);
			
		},
		fetch: function () {
			var self = this;

			return $.ajax({
				url: self.data.url,
				data: self.data.options,
				dataType: 'json'
			}).always(function () {

				self.$elem.removeClass('has-loading');
				
			}).fail(function() { 
				self.$elem.addClass('has-error');
			});
		},

		display: function ( data ) {
			var self = this;

			var item = $('<li>', {'data-id': data.id}).append( __Elem.anchorFile( data ) );
			item.append( self.setBTNRemove() );
			item.data( data );

			if( self.$listsbox.find('li').length==0 ){
				self.$listsbox.append( item );
			}
			else{
				self.$listsbox.find('li').first().before( item );
			}
		},
		setBTNRemove: function () {
			
			return $('<button>', {type: 'button', class: 'js-remove icon-remove btn-remove'});
		},
		sort: function () {
			var self = this;

			self.$elem.toggleClass('has-empty', self.$listsbox.find('li').length==0 );
		}
	}
	$.fn.rupload = function( options ) {
		return this.each(function() {
			var $this = Object.create( RUpload );
			$this.init( options, this );
			$.data( this, 'rupload', $this );
		});
	};
	$.fn.rupload.options = {
		options: {},
		multiple: false,
		name: 'file1'
	}

	/**/
	/* Invite */
	/**/
	var Invite = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $(elem);

			$.each( self.$elem.find('[ref]'), function () {
				var key = $(this).attr('ref');
				self['$'+key] = $(this);
			} );

			$.each( self.$elem.find('[act]'), function () {
				var key = $(this).attr('act');
				self['$'+key] = $(this);
			} );

			self.settings = $.extend( {}, $.fn.invite.settings, options );
			self.resize();

			self.checked = self.settings.checked || {};

			if( self.settings.invite ){
				$.each( self.settings.invite, function(key, users) {
					$.each( users, function(i, obj) {
						self.checked[ key+'_'+obj.id ] = obj;
					});
				} );
			}

			self.data = {
				options: self.settings.options || {}
			};

			self.refresh();
			self.Events();
		},

		resize: function () {
			var self = this;

			var parent = self.$listsbox.parent();

			var offset = parent.position();
			var outerHeight = self.$elem.outerHeight();
			parent.css('height', self.$elem.outerHeight() - (self.$header.outerHeight() + 40) );
		},

		refresh: function ( length ) {
			var self = this;

			if( self.is_loading ) clearTimeout( self.is_loading ); 

			if ( self.$listsbox.parent().hasClass('has-error') ){
				self.$listsbox.parent().removeClass('has-error')
			}

			if ( self.$listsbox.parent().hasClass('has-empty') ){
				self.$listsbox.parent().removeClass('has-empty')
			}

			self.$listsbox.parent().addClass('has-loading');

			self.is_loading = setTimeout(function () {

				self.fetch().done(function( results ) {
					
					// self.data = $.extend( {}, self.data, results );

					self.$listsbox.toggleClass( 'has-empty', results.length==0 );
					self.buildFrag( results );
					self.display();

				});
			}, length || 1);
		},
		fetch: function () {
			var self = this;

			if( self.is_search ){
				self.$actions.find(':input').addClass('disabled').prop('disabled', true);
			}

			$.each( self.$actions.find('select[act=selector]'), function () {
				self.data.options[ $(this).attr('name') ] = $(this).val();
			} );


			return $.ajax({
				url: self.settings.url,
				data: self.data.options,
				dataType: 'json'
			}).always(function () {

				self.$listsbox.parent().removeClass('has-loading');

				if( self.is_search ){
					self.$actions.find(':input').removeClass('disabled').prop('disabled', false);
					self.$inputsearch.focus();
					self.is_search = false;
				}
				
			}).fail(function() { 
				self.$listsbox.parent().addClass('has-error');
			});
		},
		buildFrag: function ( results ) {
			var self = this;

			var data = {
				total: 0,
				options: {},
				lists: []
			};

			$.each( results, function (i, obj) {
				
				data.options = $.extend( {}, data.options, obj.data.options );
				if( obj.data.options.more==true ){
					data.options.more = true;
				}

				data.total += parseInt( obj.data.total );

				$.each(obj.data.lists, function (i, val) {

					if( !val.type ){
						val.type = obj.object_type;
					}

					if( !val.category ){
						val.category = obj.object_name;
					}

					data.lists.push( val ); 
				});
			} );

			self.data = $.extend( {}, self.data, data );

			self.$listsbox.parent().toggleClass('has-more', self.data.options.more);
			self.$listsbox.parent().toggleClass('has-empty', self.data.total==0 );
		},
		display: function( item ) {
			var self = this;

			self.$listsbox.parent().removeClass('has-loading');

			$.each( self.data.lists, function (i, obj) {
				
				var item = $('<li>', {class: 'ui-item', 'data-id': obj.id, 'data-type': obj.type}).html( __Elem.anchorBucketed( obj ) );

				item.data( obj );
				item.append('<div class="btn-checked"><i class="icon-check"></i></div>');

				if( self.checked[ obj.type + "_" + obj.id ] ){
					item.addClass('has-checked');
					self.setToken( obj, true );
				}

				self.$listsbox.append( item );
			});

			if( !self.$elem.hasClass('on') ){
				self.$elem.addClass('on');
			}

			self.resize();
		},

		Events: function () {
			var self = this;

			self.$listsbox.parent().find('.ui-more').click(function (e) {
				self.data.options.pager++;

				self.refresh( 300 );
				e.preventDefault();
			});

			self.$listsbox.delegate('.ui-item', 'click', function (e) {
				
				var checked = !$(this).hasClass('has-checked');

				$(this).toggleClass('has-checked', checked );
				self.setToken( $(this).data(),  checked );
				e.preventDefault();
			});

			self.$tokenbox.delegate('.js-remove-token', 'click', function (e) {
				
				var data = $(this).closest('[data-id]').data();

				delete self.checked[ data.type + "_" + data.id ];
				self.$tokenbox.find('[data-id='+ data.id +'][data-type='+ data.type +']').remove();
				self.$listsbox.find('[data-id='+ data.id +'][data-type='+ data.type +']').removeClass('has-checked');
				self.resize();
				e.preventDefault();
			});

			self.$actions.find('select[act=selector]').change(function () {

				self.data.options.q = $.trim( self.$inputsearch.val() );
				self.data.options.pager = 1;
				self.data.options[ $(this).attr('name') ] = $(this).val();

				self.$listsbox.empty();
				self.refresh( 1 );
			});

			self.$elem.find('.js-selected-all').click(function () {

				var item = self.$listsbox.find('.ui-item').not('.has-checked');
				
				var checked = true;
				if( item.length == 0 ){
					checked = false;
				}

				$.each(self.$listsbox.find('.ui-item'), function (i, obj) {
					
					if( checked && !$(this).hasClass('has-checked') ){
						$(this).toggleClass('has-checked', checked );
						self.setToken( $(this).data(),  checked );
					}
					else if( $(this).hasClass('has-checked') ){
						$(this).toggleClass('has-checked', checked );
						self.setToken( $(this).data(),  checked );
					}
					

				});
			});


			var searchVal = $.trim( self.$inputsearch.val() );			
			self.$inputsearch.keyup(function () {
				var val  = $.trim( $(this).val() );

				if( val=='' && val!=searchVal ){
					searchVal = '';
					self._search( searchVal );
				}				
			}).keypress(function (e) {
				if(e.which === 13){
					e.preventDefault();

					var text = $.trim( $(this).val() );
					if( text!='' ){
						searchVal = text;
						self._search( text );
					} 
				}
			});
		},

		setToken: function (data, checked) {
			var self = this;

			if( checked ){
				self.checked[ data.type + "_" + data.id ] = data;

				if( self.$tokenbox.find('[data-id='+ data.id +'][data-type='+ data.type +']').length==1 ){ return false; }
				
				var $el = __Elem.anchorBucketed(data);
				$el.addClass('anchor24');

				var item = $('<li>', {class: 'ui-item has-action', 'data-id': data.id, 'data-type': data.type}).append(
					  $el
					, $('<input>', {type: 'hidden', name: 'invite[id][]', value: data.id })
					, $('<input>', {type: 'hidden', name: 'invite[type][]', value: data.type})
					, $('<button>', {type: 'button', class: 'ui-action top right js-remove-token'}).html( $('<i>', {class: 'icon-remove'}) )
				);

				item.data( data );

				self.$tokenbox.append( item );
				self.$tokenbox.scrollTop(self.$tokenbox.prop("scrollHeight"));
			}
			else{
				delete self.checked[ data.type + "_" + data.id ];
				self.$tokenbox.find('[data-id='+ data.id +'][data-type='+ data.type +']').remove();
			}

			self.resize();

			self.$elem.find('.js-selectedCountVal').text( Object.keys( self.checked ).length );
		},
		_search: function (text) {
			var self = this;

			self.data.options.pager = 1;
			self.data.options[ 'q' ] = text;
			self.is_search = true;

			self.$listsbox.empty();
			self.refresh( 500 );
		},	
	}
	$.fn.invite = function( options ) {
		return this.each(function() {
			var $this = Object.create( Invite );
			$this.init( options, this );
			$.data( this, 'invite', $this );
		});
	};
	$.fn.invite.settings = {
		multiple: false,
	}

	/**/
	/* listplan */
	/**/
	var Listplan = {
		init: function ( options, elem ) {
			var self = this;

			self.$elem = $(elem);
			self.options = $.extend( {}, $.fn.listplan.settings, options );

			// upcoming
			self.upcoming.init( self.options.upcoming || {}, self.$elem.find('[ref=upcoming]'), self );

			self.Events();
		},
		upcoming: {

			init: function ( options, $elem, than  ) {
				var self = this;

				self.than = than;
				self.$elem = $elem;
				self.$listsbox = self.$elem.find('[ref=listsbox]');
				self.$more = self.$elem.find('[role=more]');

				self.data = options;

				self.refresh( 1 );

				self.$more.click(function (e) {
					e.preventDefault();

					self.data.options.pager++;
					self.refresh( 300 );
				});
			},
			refresh: function ( length ) {
				var self = this;

				if( self.is_loading ) clearTimeout( self.is_loading ); 

				if ( self.$elem.hasClass('has-error') ){
					self.$elem.removeClass('has-error')
				}

				if ( self.$elem.hasClass('has-empty') ){
					self.$elem.removeClass('has-empty')
				}

				self.$elem.addClass('has-loading');

				self.is_loading = setTimeout(function () {

					self.fetch().done(function( results ) {

						self.data = $.extend( {}, self.data, results );

						self.$elem.toggleClass( 'has-empty', parseInt(self.data.total)==0 );
						if( results.error ){

							if( results.message ){
								self.$elem.find('[ref=message]').text( results.message );
								self.$elem.addClass('has-error');
							}
							return false;
						}

						$.each( results.lists, function (i, obj) {
							self.display( obj );
						} );

						self.$elem.toggleClass('has-more', self.data.options.more);
					});
				}, length || 1);			
			},
			fetch: function () {
				var self = this;

				return $.ajax({
					url: self.data.url,
					data: self.data.options,
					dataType: 'json'
				}).always(function () {

					self.$elem.removeClass('has-loading');
					
				}).fail(function() { 
					self.$elem.addClass('has-error');
				});
			},
			display: function ( data ) {
				var self = this;
				self.$listsbox.append( self.than.setItem( data ) );
			},
		},

		setItem: function (data) {
			
			data.icon = 'calendar';
			var li = $('<li>', {class: 'ui-item', 'data-id': data.id}).html( __Elem.anchorBucketed(data) );

			li.data( data );

			var actions = $('<div>', {class: 'ui-actions'});

			actions.append(
				  $('<button>', {type: 'button', class: 'action js-edit'}).html( $('<i>', {class: 'icon-pencil'}) ) 
				, $('<button>', {type: 'button', class: 'action js-remove'}).html( $('<i>', {class: 'icon-remove'}) ) 
			)

			li.append( actions );

			return li;
		},

		Events: function () {
			var self = this;

			if( self.options.add_url ){

				self.$add = self.$elem.find('[role=add]');
				self.$elem.find('.js-add').click(function () {
					self.add();
				});
			}

			if( self.options.edit_url ){
				self.$elem.delegate('.js-edit', 'click', function (e) {
					e.preventDefault();

					var $parent = $(this).closest('[data-id]');
					self.edit( $(this).closest('[data-id]').data(), $parent );
				});
			}

			if( self.options.remove_url ){
				self.$elem.delegate('.js-remove', 'click', function (e) {

					var $parent = $(this).closest('[data-id]');
					self.remove( $parent.data(), $parent );
				});
			}
			
		},

		add: function () {
			var self = this;

			self.$add.addClass('disabled').addClass('is-loader').prop('disabled', true);
			Dialog.load(self.options.add_url, {callback: 'bucketed'}, {
				onClose: function () {
					self.$add.removeClass('disabled').removeClass('is-loader').prop('disabled', false);
				},
				onSubmit: function ($el) {
					self.$add.removeClass('disabled').removeClass('is-loader').prop('disabled', false);

					$form = $el.$pop.find('form');
					Event.inlineSubmit( $form ).done(function( result ) {

						result.url = '';
						Event.processForm($form, result);

						if( result.error ){
							return false;
						}

						var item = self.setItem( result.data );
						var $listsbox = self.$elem.find('[ref=upcoming]').find('[ref=listsbox]');

						if( $listsbox.find('li').length > 0){
							$listsbox.find('li').first().before( item );
						}
						else{
							$listsbox.append( item );
						}

						Dialog.close();
					});
				}
			});
		},

		edit: function ( data, $el ) {
			var self = this;

			$el.addClass('disabled').prop('disabled', true);
			Dialog.load(self.options.edit_url, {id: data.id, callback: 'bucketed'}, {
				onClose: function () {
					$el.removeClass('disabled').prop('disabled', false);
				},
				onSubmit: function ($d) {
					$el.removeClass('disabled').prop('disabled', false);

					$form = $d.$pop.find('form');
					Event.inlineSubmit( $form ).done(function( result ) {

						$el.removeClass('disabled').prop('disabled', false);

						result.url = '';
						Event.processForm($form, result);

						if( result.error ){
							return false;
						}

						var $listsbox = self.$elem.find('[ref=upcoming]').find('[ref=listsbox]');
						$listsbox.find('[data-id='+ data.id +']').replaceWith( self.setItem( result.data ) );

						Dialog.close();
					});
				}
			});
		},

		remove: function (data, $el) {
			var self = this;

			$el.addClass('disabled').prop('disabled', true);
			Dialog.load(self.options.remove_url, {id: data.id, callback: 1}, {
				onClose: function () {
					$el.removeClass('disabled').prop('disabled', false);
				},
				onSubmit: function ($d) {

					$form = $d.$pop.find('form');
					Event.inlineSubmit( $form ).done(function( result ) {

						$el.removeClass('disabled').prop('disabled', false);

						result.url = '';
						Event.processForm($form, result);

						if( result.error ){
							return false;
						}

						var $listsbox = self.$elem.find('[ref=upcoming]').find('[ref=listsbox]');
						$listsbox.find('[data-id='+ data.id +']').remove();

						Dialog.close();
					});
				}
			});
		}
	}
	$.fn.listplan = function( options ) {
		return this.each(function() {
			var $this = Object.create( Listplan );
			$this.init( options, this );
			$.data( this, 'listplan', $this );
		});
	};
	$.fn.listplan.options = {
		multiple: false,
	}

	
})( jQuery, window, document );


$(function () {
	
	// navigation
	$('.navigation-trigger').click(function(e){
		e.preventDefault();
		$('body').toggleClass('is-pushed-left', !$('body').hasClass('is-pushed-left'));

		$.get( Event.URL + 'me/navTrigger', {
			'status': $('body').hasClass('is-pushed-left') ? 1:0
		});
	});

	$('.customers-main').click(function(e){

		var $parent = $(this).closest('.customers-content');
		if( $parent.hasClass('is-pushed-right') ){
			$parent.removeClass('is-pushed-right');
		}
		e.preventDefault();
	});


	$('.customers-right-link-toggle').click(function(e){
		var $parent = $(this).closest('.customers-content');
		$parent.toggleClass('is-pushed-right', !$parent.hasClass('is-pushed-right'));

		e.preventDefault();
		// e.stopPropagation();
	});
	
	
});