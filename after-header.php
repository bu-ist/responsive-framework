<?php bu_flexi_announcement('<div class="announcement">', '</div>'); ?>
<?php if (function_exists('bu_content_banner')) {
		bu_content_banner($post->ID, $args = array(
			'before' => '<div class="banner-container window-width">',
			'after' => '</div>',
			'class' => 'banner',
			'position' => 'window-width'

			));
		bu_content_banner($post->ID, $args = array(
			'before' => '<div class="banner-container page-width">',
			'after' => '</div>',
			'class' => 'banner',
			'maxwidth' => bu_flexi_get_page_width(),
			'position' => 'page-width'
			));
} ?>
