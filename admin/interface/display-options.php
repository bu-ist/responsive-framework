<div class="wrap">
	<h2>Display Options</h2>
	<p>Change settings how content is displayed. Note that the News page template has its own display options.</p>
	<?php if ($msg): ?>
	<div class="updated"><p><?php echo $msg; ?></div>
	<?php endif; ?>
	<form method="post" action="">
		<h3>Posts</h3>
		<p>
			<input type="checkbox" name="flexi_display[cat]" id="flexi_display_cat_1" value="1" <?php checked($display_opts['cat'], 1, true); ?>/>
			<label for="flexi_display_cat_1">Display post categories</label>
			<br />
		</p>
		<p>
			<input type="checkbox" name="flexi_display[tag]" id="flexi_display_tag_1" value="1" <?php checked($display_opts['tag'], 1, true); ?>/>
			<label for="flexi_display_tag_1">Display post tags</label>
			<br />
		</p>
		<p>
			<input type="checkbox" name="flexi_display[author]" id="flexi_display_author_1" value="1" <?php checked($display_opts['author'], 1, true); ?>/>
			<label for="flexi_display_author_1">Display post author</label>
			<br />
		</p>
		<p>
			<?php wp_nonce_field('flexi_display_options_nonce', 'flexi_display_options_nonce', false, true); ?>
			<input type="submit" class="button-primary" value="Save Changes" />
		</p>
	</form>
</div>