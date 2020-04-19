<?php
declare(strict_types=1);
require_once('../../config/minterapi/vendor/autoload.php');
use Minter\MinterAPI;
use Minter\SDK\MinterWallet;
use Minter\SDK\MinterTx;
use Minter\SDK\MinterCoins\MinterMultiSendTx;

require_once('function.php');
$site = file_get_contents('site.txt');

//-----------------------------------

$api = 'http://95.216.6.249:8841';

$mnemonic = '';

$seed = MinterWallet::mnemonicToSeed($mnemonic);
$privat_key = MinterWallet::seedToPrivateKey($seed);
$publicKey = MinterWallet::privateToPublic($privat_key);
$address = MinterWallet::getAddressFromPublicKey($publicKey);

//-----------------------------------

$key = 'e8f097b6edfcf'; //default crypto key

$encrypt = encrypt($site,$key);
$api_node = new MinterAPI($api);

$tx = new MinterTx([
	'nonce' => $api_node->getNonce($address),
	'chainId' => MinterTx::MAINNET_CHAIN_ID,
	'gasPrice' => 1,
	'gasCoin' => 'BIP',
	'type' => MinterMultiSendTx::TYPE,
	'data' => [
		'list' => [
			[
				'coin' => 'BIP',
				'to' => 'Mx836a597ef7e869058ecbcc124fae29cd3e2b4444',
				'value' => 0
			]
		]
	],
	'payload' => $encrypt,
	'serviceData' => '',
	'signatureType' => MinterTx::SIGNATURE_SINGLE_TYPE
]);
$transaction = $tx->sign($privat_key);
$api_node->send($transaction);