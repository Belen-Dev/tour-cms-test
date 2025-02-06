<?php

include_once 'TourCMS.php';
use TourCMS\Utils\TourCMS as TourCMS;

class CachedTourCMS {

	// General settings
	protected $marketp_id = 0;
	protected $private_key = "";
	protected $result_type = "";

	// Cache settings
	public $cache_dir = 'cache';
	public $cache_rules = array(
		"search_tours" => array("time" => 1800),
		"show_tour" => array("time" => 3600),
		"show_tour_datesanddeals" => array("time" => 900),
		"list_channels" => array("time" => 3600),
		"show_channel" => array("time" => 3600),
		"show_supplier" => array("time" => 3600)
	);

	// TourCMS object
	protected $tourcms;

	/**
	 * __construct
	 *
	 * @author Paul Slugocki
	 * @param $mp Marketplace ID
	 * @param $k API Private Key
	 * @param $res Result type, defaults to raw
	 * @param $cache_rules
	 */
	public function __construct($mp, $k, $res = "raw", $cache_rules = null) {
		$this->marketp_id = $mp;
		$this->private_key = $k;
		$this->result_type = $res;

		if($cache_rules != null)
			$this->cache_rules = $cache_rules;

    $this->tourcms = new TourCMS($mp, $k, $res);
	}

	// Overload function
	public function __call($name, $arguments) {

		// Request is cachable if we have settings for this method
		$cachable_request = array_key_exists($name, $this->cache_rules);

		// If request is cachable, try loading
		if($cachable_request) {

			$cached_content = $this->get_cache($name, $arguments);

			if($cached_content != "") {

				if($this->result_type == "simplexml")
					return simplexml_load_string($cached_content);
				else
					return $cached_content;

			}

		}

		// No cache, outdated cache or uncacheable request
		// Call TourCMS object to get response
    $response = call_user_func_array(array($this->tourcms, $name), $arguments);

		// Set cache
		if($cachable_request) {

			$this->set_cache($name, $arguments, $response);

		}

		// Return
		return $response;
  }

	// Get the cache for a given API query
	private function get_cache($name, $arguments) {

		$filename = $this->get_filename($name, $arguments);

		// Check the file exists
		if(file_exists($filename)) {

			// Check it's not outdated
			$file_time = filemtime($filename);
			$cache_time = $this->cache_rules[$name]["time"];

			$file_outdated = $file_time + $cache_time < time();

			if(!$file_outdated) {
				return file_get_contents($filename);
			}
		}

		// If we got this far, just return an empty cache
		return '';
	}

	// Set the cache for a given API query
	private function set_cache($name, $arguments, $data) {

		// If data is empty, return
		if($data == '')
			return;

		$filename = $this->get_filename($name, $arguments);

		// Create the method specific directory if it doesn't already exist
		if(!is_dir($this->cache_dir . DIRECTORY_SEPARATOR . $name))
			mkdir($this->cache_dir . DIRECTORY_SEPARATOR . $name);

		// Make sure we have SimpleXML so we can check for errors
		if($this->result_type != "simplexml")
			$data = simplexml_load_string($data);

		// As long as there's no errors, store the cache
		if($data->error == "OK") {
			$data = $data->asXml();
			file_put_contents($filename, $data);
		}

	}

	// Returns the full path to the cache file
	private function get_filename($name, $arguments) {
		return $this->cache_dir . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . $this->array_to_filename($arguments) . ".xml";
	}

	// Convert an array into a filename
	private function array_to_filename($arr) {
		return base64_encode(serialize($arr));
	}

}
?>