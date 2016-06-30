<?php 


	function createNewZip($newZipFolder,$fileContents,$fileName)
	{
	
		$zip = new ZipArchive();
		$filename = $newZipFolder;

		$result = $zip->open($filename, ZipArchive::CREATE);
		
		if($result !== TRUE)
		{
			exit("cannot open <$filename>\n");
		}
		else
		{
			$zip->addFromString($fileName,$fileContents);
			$zip->close();
			echo 'ok everything worked';
		}
		
	}