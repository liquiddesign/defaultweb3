<?php

class MainContentCest
{
	/**
	 * @var \Nette\DI\Config\Loader
	 */
	private $loader;
	
	/**
	 * @var string[]
	 */
	private $data;
	
	public function _before(AcceptanceTester $i)
	{
		$this->loader = new \Nette\DI\Config\Loader();
		$this->data = $this->loader->load(__DIR__ . '/data.neon');
		$i->adminLogin();
	}
	
	public function createArticle(AcceptanceTester $i): void
	{
		/*$i->amOnPage('/admin/web/web/menu');
		$i->click('Přidat položku menu');
		$i->see('Nová položka menu');
		$i->fillField('name[cz]', $this->data['web']['name']);
		$i->fillField('page[url][cz]', $this->data['web']['url']);
		$i->click('Uložit');
		$i->amOnPage('/' . $this->data['web']['url']);
		$i->see($this->data['web']['name']);*/
	}
	
	public function createSecretArticle(AcceptanceTester $i): void
	{
		/*$i->amOnPage('/admin/web/web/menu');
		$i->click('Přidat položku menu');
		$i->see('Nová položka menu');
		$i->fillField('name[cz]', $this->data['web']['secret']['name']);
		$i->fillField('page[url][cz]', $this->data['web']['secret']['url']);
		$i->fillField('article_password', $this->data['web']['secret']['password']);
		$i->click('Uložit');
		$i->amOnPage('/' . $this->data['web']['secret']['url']);
		$i->see('Tato stránka je chráněna heslem');
		$i->fillField('article_password', $this->data['web']['secret']['password']);
		$i->click('Odemknout');*/
		//TODO: obsah je obnoven ajaxem...
	}
	
	public function editMainContent(AcceptanceTester $i): void
	{
		/*$i->amOnPage('/admin/web/web/menu');
		$i->click('Upravit');
		$i->see('Položka menu:');*/
	}
}