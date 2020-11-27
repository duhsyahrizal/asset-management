<?php
/*
	Cifrario di Vigen�re [PHP] - Fabio Donatantonio 2010
	
	SINTASSI:
	$cifrario = new Vigenere($chiave);
	$txt_cifrato = $cifrario->cifratura($testo);
	$txt_chiaro = $cifrario->decifratura($txt_cifrato);
	$cifrario->stampaTavola();
*/
class Vigenere{
	var $alfabeto = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
	var $matrice;
	var $chiave;
	
	// Il costruttore imposta la chiave e realizza la matrice
	function Vigenere($chiave){
		$this->chiave = str_replace(array(" ",".",",",";"),"", $chiave);
		$app1 = array();
		$app2 = array();
		$alfabeto_app = array();
		for($i=0; $i<36; $i++){
			$k=0;
			$app1 = array_slice($this->alfabeto,0,$i);
			$app2 = array_slice($this->alfabeto,$i);
			$this->matrice[$i] = array_merge($app2,$app1);
		}
	}
	
	// Metodo che stampa la matrice
	function stampaTavola(){
		echo "<table border='1' cellpadding='1' cellspacing='0'>
		<tr><td rowspan='27' width='50px' align='center'>T<br>E<br>S<br>T<br>O<br> <br>I<br>N<br> <br>C<br>H<br>I<br>A<br>R<br>O<br></td><td colspan='36' align='center' height='50px'>CHIAVE</td></tr>";
		for($i=0; $i<36; $i++){
			echo "<tr>";
			for($j=0; $j<36; $j++){
				echo "<td align='center'>".$this->matrice[$i][$j]."</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}
	
	// Metodo per la cifratura
	function cifratura($testo){
		$txt_cifrato = "";
		$l_chiave = strlen($this->chiave);
		$k = 0;
		for($i=0; $i<strlen($testo); $i++){
			$chr_t = substr($testo,$i,1);
			$chr_c = substr($this->chiave,$k,1);
			
			if(in_array(strtoupper($chr_t),$this->alfabeto) && in_array(strtoupper($chr_c),$this->alfabeto)){
				$x = array_search(strtoupper($chr_t),$this->alfabeto);
				$y = array_search(strtoupper($chr_c),$this->alfabeto);
				$txt_cifrato = $txt_cifrato.$this->matrice[$x][$y];
				$k++;
			}else{
				$txt_cifrato = $txt_cifrato.strtoupper($chr_t);
			}
			if($k==$l_chiave) $k = 0;
		}
		return $txt_cifrato;
	}
	
	// Metodo per la decifratura
	function decifratura($testo){
		$txt_decifrato = "";
		$l_chiave = strlen($this->chiave);
		$k = 0;
		for($i=0; $i<strlen($testo); $i++){
			$chr_t = substr($testo,$i,1);
			$chr_c = substr($this->chiave,$k,1);
			if(in_array(strtoupper($chr_t),$this->alfabeto) && in_array(strtoupper($chr_c),$this->alfabeto)){
				$colonna = array_search(strtoupper($chr_c),$this->alfabeto);
				$riga = 0;
				for($c=0; $c<36; $c++){
					if($this->matrice[$c][$colonna]==$chr_t){
						$riga = $c;
						break;
					}
				}
				$txt_decifrato = $txt_decifrato.$this->matrice[$riga][0];
				$k++;
			}else{
				$txt_decifrato = $txt_decifrato.$chr_t;
			}
			if($k==$l_chiave) $k = 0;
		}
		return $txt_decifrato;
	}
}
?>