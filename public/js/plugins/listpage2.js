// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var List = {
		init: function ( options, elem ) {
			var self = this;
			self.elem = elem;

			self.setElem();
			self.settings = $.extend( {}, $.fn.listpage2.options, options );

			self.data = {
				total: 0,
				options: {
					pager: 1,
				},
				url: self.settings.url
			};

			self.resize();
			$( window ).resize(function () {
				self.resize();
			});
			self.$elem.addClass('on');

			self.ids = [];
			self.Events();

		},
		setElem: function () {
			var self = this;
			self.$elem = $(self.elem);
			self.$elem.find('[ref]').each(function () {
				if( $(this).attr('ref') ){
					var ref = "$" + $(this).attr('ref');
					self[ref] = $(this);
				}
				
			});
		},
		resize: function () {
			var self = this;

			if( $('#doc').hasClass('fixed_elem') ) return;
			
			var outer = $( window ); // $( window );
			var offset = self.$elem.offset();
			var right = 0;
			var fullw = outer.width()- (offset.left+right);
			var fullh = outer.height(); // + outer.scrollTop();

			var headerH = 0;
			if( self.$header ){
				headerH = self.$header.outerHeight();

				self.$header.css({
					top: 0,
					left: offset.left,
					width: fullw - 16,
					// right: right,
					position: 'fixed'
				});
			}

			self.$elem.find('.listpage2-table-overlay-warp').css({
				left: offset.left,
			});

			self.$table.css({
				paddingTop: headerH,
				// width: fullw,
				// height: fullh - (offset.top),
				// overflow:'hidden'
			});

			self.$tabletitle.css({
				position: 'fixed',
				left: offset.left + 20,
				right: right + 20,
				zIndex: 20
			});
			
			self.$tablelists.css({
				marginTop: self.$tabletitle.outerHeight(),
				/*height: fullh - (offset.top+headerH+self.$tabletitle.outerHeight()),
				overflowY: 'auto'*/
			});

			var totalW = 0;
			if(self.$tablelists.find('table tr:first>td').hasClass('empty')){ return false; }

				self.$tablelists.find('table tr:first>td').each(function ( i ) {

				var td = $(this);
				var th = self.$tabletitle.find('table th[data-col='+i+']');

				if( td.hasClass('name') ){
					return
				}

				var outerW = td.outerWidth()
				var width = td.width();

				if( th.width() > width){
					outerW = th.outerWidth();
					width = th.width();
				}
				
				totalW+=outerW;
				td.width( width );
				th.width( width );
			});


			if( totalW > 0 && self.$tablelists.find('td.name .ellipsis').length){

				totalW += parseInt( self.$tablelists.find('td.name').css('padding-left') );
				totalW += parseInt( self.$tablelists.find('td.name').css('padding-right') );
				self.$tablelists.find('td.name .ellipsis').css('max-width',  fullw-totalW);
			}

			if( self.$table.hasClass('has-empty') ){
				self.$tabletitle.css( 'padding-right', 0 );

				self.$table.find('.listpage2-table-empty').css( 'padding-top', self.$tabletitle.outerHeight()+headerH );
			}
			else{
				self.$tabletitle.css( 'padding-right', self.$tabletitle.outerWidth() - self.$tablelists.find('table').outerWidth() );
			}
		},

		Events: function () {
			var self = this;

			self.$elem.mouseover(function () {
				self.resize();
			});

			$('input#checkboxes', self.$tabletitle).change( function (e) {
				e.preventDefault();
				self.selection($(this).is(':checked'), 'all');
			});

			$('input#toggle_checkbox', self.$tablelists).change( function (e) {
				e.preventDefault();
				self.selection($(this).is(':checked'), $(this).parents('tr') );
			});

			$('.navigation-trigger').click( function (e) {
				self.resize();
			});

			self.$elem.find('.js-refresh').click(function (e) {

				self.refresh( 200 );
				e.preventDefault();
			});

			self.$elem.find('#more-link').delegate('a.next, a.prev', 'click', function (e) {
				
				pager = parseInt( self.data.options.pager );
				pager += $(this).hasClass('prev')? -1 : 1;

				self.data.options.pager = pager;
				self.refresh( 1 );
				e.preventDefault();
			});
			
			$('a.link-sort', self.$tabletitle).click( function (e) {

				var val = $(this).attr('data-sort') || 'asc';

				val = val=='asc' ? 'desc' : 'asc';
				$(this).attr('data-sort', val);

				// set data
				self.data.options.dir = val;
				self.data.options.sort = $(this).attr('data-sort-val');
				self.refresh( 1 );

				// set elem
				self.$tabletitle.find( '.sorttable.asc' ).removeClass('asc');
				self.$tabletitle.find( '.sorttable.desc' ).removeClass('desc');
				$(this).parent().addClass( val );

				e.preventDefault();
			});

			if( self.$elem.find('select[ref=selector]').length>0 ){
				$.each( self.$elem.find('select[ref=selector]'), function() {
					
					if( $(this).attr('name') ){
						self.data.options[ $(this).attr('name') ] = $(this).val();
					}
				} );
			}

			var $closedate = self.$elem.find('[ref=closedate]');
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

				if( closedateOptions.length > 0 ){
					$closedate.closedate({
						onComplete: function ( that ) {
							// console.log( 'Complete', that, this );	
						},
						onChange: function ( that ) {

							var data = that.$menu.find('li.active').data();
							if(data.value == ''){
								delete self.data.options.period_start;
								delete self.data.options.period_end;
							}
							else{
								self.data.options.period_start = that.startDateStr;
								self.data.options.period_end = that.endDateStr;
							}

							self.refresh( 1 );
						},

						options: closedateOptions,
						activeIndex: activeIndex
					});
				}
				else self.refresh( 1 );

			}
			else{
				self.refresh( 1 );
			}

			/**/
			/* search */
			self.$elem.find('.search-input').keydown(function(e){
				var text = $.trim( $(this).val() );

				if(e.keyCode == 13 && text!='') {
					self.search( text );
				}

			}).keyup(function(e){
				var text = $.trim( $(this).val() );

				if( text=='' && text!= self.data.options.q ){
					self.search( text );
				}
			});
			self.$elem.find('.form-search').submit(function (e) {
				var text = $.trim( $(this).find('.search-input').val() );

				if( text!='' ){
					self.search( text );
				}
				
				e.preventDefault();
			});

			
			if( self.$header ){

				self.$header.find('select[ref=selector]').change(function () {

					self.data.options.pager = 1;
					self.data.options[ $(this).attr('name') ] = $(this).val();

					self.refresh( 1 );
				});
			}
			

			/*self.$elem.delegate('.js-change', 'change', function() {
				var url = $(this).data('url') || $(this).attr('stringify'),
					name = $(this).attr('name')
					val = $(this).val();

				console.log( url, name, val );
				if( !url ) return false;
			});*/	
		},

		search: function (text) {
			var self = this;

			self.data.options.pager = 1;
			self.data.options[ 'q' ] = text;
			self.is_search = true;
			self.refresh( 500 );
		},

		setSelectedDate: function () {
			var self = this;
		},

		selection: function (checked, item) {
			var self = this;

			if( item == 'all' ){
				$.each(self.$tablelists.find('tr'), function (i, obj) {
					var item = $(this);

					if(checked==true && !item.hasClass('has-checked')){
						self.selectItem(item);
					}
					else if(checked==false && item.hasClass('has-checked')){
						self.cancelItem(item);
					}
				});
			}
			else{
				if(checked){
					self.selectItem(item);
				}
				else{
					self.cancelItem(item);
				}
			}
		},
		selectItem: function (el) {
			var self = this;
			var toggle_checkbox = el.find('input#toggle_checkbox');
			var id = el.attr('data-id');
			toggle_checkbox.prop('checked', true);
			el.addClass('has-checked');

			self.ids.push( parseInt(id) );
			self.active();
		},
		cancelItem: function (el) {
			var self = this;

			var toggle_checkbox = el.find('input#toggle_checkbox');
			var id = el.attr('data-id');
			toggle_checkbox.prop('checked', false);
			el.removeClass('has-checked');

			self.ids.splice(self.ids.length-1, parseInt(id));
			self.active();
		},
		active: function () {
			var self = this;

			if(self.ids.length > 0){
				self.$actions.addClass('hidden_elem');
				self.$selection.removeClass('hidden_elem').find('.count-value').text('เลือกแล้ว '+ self.ids.length + ' รายการ');
			}
			else{

				self.$selection.addClass('hidden_elem').find('.count-value').text("");
				self.$tabletitle.find('input#checkboxes').prop('checked', false);
				self.$actions.removeClass('hidden_elem');
			}

			self.resize();
		},

		refresh: function ( length ) {
			var self = this;

			if( self.is_loading ) clearTimeout( self.is_loading ); 
			self.$elem.addClass('has-loading');

			if( !self.data.url ) return false;
			self.is_loading = setTimeout(function () {
				self.fetch().done(function( results ) {

					self.data = $.extend( {}, self.data, results.settings );
					self.$tablelists.parent().toggleClass( 'has-empty', parseInt(self.data.total)==0 ? true: false );
					
					self.setMore();

					if( results.selector ){
						self.setSelector( results.selector );
					}
					// self.buildFrag();
					// console.log( self.data.options.sql );
					self.display( results.body );
				});
			}, length || 1);
		},
		fetch: function() {
			var self = this;

			// console.log( self.data.options );
			// var qLoad = setTimeout( function () {
			
			// set url
			/*var returnLocation = history.location || document.location,
				href = self.data.url+"?"+$.param(self.data.options),
				title = "";*/
			// history.pushState('', title, href);
			// document.title = title;

			if( self.is_search ) self.$elem.find('.search-input').attr('disabled', true);

			return $.ajax({
				url: self.data.url,
				data: self.data.options,
				dataType: 'json'
			}).always(function () {

				// console.log( self.data.options );
				self.$elem.removeClass('has-loading');

				if( self.is_search ){
					self.$elem.find('.search-input').attr('disabled', false);
					self.$elem.find('.search-input').focus();

					self.is_search = false;
				}
				
			}).fail(function() { 
				self.$elem.addClass('has-error');
			});
		},
		display: function( item ) {
			var self = this;

			$item = $( item );
			self.$tablelists.html( item );
			self.resize();

			Event.plugins( self.$tablelists );

			if( self.$elem.hasClass('offline') ){
				self.$elem.removeClass('offline');
			}
			
		},

		setMore: function () {
			var self = this;

			var options = self.data.options;
			var total = self.data['total'],
				pager = options['pager'],
				limit = options['limit'];

			self.$elem.find('#more-link').empty();
			if( total==0 ){
				self.$elem.find('#more-link').addClass('hidden_elem');
				return false;
			} 

			if( self.$elem.find('#more-link').hasClass('hidden_elem') ){
				self.$elem.find('#more-link').removeClass('hidden_elem');
			}
			
			var length = parseInt(total/limit); // floor( );

			if(total%limit){
				length++;
			}

			var first = (limit*pager)-limit+1,
				last = limit*pager;

			if( last>total ){
				last = total;
			}

			self.$elem.find('#more-link').append(
				  $('<span>', {class: 'mhs'}).append(
					  first
					, '-'
					, last
					, $('<span>', {class: 'mhs', text: 'จาก'})
					, PHP.number_format(total)
				)

				, pager > 1 
					? $('<a>', {class: 'prev'}).html( $('<i>', {class: 'icon-angle-left'}) )
					: $('<span>', {class: 'prev disabled fcg'}).html( $('<i>', {class: 'icon-angle-left'}) )

				, pager==length
					? $('<span>', {class: 'next disabled fcg'}).html( $('<i>', {class: 'icon-angle-right'}) )
					: $('<a>', {class: 'next'}).html( $('<i>', {class: 'icon-angle-right'}) )
			);
		},

		setSelector: function ( results ) {
			var self = this;

			$.each(results, function (key, lists) {
				
				$item = self.$elem.find('select[ref=selector][name='+key+']');
				
				if( $item ){
					$item.empty();

					$.each(lists, function (i, val) {
						$item.append( $('<option>', {
								'text': val.text + ( val.total>0? ' ('+val.total+')':'' ) ,
								'value': i,
								'selected': val.current
							})
						);
					});
					
				}
			});
		}
	};

	$.fn.listpage2 = function( options ) {
		return this.each(function() {
			var $this = Object.create( List );
			$this.init( options, this );
			$.data( this, 'listpage2', $this );
		});
	};

	$.fn.listpage2.options = {
		options: {
			pager: 1
		},
		/*onOpen: function() {},
		onClose: function() {}*/
	};
	
})( jQuery, window, document );