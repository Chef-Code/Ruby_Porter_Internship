<?php

include "/var/www/project/vendor/autoload.php";
	
	use Symfony\Component\Yaml\Parser;
	use Symfony\Component\Yaml\Dumper;
	
	$yaml = new Parser;

		$values = $yaml->parse(file_get_contents('Lonnie_config_.yml'));
		
		$rai = new RecursiveArrayIterator($values);	
		$rii = new RecursiveIteratorIterator($rai, RecursiveIteratorIterator::SELF_FIRST);
		
		foreach($rii as $k => $v){
			
			if(!is_array($v))
			{
				echo "<pre>";
				echo "$k : $v ";
				echo "</pre>";
			}
			
		}
		
		/*$dumper = new Dumper();

		echo $dumper->dump($values);*/
		