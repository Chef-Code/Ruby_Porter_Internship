<?php
	include "/var/www/project/vendor/autoload.php";
	
	use Symfony\Component\Yaml\Yaml;
	use Symfony\Component\Yaml\Dumper;
	
	$yaml = Yaml::parse(file_get_contents('config.yaml'));
	
	
	
	foreach($_POST as $post){
		
	}
	
	class Configuration 
	{
		//define properties
		public $key;
		
		//constructor
		public function __construct() {
			$this->$key = Configuration[$key];
		}
				
	}