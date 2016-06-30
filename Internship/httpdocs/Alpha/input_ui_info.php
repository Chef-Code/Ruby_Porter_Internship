<?php
	include "/var/www/project/vendor/autoload.php";
	
	use Symfony\Component\Yaml\Yaml;
	use Symfony\Component\Yaml\Dumper;
	
	//Global POST Array variables
	$machines_id = $_POST['machines_id'];
	$machines_hostname = $_POST['machines_hostname'];
	$machines_ip = $_POST['machines_ip'];
	
	$server_name = $_POST['server_name'];
	$server_aliases = $_POST['server_aliases']
	$www_root = $_POST['www_root'];
	
	$root_password = $_POST['root_password'];
	$user_name = $_POST['user_name'];
	$user_password = $_POST['user_password'];
	$db_name = $_POST['db_name'];
	$grant_user = $_POST['grant_user'];
	$grant_table = $_POST['grant_table'];
	$grant_privileges = $_POST['grant_privileges'];
	
	$yaml = Yaml::parse(file_get_contents('config.yaml'));
	
	
	$categories = array('vagrantfile','nginx','mariadb');
	$vagrantfile = array('target','vm','ssh','vagrant','proxy');
	$vm = array('provider','provision','synced_folder','usable_port_range','post_up_message');

	//$values = new ArrayObject($values);
		
	
	$arrayWithUserInput = array(
		"machines" => array(
			"id" => $machines_id,
			"hostname" => $machines_hostname,
			"ip" => $machines_ip
		),
		"nginx" => array(
			"vhosts" => array(
				"server_name" => $server_name,
				"server_aliases" => $server_aliases,
				"www_root" => $www_root
			)
		),
		"mariadb" => array(
			"settings" => array(
				"root_password" => $root_password
			),
			"users" => array(
				"name" => $user_name,
				"password" => $user_password
			),
			"databases" => array(
				"name" => $db_name
			),
			"grants" => array(
				"user" => $grant_user,
				"table" => $grant_table,
				"privileges" => $grant_privileges
			)
		)
	);
	$datetime = new DateTime;
	
	echo $datetime->format("d/m/Y");
	
	$today = getdate(time());
			$day = $today['mday'];
			$mon = $today['mon'];
			$year = $today['year'];
			$hour = $today['hours'];
			$min = $today['minutes'];
			$sec = $today['seconds'];
			
		$dateStamp = "$day"."_"."$mon"."_"."$year"."_";
		$timeStamp = "$hour"."_"."$min"."_"."$sec";