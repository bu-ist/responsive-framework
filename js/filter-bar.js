var responsive = responsive || {};

responsive.filtering = responsive.filtering || {};

responsive.filtering = ( function( $ ) {

	/**
	 * Settings for filtering.
	 *
	 * Handles setting up basic search and filtering through List.js.
	 * Controls whether or not search will be used on page, what filters
	 * will be used, and what content will be considered for either search
	 * or filtering through List.js.
	 *
	 * You may also interact with the List.js setup object directly, if you like.
	 *
	 * Acceptable filter types: radio, checkbox, checkbox-group, dropdown.
	 */

	var settings = {
		userInterface: {
			search: {
				class: 'js-search'
			},
			filters: [
				{
					class: 'js-radio',
					type: 'radio'
				},
				{
					class: 'js-checkbox',
					type: 'checkbox'
				},
				{
					class: 'js-checkbox-group',
					type: 'checkbox-group'
				},
				{
					class: 'js-dropdown',
					type: 'dropdown'
				}
			],
		},
		contentTargets: [
			'js-searchby-title',
			'js-searchby-content',
			'js-searchby-category'
		]
	};

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

		init: function( themeSettings ) {
			var ths = this;

			if ( undefined !== themeSettings ) {
				settings = themeSettings;
			}

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
			this.$searchInput = $( '.' + settings.userInterface.search.class );
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
			// and initializes with our filter names from the settings object.
			this.currentFilters = {};

			for ( var i = settings.userInterface.filters.length - 1; i >= 0; i-- ) {
				this.currentFilters[settings.userInterface.filters[i].class] = [];
			}

			console.log(this.currentFilters);

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
			this.listJSSettings = {
				valueNames: settings.contentTargets,
				searchClass: settings.userInterface.search.class,
				listClass: 'js-list'
			};

			return this.listJSSettings;
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