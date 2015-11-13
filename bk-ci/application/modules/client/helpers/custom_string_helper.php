<?php
function filter_text($str = '')
{
	$str	=	preg_replace('/<p>[\s]*&nbsp;[\s]*<\/p>/is','',$str);
    $str	=	strip_tags($str,'<a><b><h1><h2><h3><h4>');
    return $str;
}

function show_thumb($str,$thumb = '155-110')
{	
	if($thumb == "")
	{
		$rs = site_url(preg_replace('/(thumb)_([0-9\-])+\//is','',$str));
	}
	else
	{
		$rs = site_url(preg_replace('/(thumb)_([0-9\-])+\//is','$1_'.$thumb.'/',$str));
	}
	return $rs;
}

function snippet($text, $length=140, $tail="...")
{
    $text = trim($text);
    $txtl = strlen($text);
    if($txtl > $length)
    {
        for($i=1;$text[$length-$i]!=" ";$i++)
        {
            if($i == $length)
            {
                return substr($text,0,$length) . $tail;
            }
        }
        $text = substr($text,0,$length-$i+1) . $tail;
    }
    return $text;
}

function timetostr($date)
{
	return strtotime($date);
}

function get_title($match = '', $replace = '') {
    $CI = & get_instance();
    return str_replace($match, $replace, $CI->config->item('title'));
}

function get_description($match = '', $replace = '') {
    $CI = & get_instance();
    return str_replace($match, $replace, $CI->config->item('description'));
}

function get_keywords($match = '', $replace = '') {
    $CI = & get_instance();
    return str_replace($match, $replace, $CI->config->item('keywords'));
}

