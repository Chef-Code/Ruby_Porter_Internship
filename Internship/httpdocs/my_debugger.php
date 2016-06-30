<?php
	include "/var/www/project/vendor/autoload.php";
	
	use Symfony\Component\Yaml\Parser;
	use Symfony\Component\Yaml\Exceptions\Exception;
	use Symfony\Component\Yaml\Dumper;
	
	try {
		
		$yaml = new Parser;

		$values = $yaml->parse(file_get_contents('Lonnie_config.yaml'));
		
		echo "<pre>";
		print_r($values);
		echo "</pre>";

	}
	catch (ParseException $e) {
		printf("Unable to parse the YAML string: %s", $e->getMessage());
	}