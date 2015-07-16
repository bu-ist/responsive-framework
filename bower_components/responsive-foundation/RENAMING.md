# Responsive Foundation SCSS Renaming/Restructuring Log

Based on newly defined coding standards established in October 2014 by the BU Webteam, Responsive Foundation files have changed. Changes include restructuring, reformatting, recommenting, and renaming of SCSS partials and some JavaScript.

## SCSS Renaming Map

### Grayscale color variables

* $black --> $grayScale-0
* $gray_darkest --> $grayScale-1
* $gray_darker --> $grayScale-2
* $gray_dark --> $grayScale-3
* $gray_light --> $grayScale-7
* $gray_lighter --> $grayScale-9
* $white --> $grayScale-f

### Breakpoint variables

* $container_S: --> $container-S
* $container_M: --> $container-M
* $container_L: --> $container-L

### Class and ID Names

* #page_wrapper --> .wrapper
* #utility --> .utilityNav
* #right-content-area --> .sidebar
* #bottom-content-area --> .footbar
* .responsive-video --> .responsiveVideo
* .banner-container --> .bannerContainer
* .window-width --> .bannerContainer-windowWidth (check child themes, like research, for content banner changes)
* .page-width --> .bannerContainer-pageWidth
* .content-width --> .bannerContainer-contentWidth
* .open --> .is-open
* .navopen --> .nav-open (also changed in toggle.js, and needs to be adjusted in cfa theme)

#### Remanimg. Again.

* #nav --> .primaryNav-menu --> .primaryNav-menu-menu
* .mainNav --> .navContainer --> .primaryNav
* .contentWrapper --> .content
	* .container --> .content-container
* .footbar .container --> .footbar .footbar-container

## Additions

* z-index scale in _variables.scss
* sidebar widget border colors, sidebar widget background colors, page grid border colors, page grid background colors, footbar widget border colors in _variables.scss



## Restructuring

* header.php: added <div class="wrapper">, <div class="contentWrapper"> before bu_content_banner function (line 113, 114)
* footer-no-sidebar.php, footer.php: added </div><!-- .contentWrapper -->, </div><!-- .wrapper --> after <?php wp_footer(); ?>
* separated navigation styles in to their own partial: _navigation.scss (in burf-theme)

### Grid variables

* $grid-rowMargin
* $grid-columnPadding

## TODO

* Remove any instance of generic grid classes from template markup, e.g. `.col-md-8` and instead use `@extend`
* Create global typography styles that work for all content, including widgets, without specifically having to target `<article>`. Overrides should be applied to all other areas, e.g. the `primaryNav-menu`. 
* rgba colors are not consistently using mixin or don't have have solid fallback (e.g. in `.footbar`)




