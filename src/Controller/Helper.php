<?php
namespace App\Controller;


Trait Helper
{
	/**
	 * Permet de générer un Slug à partir d'un String
	 * @param $text
	 * @return String Slug
	 * @see https://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
	 */
	public function slugify($text)
	{
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		// trim
		$text = trim($text, '-');

		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		// lowercase
		$text = strtolower($text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
	}

	public function checkInput($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function str_random($length){
		$alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
		return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
	}


}