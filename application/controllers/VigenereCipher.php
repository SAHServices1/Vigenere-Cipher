<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VigenereCipher extends CI_Controller {

	function Mod($a, $b)
	{
		return ($a % $b + $b) % $b;
	}

	function Encipher($input, $key)
	{
		return $this->Cipher($input, $key, true);
	}

	function Decipher($input, $key)
	{
		return $this->Cipher($input, $key, false);
	}

	function Cipher($input, $key, $encipher)
	{
		$keyLen = strlen($key);

		for ($i = 0; $i < $keyLen; ++$i)
			if (!ctype_alpha($key[$i]))
			return "";

		$output = "";
		$nonAlphaCharCount = 0;
		$inputLen = strlen($input);

		for ($i = 0; $i < $inputLen; ++$i)
		{
			if (ctype_alpha($input[$i]))
			{
				$cIsUpper = ctype_upper($input[$i]);
				$offset = ord($cIsUpper ? 'A' : 'a');
				$keyIndex = ($i - $nonAlphaCharCount) % $keyLen;
				$k = ord($cIsUpper ? strtoupper($key[$keyIndex]) : strtolower($key[$keyIndex])) - $offset;
				$k = $encipher ? $k : -$k;
				$ch = chr(($this->Mod(((ord($input[$i]) + $k) - $offset), 26)) + $offset);
				$output .= $ch;
			}
			else
			{
				$output .= $input[$i];
				++$nonAlphaCharCount;
			}
		}

		return $output;
	}

	public function index()
	{
		$text = "Muhammadabdulhadi, Cryptography";
		$cipherText = $this->Encipher($text, "cipher");
		$plainText = $this->Decipher($cipherText, "cipher");
		echo '<strong> OUTPUT:'. '<strong> <br> CipherText is: ' . $cipherText . '<br> Plain Text is: ' . $plainText;
		
	}
}
