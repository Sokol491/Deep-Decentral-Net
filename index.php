<?php
require_once('header.php');
//-----------------------------------

$site = strtolower($_POST['hash']);

$key = explode("/", $site)[1];
$site = explode("/", $site)[0];
if ($key=='')
{
	$key = 'e8f097b6edfcf'; //default crypto key
}
if ($site=='')
	{
		$hash = '0xf7a547eb9569f548911568c29812cf392fc2823ce7492c5ab10e605e61879d87';
	}
elseif (explode(".", $site)[1]=='ddn')
	{
		$json = file_get_contents('https://raw.githubusercontent.com/Sokol491/Deep-Decentral-Net/master/nodelist.json');
		$hash = json_decode($json)->$site->hash;
		if ($hash == '')
			{
				$hash = '0x077bcd7807935ccab5ec850abaf383496016f12d707f396d7c2be610fa034797'; //Error. The site address was not found.
			}
	}
elseif (explode(".", $site)[1]=='minter')
	{
		$hash = explode(".", $site)[0];
	}
else
	{
		$hash = '0x077bcd7807935ccab5ec850abaf383496016f12d707f396d7c2be610fa034797'; //Error. The site address was not found.
	}
//-----------------------------------

require_once('function.php');
//$hash = $_POST['hash'];
$api = 'http://95.216.6.249:8841';

decrypt($api,$hash,$key);
//-----------------------------------