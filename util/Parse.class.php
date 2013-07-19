<?

class Parse extends Object{


	static function urls($txt){
		$reg = "/<\s*a\s+[^>]*href\s*=\s*[\"']?([^\"' >]+)[\"' >]/isU";

		preg_match_all( $reg, $txt, $links );
		list( $elementos, $enlaces) = $links;

		if ( count ($enlaces) == 0) return array();

		return $enlaces;

	}


	static function emails($txt){
		preg_match_all("/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i", $html, $data);
		if ( count($data[0]) == 0) return array();
		return $data[0];

	}
}
