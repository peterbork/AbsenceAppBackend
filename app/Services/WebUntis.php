<?php
namespace App\Services;

use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: Bork
 * Date: 25-11-2017
 * Time: 23:27
 */

class WebUntis {
	protected $url;
	protected $key;

	public function __construct() {
		$this->url = "https://api.webuntis.dk/api/";
		$this->key = env('WEBUNTIS_KEY');
	}

	public function request($method, $url, $options = []) {
		$client = new Client([
			'base_uri' => $this->url,
			'headers' => [
				"x-api-key" => $this->key,
				"Accept-Encoding" => "gzip, deflate"
			]
		]);

		return json_decode($client->request($method, $url, $options)->getBody());
	}
}