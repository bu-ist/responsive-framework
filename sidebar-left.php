<?php if(bu_flexi_is_layout(array('max_2col_left', 'med_2col_left', 'max_3col_split'))) : ?>
	<div id="col1" class="sub" role="complementary">
		<?php if(bu_flexi_is_layout('max_2col_left') && is_active_sidebar('sidebar-1')) : ?>
			<div id="sidebar1">
				<?php dynamic_sidebar('sidebar-1'); ?>
			</div>
		<?php endif; ?>
		<?php if(bu_flexi_is_layout(array('max_2col_left'))) : ?>
			<div id="sidebar2">
			<?php bu_flexi_primary_sidebar(); ?>
			</div>
			<div id="sidebar3">
				<?php dynamic_sidebar('sidebar-3'); ?>
			</div>
		<?php elseif(bu_flexi_is_layout(array('med_2col_left', 'max_3col_split'))) : ?>
			<div id="sidebar2">
			<?php bu_flexi_primary_sidebar(); ?>
			</div>
		<?php endif; ?>
	</div><!-- /#sub -->
<?php endif; ?>	
