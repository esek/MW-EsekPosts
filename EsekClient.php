<?php

const USER_QUERY = "
	query userPosts(\$username:String!) {
		user(username:\$username) {
			postHistory {
				post {
					id
					postname
				}
				start
				end
			}
		}
	}
";

class EsekClient
{

	private $URL;
	private $API_KEY;

	function __construct()
	{
		global $wgEsek;

		$this->URL = $wgEsek['ekorre_url'];
		$this->API_KEY = $wgEsek['ekorre_api_key'];
	}

	/**
	 * Makes a graphql request to the api server
	 */
	private function _makeRequest(string $query, array $variables)
	{
		$url = $this->URL;

		$headers = [
			'X-E-Api-Key: ' . $this->API_KEY,
			'Content-Type: application/json',
		];

		$data = [
			'query' => $query,
			'variables' => $variables,
		];

		$data = json_encode($data);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);
		$response = json_decode($response, true);

		return $response;
	}

	public function getPostsForUser(string $username)
	{
		$query = USER_QUERY;

		$variables = [
			'username' => $username,
		];

		try {
			$response = $this->_makeRequest($query, $variables);
			$history = $response['data']['user']['postHistory'];

			echo $history;

			return array_map(function ($post) {
				return [
					'id' => $post['post']['id'],
					'name' => $post['post']['postname'],
					'start' => $post['start'],
					'end' => $post['end'],
				];
			}, $history);
		} catch (Exception $e) {
			return [];
		}
	}
}
