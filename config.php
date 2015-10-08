<?php
/**
 * Config Class for Azukari
 */
class AzukariConfig {

	/*
	 * Set the path of the directory to store the files.
	 * Attention, the path should end with a slash(/).
	 */
	public static function storeBasePath(){
		// WARN: IT IS SAMPLE AND YOU SHOULD MODIFY IT TO CORRECT PATH.
		return __DIR__.'/store/';
	}

	public static function storeBaseUrl(){
		// WARN: IT IS SAMPLE AND YOU SHOULD MODIFY IT TO CORRECT PATH.
		return 'http://localhost/WebProjects/Azukari/store/';
	}	

}
?>