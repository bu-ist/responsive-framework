jQuery( document ).ready(function($) {
	function verifyNav() {
		let lis = jQuery('#update-nav-menu #post-body ul.menu li');
		lis.each(function () {
			// First Check if active in sort and don't act on the placeholder dive.
			if ( !$(this).hasClass('ui-sortable-helper') && !$(this).hasClass('sortable-placeholder')) {
				// If not active and not at 0 depth reset to 0 depth and alert user.
				if ( !$(this).hasClass('menu-item-depth-0') ) {
					let itemID = $(this).attr('id');
					let item = document.getElementById( itemID );
					let itemClasses = item.className;
					itemClasses = itemClasses.split( ' ' );
					itemClasses.forEach((element, index) => {
						if ( -1 !== element.toString().indexOf('menu-item-depth') ) {
							let currentDepthClass = itemClasses[index];
							$(this).removeClass(currentDepthClass);
							$(this).addClass('menu-item-depth-0');
							$(this).find( '.is-submenu').hide();
							window.alert( 'Nested menu items not allowed on Utility Menu. Menu item Reset to top level.');
						}
					} );
				}
			}
		});
	}

	// Setup Observer only on Utility Menu.
	let selectedMenu = jQuery('.manage-menus select').find(':selected').text();

	if( 'Utility Menu (Utility Navigation)' === selectedMenu.trim() ) {
		// Select the node that will be observed for mutations.
		const targetNode = document.getElementById('update-nav-menu');

		// Options for the observer (which mutations to observe).
		const config = {attributes: true, childList: true, subtree: true};

		// Create an observer instance linked to the callback function.
		const observer = new MutationObserver(verifyNav);

		// Start observing the target node for configured mutations
		observer.observe(targetNode, config);
	}
});
