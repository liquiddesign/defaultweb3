<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use PHPUnit\Framework\AssertionFailedError;

class Acceptance extends \Codeception\Module
{
	/**
	 * @var array
	 */
	private $loadedModules;
	
	public function isProduction(): bool
	{
		if (\is_file(__DIR__.'/../../../app/config/config.local.neon')) {
			return false;
		}
		
		return true;
	}
	
	public function hasPage(string $url): bool
	{
		try {
			$this->getModule('Db')->seeInDatabase('pages_page', [
				'plink' => $url,
			]);
		} catch (AssertionFailedError $f) {
			return false;
		}
		
		return true;
	}
	
}
