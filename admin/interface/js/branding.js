jQuery(function($) {
	$('#branding-form input').change(function() {
		if ($('#branding-logotype input').attr('checked')
				|| $('#branding-signature input').attr('checked'))
		{
			$('#parent-entity').hide().find('input').val('');
			$('#sponsoring-entity').hide().find('input').val('');
		}
		else if ($('#branding-logotype-stacked input').attr('checked'))
		{
			$('#sponsoring-entity').hide().find('input').val('');
			$('#parent-entity').show('fast');
		}
		else if ($('#branding-non-entity input').attr('checked'))
		{
			$('#parent-entity').hide().find('input').val('');
			$('#sponsoring-entity').show('fast');
		}

		showSample();
	}).change();

	$('#branding-form').submit(function() {
		if (!$('input[name="branding"]:checked').length)
		{
			showError('Must select a branding option');
			return false;
		}
		else if ($('#branding-logotype-stacked input').attr('checked')
				&& !$('#parent-entity input').val())
		{
			showError('Must provide a parent entity for this branding option', $('#parent-entity input'));
			return false;
		}
		else if ($('#branding-non-entity input').attr('checked')
				&& !$('#sponsoring-entity input').val())
		{
			showError('Must provide a sponsoring entity for this branding option', $('#sponsoring-entity input'));
			return false;
		}
	});

	function showError(msg, target)
	{
		$('div.wrap .error').remove();
		var error = $('<div class="error"></div>').text(msg);

		if (typeof target === 'undefined')
		{
			target = $('#branding-header');
		}

		target.after(error);
	}

	function showSample()
	{
		$('#samples div').hide('');
		if ($('#branding-logotype input').attr('checked'))
		{
			$('#samples h3').show();
			$('#logotype').fadeIn('fast');
		}
		if ($('#branding-signature input').attr('checked'))
		{
			$('#signature').fadeIn('fast');
			$('#samples h3').show();
		}
		if ($('#branding-logotype-stacked input').attr('checked'))
		{
			$('#logotype-stacked').fadeIn('fast');
			$('#samples h3').show();
		}
		if ($('#branding-non-entity input').attr('checked'))
		{
			$('#non-entity').fadeIn('fast');
			$('#samples h3').show();
		}
	}

	$('#swatch').change(function() {
		$('#current-logo').css('background-color', $(this).find('option:selected').val());
	});
});
