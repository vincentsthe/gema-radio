<?php

namespace app\helpers;

class FormatHelper {
	public static function currency($value) {
		setlocale(LC_MONETARY, 'id_ID.UTF-8');
		return preg_replace("/IDR/", "Rp ", money_format('%i', floatval($value)));
	}
}