<?php
/**
 * Created by Navatech.
 * @project yii2-transmission
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    4/23/2016
 * @time    3:57 PM
 */
namespace phuong17889\transmission\components;
class Transmission extends \Transmission\Transmission {

	/**
	 * @return int
	 */
	public function getTotalSize() {
		$total = 0;
		foreach ($this->all() as $torrent) {
			$total += $torrent->getSize();
		}
		return $total;
	}
}