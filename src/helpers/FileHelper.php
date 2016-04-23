<?php
/**
 * Created by Navatech.
 * @project yii2-transmission
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    4/23/2016
 * @time    3:34 PM
 */
namespace phuong17889\transmission\helpers;
/**
 * {@inheritDoc}
 */
class FileHelper extends \yii\helpers\FileHelper {

	/**
	 * @param $number
	 *
	 * @return string
	 */
	public static function size($number) {
		$response = number_format($number) . ' B';
		if ($number > 1024) {
			$number /= 1024;
			$response = number_format($number, 3) . ' KB';
			if ($number > 1024) {
				$number /= 1024;
				$response = number_format($number, 3) . ' MB';
				if ($number > 1024) {
					$number /= 1024;
					$response = number_format($number, 3) . ' GB';
					if ($number > 1024) {
						$number /= 1024;
						$response = number_format($number, 3) . ' TB';
					}
				}
			}
		}
		return $response;
	}
}