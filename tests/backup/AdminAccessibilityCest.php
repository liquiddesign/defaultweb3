<?php

use Codeception\Util\HttpCode;
use Lqd\Security\Authenticator;

class AdminAccessibilityCest
{
	/**
	 * @var string
	 */
	private $pwd;
	
	/**
	 * @var string
	 */
	private $usr;
	
	/**
	 * @var \Nette\DI\Config\Loader
	 */
	private $loader;
	
	/**
	 * @var string []
	 */
	private $loadedModules;
	
	/**
	 * @var string []
	 */
	private $data;
	
	/**
	 * @var \Storm\Connection
	 */
	private $stm;
	
	public function _before(AcceptanceTester $i): void
	{
		$this->loader = new \Nette\DI\Config\Loader();
		$this->loadedModules = $this->loader->load(__DIR__ . '/../../app/config/config.custom.neon');
		// popremyslet
		$this->data = $this->loader->load(__DIR__ . '/data.neon');
		$i->adminLogin();
	}
	
	public function checkAdminRights(AcceptanceTester $i)
	{
	
	}
	
	public function checkMenu(AcceptanceTester $i): void
	{
		foreach ($this->loadedModules['modules'] as $k => $v) {
			if (\is_file(__DIR__ . '/../../vendor/lqdlib/' . $v . '/config.neon')) {
				$config = $this->loader->load(__DIR__ . '/../../vendor/lqdlib/' . $v . '/config.neon');
				
				if (\array_key_exists('admin', $config)) {
					foreach ($config['admin']['menu'] as $item) {
						$plink = \str_replace(':', '/', $item['plink']);
						$url = \preg_replace('/Admin/', '', $plink, 1);
						
						foreach ($item['items'] as $submenu) {
							$page = \strtolower('/admin' . \str_replace('//', '/', $url . $submenu['action']));
							$i->amOnPage($page);
							$i->seeResponseCodeIs(200);
							$i->seeElement('h3');
						}
					}
				}
			}
		}
	}
}
