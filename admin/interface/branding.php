<div class="wrap">

<h2>Flexi Branding</h2>
<?php echo $msg;?>

<p>
	Choose the branding type below to change branding options for this site.  Logos will
	be regenerated as well.
</p>

<h3>Current logo
	<select id="swatch">
		<option value="inherit">No background</option>
		<option value="#CC0000">Red</option>
		<option value="#07144B">Blue</option>
		<option value="#000000">Black</option>
	</select>
</h3>

<div id="current-logo">
	<img src="<?php bu_flexi_get_header_image();?>" alt="Current logo" />
</div>

<h3 id="branding-header">Branding Settings</h3>
<form method="POST" id="branding-form">
	<?php wp_nonce_field('branding-submit', 'branding-nonce');?>
	<div class="section">
		<div class="head">Entity Status</div>
		<div class="inputs">
			<label id="branding-logotype">
				<input type="radio" name="branding" value="logotype" <?php echo $check_logotype;?>>
				Official Entity, Sub-brand Logotype
			</label>
			<label id="branding-signature">
				<input type="radio" name="branding" value="signature" <?php echo $check_signature;?>>
				Official Entity, Sub-brand Signature
			</label>
			
			<label id="branding-logotype-stacked">
				<input type="radio" name="branding" value="logotype-stacked" <?php echo $check_stacked;?>>
				Official Entity with Parent
			</label>
			
			<label id="branding-non-entity">
				<input type="radio" name="branding" value="non-entity" <?php echo $check_non_entity;?>>
				Non-Official Entity
			</label>
		</div>
	</div>

	<div id="extra-field">
	<div class="section" id="parent-entity" style="display: none">
		<div class="head">Parent Entity</div>
		<div class="inputs">
			<input type="input" name="parent-entity">
		</div>
	</div>
	
	<div class="section" id="sponsoring-entity" style="display: none">
		<div class="head">Sponsoring Entity</div>
		<div class="inputs">
			<input type="input" name="sponsoring-entity">
		</div>
	</div>
	</div>

	<input type="submit" class="button" value="Update Branding" />
</form>

<div id="samples">
	<h3 style="display: none">Sample</h3>
	<div id="logotype-stacked" style="display: none">
		<img src="<?php echo get_bloginfo('template_directory');?>/admin/interface/images/logotype-stacked.png">
	</div>
	<div id="non-entity" style="display: none">
		<img src="<?php echo get_bloginfo('template_directory');?>/admin/interface/images/non-entity.png">
	</div>
	<div id="signature" style="display: none">
		<img src="<?php echo get_bloginfo('template_directory');?>/admin/interface/images/signature.png">
	</div>
	<div id="logotype" style="display: none">
		<img src="<?php echo get_bloginfo('template_directory');?>/admin/interface/images/logotype.png">
	</div>
</div>
