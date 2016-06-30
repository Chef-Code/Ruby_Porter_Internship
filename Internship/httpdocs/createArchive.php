<?php 

	#$archive_name = "archive.zip"; // name of zip file
	#$archive_folder = "folder"; // the folder which you archivate
	
	function createArchive($archive_name, $archive_folder){
		
		$zip = new ZipArchive(); 
		
		if ($zip -> open($archive_name, ZipArchive::CREATE) === TRUE) 
		{ 
			$dir = preg_replace('/[\/]{2,}/', '/', $archive_folder."/"); 
			
			$dirs = array($dir); 
			while (count($dirs)) 
			{ 
				$dir = current($dirs); 
				$zip -> addEmptyDir($dir); 
				
				$dh = opendir($dir); 
				while($file = readdir($dh)) 
				{ 
					if ($file != '.' && $file != '..') 
					{ 
						if (is_file($file)) 
							$zip -> addFile($dir.$file, $dir.$file); 
						elseif (is_dir($file)) 
							$dirs[] = $dir.$file."/"; 
					} 
				} 
				closedir($dh); 
				array_shift($dirs); 
			} 
			
			$zip -> close(); 
			echo 'Archiving is sucessful!'; 
		} 
		else 
		{ 
			echo 'Error, can\'t create a zip file!'; 
		} 
	}
	
	
	
	/*
		// send $filename to browser
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mimeType = finfo_file($finfo, $filename);
	$size = filesize($filename);
	$name = basename($filename);

	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
		// cache settings for IE6 on HTTPS
		header('Cache-Control: max-age=120');
		header('Pragma: public');
	} else {
		header('Cache-Control: private, max-age=120, must-revalidate');
		header("Pragma: no-cache");
	}
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // long ago
	header("Content-Type: $mimeType");
	header('Content-Disposition: attachment; filename="' . $name . '";');
	header("Accept-Ranges: bytes");
	header('Content-Length: ' . filesize($filename));

	print readfile($filename);
	exit;*/
	