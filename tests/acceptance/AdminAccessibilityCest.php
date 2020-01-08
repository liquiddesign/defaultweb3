<?php

use Codeception\Util\HttpCode;

class AdminAccessibilityCest
{
	private $pwd = '';
	
	public function _before(AcceptanceTester $i): void
	{
	
	}
	
	public function checkMenu(AcceptanceTester $i): void
	{
		$i->login('servis', $this->pwd);
		$load = new \Nette\DI\Config\Loader();
		$loadedModules = $load->load(__DIR__.'/../../app/config/config.custom.neon');
		
		foreach ($loadedModules['modules'] as $k => $v) {
			if (\is_file(__DIR__.'/../../vendor/lqdlib/'.$v.'/config.neon')) {
				$config = $load->load(__DIR__.'/../../vendor/lqdlib/'.$v.'/config.neon');
				
				if (\array_key_exists('admin', $config)) {
					foreach ($config['admin']['menu'] as $item) {
						$plink = \str_replace(':', '/', $item['plink']);
						$url = \preg_replace('/Admin/', '', $plink, 1);
						
						foreach ($item['items'] as $submenu) {
							$page = \strtolower('/admin' . \str_replace('//', '/', $url.$submenu['action']));
							$i->amOnPage($page);
							$i->seeResponseCodeIs(200);
						}
					}
				}
			}
		}
	}
	
	public function errorPage(AcceptanceTester $i): void
	{
		$i->amOnPage('/adfsdfsgfsfg');
		$i->seeResponseCodeIs(404);
	}
}
