<?php
/**
 * Created by Navatech.
 * @project yii2-transmission
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    4/23/2016
 * @time    3:31 PM
 */
namespace phuong17889\transmission;

use phuong17889\transmission\components\Client;
use phuong17889\transmission\components\Session;
use phuong17889\transmission\components\Transmission;

/**
 * {@inheritDoc}
 */
class Module extends \yii\base\Module {

	public $host = null;

	public $port = null;

	public $path = null;

	public $auth = [
		'username' => 'transmission',
		'password' => 'transmission',
	];

	public $dirs = [
		'downloadDir'   => '/var/www/html/web/uploads/torrent/completed',
		'incompleteDir' => '/var/www/html/web/uploads/torrent/incomplete',
	];

	/**@var Session */
	public $session;

	/**@var Client */
	public $client;

	/**@var Transmission */
	public $transmission;

	/**
	 * Init new transmission
	 */
	public function init() {
		parent::init();
		$this->transmission = new Transmission($this->host, $this->port, $this->path);
		$this->client       = new Client($this->host, $this->port, $this->path);
		$this->client->authenticate($this->auth['username'], $this->auth['password']);
		$this->transmission->setClient($this->client);
		$this->session = $this->transmission->getSession();
		if (!file_exists($this->dirs['downloadDir'])) {
			mkdir($this->dirs['downloadDir'], true);
		}
		if (!file_exists($this->dirs['incompleteDir'])) {
			mkdir($this->dirs['incompleteDir'], true);
		}
		$this->session->setDownloadDir($this->dirs['downloadDir']);
		$this->session->setIncompleteDir($this->dirs['incompleteDir']);
		$this->session->setSeedRatioLimit(0.5);
		$this->session->setIncompleteDirEnabled(true);
		$this->session->save();
	}
}