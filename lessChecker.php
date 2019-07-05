<?php
function getPaths($searchFor = '.less', $dir1 = 'widget'){
	$files1 = scandir($dir1);
	$paths = array();
	// print_r($files1);
	for ($i = 2; $i < sizeof($files1); $i++){
		$dir2 = $dir1.'/'.$files1[$i].'/instances';
	// echo "$i: ";
	// print_r($dir2);
	// echo "<br>";
		$files2 = scandir($dir2);
		for ($j = 2; $j < sizeof($files2); $j++){
			$dir3 = $dir2.'/'.$files2[$j];
			$files3 = scandir($dir3);
			for ($k = 2; $k < sizeof($files3); $k++){
				$finalFile = $files3[$k];
				if (strpos($finalFile, $searchFor) !== false){
					$singlePath = $dir3.'/'.$finalFile;
					array_push($paths, $singlePath);
				}
			}
		}
	}
	return $paths;
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

$paths = getPaths();
checkFiles($paths);

?>