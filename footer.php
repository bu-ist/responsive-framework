</div><!-- .container -->
</div><!-- #page_wrapper -->

<?php
	if(is_dynamic_sidebar("bottom-content-area")):
		?>
		<aside id="bottom-content-area">
			<div>
				<?php dynamic_sidebar("bottom-content-area"); ?>
			</div>
		</aside>
		<?php
	endif;	    	
?>

<footer role="contentinfo">
	<a href="#top" title="Jump back to top">&#8593;</a>
	<?php
		if(function_exists('bu_footer_content')) {
			bu_footer_content();
		}
		
		
		$footer_contact = get_option("burf_setting_footer_contact");
		$footer_social_fb = get_option("burf_setting_footer_social_fb");
		$footer_social_tw = get_option("burf_setting_footer_social_tw");
		$footer_social_ig = get_option("burf_setting_footer_social_ig");
		$footer_social_yt = get_option("burf_setting_footer_social_yt");
		$footer_social_li = get_option("burf_setting_footer_social_li");
		
		if($footer_contact){ echo($footer_contact); }
		
		if($footer_social_fb){ echo("<a class='social-fb' href='" . $footer_social_fb) . "'>facebook</a>"; }
		if($footer_social_tw){ echo("<a class='social-tw' href='" . $footer_social_fb) . "'>twitter</a>"; }
		if($footer_social_ig){ echo("<a class='social-ig' href='" . $footer_social_fb) . "'>instagram</a>"; }
		if($footer_social_yt){ echo("<a class='social-yt' href='" . $footer_social_fb) . "'>youtube</a>"; }
		if($footer_social_li){ echo("<a class='social-li' href='" . $footer_social_fb) . "'>linkedin</a>"; }
		
		
		
		
	?>
</footer>

<?php wp_footer(); ?>


</body>
</html>