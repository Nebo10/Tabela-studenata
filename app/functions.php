<?php 

	// Ova funkcija nam vraca punu putanju fajla
	// Molim da se definise putanja do foldera gdje se nalazi sajt
	function url($file_name)
	{
		$path = 'http://localhost/kurs/project/';
		return $path . $file_name;
	}

 ?>