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

	public $host           = null;

	public $port           = null;

	public $path           = null;

	public $clientOptions  = [
		'username' => 'transmission',
		'password' => 'transmission',
	];

	public $sessionOptions = [];

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
		$this->client->authenticate($this->clientOptions['username'], $this->clientOptions['password']);
		$this->transmission->setClient($this->client);
		$this->setSessionOptions();
	}

	private function setSessionOptions() {
		if (!isset($this->sessionOptions['uploadSpeedLimitEnabled'])) {
			$this->sessionOptions['uploadSpeedLimitEnabled'] = false;
		}
		if (!isset($this->sessionOptions['downloadSpeedLimitEnabled'])) {
			$this->sessionOptions['downloadSpeedLimitEnabled'] = false;
		}
		if (!isset($this->sessionOptions['downloadDir'])) {
			$this->sessionOptions['downloadDir'] = \Yii::getAlias('@app/web/uploads/torrent/completed');
		}
		if (!isset($this->sessionOptions['incompleteDir'])) {
			$this->sessionOptions['incompleteDir'] = \Yii::getAlias('@app/web/uploads/torrent/incomplete');
		}
		if (!file_exists($this->sessionOptions['downloadDir'])) {
			mkdir($this->sessionOptions['downloadDir'], 0777, true);
		}
		if (!file_exists($this->sessionOptions['incompleteDir'])) {
			mkdir($this->sessionOptions['incompleteDir'], 0777, true);
		}
		$this->session = $this->transmission->getSession();
		$this->session->setDownloadDir($this->sessionOptions['downloadDir']);
		$this->session->setIncompleteDir($this->sessionOptions['incompleteDir']);
		$this->session->setIncompleteDirEnabled(true);
		$this->session->setUploadSpeedLimitEnabled($this->sessionOptions['uploadSpeedLimitEnabled']);
		if ($this->session->isUploadSpeedLimitEnabled()) {
			$this->session->setUploadSpeedLimit($this->sessionOptions['uploadSpeedLimit']);
		}
		$this->session->setDownloadSpeedLimitEnabled($this->sessionOptions['downloadSpeedLimitEnabled']);
		if ($this->session->isDownloadSpeedLimitEnabled()) {
			$this->session->setDownloadSpeedLimit($this->sessionOptions['downloadSpeedLimit']);
		}
		$this->session->save();
	}
}