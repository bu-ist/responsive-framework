# Changelog

## Unreleased

* Added CONTRIBUTING.md file for contribution rules.
* Removed use of `file_get_contents()` in the Customizer.
* Responsive Framework "header" templates are now renamed to "masthead"
 templates to avoid confusion with WordPress core's header template
 functionality.
* Page templates have been updated to be more simple. A template part should be
 a repeatable chunk that can be used within the loop. All logic determining
 what should show, how, or where, should be contained in the page template.
* For most post types, single templates only display content in one way. For
 that reason, single templates should not use `get_template_part()` unless more
 than one display variations actually exist.
* Updated profile, news, and page templates to use the above thought process.
* `responsive_post_lists_show_news_meta()` no longer requires a settings array
 to be passed when called. By default, it will utilize the settings selected on
 the news page. An array of settings different form those selected can still be
 passed.
* Introduce several action hooks to make it easier for child themes to inject
 markup without having to copy the entire template file. Hooks introduced:
  * `r_before_closing_content_container`
  * `r_after_closing_content_container`
  * `r_before_closing_content`
  * `r_after_closing_content`
  * `r_after_closing_content`
  * `r_after_opening_body_tag`
  * `r_before_masthead`
  * `r_after_masthead`
  * `r_before_opening_content`
  * `r_after_opening_content`
  * `r_before_opening_content_container`
  * `r_after_opening_content_container`
  * `r_before_branding_masterplate`
  * `r_after_branding_masterplate`
  * `r_before_bumc_branding_logo`
  * `r_after_bumc_branding_logo`
  * `r_before_branding_disclaimer`
  * `r_after_branding_disclaimer`
  * `r_before_content_banner_{position}`
  * `r_before_content_banner`
  * `r_after_content_banner_{position}`
  * `r_after_content_banner`
* Added `r_content_banner_args` filter for modifying generated content banner
 arguments.
* Added `r_content_banner_output` filter for modifying content banner output.
 This was previously `responsive_content_banner_output`.
* Add `branding.php` template part so child themes can override the default
 branding markup by calling `remove_theme_support( 'bu-branding' )`.
* Add `r_script_location` filter for changing the loading location of the
 theme's JavaScript file.
* Add `r_enqueue_modernizr` filter for preventing Modernizr from being
 enqueued. Child themes and plugins can use this to load their own build of
 Modernizr.
* Add video autoplay to the list of Modernizr checks.
* Introduce `r_get_template_part()`. Adds the ability to theme a specific post
 type's display in archive contexts within a child theme without having to
 change the `archive.php` template that serves as the default for all archive
 pages. For more details see [102e38a](https://github.com/bu-ist/responsive-framework/pull/153/commits/102e38aa79a6d42bd782d5d4be5c1d3f20fc5b83).
* Introduce `r_get_archive_sidebar()`. Adds the ability to theme sidebars for
 specific archive contexts without having to change the `archive.php` template
 in a child theme. For more details see [55f3602](https://github.com/bu-ist/responsive-framework/pull/153/commits/55f3602dc496439d414f28a24b72dd6e19edec99).
* Update `responsive_term_links()` to act as a wrapper of `get_the_term_list()`
 to solve several issues. See [#185](https://github.com/bu-ist/responsive-framework/issues/185).
* Set up unit testing with Travis CI with an initial test suite. These should be
 updated and maintained with every pull request.
* Set up Code Climate test coverage reporting.
* Make sure `post_class()` is used for every container of every post,
 regardless of post type.
* Comment message field is now marked required. The browser will now notify the
 commenter when they try to submit the form if the field is empty.
* Ensure `role="main"` is used properly and adheres to the proper accessibility
 standards.
* Add HTML5 required attributes to comment form elements and require comments.
* Fixes a longstanding issue with the left navigation layout where pages with
 little to no content would cut off the navigation.
* Remove unnecessary gravatars markup.
* Clarifies the use of Footer Additional Information in the Customizer.
* Adds a new class, `content-area`, for styling what was formerly
 `article[role=main]`.
* Moves `profiles.php` to the root of the theme directory from `/page-templates`
 to allow users to select which profile format to use on the profiles template.
* Introduce `r_content_container_class()` for displaying the class attribute
 for the content container element. Classes are filterable through the
 `r_content_container_class` filter.
* Restructured HTML and added CSS classes in the footer for cleaner branding
 styles.
* Add extra classes to `post_class()` based on template part and template type.
* Introduces unique classes to output HTML based on content type and scope of
 styles. For example, a title on the new calendar widget classes using the graphic
 format will have both `.widget-calendar-title` and `.widget-calendar-title-graphic`,
 which makes it clearer exactly which content is affected when overriding a class.
* Smarter use of CSS inheritance in the fonts and color palette CSS generated byline
 Customizer.
* Introduces a class for the first calendar event at a time in a long list of times.
* Cleans up unnecessary wrapper HTML from Flexi Framework.
* Major improvements to the default course feeds template, which now link to
 building location, show course instructors, fix the broken course type and display
 as a whole word instead of an abbreviation, display semester availability,
 display prerequisites for the course, and removes the cryptic course ID in favor
 of a clearer display of section ID, semester, and year.
* Adds unique callbacks for calendar widget formats and updates tags to HTML5.

## 1.5.3

* Move the body `id` declaration in front of `class`.

## 1.5.2

* Fix `responsive_maybe_hide_homepage_h1()` to accept the second parameter for
 `the_title` filter.
* Introduce the `r_script_dependencies` filter. Used to filter script
 dependencies for child theme script files.

## 1.4.3

* Fix for BUniverse embeds/shortcode to support HTTPS.

## 1.4.2

* Updating to newest tag (1.3.2) of Responsive Foundation

## 1.4.1

* Updating to newest tag (1.3.0) of Responsive Foundation

## 1.4.0

* Calendar api update: enabling monthly dropdown menu & topic heading text
* Search form & search form accessibility improvements
* Branding updates
* Customizer Layout & Fonts bug fix (#43)

## 1.3.5

* Fixing post display options array [Commit](https://github.com/bu-ist/responsive-framework/commit/dd72447ea1e54b5ee7ba572a00b82d4c1691321e)
* Update to [Responsive Foundation 1.2.1](https://github.com/bu-ist/responsive-foundation/releases/tag/1.2.1)

## 1.3.4-beta

* Create new gravity forms contact forms only when necessary.
  * They should be generated only when current site has contact forms using the
   Contact Us plugin.
  * Previous bug: gravity forms were generated for sites without contact forms.
   And if the theme got activated multiple times, more gravity forms were
   generated each time.

## 1.3.3-beta

* Updating to Responsive Foundation 1.2.0 (Bunnies)

## 1.3.2-beta

* Add filter to responsive_content_banner to manipulate output on theme level

## 1.3.1-beta

* Add `no-access.php` and no-access-bumc.php` template files to framework for
 Audience plugin on bumc.bu.edu

## 1.3.0-beta

* Responsi-as-a-Service beta release
* Enable Customizer font palettes for non-child themes
* Enable Customizer color palettes for non-child themes
* Add Customizer display options for toggling visibility of post meta fields
* Add Customizer sidebar options for toggling usage of alternate footbars
* Update footer branding styles to support BUMC logo, disclaimer link
* Update site initialization / automated Flexi migration logic

## 1.2.2

* Add fallback for branding

## 1.2.1

* Change empty value for calendar event time from '&nbsp;' to ''
* Add site initialization and Flexi migration logic (dormant pending release of
 Site Manager 4.0.0)
* Fix #30: Don't display search icon when search is disabled
* Fix #32: Don't override threaded comment depth set via Settings > Discussion
* Fix #19: Update social media icons to add alternate icons, fix issues with
 Flickr / Vine and Google+. See [a304709](https://github.com/bu-ist/responsive-foundation/commit/a30470947bc5bf05533e183e31f2060dd89d99c2).
* Fix typo with archive button.

## 1.2.0

* Add support for BU Branding plugin
* Add template tags for display of BUMC logo and disclaimer
* Add support for BU Sharing plugin
* Introduce `responsive_share_tools()` for share tools display
* Ensure Customizer is accessible to non-super admin
* Remove shims for BU Profiles / Content Banner template tags that have been
 integrated into plugins
* Add hooks to upgrade function to support pending migration of Research theme

## 1.1.0

* Add basic BUniverse embed provider
* Archive template now utilizes profile template parts for profile-specific
 taxonomy archives (#22)
* Profile shortcode templates now utilize template partials
* Navigation template tags now support customizable labels and screen reader
 text (#23)
* Navigation template tags are now post type-agnostic
* Fix posts navigation button placement (they were reversed)
* Fix #18: Empty <p> tags when no post meta exists for News template
* Fix #21: Use correct class attribute for `[buniverse]` shortcode
* Introduce `responsive_archive_type()` and `responsive_queried_post_types()`
 helpers (#22)
* Deprecate `responsive_paging_nav()` in favor of
 `responsive_posts_navigation()`
* Deprecate `responsive_post_nav()` in favor of `responsive_post_navigation()`

## 1.0.3

* Update to [Responsive Foundation 1.0.3](https://github.com/bu-ist/responsive-foundation/releases/tag/1.0.3)

## 1.0.2

* Add href to BU masterplate

## 1.0.1

* Add shortcode parsing for core text widgets
* Fix footbar position in sideNav layout
* Refactored header markup

## 1.0.0

* Deemed stable for child theme development

## 0.9.1

* Pre-release version of Responsi.
* Child themes based on 0.9.1 include: r-cfa, r-hr, r-pardeeschool, r-research,
 and r-school.
