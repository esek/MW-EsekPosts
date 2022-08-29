<?php

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

		return "<p>Denna funktionalitet har flyttat <a href=\"https://esek.se/member/@$username\" target=\"_blank\">hit!</a></p>";
	}

	public static function fetchPosts()
	{
		// TODO: Fetch the actual posts
	}
}
