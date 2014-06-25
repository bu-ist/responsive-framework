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
	<p>&copy;<?php echo date("Y"); ?> <a href="#top" title="Jump back to top">&#8593;</a></p>
</footer>

<?php wp_footer(); ?>


</body>
</html>