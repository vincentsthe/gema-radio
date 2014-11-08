<?php

namespace app\helpers;
function money_format($string,$value){
	return $value;
}
class FormatHelper {
	public static function currency($value) {
		return preg_replace("/IDR/", "Rp ", money_format('%i', floatval($value)));
	}
}