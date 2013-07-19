<?php


class CoreUtils extends Object{

	static function truncate($text, $length = 100, $ending = "...", $exact = true, $considerHtml = true) {
		if (is_array($ending)) {
			extract($ending);
		}
		if ($considerHtml) {
			if (strlen(preg_replace("/<.*?>/", "", $text)) <= $length) {
				return $text;
			}
			$totalLength = strlen($ending);
			$openTags = array();
			$truncate = "";
			preg_match_all("/(<\/?([\w+]+)[^>]*>)?([^<>]*)/", $text, $tags, PREG_SET_ORDER);
			foreach ($tags as $tag) {
				if (!preg_match("/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s", $tag[2])) {
					if (preg_match("/<[\w]+[^>]*>/s", $tag[0])) {
						array_unshift($openTags, $tag[2]);
					} else if (preg_match("/<\/([\w]+)[^>]*>/s", $tag[0], $closeTag)) {
						$pos = array_search($closeTag[1], $openTags);
						if ($pos !== false) {
							array_splice($openTags, $pos, 1);
						}
					}
				}
				$truncate .= $tag[1];

				$contentLength = strlen(preg_replace("/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i", " ", $tag[3]));
				if ($contentLength + $totalLength > $length) {
					$left = $length - $totalLength;
					$entitiesLength = 0;
					if (preg_match_all("/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i", $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
						foreach ($entities[0] as $entity) {
							if ($entity[1] + 1 - $entitiesLength <= $left) {
								$left--;
								$entitiesLength += strlen($entity[0]);
							} else {
								break;
							}
						}
					}

					$truncate .= substr($tag[3], 0 , $left + $entitiesLength);
					break;
				} else {
					$truncate .= $tag[3];
					$totalLength += $contentLength;
				}
				if ($totalLength >= $length) {
					break;
				}
			}

		} else {
			if (strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = substr($text, 0, $length - strlen($ending));
			}
		}
		if (!$exact) {
			$spacepos = strrpos($truncate, " ");
			if (isset($spacepos)) {
				if ($considerHtml) {
					$bits = substr($truncate, $spacepos);
					preg_match_all("/<\/([a-z]+)>/", $bits, $droppedTags, PREG_SET_ORDER);
					if (!empty($droppedTags)) {
						foreach ($droppedTags as $closingTag) {
							if (!in_array($closingTag[1], $openTags)) {
								array_unshift($openTags, $closingTag[1]);
							}
						}
					}
				}
				$truncate = substr($truncate, 0, $spacepos);
			}
		}

		$truncate .= $ending;

		if ($considerHtml) {
			foreach ($openTags as $tag) {
				$truncate .= "</$tag>";
			}
		}

		return $truncate;
	}
	
	static function delTag( $html , $tag){
		$pos1 = false;
		$pos2 = false;
		do {
			if ($pos1 !== false && $pos2 !== false) {
				$first = NULL;
				$second = NULL;
				if ($pos1 > 0)
				$first = substr($html, 0, $pos1);
				if ($pos2 < strlen($html) - 1)
				$second = substr($html, $pos2);
				$html = $first . $second;
			}
			preg_match("/<".$tag."[^>]*>/i", $html, $matches);
			$str1 =& $matches[0];
			preg_match("/<\/".$tag.">/i", $html, $matches);
			$str2 =& $matches[0];
			$pos1 = strpos($html, $str1);
			$pos2 = strpos($html, $str2);
			if ($pos2 !== false)
			$pos2 += strlen($str2);
		} while ($pos1 !== false && $pos2 !== false);
		return $html;

	}
	
	static function delXss( $html ){
		$tmp = self::delTag($html, "script");
		$tmp = self::delTag($tmp, "style");
		return $tmp;
	}
	
	static function cleanHtml( $html ){
	 	$tmp = self::delTag($html, "script");
		$tmp = self::delTag($tmp, "style");
		return htmlentities($tmp, null, "utf-8");	
	}


}