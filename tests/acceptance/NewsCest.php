<?php

class NewsCest
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
		$this->data = $this->loader->load(__DIR__.'/data.neon');
		$i->adminLogin();
	}
	
	public function createNews(AcceptanceTester $i): void
	{
		$i->amOnPage('/admin/news/news/news');
		$i->click('Přidat novinku');
		$i->see('Nový záznam');
		$i->fillField('name[cz]', $this->data['news']['name']);
		$i->fillField('text[cz]', $this->data['news']['text']);
		$i->fillField('page[url][cz]', $this->data['news']['url']);
		$i->click('Uložit');
		$i->amOnPage('/novinky');
		$i->click($this->data['news']['name']);
		$i->seeInCurrentUrl('/n/'. $this->data['news']['url']);
		$i->see($this->data['news']['text']);
		
	}
	
	public function editNews(AcceptanceTester $i): void
	{
		$i->amOnPage('/admin/news/news/news');
		$i->click('Upravit');
		$i->see('Novinka:');
	}
}