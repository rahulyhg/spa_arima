// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {
	
	var Programs = {
		init: function( options, elem ){
			var self = this;

			self.elem = elem;
			self.$elem = $( elem );

			self.options = $.extend( {}, $.fn.programs.options, options );


			if( self.options.programs.length>0 ){
				$.each(self.options.programs, function (i, obj) {
					self.add( obj );
				});
			}
			else{
				self.add();
			}
			
			self.$elem.find('.js-add-programs').click(function () {
				self.add();
			});
		},

		add: function ( data ) {
			var self = this;
			self.$elem.find('.programs-tour').append( self.setItemDays( data ) );
			self.sort();
		},

		setItemDays: function ( data ) {
			var self = this;

			var data = data || {
				timing: []
			};
			var $textarea = $('<textarea>', {
				type:'name',
				class: 'inputtext input-days',
				name: "pro_name[]",
			}).val( data.pro_name );

			$add = $('<a>', {
				class:'fsm rfloat mrs',
				text: 'inputtext',
				text: "เพิ่มเวลา"
			});

			var tbody = $('<tbody>');

			var $cancel = $('<a>', {class: 'rfloat fsm mts'}).append( $('<i>', {class: 'icon-remove'}), 'ยกเลิก' );

			var li = $('<li>').append(
				$('<div>', {class: 'head clearfix'}).append(
					  $cancel
					, $('<div>', {class: 'label', text: 'วันที่'}).append( $('<span>', {class: 'days-text mls'}) )
					, $('<div>', {class:'name'}).html( $textarea )
				)
				, $('<table>', {class: 'timing'}).append(
					$('<thead>').append(
						$('<tr>').append(
							  $('<th>', {class: 'label', text: 'เวลา'})
							, $('<th>', {class: '', text: 'รายระเอียด'})
							, $('<th>', {class: 'cancel'})
						)
					)
					, tbody
				)
				, $('<div>', {class: 'clearfix'}).css('margin-right', 30).append( $add )
			);

			// $textarea.autosize();

			if( data.timing.length>0 ){
				$.each( data.timing, function (i, obj) {
					tbody.append( self.setItemTile( obj ) );
				} );

			}
			else{
				tbody.append( self.setItemTile() );
			}

			
			$add.click(function () {
				tbody.append( self.setItemTile() );
				self.sort();
			});

			$cancel.click(function () {

				if( self.$elem.find('.programs-tour>li').length==1 ){
					self.$elem.find('.programs-tour>li').find(':input').val('');
				}
				else{
					li.remove();
				}

				self.sort();
			});

			return li;
		},

		setItemTile: function(data) {
			var self = this;
			var data = data || {};

			var $textarea = $('<textarea>', {
				class: 'inputtext input-timing'
			}).val( data.time_description );

			$cancel = $('<a>', {class: 'btn-icon'}).html( $('<i>', {class: 'icon-remove'}) );

			var tr = $('<tr>').append(
				  $('<td>', {class: 'label'}).append( self.setSelectHours(data.time_time) )
				, $('<td>').append( $textarea )
				, $('<td>').append( $cancel )
			);

			$cancel.click(function () {
				
				if( $(this).parents('.timing').find('tr').length==2){
					$(this).parents('.timing').find('tr').find(':input').val('');
				}
				else{
					tr.remove();
				}

				self.sort();
				
			});

			$textarea.autosize();

			return tr;
		},

		setSelectHours: function ( val ) {
			$select = $('<select>', {class: 'inputtext select-timing'});

			var $hours = 24;
			for (var h = 0; h < $hours; h++) {
				var $h = h<10 ? "0"+h:h;

				for (var i = 0; i < 2; i++) {
					var $i = i==0 ? '00':'30';

					var timing = h*3600;

					if( i==1 ){
						timing += 30*60;
					}					

					$select.append( $('<option>', {
						text: $h+':'+$i, 
						value: timing,
						selected: parseInt(val)==timing ? true: false
					}) );
				}
				


				
			}


			return $select;
		},

		sort: function () {
			var self = this;

			var c = 0;
			$.each( self.$elem.find('.programs-tour>li' ), function (i, item) {
				var $item = $(item);

				$item.find('.days-text').text( (c+1) );
				$item.find('.input-days').attr('name', 'items['+ c +'][name]');

				var r = 0;
				$.each( $item.find('.timing>tbody>tr' ), function (index, tr) {
					var $tr = $(tr);

					$tr.find('.select-timing').attr('name', 'items['+ c +'][timing]['+ r +'][time]');
					$tr.find('.input-timing').attr('name', 'items['+ c +'][timing]['+ r +'][text]');

					r++;
				});


				c++;
			});	
		}
	};

	$.fn.programs = function( options ) {
		return this.each(function() {
			var $this = Object.create( Programs );
			$this.init( options, this );
			$.data( this, 'programs', $this );
		});
	};
	
	$.fn.programs.options = {
	};
	
})( jQuery, window, document );