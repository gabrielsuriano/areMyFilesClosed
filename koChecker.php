<?php
function checkFiles($path, $problemOpen = '<!-- ko', $problemClose = '<!-- /ko'){
	$numErrors = 0;
	$handle = fopen($path, "r");
	if ($handle) {
			// echo "--==== COMECO DE ARQUIVO ====--<br><br>";
		$linhaAtual = 1;
		$pilhaKOs = array();
		$listaKOs = array();
		$listaKOsMuitaDiferenca = array();
		while (($buffer = fgets($handle, 4096)) !== false) {
				// echo $buffer;
				// echo "<br>";
			if (strpos($buffer, $problemOpen) !== false){
				array_push($pilhaKOs, $linhaAtual);
			}
			if (strpos($buffer, $problemClose) !== false){
				$linhaAbriu = array_pop($pilhaKOs);
				$bloco = "( $linhaAbriu | $linhaAtual )";
				array_push($listaKOs, $bloco);
				$diferenca = $linhaAtual - $linhaAbriu;
				if ($diferenca > 10){
					array_push($listaKOsMuitaDiferenca, $bloco);
					echo "$bloco = $diferenca <br>";
				}
			}
			$linhaAtual++;
		}
		if (!feof($handle)) {
				// echo "Erro: falha inexperada de fgets()\n";
		}

		fclose($handle);
			// echo "--==== FIM DE ARQUIVO ====--<br><br><br><br><br>";
	}
}
checkFiles('teste2.template');
?>