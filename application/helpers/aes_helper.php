<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *   \brief Encrypt datas<br>
 */
function AesEncrypt($value) {
	$ci = get_instance();
	$passphrase = $ci->config->item('encryption_key');
	$salt = openssl_random_pseudo_bytes(8);
	$salted = '';
	$dx = '';
	while (strlen($salted) < 48) {
		$dx = md5($dx . $passphrase . $salt, true);
		$salted .= $dx;
	}
	$key = substr($salted, 0, 32);
	$iv = substr($salted, 32, 16);
	$encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
	$data = array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt));

	return urlencode(base64_encode(json_encode($data)));
}
/**
 *   \brief Decrypt
 */
function AesDecrypt($base64URL) {
	$ci = get_instance();
	$passphrase = $ci->config->item('encryption_key');
	$jsondata = json_decode(base64_decode(urldecode($base64URL)), true);
	$salt = hex2bin($jsondata["s"]);
	$ct = base64_decode($jsondata["ct"]);
	$iv = hex2bin($jsondata["iv"]);
	$concatedPassphrase = $passphrase . $salt;
	$md5 = array();
	$md5[0] = md5($concatedPassphrase, true);
	$result = $md5[0];
	for ($i = 1; $i < 3; $i++) {
		$md5[$i] = md5($md5[$i - 1] . $concatedPassphrase, true);
		$result .= $md5[$i];
	}
	$key = substr($result, 0, 32);
	$data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
	return json_decode($data, true);
}
