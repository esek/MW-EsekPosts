<?php

class EsekPosts
{
	// Register any render callbacks with the parser
	public static function onParserFirstCallInit(Parser $parser)
	{
		// When the parser sees the <sample> tag, it executes renderTagSample (see below)
		$parser->setHook('Posts', [self::class, 'renderPosts']);
	}

	// Render <sample>
	public static function renderPosts($input, array $args, Parser $parser, PPFrame $frame)
	{
		// Nothing exciting here, just escape the user-provided input and throw it back out again (as example)
		return htmlspecialchars($input);
	}
}
