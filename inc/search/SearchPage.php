<?php

/**
 * This class handles the logic used in searchpage.php
 */
require_once 'providers/GSS_Provider.php';
class SearchPage {

	public $provider;

	function __construct( $site_url ) {
		if ( ! $site_url ) {
			$site_url = get_site_url();
		}
		$this->provider       = new GSS_Provider();
		$this->provider->site = $site_url;
		$got_results          = $this->provider->get_results();
	}

	/**
	 * Render a result item
	 *
	 * @param  Object  $item Search result item returned by Google Site Search
	 * @param  boolean $echo True if results should be echo'ed
	 * @return String        the result item
	 */
	function render_item( $item, $echo = false ) {
		$mime           = empty( $item->mime ) ? '' : '[' . $item->mime . ']';
		$render_string  = '<h3><a href="' . $item->link . '">' . $item->htmlTitle . '</a>&nbsp;<span class="mime">' . $mime . '</span></h3>';
		$render_string .= '<p>' . $item->htmlSnippet . '</p>';
		$render_string .= '<cite>' . $item->link . '</cite>';
		apply_filters( 'search_results_item', $render_string, $item );
		if ( $echo ) {
			echo $render_string;
		}
		return $render_string;
	}

	/**
	 * Get the pager for the current page.
	 *
	 * @param  boolean $echo True if results should be echo'ed.
	 * @return string        results for the current page.
	 */
	function render_pager( $echo = false, $container_class = 'search-pagenator', $current_page_class = 'current' ) {

		$pages = '';
		if ( $this->provider->have_prev_search_page() ) {
			$prev_page = sprintf( '<a href="%s">prev</a>', $this->provider->prev_page_search_url() );
			$pages    .= apply_filters( 'search_results_previous_page', $prev_page, $this->provider->prev_page_search_url() );
		}

		// max 10 pages of results.
		$num_pages_results = ceil( $this->provider->page_count / $this->provider->results_per_page );
		$last_page         = min( 10, $num_pages_results );
		for ( $i = 1; $i <= $last_page; $i++ ) {
			$pager = sprintf( '<a class="page" href="%s">%s</a>', $this->provider->page_search_url( $i ), $i );
			if ( $i == $this->provider->page_current ) {
				$pager = sprintf( '<a class="page current" href="%s">%s</a>', $this->provider->page_search_url( $i ), $i );
			}
			$options = array( $this->provider->page_search_url( $i ), $i, $this->provider->page_current );
			$pages  .= apply_filters( 'search_results_page', $pager, $options );
		}

		if ( $this->provider->have_next_search_page() && $this->provider->page_current < $last_page ) {
			$next_pager = sprintf( '<a href="%s">next</a>', $this->provider->next_page_search_url() );
			$pages     .= apply_filters( 'search_results_next_page', $next_pager, $this->provider->next_page_search_url() );
		}
		$pager = sprintf( '<div class="%s">%s</div>', $class, $pages );
		$pager = apply_filters( 'search_results_pager', $pager, $pages );
		if ( $echo ) {
			echo $pager;
		}
		return $pager;
	}
}
