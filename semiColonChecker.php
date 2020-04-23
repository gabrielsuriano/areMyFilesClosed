<?php
function getFolders($dir, &$folderStack, &$fileArray, $fileExtensionSearching = ".less"){
	$files = scandir($dir);
	for ($i = 2; $i < sizeof($files); $i++){
		$file = $files[$i];
		$newPath = $dir.'/'.$file;
		if (is_dir($newPath) && strpos($file, '.ccc') === false){
			array_push($folderStack, $newPath);
		}
		else if (strpos($file, $fileExtensionSearching) !== false){
			array_push($fileArray, $newPath);
		}
	}
}

function getFilesPath($rootDirectory, $fileExtensionSearching = '.less'){
	$folderStack = array();
	array_push($folderStack, $rootDirectory);
	$fileArray = array();
	while (sizeof($folderStack) > 0) {
		$path = array_pop($folderStack);
		getFolders($path, $folderStack, $fileArray, $fileExtensionSearching);
	}
	return $fileArray;
}

function checkFiles($paths, $problemOpen = '{', $problemClose = '}'){
	$numErrors = 0;
	for ($i = 0; $i < sizeof($paths); $i++){
		$handle = fopen($paths[$i], "r");
		if ($handle) {
			// echo "--==== COMECO DE ARQUIVO ====--<br><br>";
			$numOpen = 0;
			$numClose = 0;
			while (($buffer = fgets($handle, 4096)) !== false) {
				// echo $buffer;
				// echo "<br>";
				if (strpos($buffer, $problemOpen) !== false){
					$numOpen++;
				}
				if (strpos($buffer, $problemClose) !== false){
					$numClose++;
				}

			}
			if (!feof($handle)) {
				// echo "Erro: falha inexperada de fgets()\n";
			}

			fclose($handle);
			// echo "--==== FIM DE ARQUIVO ====--<br><br><br><br><br>";
			$conta = $numClose - $numOpen;
			// echo "Arquivo: ".$paths[$i]." | Aberto: $numOpen | Fechado: $numClose | Subtracao: $conta<br>";
			if ($conta != 0){
				echo "Arquivo: ".$paths[$i]." | Aberto: $numOpen | Fechado: $numClose | Subtracao: $conta<br>";
				$numErrors++;
			}
		}
	}
	if ($numErrors == 0){
		echo "Nenhum erro foi encontrado!";
	}
}

// $paths = getPaths();
// checkFiles($paths);
$filePaths = getFilesPath('TEST_Yamaha');
checkFiles($filePaths);
?>
