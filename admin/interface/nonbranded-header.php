<div class="wrap">

<h2>Non-branded Site Header</h3>
<?php echo $msg;?>

<?php if ($_GET['error']):?>
<div class="error">
	<?php echo htmlentities($_GET['error'], ENT_QUOTES, 'UTF-8');?>
</div>
<?php endif;?>
<p>Configure your site's header settings below. You may choose between a text-based header or upload
an image.</p>

<form method="POST" enctype="multipart/form-data">
	<?php wp_nonce_field('flexi-non-branded-header', 'flexi-nonce');?>
	<h3>Selected a header type</h3>
	<label><input id="type-text" type="radio" name="input_type" value="text" <?php echo $text_checked;?> /> Text</label><br/>
	<label><input id="type-image" type="radio" name="input_type" value="image" <?php echo $image_checked;?> /> Image</label><br/>
	<hr />

	<div id="type-text-form">
		<h3>Text and Color</h3>
		<input type="text" id="text-header" name="text-header" value="<?php echo htmlentities($text, ENT_QUOTES, 'UTF-8');?>"/><br/>
		<p class="hint">You may enter any text here, HTML is not permitted</p>
		
		<div id="cp-wrapper">
			<input type="text" id="text-color" name="text-color" value="<?php echo $text_color;?>" />
			<div id="colorpicker"></div>
		</div>
		<input type="submit" value="Preview" class="button preview-btn" />
	</div>

	<div id="type-image-form">
		<h3>Upload a custom logo</h3>
		<?php if ($image_src): ?>
		<div class="current-logo"><img src="<?php echo $image_src;?>" alt="<?php echo htmlentities($alt_text, ENT_QUOTES, 'UTF-8');?>" /></div>
		<?php endif;?>
		
		<input type="file" name="custom-logo" id="custom-logo" /><br />
		<?php if ($image_src): ?>
		<p class="hint">Leave this empty to continue using your current header and just change the alt text.</p>
		<?php endif;?>
		
		<label>
			<strong>Alt text:</strong>
			<input type="text" id="alt-text" name="alt-text" value="<?php echo htmlentities($alt_text, ENT_QUOTES, 'UTF-8'); ?>" />
		</label>
		
		<p class="hint">Header must be a .png, .gif, or .jpg that is 84px tall and at most 600px wide</p>
		<input type="submit" value="Preview" class="button preview-btn" />
		
		<?php if ($support_mobile): ?>		
		<h3>Upload a mobile logo</h3>
		<?php if ($image_src_m):?>
		<div class="current-logo-m"><img src="<?php echo $image_src_m;?>" alt="<?php echo htmlentities($alt_text_m, ENT_QUOTES, 'UTF-8');?>" /></div>
		<?php endif;?>
		
		<input type="file" name="custom-logo-m" id="custom-logo-m" /><br />
		<?php if ($image_src_m): ?>
		<p class="hint">Leave this empty to continue using your current header.</p>
		<?php endif;?>
		
		<label>
			<strong>Alt text:</strong>
			<input type="text" id="alt-text-m" name="alt-text-m" value="<?php echo htmlentities($alt_text_m, ENT_QUOTES, 'UTF-8'); ?>" />
		</label>

		<p class="hint">Header must be a .png, .gif, or .jpg that is either <?php echo FLEXI_MAX_HEADER_WIDTH_M;?>px or <?php echo 2 * FLEXI_MAX_HEADER_WIDTH_M;?>px wide.  If you use the wider format, it will be sized down to <?php echo FLEXI_MAX_HEADER_WIDTH_M;?>px to support <a href="http://en.wikipedia.org/wiki/Retina_Display" target="retina">Retina Display</a>.</p>
		<input type="submit" value="Preview Mobile" class="button preview-btn mobile" />
		<?php endif;?>
	</div>
	
	<br/><input type="submit" class="button" value="Save settings" />
</form>

<div id="header-preview"></div>

</div>
