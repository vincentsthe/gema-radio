<?php

namespace app\helpers;

class TimeHelper {
	/**
	 * Convert the string $formattedDate into timestamp
	 * The formattedDate is assumed to have format "%d-%m-%Y %H:%M"
	 * 
	 * @param string $formattedDate
	 * @return number timestamp
	 */
	public static function formattedDateToTimestamp($formattedDate, $format = "%d-%m-%Y %H:%M") {
		$time = strptime($formattedDate, $format);
		return mktime($time['tm_hour'], $time['tm_min'], 0, $time['tm_mon']+1, $time['tm_mday'], $time['tm_year'] + 1900);
	}
	
	/**
	 * Convert timestamp to formatted date.
	 * Date format is "%d-%m-%Y %H:%M"
	 * 
	 * @param int $timestamp 	timestamp to be converted
	 * @return string			Formatted date
	 */
	public static function timestampToFormattedDate($timestamp, $format = "d-m-Y H:i") {
		return date($format, $timestamp);
	}

	public static function getBeginningHourTime() {
		$timestamp = time()-60 - ((time()-60) % 3600);
		return self::timestampToFormattedDate($timestamp, "H:i:s");
	}

	public static function getTomorrowDate($date) {
		$timestamp = self::formattedDateToTimestamp($date, "%Y-%m-%d");
		$timestamp += 24*60*60;
		return self::timestampToFormattedDate($timestamp, "Y-m-d");
	}

	public static function compareFirstDate($date1, $date2) {
		$timestamp1 = self::formattedDateToTimestamp($date1 . " 00:00:00", "%Y-%m-%d %H:%M:%S");
		$timestamp2 = self::formattedDateToTimestamp($date2 . " 00:00:00", "%Y-%m-%d %H:%M:%S");

		return ($timestamp1<=$timestamp2);
	}

	public static function getDay($formattedDate, $format) {
		$day = self::timestampToFormattedDate(self::formattedDateToTimestamp($formattedDate, $format), "D");

		switch ($day) {
			case "Mon":
				return "Senin";
				break;
			case "Tue":
				return "Selasa";
				break;
			case "Wed":
				return "Rabu";
				break;
			case "Thu":
				return "Kamis";
				break;
			case "Fri":
				return "Jumat";
				break;
			case "Sat":
				return "Sabtu";
				break;
			case "Sun":
				return "Minggu";
				break;
			default:
				return $day;
		}
	}

	public static function getDate($formattedDate, $format) {
		$day = self::timestampToFormattedDate(self::formattedDateToTimestamp($formattedDate, $format), "j");
		$month = self::timestampToFormattedDate(self::formattedDateToTimestamp($formattedDate, $format), "n");
		$year = self::timestampToFormattedDate(self::formattedDateToTimestamp($formattedDate, $format), "Y");

		switch ($month) {
			case 1:
				$month = "Januari";
				break;
			case 2:
				$month = "Februari";
				break;
			case 3:
				$month = "Maret";
				break;
			case 4:
				$month = "April";
				break;
			case 5:
				$month = "Mei";
				break;
			case 6:
				$month = "Juni";
				break;
			case 7:
				$month = "Juli";
				break;
			case 8:
				$month = "Agustus";
				break;
			case 9:
				$month = "September";
				break;
			case 10:
				$month = "Oktober";
				break;
			case 11:
				$month = "November";
				break;
			case 12:
				$month = "Desember";
				break;
		}

		return $day . " " . $month . " " . $year;
	}
}