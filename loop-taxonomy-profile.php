<?php if ( have_posts() ): ?>
<h1>Profiles <?php if ( is_tax() ):?> &raquo; <?php bu_current_term_name();?> <?php endif; ?></h1>
<?php // Output profile taxonomies to match basic listing format
if ( function_exists( 'bu_profile_get_template_part' ) ) {
	bu_profile_get_template_part( 'basic' );
} ?>
<p class="navigation"><span class="previous"><?php previous_posts_link( 'Last' ) ?></span> <span class="next"><?php next_posts_link( 'Next' ) ?></span></p><!-- /.navigation -->
<?php else: ?>
<p>No profiles were found under <strong><?php bu_current_term_name(); ?></strong>.</p>
<?php endif; ?>
