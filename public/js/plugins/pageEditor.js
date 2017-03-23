// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var PageEditor = {
		init: function ( options, elem ) {
			var self = this;
			self.$elem = $(elem);


			self.$tree = self.$elem.find('[ref=page-pages]');

			self.$elem.delegate('.pages-tree-node', "click", function(e) {

				if( $(this).hasClass('active') ) return false;

				$(this).addClass('active').siblings().removeClass('active');
				self.pageActive();
				
				e.preventDefault();  
				e.stopPropagation();
			});


			self.pageSoft();

			self.$sections = self.$elem.find('[ref=page-sections]');
			Event.setPlugin( self.$sections, 'sortable', {
				onChange: function(){
						
				}
			} );
			self.$sections.find('li').on("click", function(e) {
				$(this).addClass('active').siblings().removeClass('active');
				e.preventDefault();  
				e.stopPropagation();
				console.log( 'click sections' );
			});
			self.$sections.find('li').on("dragover", function(e) {
				e.preventDefault();  
				e.stopPropagation();

				$(this).addClass('dragging');
			});
			self.$sections.find('li').on("dragleave", function(e) {
				e.preventDefault();  
				e.stopPropagation();

				$(this).removeClass('dragging');
			});
			self.$sections.find('li').on("drop", function(e) {
				e.preventDefault();  
				e.stopPropagation();
				
				$(this).removeClass('dragging');
			});


			self.$tree.find('li').first().addClass('active');
			self.pageActive();
			

			// new Page
			self.$elem.find('.js-add-page').click(function () {
				
				self.pageAdd();
			});
			// setting Page
			self.$elem.find('.js-setting-page').click(function () {
				
				self.pageSetting( $(this).closest('li').attr('data-id') );
			});


			self.$page = self.$elem.find('#editorpage-page');
			self.$elem.find(':input.js-change-page').not('[plugin]').change(function () {
				
				self.setPageStyle();
				// self.pageSetting( $(this).closest('li').attr('data-id') );
			});
			self.setPageStyle();

			self.$elem.find('.js-change-page[plugin=colorpicker]').colorpicker().on('changeColor', function(e) {
				self.setPageStyle();
			});

			self.$elem.find('[data-key][plugin=colorpicker]').colorpicker().on('changeColor', function(e) {
				
				self.setElemStyle( self.$elem.find('#' + $(this).attr('data-key') ), $(this).attr('data-style'), $(this).val() );
			});

			$.each( self.$elem.find(':input[data-key]'), function () {
				
				if( $(this).val()!='' ){
					self.setElemStyle( self.$elem.find('#' + $(this).attr('data-key') ), $(this).attr('data-style'), $(this).val() );
				}

			} );
			
			self.$elem.find('.js-add-section').click( function(e) {
				self.sectionAdd();
			});

		},

		setElemStyle: function ( $el, n, v) {
			$el.css( n, v);
		},

		setPageStyle: function () {
			var self = this;

			var css = '';
			$.each( self.$elem.find(':input.js-change-page'), function () {

				var type = $(this).attr('data-type');
				var style = $(this).attr('data-style');
				var c = '';

				if( type=='font' ){

					c = $(this).find(':selected').attr('data-style');
				}
				else if( $(this).val()!='' ){

					c = style + ':' + $(this).val();
				}

				css += css!='' ? ';':'';
				css += c;
			} );

			self.$page.attr( 'style', css );


			self.$elem.find('.editorpage-main').css('background-color', self.$page.css('background-color'));

			// save 
		},

		pageActive: function () {
			var self = this;

			self.pageID =  self.$tree.find('li.active').attr('data-id');
			self.getSections();
		},

		getSections: function () {
			var self = this;

			$.get( URL + 'pages/getSections/' + self.pageID , function ( res ) {
				
				console.log( res );
			}, 'json');
		},

		pageAdd: function () {
			var self = this;

			var $save = $('<a>', {class: 'btn btn-blue', text: 'Save'});
			var $input = $('<input>', {type: 'text', class: 'inputtext', name: 'name'});


			Dialog.open({
				title: 'New Page',
				body: $input[0],
				button: $save[0],
			});

			var t;
			$save.click(function () {
				
				if( $save.hasClass('btn-error') ) $save.removeClass('btn-error');
				clearTimeout( t );

				if( $input.val() == '' ){
					$save.addClass('btn-error');

					t = setTimeout( function () {
						$save.removeClass('btn-error');
					}, 800);
				}
				else{

					self.pageAdd_save( $input.val() );
				}

			});
		},
		pageAdd_save: function ( text ) {
			var self = this;

			// loading...

			$.post( URL + 'pages/save', {name: text}, function (res) {


				if( res.message ){
					Event.showMsg({ text:  res.message, load: true , auto: true });
				}

				if( res.error ){
					// alert( res.error );
					return false;
				}	

				Dialog.close();
				self.$tree.append( self.setItemPage( res ) );
				self.pageSoft()

			}, 'json');
		},
		setItemPage: function (data) {

			var data = data || {}; 
			var $li =  $('<li>', {class: 'pages-tree-node', 'data-id': data.id, 'draggable': "true"});

			$li.append( $('<a>', {class: 'pages-tree-item-options'}).html( $('<i>', {class: 'icon-cog'}) ) );
			$li.append( $('<div>', {class: 'pages-tree-item', text: data.name}) );

			return $li;
		},
		pageSoft: function () {
			var self = this;

			var placeholder = self.$tree.clone();

			self.$tree.replaceWith(placeholder);
            self.$tree = placeholder;

			// 
			Event.setPlugin( self.$tree, 'sortable', {
				onChange: function(){
					self.pageSoft_change();
				}
			} );
			
			self.$tree.find('li').on("dragover", function(e) {
				e.preventDefault();  
				e.stopPropagation();

				$(this).addClass('dragging');
			});
			self.$tree.find('li').on("dragleave", function(e) {
				e.preventDefault();  
				e.stopPropagation();

				$(this).removeClass('dragging');
			});
			self.$tree.find('li').on("drop", function(e) {
				e.preventDefault();  
				e.stopPropagation();
				
				$(this).removeClass('dragging');
			});
		},
		pageSoft_change: function () {
			var self = this;

			var ids = [];
			$.each( self.$elem.find('li.pages-tree-node'), function () {
				ids.push( $(this).attr('data-id') );	
			});

			$.post( URL + 'pages/soft', {ids: ids} );
		},
		pageSetting: function(){
			var self = this;

		},

		sectionAdd: function () {
			var self = this;

			Dialog.load( URL + 'pages/section_add/', {page_id: self.pageID}, {
				onSubmit: function ( $dialog ) {

					Dialog.close();
					var category = $dialog.$pop.find('[name=category]').val();
					$.post( URL + 'pages/addSection/', {page_id: self.pageID,category: category }, function (res) {
						

						console.log( res );

					}, 'json');
					
				}
			});
		}

	}

	$.fn.pageEditor = function( options ) {
		return this.each(function() {
			var $this = Object.create( PageEditor );
			$this.init( options, this );
			$.data( this, 'pageEditor', $this );
		});
	};
	
})( jQuery, window, document );