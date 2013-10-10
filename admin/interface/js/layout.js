
jQuery(document).ready(function($){
	var init_size = $('input[name=width]:checked').val();
	var supported = {
		max: {
			sidebar: ['2col_right', '3col_split'],
			footbar: ['even_3col', 'even_4col', 'staggered_3col', 'staggered_4col'],
			message: 'available for Maximum Width',
			default_sidebar: '2col_right',
			default_footbar: 'even_4col'
		},
		med: {
			sidebar: ['2col_left', '2col_right'],
			footbar: ['even_3col', 'staggered_2col'],
			message: 'available for Medium Width',
			default_sidebar: '2col_right',
			default_footbar: 'even_3col'
		},

		micro: {
			sidebar: [],
			footbar: ['even_1col', 'even_2col'],
			message: 'available for Micro Width',
			default_sidebar: '',
			default_footbar: 'even_2col'
		}
	}


	var disable_fields = function(size, field) {
		$('input[name^=' + field + ']').each(function(){
			var $this = $(this);
			if($.inArray($this.val(), supported[size][field]) == -1) {
				$this.parents('p').hide();
				$this.removeAttr('checked');
			} else {
				$this.parents('p').show();
			}
		});

		if(field == 'sidebar' && size == 'micro') {
			$('h4.sidebar').hide();
		} else if(field == 'sidebar') {
			$('h4.sidebar').show();
		}
	}

	var update = function() {
		var classes;

		var size = $('input[name=width]:checked').val();
		var sidebar = $('input[name=sidebar]:checked').val();
		var footbar = $('input[name="footbar[footbar]"]:checked').val();
		if(size == 'micro') {
			classes = size + '_1col ' + footbar;
		} else {
			classes = size + '_' + sidebar + ' ' + footbar;
		}

		$('#flexi-preview').attr('class', classes);
	}

	$('input:radio').click(function(e) {
		var $this = $(this);
		if($this.attr('name') == 'width') {
			var size = $this.val();
			disable_fields(size, 'sidebar');
			if(size != 'micro') $('#sidebar_' + supported[size].default_sidebar).attr('checked', 'checked');
			disable_fields(size, 'footbar');
			$('input[id*=footbar_' + supported[size].default_footbar + ']').each(function(){
				$(this).attr('checked', 'checked');
			});
			$('h3.widget_areas span').text(supported[size].message);
			if(size == 'max') {
				$('label[for=sidebar_2col_right]').text('Two sidebars on the right side of the page');
			} else {
				$('label[for=sidebar_2col_right]').text('One sidebar on the right side of the page');
			}
		}
		update();
	});
	
	$('input[name="enable_multi_footbars"]').change(function(e){
		var $this = $(this);
		
		if( $this.attr('checked') ) {
			var size = $('input[name=width]:checked').val();
			$('#alternate-footbars').removeClass('no-show');
			
			// Reset footbar selection for alternate footbars
			$('#alternate-footbars input[id*=footbar_' + supported[size].default_footbar + ']').each(function(){
				$(this).attr('checked', 'checked');
			});
		} else {
			$('#alternate-footbars').addClass('no-show');
		}

	});

	disable_fields(init_size, 'sidebar');
	disable_fields(init_size, 'footbar');
	$('h3.widget_areas span').text(supported[init_size].message);



});

