<?php

namespace app\helpers;
function money_format($string,$value){
	return $value;
}
class FormatHelper {
	public static function currency($value) {
		return "Rp " . number_format(floatval($value), 2, '.', ',');
	}
}