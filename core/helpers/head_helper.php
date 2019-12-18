<?php
define("HEAD", true);

function icon_load($url)
{
	if(!empty($url))
	{
		$url = (substr($url, 0, 1) == "/") ? substr($url, 1) : $url;
		return "<link href=\"".SERVER_ADDRESS.$url."\" rel=\"shortcut icon\" type=\"image/x-icon\" />\n";
	}
	else
	{
		return ;
	}
}

function add_title($title)
{
	if(!empty($title))
	{
		return "<title>{$title}</title>";
	}
	else
	{
		return ;
	}
}

function add_basehref()
{
	return "<base href=\"".SERVER_ADDRESS."\" />";
}

?>