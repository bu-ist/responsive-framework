var responsive = responsive || {};

responsive.filtering = responsive.filtering || {};

responsive.filtering = ( function( $ ) {

	/**
	 * Filtering object.
	 *
	 * Responsible for handling the filtering of custom posts based on
	 * user selection.
	 */
	return {
		/**
		 * Initializes the object. Defines properties and executes runtime logic.
		 */
		init: function() {
			var ths = this;
			// Defines all object properties (DOM selectors, UI state, etc).
			this.setup();
		},

		/**
		 * Defines all object properties.
		 */
		setup: function() {
			// Define DOM selectors.
			this.defineSelectors();
			// Set UI object properties.
			this.defineProperties();
			// Attach events.
			this.attachEvents();
		},

		/**
		 * Defines all jQuery selectors and DOM elements for quick access.
		 */
		defineSelectors: function() {
			// Defines the search text input.
			this.$searchInput = $( '.js-search' );
			// Stores the wrapper containing all filter inputs, for quick access.
			this.$filtersWrapper = $( '#js-filter-wrapper' );
			// Stores all the filter inputs (checkboxes and radio inputs).
			this.$filters = this.$filtersWrapper.find( 'input' );
		},

		/**
		 * Defines UI state and other critical properties.
		 */
		defineProperties: function() {
			// Keeps track of the current filter values (may be checkbox or radio)
			// and initializes with our ListJS filter values.
			this.currentFilters = {};

			// This is probably not quite right, because this object will have both
			// filters and search. We only want filters. How do we identify these dynamically?
			var listJSFilters = this.getOptions().valueNames;

			for ( var i = listJSFilters.length - 1; i >= 0; i-- ) {
				this.currentFilters[listJSFilters[i]] = [];
			}

			// Initializes a new ListJS instance and stores it for quick access.
			this.resultsList = new List( 'main', this.getOptions() );
		},

		attachEvents: function () {
			this.updateResults = this.updateResults.bind( this );
			this.$searchInput.on( 'input', this.updateResults );
		},

		/**
		 * Retrieves ListJS options for creating a ListJS instance.
		 */
		getOptions: function () {
			return {
				valueNames: [
					'js-searchby-title',
					'js-searchby-content',
					'js-searchby-category'
				],
				searchClass: 'js-search',
				listClass: 'js-list'
			};
		},

		/**
		 * Handles searching and filtering.
		 */

		updateResults: function () {
			var searchVal = this.$searchInput.val();
			this.resultsList.search( searchVal );
		}
	};

}( jQuery ) );

// Kick off the program finder object and run initial logic.
responsive.filtering.init();