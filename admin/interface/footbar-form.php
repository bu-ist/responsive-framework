<fieldset>
<?php foreach( $footbars as $id => $footbar): ?>
	<p><input type="radio" id="footbar_layout_<?php echo $id; ?>" name="footbar_layout" value="<?php echo $id; ?>" <?php checked( $id, $selected ); ?>/>
	<label for="footbar_layout_<?php echo $id; ?>"><?php echo $footbar['name']; ?></label></p>
<?php endforeach; ?>
	<p><input type="radio" id="footbar_layout_none" name="footbar_layout" value="none" <?php checked('none', $selected ); ?>/>
	<label for="footbar_layout_none">None</label></p>
</fieldset>
