// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var getStoreSelect = {
		init: function(options, elem) {
			var self = this;
			self.elem = elem;
			self.$elem = $(elem);
			self.options = options;

			self.$store = self.$elem.find('[name=store]');
			self.$SCry = self.$elem.find('[name=super_category]');
			self.$cry = self.$elem.find('[name=category]'); 

			$.get(self.options.url, {id: self.$store.val() }, function ( response ) {

				self.data = response;

				self.setStore();

				self.setSCry();
				self.setCry();

			}, 'json');


			self.event();
			
		},

		setStore: function () {
			var self = this;

			$.each(self.data.lists, function (i, item) {
				self.$store.append( $('<option>', {
					text: item.store_name,
					value: item.store_id,
					selected: self.options.store==item.store_id ? true: false
				}) );
			});
		},

		setSCry: function () {
			var self = this;

			self.$SCry.empty();
			
			$.each(self.data.lists[ self.$store.find(':selected').index() ].super_category.lists, function (i, item) {
				self.$SCry.append( $('<option>', {
					text: item.super_category_name,
					value: item.super_category,
					selected: self.options.super_category==item.super_category ? true: false
				}) );
			});
		},

		setCry: function () {
			var self = this;

			self.$cry.empty();

			var list = self.data.lists[ self.$store.find(':selected').index() ]
				.super_category.lists[ self.$SCry.find(':selected').index() ];

			if( !list ) return false;
			$.each( list.category.lists || {}, function (i, item) {
				
				self.$cry.append( $('<option>', {
					text: item.category_name,
					value: item.category,
					selected: self.options.category==item.category ? true: false
				}) );
			});
		},

		event: function (){
			var self = this;

			self.$store.change(function () {
				self.setSCry();
				self.setCry();
			});

			self.$SCry.change(function () {
				self.setCry();
			});
		}
	};

	$.fn.getStoreSelect = function( options ) {
		return this.each(function() {
			var $this = Object.create( getStoreSelect );
			$this.init( options, this );
			$.data( this, 'getStoreSelect', $this );
		});
	};

	$.fn.getStoreSelect.options = {
		onOpen: function() {},
		onClose: function() {}
	};
	
})( jQuery, window, document );