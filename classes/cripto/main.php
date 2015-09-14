<?php
include_once("AES.class.php");

$key128 = '2b7e151628aed2a6abf7158809cf4f3c';
$key192 = '8e73b0f7da0e6452c810f32b809079e562f8ead2522c6b7b';
$key256 = '603deb1015ca71be2b73aef0857d77811f352c073b6108d72d9810a30914dff4';
// =====================================================================================================
$Cipher = new AES(AES::AES256);

$token = "<*|*>";

function Xencri($texto){
	global $Cipher, $key256;
	$content = $Cipher->stringToHex($texto);
	return $Cipher->encrypt($content, $key256);
}

function Xdescri($texto){
	global $Cipher, $key256;
	$content = $Cipher->decrypt($texto, $key256);
	return $Cipher->hexToString($content);
}

/* encriptar strings longas */
function encri_l($str){
	global $token;
	if(strlen($str) > 15){
		$ns = "";
		$con=0;
		for($i=0; $i<strlen($str); $i++)
		{
			if($con == 15){
				$ns .= $token;
				$con=0;
			}
			$ns .= $str[$i];
			$con++;
		}
		$ns = explode($token, $ns);
		for($i=0; $i<count($ns); $i++) {
			$ns[$i] = Xencri($ns[$i]);
		}
		$ns2 = implode($token, $ns);
		return $ns2;
	}else{ return Xencri($str); }
}

/* descriptar strings longas */
function descri_l($str_en){
	global $token;
	$x = "";
	$ns = explode($token, $str_en);
	for($i=0; $i<count($ns); $i++) {
		$x .= Xdescri($ns[$i]);
	}
	return $x;
}

?>
