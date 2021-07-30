<?php
/**
 * A Google Site Search Results provider.
 */
class GSS_Provider{

    public $query;
    public $page_current;
    public $page_count;
    public $results;
    public $site;
    public $results_per_page = 10;

    function __construct(){
        $this->query = $_GET['q'];
        $this->page_current = $_GET['pg'];
        if(!$this->page_current)
            $this->page_current = 1;
        $this->site = get_site_url();
    }

    private function get_wp_search_url($query, $page){
        if(!$query) $query = $this->query;
        if(!$page) $page = $this->page_current;
        return sprintf ( "%s?q=%s&pg=%s", get_search_link(), $query, $page );
    }

    /**
     * Fetches and set's the instance's search results.
     * @return bool     true if fetch was successful. False otherwise.
     */
    public function get_results(){
        $query = urlencode($this->query);
        //$site = urlencode($this->site);
        $site = urlencode('https://www.bu.edu/researchsupport/');
        $result_start_idx = (($this->page_current-1) * $this->results_per_page) + 1; //if results_per_page = 10, page 1 starts with result 1, page 2 starts with result 11;
        $results_per_page = $this->results_per_page;
        /*
        	Note: the API key below is restricted to cms-devl sites only. It's not for production use.
        	Use your own key during development.
        	Also, the site needs to be manually set, because cms-devl isn't indexed by Google.
        	This is why I have the site hardcoded to Research Support above.
        	Parameters available here: https://developers.google.com/custom-search/v1/reference/rest/v1/cse/list
        	Possibilities: search by file type (&fileType=pdf), date range
        	Sort by date, name, in either order
        	Potentially filter by post type or other metadata, if we add structured markup: https://developers.google.com/custom-search/docs/structured_data#addtopage
        	The idea being that maybe we add a custom attribute, such as post type
        	If we're making multiple calls, we may also be able to grab stuff from the Brink, or ask
        	IS&T if they can set up a custom search engine just for Research sites.
        	Maybe even BU Editorial and non-BU editorial sites, excluding the main sites
        */
        $remote_url = "https://www.googleapis.com/customsearch/v1?key= AIzaSyDt_PqhExEUcDS3Tbr5z4ZOFPt8fcBn6IA&cx=008004593239734442268:smkjprqoaic&siteSearchFilter=i&siteSearch=".$site."&q=".$query.'&num='.$results_per_page.'&start='.$result_start_idx;
        $args = array(
            'timeout'     => 5,
            'redirection' => 5,
            'httpversion' => '1.0',
            'user-agent'  => 'WordPress/' . $wp_version . '; ' . home_url(),
            'blocking'    => true,
            'cookies'     => array(),
            'body'        => null,
            'compress'    => false,
            'decompress'  => true,
            'sslverify'   => true,
            'stream'      => false,
            'filename'    => null
        ); 
        $response = wp_remote_get($remote_url, $args);
        if(is_wp_error($response) || $response['response']['code'] !== 200){
            return false;
        }
        $this->results = json_decode($response['body']);
        $this->page_count = ceil ( $this->results->queries->request[0]->totalResults / $this->results_per_page ) ;
        return true;
    }

    /**
     * return true if fetched results have a next page.
     * @return boolean true is results have a next page, false otherwise.
     */
    public function have_next_search_page(){
        return $this->page_current < $this->page_count;
    }
    /**
     * Return the url of the next page for the current search query.
     * @return string the url
     */
    public function next_page_search_url(){
        return $this->get_wp_search_url($this->query, $this->page_current+1);
    }
    /**
     * Return true if there's a page before the current one in the pager.
     * @return boolean true if current_page > 1
     */
    public function have_prev_search_page(){
        return $this->page_current > 1;
    }
    /**
     * Fetch the pagenator's previous page.
     * @return String String url of the previous pagenator's page
     */
    public function prev_page_search_url(){
        return $this->get_wp_search_url($this->query, $this->page_current-1);
    }
    /**
     * page specific search url
     * @param  int $page the requesting page number
     * @return string       url of the page for the current search query.
     */
    public function page_search_url($page){
        return $this->get_wp_search_url($this->query, $page);
    }
}
