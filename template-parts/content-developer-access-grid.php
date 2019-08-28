<?php
/**
 * Template partial used to display content for Developers Access Grid.
 */
?>

<article role="main" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php responsive_content_banner( 'contentWidth' ); ?>

	<?php the_title( '<h1>', '</h1>' ); ?>

	<?php /*the_content()*/ ?>

	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('table.display').DataTable( {
		       /* columnDefs: [ {
		            targets: [ 0 ],
		            orderData: [ 0, 1 ]
		        }, {
		            targets: [ 1 ],
		            orderData: [ 1, 0 ]
		        }, {
		            targets: [ 4 ],
		            orderData: [ 4, 0 ]
		        } ]*/
		    } );
		    jQuery('#dev-access-grid').DataTable( {
		       /* columnDefs: [ {
		            targets: [ 0 ],
		            orderData: [ 0, 1 ]
		        }, {
		            targets: [ 1 ],
		            orderData: [ 1, 0 ]
		        }, {
		            targets: [ 4 ],
		            orderData: [ 4, 0 ]
		        } ]*/
		    } );

		    jQuery('#marcom-access-grid').DataTable( {
		        /*columnDefs: [ {
		            targets: [ 0 ],
		            orderData: [ 0, 1 ]
		        }, {
		            targets: [ 1 ],
		            orderData: [ 1, 0 ]
		        }, {
		            targets: [ 4 ],
		            orderData: [ 4, 0 ]
		        } ]*/
		    } );
		} );
	</script>
CloudFront/CloudWatch??
<H3>Applications(Web/Mobile)</H3>
<table id="" class="display">
	<thead>
		<tr>
			<th>Role</th>
			<th>Task</th>
			<th>Access Location</th>
			<th>Access Type</th>
			<th>Permissions</th>
			<th>Group</th>
			<th>Assign To</th>
		</tr>
	</thead>
	<tbody>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing</TD>
			<TD>ist-wp-app-devl101</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing</TD>
			<TD>ist-wp-assets-devl101</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing</TD>
			<TD>ist-wp-db-devl01</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing</TD>
			<TD>ist-wp-fs-devl01</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Production</TD>
			<TD>ist-wp-app-prod10*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Production</TD>
			<TD>ist-wp-assets-prod10*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Production</TD>
			<TD>ist-wp-db-prod0*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Production</TD>
			<TD>ist-wp-fs-prod10*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing</TD>
			<TD>ist-wp-app-test10*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing</TD>
			<TD>ist-wp-assets-test10*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing</TD>
			<TD>ist-wp-db-test0*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing</TD>
			<TD>ist-wp-fs-test0*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing?</TD>
			<TD>ist-wp-app-syst10*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing?</TD>
			<TD>ist-wp-assets-systt10*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing</TD>
			<TD>ist-wp-db-test0*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing</TD>
			<TD>ist-wp-fs-test0*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing?</TD>
			<TD>it.bu.edu</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing?</TD>
			<TD>SVN?</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo pts?</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Production?</TD>
			<TD>AFS?</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo/klog</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing?</TD>
			<TD>AWS</TD>
			<TD>Account?</TD>
			<TD>?</TD>
			<TD>?</TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing?</TD>
			<TD>CloudFront</TD>
			<TD>Account?</TD>
			<TD>?</TD>
			<TD>?</TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing?</TD>
			<TD>AWS</TD>
			<TD>Account?</TD>
			<TD>?</TD>
			<TD>?</TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Production</TD>
			<TD>ist-www-mysql-prod</TD>
			<TD>?</TD>
			<TD>?</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing</TD>
			<TD>ist-www-mysql-devl</TD>
			<TD>?</TD>
			<TD>?</TD>
			<TD></TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing?</TD>
			<TD>Splunk</TD>
			<TD>Account?</TD>
			<TD>?</TD>
			<TD></TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Production</TD>
			<TD>Deploy Tool</TD>
			<TD>GUI/CLI?</TD>
			<TD>?</TD>
			<TD></TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Production</TD>
			<TD>?</TD>
			<TD>SVN</TD>
			<TD>?</TD>
			<TD></TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Testing</TD>
			<TD>Specific github repos?</TD>
			<TD></TD>
			<TD></TD>
			<TD></TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Dev.</TD>
			<TD></TD>
			<TD></TD>
			<TD></TD>
			<TD></TD>
			<TD></TD>
		</TR>
		<TR>
			<td>APP Dev.</TD>
			<td>APP Dev.</TD>
			<TD>afs/bu.edu/cwis/web/phpbin</TD>
			<TD>Ssh/sftp</TD>
			<TD>Klog</TD>
			<TD></TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>APP Dev.</TD>
			<td>APP Dev.</TD>
			<TD>afs/bu.edu/cwis/web/dbin</TD>
			<TD>Ssh/sftp</TD>
			<TD>klog</TD>
			<TD></TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>APP Dev.</TD>
			<td>APP Dev.</TD>
			<TD>Specific apps or test envs?</TD>
			<TD></TD>
			<TD></TD>
			<TD></TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>APP Dev.</TD>
			<td>APP Dev.</TD>
			<TD>ist-phpbin-prod*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>APP Dev.</TD>
			<td>APP Dev.</TD>
			<TD>ist-phpbin-devl*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>APP Dev.</TD>
			<td>APP Dev.</TD>
			<TD>ist-phpbin-test*</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>Django Dev.</TD>
			<td>Django Dev.</TD>
			<TD>ist-www-mysql-devl</TD>
			<TD>Access from vsc64/65</TD>
			<TD>Full ACL</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>Django Dev.</TD>
			<td>Django Test</TD>
			<TD>ist-www-mysql-test</TD>
			<TD>Access from vsc66/67</TD>
			<TD>Full ACL</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>Django Dev.</TD>
			<td>Django Prod</TD>
			<TD>ist-www-mysql-prod</TD>
			<TD>Access from vsc68/69</TD>
			<TD>Full ACL</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>Django Dev.</TD>
			<td>Django Dev.</TD>
			<TD>http://vsc64.bu.edu</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>Django Dev.</TD>
			<td>Django Test</TD>
			<TD>http://vsc66.bu.edu</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>Django Dev.</TD>
			<td>Django Test</TD>
			<TD>http://vsc67.bu.edu</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>Django Dev.</TD>
			<td>Django Prod</TD>
			<TD>http://vsc68.bu.edu</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>Django Dev.</TD>
			<td>Django Prod</TD>
			<TD>http://vsc69.bu.edu</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Dev.</TD>
			<TD></TD>
			<TD></TD>
			<TD></TD>
			<TD></TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Dev.</TD>
			<TD></TD>
			<TD></TD>
			<TD></TD>
			<TD></TD>
			<TD></TD>
		</TR>
		<TR>
			<td>Admin</TD>
			<td>Admin</TD>
			<TD>/fs/chef/chef-repo/cookbooks/ist-wp-app</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo/klog?</TD>
			<TD></TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>Admin</TD>
			<td>Admin</TD>
			<TD>/fs/chef/chef-repo/cookbooks/ist-wp-assets</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo/klog?</TD>
			<TD></TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>Admin</TD>
			<td>Admin</TD>
			<TD>*/afs/bu.edu/cwis/web/config/servers/www/www:phpmap.txt</TD>
			<TD></TD>
			<TD>Read/write/execute/sudo/klog?</TD>
			<TD></TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>Admin</TD>
			<td>Admin</TD>
			<TD>*/afs/bu.edu/cwis/web/config/servers/www/www-test:phpmap.txt</TD>
			<TD></TD>
			<TD>Read/write/execute/sudo/klog?</TD>
			<TD></TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>Admin</TD>
			<td>Admin</TD>
			<TD>*/afs/bu.edu/cwis/web/config/servers/www/www-devl:phpmap.txt</TD>
			<TD></TD>
			<TD>Read/write/execute/sudo/klog?</TD>
			<TD></TD>
			<TD></TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<td>Admin</TD>
			<TD></TD>
			<TD></TD>
			<TD>Read/write/execute/sudo/klog?</TD>
			<TD></TD>
			<TD></TD></TR>
</tbody>
</table>

<!-- 





 -->

 
<H3>MarComm</H3>
<!-- <table id="marcom-access-grid" class="display"> -->
<table id="" class="display">
	<thead>
		<tr>
			<th>Role</th>
			<th>Task</th>
			<th>Access Location</th>
			<th>Access Type</th>
			<th>Permissions</th>
			<th>Group</th>
			<th>Assign To</th>
		</tr>
	</thead>
	<tbody>
		<TR>
			<TD>WP Dev.</TD>
			<th>Task</th>
			<TD>ist-wp-app-devl_10*.bu.edu</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<th>Task</th>
			<TD>ist-wp-app-prod_10*.bu.edu</TD>
			<TD>Ssh/sftp</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<th>Task</th>
			<TD>ist-wp-bld-pr01.bu.edu</TD>
			<TD>SSH</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<th>Task</th>
			<TD>ist-wp-app-devl101.bu.edu</TD>
			<TD>SFTP</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>webteam</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<th>Task</th>
			<TD>webdev.bu.edu*</TD>
			<TD>SFTP</TD>
			<TD>Read/write/execute/sudo</TD>
			<TD>wpcmscode</TD>
			<TD>Ticket</TD>
		</TR>
		<TR>
			<TD>WP Dev.</TD>
			<TD>WP Dev.</TD>
			<TD>Deploy Tool</TD>
			<TD>GUI/CLI?</TD>
			<TD>?</TD>
			<TD></TD>
			<TD></TD>
		</TR>
	</tbody>
</table>

<p>* They specifically need access to /w/e/webteam <i>but</i> it seems MarComm only get access to static file directories on a case by case basis. Is there a reason they sholdn't have access to all the directories/files for working on static sites?</p>
	<?php responsive_share_tools(); ?>

	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:' ), 'after' => '</div>' ) ); ?>

	<?php edit_post_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>

	<?php responsive_comments(); ?>

</article>
