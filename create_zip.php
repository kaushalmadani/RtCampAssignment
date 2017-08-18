<?php

//This file is used to make zip file.

function Zip($source, $destination)
{
	$rootPath = realpath($source);
	$zip = new ZipArchive();
	$zip->open($destination, ZipArchive::CREATE);
	$files = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($rootPath),
		RecursiveIteratorIterator::LEAVES_ONLY
	);
	$parent="";
	foreach ($files as $name => $file)
	{	
		if (!$file->isDir())
		{
			$path_info = pathinfo($file);
			$ext=$path_info['extension'];
			if($ext!="zip"){
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($rootPath) + 1);
				$zip->addFile($filePath, $parent."/".$relativePath);
			}
		}else{
			if(basename($file)=="."){
				$parent=basename(realpath($file));
			}
		}
}
$zip->close();
}
?>