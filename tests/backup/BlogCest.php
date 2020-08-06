<?php

class BlogCest
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
	
	public function createBlogPost(AcceptanceTester $i): void
	{
		$i->amOnPage('/');
		//$aLinks = $i->grabMultiple('a', 'href');
		
		var_dump($aLinks);
		
		/*$i->amOnPage('/admin/blog/blog/blog');
		$i->click('Přidat článek');
		$i->see('Nový článek');
		$i->fillField('name[cz]', $this->data['blog']['name']);
		$i->fillField('text[cz]', $this->data['blog']['text']);
		$i->fillField('page[url][cz]', $this->data['blog']['url']);
		$i->click('Uložit');
		$i->amOnPage('/b/' . $this->data['blog']['url']);
		$i->see($this->data['blog']['text']);*/
	}
	
	public function createBlogSection(AcceptanceTester $i): void
	{
		/*$i->amOnPage('/admin/blog/blog/section');
		$i->see('Rubriky');*/
	}
	
	public function editBlogPost(AcceptanceTester $i): void
	{
		/*$i->amOnPage('/admin/blog/blog/blog');
		$i->click('Upravit');
		$i->see('Článek:');*/
	}
}