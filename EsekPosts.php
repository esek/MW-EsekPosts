<?php

require_once(__DIR__ . '/EsekClient.php');

class EsekPosts
{
	const TAG_NAME = 'Posts';

	// gets run on the `ParserFirstCallInit` hook
	public static function onParserFirstCallInit(Parser $parser)
	{
		// When the parser sees the <Posts> tag, it executes renderPosts
		$parser->setHook(self::TAG_NAME, [self::class, 'renderPosts']);
	}

	public static function renderPosts($input, array $args, Parser $parser, PPFrame $frame)
	{
		// if no STIL-ID, don't return anything
		if (empty($input)) {
			return '';
		}

		$username = htmlspecialchars($input);

		$postsTable = self::fetchPosts($username);

		return $postsTable;

		// return "<p>Denna funktionalitet har flyttat <a href=\"https://esek.se/member/@$username\" target=\"_blank\">hit!</a></p>";
	}

	private static function fetchPosts(string $username)
	{
		$client = new EsekClient();
		$posts = $client->getPostsForUser($username);

		echo $posts;

		$table = self::createTableFromPosts($posts);

		return $table;
	}

	private static function createTableFromPosts(array $posts)
	{
		$table = "<table class=\"wikitable\">";
		$table .= "<tr>";
		$table .= "<th>Postnamn</th>";
		$table .= "<th>Start</th>";
		$table .= "<th>Slut</th>";
		$table .= "</tr>";

		foreach ($posts as $post) {
			$url = "https://esek.se/member/posts/" . $post['id'];

			$table .= "<tr>";
			$table .= "<td><a href=\"$url\"> target=\"_blank\"" . $post['name'] . "</a></td>";
			$table .= "<td>" . $post['start'] . "</td>";
			$table .= "<td>" . $post['end'] . "</td>";
			$table .= "</tr>";
		}

		$table .= "</table>";
		return $table;
	}
}
