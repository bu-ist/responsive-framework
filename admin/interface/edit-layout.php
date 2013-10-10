<?php
if ( !defined('ABSPATH') )
	die('-1');
?>
<div class="wrap">
	<div class="icon32" id="icon-themes"><br></div>
	<h2>Flex-Framework Layout</h2>
	<?php if(isset($message_id)): ?>
		<div id="message" class="updated fade"><p><?php echo $messages[$message_id]; ?></p></div>
	<?php endif; ?>
	<?php if(bu_is_production()): ?>
		<div class="error message">
			<p>Changing the size of the layout is not recommended on production websites.</p>
		</div>
	<?php endif; ?>
	<div id="flexi-layout-container">
		<form id="flexi-layout-form" method="post" action="">
			<?php // @todo -- how do we handle current footbar here? ?>
		<div id="flexi-preview" class="<?php echo $current_layout; ?> <?php echo $main_footbar; ?>">
			<h3>Main Layout Preview</h3>
<div id="flexi-layout">
			<h3 class="top">Page Width</h3>
			<p>
				<input type="radio" name="width" id="max-width" value="max"<?php checked('max', $current_width); ?>/>
				<label for="max-width"> Maximum</label> - <span>supports lots of content and widgets</span>
			</p>
			<p>
				<input type="radio" name="width" id="med-width" value="med"<?php checked('med', $current_width); ?>/>
				<label for="med-width"> Medium</label> - <span>supports lots of pages but fewer widgets</span>
			</p>
			<p>
				<input type="radio" name="width" id="micro-width" value="micro"<?php checked('micro', $current_width); ?>/>
				<label for="micro-width"> Micro</label> - <span>supports few pages and few widgets</span>
			</p>

			<h3 class="widget_areas">Widget Areas <span></span></h3>
			<h4 class="sidebar">Sidebar arrangement:</h4>
			<p>
				<input type="radio" name="sidebar" id="sidebar_2col_right" value="2col_right"<?php checked('2col_right', $current_sidebar); ?>/>
				<label for="sidebar_2col_right">
				<?php if($current_width == 'max'): ?>
					Two sidebars on the right side of the page
				<?php else: ?>
					One sidebar on the right side of the page
				<?php endif; ?>
				</label>
			</p>
			<p>
				<input type="radio" name="sidebar" id="sidebar_3col_split" value="3col_split"<?php checked('3col_split', $current_sidebar); ?>/>
				<label for="sidebar_3col_split"> One sidebar on each side of the page</label>
			</p>
			<p>
				<input type="radio" name="sidebar" id="sidebar_2col_left" value="2col_left"<?php checked('2col_left', $current_sidebar); ?>/>
				<label for="sidebar_2col_left"> One sidebar on the left side of the page</label>
			</p>

			<div class="footbar-layout" >
			<?php $id = 'footbar'; ?>
			<h4>Main Footbar Layout:</h4>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_even_4col" value="even_4col"<?php checked('even_4col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_even_4col"> Four evenly spaced columns</label>
			</p>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_staggered_4col" value="staggered_4col"<?php checked('staggered_4col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_staggered_4col"> Four columns with one large column</label>
			</p>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_even_3col" value="even_3col"<?php checked('even_3col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_even_3col"> Three evenly spaced columns</label>
			</p>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_staggered_3col" value="staggered_3col"<?php checked('staggered_3col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_staggered_3col"> Three columns with one large column</label>
			</p>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_staggered_2col" value="staggered_2col"<?php checked('staggered_2col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_staggered_2col"> Two columns with one large column</label>
			</p>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_even_2col" value="even_2col"<?php checked('even_2col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_even_2col"> Two evenly spaced columns</label>
			</p>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_even_1col" value="even_1col"<?php checked('even_1col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_even_1col"> One large column</label>
			</p>
			</div>
			
			<?php 
			$dynamic_footbars = bu_flexi_get_dynamic_footbar_ids();
			$footbars = bu_flexi_get_footbars($dynamic_footbars);

			// BU_SUPPORTS_DYNAMIC_FOOTBARS overrides this checkbox
			if( ! defined('BU_SUPPORTS_DYNAMIC_FOOTBARS') ): ?>
			<div id="multiple_footbar_option" >
			<p>
				<input type="checkbox" id="enable_multi_footbars" name="enable_multi_footbars" value="1" <?php checked( $enable_footbars, true ); ?> />
				<label for="enable_multi_footbars" >Enable multiple footbars</label>
			</p>
			</div>
			<?php endif; ?>
			
			<div id="alternate-footbars" <?php if( $enable_footbars == false ): ?> class="no-show" <?php endif; ?>>
			<?php foreach( $footbars as $id => $footbar ):
				$name = $footbar['name'];
				if( $id == 'footbar' )
					continue;
?>
			<div class="footbar-layout">
			<h4><?php echo $name; ?> Layout:</h4>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_even_4col" value="even_4col"<?php checked('even_4col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_even_4col"> Four evenly spaced columns</label>
			</p>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_staggered_4col" value="staggered_4col"<?php checked('staggered_4col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_staggered_4col"> Four columns with one large column</label>
			</p>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_even_3col" value="even_3col"<?php checked('even_3col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_even_3col"> Three evenly spaced columns</label>
			</p>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_staggered_3col" value="staggered_3col"<?php checked('staggered_3col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_staggered_3col"> Three columns with one large column</label>
			</p>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_staggered_2col" value="staggered_2col"<?php checked('staggered_2col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_staggered_2col"> Two columns with one large column</label>
			</p>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_even_2col" value="even_2col"<?php checked('even_2col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_even_2col"> Two evenly spaced columns</label>
			</p>
			<p>
				<input type="radio" name="footbar[<?php echo $id; ?>]" id="<?php echo $id; ?>_even_1col" value="even_1col"<?php checked('even_1col', $current_footbar_layouts[$id]); ?>/>
				<label for="<?php echo $id; ?>_even_1col"> One large column</label>
			</p>
			</div>
			<?php endforeach; ?>
			</div>

		</div><!-- /#flexi-layout -->

		</div><!-- /#flexi-preview -->
				<p class="submit clear"><input type="submit" class="button-primary" name="submit" value="<?php esc_attr_e('Update Layout'); ?>"</p>
		</form>
	</div>
</div><!-- /.wrap -->