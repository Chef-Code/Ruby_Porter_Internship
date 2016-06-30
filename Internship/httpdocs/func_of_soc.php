<?php
	include "/var/www/project/vendor/autoload.php";
	
	use Symfony\Component\Yaml\Parser;
	use Symfony\Component\Yaml\Exceptions\Exception;
	use Symfony\Component\Yaml\Dumper;
	
	$yaml = new Parser;

	$values = $yaml->parse(file_get_contents('config.yaml'));
	
	$newCopy = &$values;
	
	#@sub is the optional param
	function getTopLevel(&$array,$index,$key,$new_value,$sub = '')
	{
		$target = &$array[$index];
		
		findTarget($target,$key,$new_value,$sub);		
	}
		
	function findTarget(&$target,$key,$new_value,$sub)
	{		
		foreach($target as $k => &$v)
		{
			if(is_array($v))
			{
				findTarget($v,$key,$new_value,$sub);					
			}						
			if($k === $key)
			{
				$temp = &$v;
				$temp = $new_value;
			}				
		}
		unset($v);
		return $target;
	}
	
	function postData(&$to, $from)
	{		
		foreach($from AS $key => &$value)
		{			
			foreach($value AS $k => &$v)
			{	
				if(is_array($v))  
				{					
					#This loop is utilized-- if a second parameter is provided for more complex scenarios i.e. @vk
					foreach($v as $vk => &$vv)
					{
						#criteria usage: name="@key[@k][@vk]" passed in from html
						getTopLevel($to,$key,$k,$vk,$vv);
					}
					unset($vv);
				}
				else
				{
					#criteria usage: name="@key[@k]" passed in from html
					getTopLevel($to,$key,$k,$v);					
				}				
			}
			unset($v);			
		}	
		unset($value);
		return $to;
	}
	
	$output = postData($newCopy, $_POST);

	$user = 'Lonnie_';
	$fileName = 'config';	
	$fileExtention = '.yaml';
	$archive = 'MyZippedFolder.zip';
	$newFileNames = $user . $fileName . $fileExtention;
	

	
	$dumper = new Dumper;	
	$saveReadyFile = $dumper->dump($output);
	
	//file_put_contents($newFileNames, $saveReadyFile);
	
	//include 'createArchive.php';
	include 'createNewZip.php';
	createNewZip($archive,$saveReadyFile,$newFileNames);
	
	
	/*create_zip function accepts an array.. either I need to save to an array or change the function.
	
	I need to also learn how to include the new file... but also provide a name 
	*/



			
	  