<?php
$libPath = '../libs';
$deCodePath = '../libs/Ec_decode';
$ecPath = '../libs/Ec';


handleDir($ecPath, $ecPath, $deCodePath);


function handleDir($dir, $sourceDir, $deDir){
	$handle = opendir($dir);

	while (($file = readdir($handle)) !== false)  {
		if ($file != '.' && $file != '..'){
			$path = $dir.'/'.$file;

			if (is_dir($path)){
				handleDir($path, $sourceDir, $deDir);
			}else{
				$fileContent = decode(readFileByName($path));

				if (pathinfo($path, PATHINFO_EXTENSION) == 'php'){
				 	$fileContent = "<?php".$fileContent;
				}

				try{
					writeFileByName(str_replace($sourceDir, $deDir, $path), $fileContent);
				}catch(Exception $e){
					echo 'error';
					exit;
				}
				
			}
		}
	}
}

function writeFileByName($file, $content){
	if (!file_exists(dirname($file)) || !is_dir(dirname($file))){
		mkdir(dirname($file), 0777, true);
	}

	$handle = fopen($file, 'wb');

	fwrite($handle, $content);

	fclose($handle);
}

function readFileByName($file){
	$handle = fopen($file, 'rb');

	$fileContent = fread($handle, filesize($file));

	fclose($handle);

	return $fileContent;
}

function decode($decodeStr){
	preg_match_all('/\$OO00O0000\=([0-9]*)/', $decodeStr, $matchArr);

	if (count($matchArr) > 1 && isset($matchArr[1][0])){
		$codeLength = $matchArr[1][0];

		preg_match_all('/\$\$O0O0000O0\(\'(.*)\'\)/', $decodeStr, $matchDeCodeInfo);

		if (count($matchDeCodeInfo) > 1){
			$deCodeInfo = base64_decode($matchDeCodeInfo[1][0]);

			preg_match_all('/\'([\s\S]{10,65})\'/', $deCodeInfo, $deCodeGene);

			if (count($deCodeGene) > 1){
				$base64Code = substr($decodeStr, stripos($decodeStr, '?>') + 2);
				$base64CodeLen = strlen($base64Code);

				$base64Code = strtr(substr($base64Code, $base64CodeLen - $codeLength), $deCodeGene[1][0], $deCodeGene[1][1]);
				
				return base64_decode($base64Code);
			}
		}
	}

	return false;
}