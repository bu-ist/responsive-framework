# Changelog

## Unreleased

- Fixes broken Travis CI tests.

## 2.3.5

- Replicated the `responsive_primary_nav_before` and `responsive_primary_nav_after` hooks into the BU version of `responsive_primary_nav`
- Fixes #170

## 2.3.4

- Add quotes to iframe attributes for BUNIVERSE shortcode.

## 2.3.3

- Add template hooks to all core WP and custom page templates in the theme.
- Normalize the markup used on all page templates for consistency.
- Split the calendar template into `calendar.php` and `calendar-single.php` by
  leveraging the `template_include` filter.
- Add support for custom fields on `calendar-single.php`.

## 2.3.2

- Removes default option of "true" to address #364 where customizer could not
  persist an unchecked value for Customizer > Content Options > "Keep the posts
  sidebar on bottom".
- Bugfix on color schemes to ensure their values are properly retrieved using
  array_key_exists instead of in_array.
- Fixes broken phpunit tests for testing customizer color/font values.

## 2.3.1

Version bump to run the upgrade to accomodate new color schemes

## 2.3.0

- New and improved UI for color palette selection
- Add edit links to BU profiles partials and support for improved styling
- Add to the upgrade procedure migration of the font and color palettes
- Rebuilds the `burf_customizer_styles` option.
- Refactor of the larger code blocks into their own functions.

## 2.2.0

- Move footer-branding and footer-menus to their own template partials for
  easier child theme overrides.
- Bugfix on `responsive_primary_nav` introduced in 2.1.12. Only overrides
  container_id and container_class args for bu navigation, rather than all args.
- Bugfix on banner page titles introduced in 2.1.12. Adds a filter to set
  `bu_banner_has_text` to true on the front-end for text layouts, since that is
  the conditional that was added from 2.1.12.
- Add autoprefixer support with grunt-postcss plugin.
- Add browserslist support in package.json for front-end tools like
  autoprefixer.
- Add es6 functionality via a variety of npm packages and Gruntfile
  modifications:
    - `grunt-browserify`: A bundler that allows for easier dependency management
      and gives the ability to use `require` for separating files into modules.
      Polyfills the `require` function used in Node for the browser.
    - `babelify`: Provides a transform for browserify so we can write es6 code.
      This includes using modern `import` and `export` features rather than
      having to use `require`. This package will transpile es6 code into es5
      which browserify can bundle for the browser.
    - `@babel/core`: Required babel library for `babelify` package.
    - `@babel/preset-env`: The recommended "smart" preset for configuring babel
      to take advantage of latest es6 features.
    - `@wordpress/babel-preset-default`: Adds WordPress es6 configurations.
    - `@wordpress/eslint-plugin`: Adds linting rules to adhere to WordPress
      standards for the `eslint` package.
    - `browserify-shim`: makes CommonJS incompatible files browserifyable (files
      that don’t support `require` from the CommonJS module syntax). Also allows
      us to determine what global variables we will use in our project that will
      NOT be bundled, such as jQuery.
    - `eslint` For code climate and text editors to lint and autofix their code.
    - Updates `grunt-contrib-clean` to 2.0.0. Also adds a clean:js task to clear
      contents of directories for new compiled files to reside in, so that old
      irrelevant files don't stick around.
- Adds `grunt-sass-lint` for separate `grunt sasslint` task.
- Adds `browserslist` to package.json so front-end tooling packages like `babel`
  and `autoprefixer` (not yet in Framework) can share the same configurations
  for browser support.
- Adds `.babelrc` configuration file for es6 configs.
- Adds `.eslintrc.json` configuration file for eslint configs.
- Adds `.sasslintrc` for grunt sasslint command and code climate.
- Pulls in Responsive Foundation as an es6 module.
- Refactors `galleries.js` to bundle together with our lightgallery,
  lg-thumbnail pacakges (Also Removed these hardcoded js libraries in
  the repo since they can be pulled in and bundled together with the code).
- Refactors all JS files to be written in modern es6 syntax.
- Updates codeclimate to use eslint-5 and sass-lint instead of scss-lint which
  will eventually be deprecated or will not support latest sass features.

## 2.1.13

- Minor update to change how content was checked for banners, switching to the bu_banners spefic `has_text`.
- Resolve PHP Warnings when `responsive_get_posts_archive_link` is called on a
  page that doesn't have any categories assigned to it.

## 2.1.12

- Bower cleanup.
- Fix font labeling in the customizer to match actual fonts.
- Add filter for `responsive_font_options` for customizer fonts.
- Add filter for `responsive_get_font_palette` for when `f1` no longer exists
  and a value hasn't been set yet.
- Remove `bundle install` from package.json postinstall scripts.
- Upgrade `grunt-sass` from 2.0.0 to 3.0.2.
- Print Stylesheet partial creation in Foundation: `/css-dev/burf-base/_print.scss`
- Added mega navigation menu to customizer
- Added new masthead markup for mega nav
- Added new menu location for "short" nav
- Add filter to alllow for modification of `bu_navigation_display_primary`
  defaults from within framework.
- Add before/after action hooks for the `responsive_primary_nav` and
  `responsive_utility_nav`, so additional markup can be added by child themes.

## 2.1.11

- Bugfix: Fixed buttons inside of widgets to have white text

## 2.1.10

-	Update WordPress version in Travis tests to our current install version 4.9.7
-	Update Unit Tests for `test_responsive_is_bu_domain_true()` to work with single
	or multi-site installations.
-	Update deprecated Gravity Form call `GFForms::setup()`
-	NPM Packages removed grunt-bowercopy.
-	NPM Packages updated grunt-contrib-watch, grunt-modernizr, & lightgallery.
-	Remove Ruby Sass gem.

## 2.1.9

- Bugfix: Prevented empty post title from rendering in `responsive_the_title()`
  template tag.
- Bugfix: Fixed typo in name of filter used to visually hide home page title.
  Was `responsive_the_title_classes` and is now `responsive_the_title_class`.
- Merged commits from responsive-framework-1x/develop to backfill history of
  project. Cleaned the history of protected branding assets.

## 2.1.8

- Added new template tag, `responsive_the_title()`, intended to output the page
  title for each single post/page template.
- Added new filter to the new `responsive_the_title()` template_tag, named
  `responsive_filter_the_title` which can be used to modify/prevent the output
  of page titles in responsive-framework.
- Added new functions partial `/inc/bu-banners.php` to provide additional
  support features for bu-banners plugin. Currently adds the h1 page title to
  banner if exists and title field is empty, and suppresses the
  responsive-framework page title. to use an h1 element with the current page
  title if the banner title is left empty.

## 2.1.7

- Add "Eiffel" and "Comm Ave" color themes to customizer.

## 2.1.6

- Fixes count of widgets on alternative footbar.

## 2.1.5

- Refactored `page-templates/calendar.php` for easier child-theming by
  separating logic into functions that now live in the existing
  `/inc/calendar.php` functions file, and moving templating chunks into
  `template-parts/calendar/calendar.php` and
  `template-parts/calendar/single-event.php`.
- Added new filter for calendar template for changing hardcoded labels on the
  `template-parts/calendar/single-event.php` partial, named
  `responsive_calendar_event_labels`.
- Resolved fatal error in single-site installs by replacing `get_current_site`
  with `network_home_url` in the `responsive_is_bu_domain` function defined in
  `inc/template-tags.php:33`.

## 2.1.4

- Adds skip link support.
- Color contrast accessibility fixes to comply with MWAS
- Added skip-link feature for keyboard navigation

## 2.1.3

- Added `responsive_is_wpdocs()`, to check for the wpdocs subdomain.
- Added BU Hub Indicator. Incorporated adjustments to line height.

## 2.1.2

- Move 2.1.2 to a new repo for a fresh start in prepartion to begin the open
  source process.

## 2.0.0

- Added CONTRIBUTING.md file for contribution rules.
- Removed use of `file_get_contents()` in the Customizer.
- Responsive Framework "header" templates are now renamed to "masthead"
  templates to avoid confusion with WordPress core's header template
  functionality.
- Page templates have been updated to be more simple. A template part should be
  a repeatable chunk that can be used within the loop. All logic determining
  what should show, how, or where, should be contained in the page template.
- For most post types, single templates only display content in one way. For
  that reason, single templates should not use `get_template_part()` unless more
  than one display variations actually exist.
- Updated profile, news, and page templates to use the above thought process.
- `responsive_post_lists_show_news_meta()` no longer requires a settings array
  to be passed when called. By default, it will utilize the settings selected on
  the news page. An array of settings different form those selected can still be
  passed.
- Introduce several action hooks to make it easier for child themes to inject
  markup without having to copy the entire template file. Hooks introduced:
  - `r_after_opening_body_tag`
  - `r_before_opening_wrapper`
  - `r_after_opening_wrapper`
  - `r_before_opening_container_outer`
  - `r_after_opening_container_outer`
  - `r_before_opening_container_inner`
  - `r_after_opening_container_inner`
  - `r_before_masthead`
  - `r_after_masthead`
  - `r_before_closing_container_inner`
  - `r_after_closing_container_inner`
  - `r_before_closing_container_outer`
  - `r_after_closing_container_outer`
  - `r_before_closing_wrapper`
  - `r_after_closing_wrapper`
  - `r_before_branding_masterplate`
  - `r_after_branding_masterplate`
  - `r_before_bumc_branding_logo`
  - `r_after_bumc_branding_logo`
  - `r_before_branding_disclaimer`
  - `r_after_branding_disclaimer`
  - ~~`r_before_content_banner_{position}`~~
  - ~~`r_before_content_banner`~~
  - ~~`r_after_content_banner_{position}`~~
  - ~~`r_after_content_banner`~~
- ~~Added `r_content_banner_args` filter for modifying generated content banner
  arguments.~~
- ~~Added `r_content_banner_output` filter for modifying content banner output.
  This was previously `responsive_content_banner_output`.~~
- Add `branding.php` template part so child themes can override the default
  branding markup by calling `remove_theme_support( 'bu-branding' )`.
- Add `r_script_in_footer` filter for changing the loading location of the
  theme's JavaScript file.
- Add `r_enqueue_modernizr` filter for preventing Modernizr from being enqueued.
  Child themes and plugins can use this to load their own build of Modernizr.
- Add video autoplay to the list of Modernizr checks.
- Introduce `r_get_template_part()`. Adds the ability to theme a specific post
  type's display in archive contexts within a child theme without having to
  change the `archive.php` template that serves as the default for all archive
  pages. For more details see
  [102e38a](https://github.com/bu-ist/responsive-framework/pull/153/commits/102e38aa79a6d42bd782d5d4be5c1d3f20fc5b83).
- Introduce `r_get_archive_sidebar()`. Adds the ability to theme sidebars for
  specific archive contexts without having to change the `archive.php` template
  in a child theme. For more details see
  [55f3602](https://github.com/bu-ist/responsive-framework/pull/153/commits/55f3602dc496439d414f28a24b72dd6e19edec99).
- Update `responsive_term_links()` to act as a wrapper of `get_the_term_list()`
  to solve several issues. See
  [#185](https://github.com/bu-ist/responsive-framework/issues/185).
- Set up unit testing with Travis CI with an initial test suite. These should be
  updated and maintained with every pull request.
- Set up Code Climate test coverage reporting.
- Make sure `post_class()` is used for every container of every post, regardless
  of post type.
- Comment message field is now marked required. The browser will now notify the
  commenter when they try to submit the form if the field is empty.
- Ensure `role="main"` is used properly and adheres to the proper accessibility
  standards.
- Add HTML5 required attributes to comment form elements and require comments.
- Fixes a longstanding issue with the left navigation layout where pages with
  little to no content would cut off the navigation.
- Remove unnecessary gravatars markup.
- Clarifies the use of Footer Additional Information in the Customizer.
- Adds a new class, `content-area`, for styling what was formerly
  `article[role=main]`.
- Moves `profiles.php` to the root of the theme directory from `/page-templates`
  to allow users to select which profile format to use on the profiles template.
- Introduce `r_container_inner_class()` for displaying the class attribute for
  the inner content container element. Classes are filterable through the
  `r_container_inner_class` filter.
- Introduce `r_container_outer_class()` for displaying the class attribute for
  the outer content container element. Classes are filterable through the
  `r_container_outer_class` filter.
- Fetch the `.mdlrc` and `markdown.rb` files from the [coding standards
  repository](https://github.com/bu-ist/coding-standards/tree/master).
- Restructured HTML and added CSS classes in the footer for cleaner branding
  styles.
- Add extra classes to `post_class()` based on template part and template type.
- Introduces unique classes to output HTML based on content type and scope of
  styles. For example, a title on the new calendar widget classes using the
  graphic format will have both `.widget-calendar-title` and
  `.widget-calendar-title-graphic`, which makes it clearer exactly which content
  is affected when overriding a class.
- Smarter use of CSS inheritance in the fonts and color palette CSS generated
  byline Customizer.
- Introduces a class for the first calendar event at a time in a long list of
  times.
- Cleans up unnecessary wrapper HTML from Flexi Framework.
- Major improvements to the default course feeds template, which now link to
  building location, show course instructors, fix the broken course type and
  display as a whole word instead of an abbreviation, display semester
  availability, display prerequisites for the course, and removes the cryptic
  course ID in favor of a clearer display of section ID, semester, and year.
- Adds unique callbacks for calendar widget formats and updates tags to HTML5.
- Adds a lightbox for galleries automatically.
- Add a page template dropdown filter to the top of the page admin screen.
- Switches `content-container` class to a plain div inside of `main`, which
  enables you to use this class as many times as you need to, such as in a
  landing page.
- UI improvements: "Layout" is now called "Navigation Style" in Customizer to
  avoid future conflicts with a potential layout builder and clarify
  functionality.
- Underscores are no longer stripped from classes in HTML.
- Title attributes have been removed from anchor tags to promote accessibility.
- Upgrade Modernizr and add new tests: sticky, video autoplay.
- Deactivate the BU Mobile plugin when the theme is activated.
- Introduce pull request and issue templates.
- Add `<picture>` element support detection to Modernizr.
- Prepare the theme for localization using internationalization best practices.
- Remove `bu_search_form_query_attributes` filter function. This is now the
  default behavior in BU-CMS.
- Remove Content Banner support.
- Add Grunt time reporting.
- Rename `content-none.php` to `no-content.php`.

## 1.5.6

- Remove empty IE conditional at the beginning of `header.php`
  ([#272](https://github.com/bu-ist/responsive-framework/issues/272)).
- Ensure the correct default value is returned for
  `BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM`
  ([#268](https://github.com/bu-ist/responsive-framework/pull/268)).

## 1.5.5

- Fix bug where nav toggle icon was not receiving the correct color (#251).

## 1.5.4

- Enables pinch to zoom for accessibility on mobile.
- Fixes a bug where BUMC branding styles do not apply correctly.
- Add `right` default to `burf_setting_sidebar_location` option.

## 1.5.3

- Move the body `id` declaration in front of `class`.

## 1.5.2

- Fix `responsive_maybe_hide_homepage_h1()` to accept the second parameter for
  `the_title` filter.
- Introduce the `r_script_dependencies` filter. Used to filter script
  dependencies for child theme script files.

## 1.4.3

- Fix for BUniverse embeds/shortcode to support HTTPS.

## 1.4.2

- Updating to newest tag (1.3.2) of Responsive Foundation

## 1.4.1

- Updating to newest tag (1.3.0) of Responsive Foundation

## 1.4.0

- Calendar api update: enabling monthly dropdown menu & topic heading text
- Search form & search form accessibility improvements
- Branding updates
- Customizer Layout & Fonts bug fix (#43)

## 1.3.5

- Fixing post display options array
  [Commit](https://github.com/bu-ist/responsive-framework/commit/dd72447ea1e54b5ee7ba572a00b82d4c1691321e)
- Update to [Responsive Foundation
  1.2.1](https://github.com/bu-ist/responsive-foundation/releases/tag/1.2.1)

## 1.3.4-beta

- Create new gravity forms contact forms only when necessary.
  - They should be generated only when current site has contact forms using
    the Contact Us plugin.
  - Previous bug: gravity forms were generated for sites without contact
    forms. And if the theme got activated multiple times, more gravity forms
    were generated each time.

## 1.3.3-beta

- Updating to Responsive Foundation 1.2.0 (Bunnies)

## 1.3.2-beta

- Add filter to responsive_content_banner to manipulate output on theme level

## 1.3.1-beta

- Add `no-access.php` and no-access-bumc.php` template files to framework for
  Audience plugin on bumc.bu.edu

## 1.3.0-beta

- Responsi-as-a-Service beta release
- Enable Customizer font palettes for non-child themes
- Enable Customizer color palettes for non-child themes
- Add Customizer display options for toggling visibility of post meta fields
- Add Customizer sidebar options for toggling usage of alternate footbars
- Update footer branding styles to support BUMC logo, disclaimer link
- Update site initialization / automated Flexi migration logic

## 1.2.2

- Add fallback for branding

## 1.2.1

- Change empty value for calendar event time from '&nbsp;' to ''
- Add site initialization and Flexi migration logic (dormant pending release of
  Site Manager 4.0.0)
- Fix #30: Don't display search icon when search is disabled
- Fix #32: Don't override threaded comment depth set via Settings > Discussion
- Fix #19: Update social media icons to add alternate icons, fix issues with
  Flickr / Vine and Google+. See
  [a304709](https://github.com/bu-ist/responsive-foundation/commit/a30470947bc5bf05533e183e31f2060dd89d99c2).
- Fix typo with archive button.

## 1.2.0

- Add support for BU Branding plugin
- Add template tags for display of BUMC logo and disclaimer
- Add support for BU Sharing plugin
- Introduce `responsive_share_tools()` for share tools display
- Ensure Customizer is accessible to non-super admin
- Remove shims for BU Profiles / Content Banner template tags that have been
  integrated into plugins
- Add hooks to upgrade function to support pending migration of Research theme

## 1.1.0

- Add basic BUniverse embed provider
- Archive template now utilizes profile template parts for profile-specific
  taxonomy archives (#22)
- Profile shortcode templates now utilize template partials
- Navigation template tags now support customizable labels and screen reader
  text (#23)
- Navigation template tags are now post type-agnostic
- Fix posts navigation button placement (they were reversed)
- Fix #18: Empty <p> tags when no post meta exists for News template
- Fix #21: Use correct class attribute for `[buniverse]` shortcode
- Introduce `responsive_archive_type()` and `responsive_queried_post_types()`
  helpers (#22)
- Deprecate `responsive_paging_nav()` in favor of
  `responsive_posts_navigation()`
- Deprecate `responsive_post_nav()` in favor of `responsive_post_navigation()`

## 1.0.3

- Update to [Responsive Foundation
  1.0.3](https://github.com/bu-ist/responsive-foundation/releases/tag/1.0.3)

## 1.0.2

- Add href to BU masterplate

## 1.0.1

- Add shortcode parsing for core text widgets
- Fix footbar position in sideNav layout
- Refactored header markup

## 1.0.0

- Deemed stable for child theme development

## 0.9.1

- Pre-release version of Responsi.
- Child themes based on 0.9.1 include: r-cfa, r-hr, r-pardeeschool, r-research,
  and r-school.
