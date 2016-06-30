<?php
	include "/var/www/project/vendor/autoload.php";
	
	use Symfony\Component\Yaml\Parser;
	use Symfony\Component\Yaml\Exceptions\Exception;
	use Symfony\Component\Yaml\Dumper;
	
	try {
		
		$yaml = new Parser;

		$values = $yaml->parse(file_get_contents('config.yaml'));
		
		//$newvalues = $values;
		
		$rai = new RecursiveArrayIterator($values/*$newvalues*/);

		//$ref_rai = &$rai;
		
		$rii = new RecursiveIteratorIterator(&$rai, RecursiveIteratorIterator::SELF_FIRST);
		
		//$newrii = &$rii;
		
 		echo $_POST['machines_id'];
		
		foreach ($rii/*$newrii*/ as $k => $v)
		{	
			$depth = $rii->getDepth();
			$altdepth = $depth;
			
			if($altdepth != 0){
				
				$subIt = $rii->getSubIterator($altdepth-1)->key();
			}
																				
		/***************MACHINE********************************/                
																				
			#Get id and hostname location in the array
			if($depth == 6 && substr($subIt,0,4) === 'vflm')
			{
				if($k === 'id'){

					//unset($v);
					$refv = $v;
					$refv = $_POST['machines_id'];
					// echo "$refv <br>";
					// echo "$v";
					
					//$debug_to_console($v);
				}
				
				if($k === 'hostname'){					
					$v = $_POST['machines_hostname'];
				}
			}
			
			#get ip location in the array
			if($depth == 7 && $subIt === 'network'){
				
				if($k === 'private_network'){					
					$v = $_POST['machines_ip'];
				}
			}
			
		/************Nginx************************************/	
		
			#get the vhosts specific stuff
			if($depth == 3 && substr($subIt,0,4) ==='nxv_'){
				
				if($k === 'server_name'){
					
					$v = $_POST['server_name']; 
				}
				
				if($k === 'server_aliases'){
					#server_aliases are stored as aa an array
					if(is_array($v)){
						
						foreach($v as $vk => $vv){
							
							$vv_num = count($vv);
							
							if($vv_num === 1){
								$vv = $_POST['server_aliases'];
							}							
						}						
					}
				}
				if($k === 'www_root'){
					
					$v = $_POST['www_root']; 
				}
			}
			
		/*************MariaDB********************************/
		
			if($k === 'mariadb'){

				foreach($v as $vk => $vv){

					if($vk === 'settings'){
						$settings = $vv['root_password'];
						
						$settings = $_POST['root_password'];
					
					}
					if($vk === 'users'){
						$user = $vv['mariadbnu_4bkdh5y5m6xc'];
						$_name = $user['name'];
						$_password = $user['password'];
						
						$_name = $_POST['user_name'];
						$_password = $_POST['user_password'];

					}
					if($vk === 'databases'){
						$db = $vv['mariadbnd_like5wbb71dg'];
						$db_name = $db['name'];
						
						$db_name = $_POST['db_name'];
					}
					if($vk === 'grants'){
						
						$grants = $vv['mariadbng_cq85n60c9u3x'];
						$g_user = $grants['user'];
						$g_table = $grants['table'];
						$g_privs = $grants['privileges'];
						
						$g_user = $_POST['grant_user'];
						$g_table = $_POST['grant_table'];						
						$g_privs[] = $_POST['grant_privileges'];
					}					
				}
			
				
			}
			//var_dump($rii);
			 echo "<pre>";
			 print_r($rai);
			 echo "</pre>";
		//var_dump($rii);
		
		
			
		$directoryPath = '/user_configs/';
		$user = 'Lonnie' . '_';
		$fileType = 'config' . '_';
		
		$fileExtention = '.yml';
		
		$newFile = $user . $fileType . $fileExtention;
		
		$dumper = new Dumper;
				
		$userRefinedYaml = $values;
//echo $dumper->dump($values);
		//echo $dumper->dump($userRefinedYaml);
				
				/*if (!is_dir($directoryPath . $user)) {
				// dir doesn't exist, make it
				mkdir($directoryPath . $user, 01777, true);
				}*/

		//file_put_contents($user . $fileType . $fileExtention, $newYaml);	
		}
	}
	catch (ParseException $e) {
		printf("Unable to parse the YAML string: %s", $e->getMessage());
	}
	
	