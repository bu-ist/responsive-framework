jQuery(function($) {
	// Initialize color picker
	$('#colorpicker').hide();
	$('#colorpicker').farbtastic('#text-color');
	$('#text-color').click(function() {
		$('#colorpicker').toggle();
	});
	$('#colorpicker').hover(
		function() {$(this).data('hovering', true);},
		function() {$(this).data('hovering', false);}
	);
	$('body').mousedown(function() {
		if (!$('#colorpicker').data('hovering'))
		{
			$('#colorpicker').hide();
		}
	});
	
	
	$('#type-text, #type-image').change(function() {
		if ($('#type-text').attr('checked'))
		{
			$('#type-text-form').show();
			$('#type-image-form').hide();	
		}
		else
		{
			$('#type-text-form').hide();
			$('#type-image-form').show();		
		}
	});
	$('#type-image').change	();

	// Initialize ghost text
	if (!$('#text-header').val())
	{
		$('#text-header')
			.val('Your title here')
			.css('color', '#bbb')
			.focus(function() {
				$(this).val('');
				$(this).css('color', '');
			});
	}
	
	$('.preview-btn').click(function() {
		var url = '',
			mobile = ($(this).hasClass('mobile'));
		
		function preview(url, width, title)
		{
			if (typeof width == 'undefined')
			{
				width = $('body').outerWidth() - 200;
			}
			
			if (typeof title == 'undefined')
			{
				title = 'Preview';
			}
				
			url = url + '&TB_iframe&width=' + width;
			tb_show('Preview', url);
		}
		
		if ($('#type-text').attr('checked'))
		{
			if (!$('#text-header').val() || !$('#text-color').val())
			{
				alert('Please provide header text and color.');
				return false;
			}
			url = site_url + '/?preview-header=text&text='
				+ encodeURIComponent($('#text-header').val())
				+ '&c=' + encodeURIComponent($('#text-color').val());
			if (mobile)
			{
				url += '&wantsMobile=true';
				preview(url + '&wantsMobile=true', 640, 'Mobile preview');
			}
			else
			{
				preview(url);
			}
		}
		else if ($('#type-image').attr('checked'))
		{
			var url = ajaxurl + '?action=flexi-header-preview',
				input_id = 'custom-logo',
				alt = $('#alt-text').val();
				
			if (mobile)
			{
				url += '&mobile=1';
				input_id += '-m';
				alt = $('#alt-text-m').val();
			}

			if (!$('#' + input_id).val())
			{
				alert('Please select a logo to upload before previewing.')
				return false;
			}

			$.ajaxFileUpload({
				'url': url,
				'secureurl': false,
				'fileElementId': input_id,
				'dataType': 'json',
				'success': function(data)
					{
						if (data.status)
						{
							url = site_url + '/?preview-header=image&alt='
								+ encodeURIComponent(alt)
								+ '&f=' + encodeURIComponent(data.filename);
							if (mobile)
							{
								url += '&wantsMobile=true';
								preview(url + '&wantsMobile=true', 640, 'Mobile preview');
							}
							else
							{
								preview(url)
							}
						}
						else
						{
							alert(data.error);
						}
					},
				'error': function(data)
					{
						alert('Failed during file upload; unable to preview.');
					}
			});
			
			return false;
		}
		else
		{
			alert('Please select a header type before attempting to preview.');
			return false;
		}
		
		return false;
	});
});