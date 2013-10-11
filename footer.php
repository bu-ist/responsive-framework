</section><!--/#content-->

<footer>
	<div class="container <?php bu_flexi_masterplate_class(); ?>">
    	<?php bu_flexi_show_masterplate(); ?>
    	<?php bu_flexi_show_bumc_branding(); ?>
    	<?php
    		if(function_exists('bu_footer_content')) {
    			if(function_exists('bu_edit_footer_link')) bu_edit_footer_link('Edit', '<p class="edit-link">', '</p>');
    			bu_footer_content();
    		} else {
    	?>
    	<ul>
        	<li><a href="/" title="Boston University">Boston University</a></li>
        	<li><a href="/search/" title="Search">Search</a></li>
        	<li><a href="/directory/" title="Directory">Directory</a></li>
        	<li><a href="<?php bloginfo('url');?>/contact-us/" title="Contact Us">Contact</a></li>
        	<li class="butoday"><a href="/today/" title="News &amp; Events for the BU Community"><span>BU</span> Today</a></li>
    	</ul>
    	<?php } ?>
    
		<?php
			$has_action = has_action('bu_switch_version_link');
			$disclaimer_enabled = bu_flexi_is_disclaimer_on();
			if ($has_action || $disclaimer_enabled):?>
    	<ul>
			<?php if ($has_action):?><li><?php do_action('bu_switch_version_link'); ?></li><?php endif;?>
    		<?php if ($disclaimer_enabled):?><li><?php bu_flexi_do_disclaimer(); ?></li><?php endif;?>
    	</ul>
		<?php endif;?>
	</div><!--/.container-->
</footer><!--/#footer-->

 
<?php wp_footer(); ?>
</body>
</html>
