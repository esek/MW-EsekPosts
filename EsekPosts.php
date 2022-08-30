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
	}

	private static function fetchPosts(string $username)
	{
		$client = new EsekClient();
		$posts = $client->getPostsForUser($username);

		if (count($posts) == 0) {
			return "<p>$username har inte haft några poster ännu...</p>";
		}

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
			$post_url = "/index.php/" . $post['name'];

			$table .= "<tr>";
			$table .= "<td><a href=\"$post_url\">" . $post['name'] . "</a></td>";
			$table .= "<td>" . $post['start'] . "</td>";
			$table .= "<td>" . $post['end'] . "</td>";
			$table .= "</tr>";
		}

		$table .= "</table>";
		return $table;
	}
}
