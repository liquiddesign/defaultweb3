<?php

class WidgetCest
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
	
	public function textBoxWidget(AcceptanceTester $i): void
	{
		/*$i->amOnPage('/admin/web/web/textboxes');
		$i->see('Textové boxy');
		$i->click('Přidat textbox');
		$i->see('Nový textový box');
		$i->amOnPage('/admin/web/web/textboxes');
		$i->click('Upravit');
		$i->see('Textový box:');*/
	}
	
	public function sliderWidget(AcceptanceTester $i): void
	{
		/*$i->amOnPage('/admin/web/web/slider');
		$i->see('Obrázky v slideru');
		$i->click('Přidat obrázek');
		$i->see('NOVÝ SLIDER OBRÁZEK');
		$i->amOnPage('/admin/web/web/slider');
		
		try {
			$i->see('Upravit');
			$i->click('Upravit');
			$i->see('Úprava obrázku');
		} catch (Throwable $e) {
			$i->dontSee('Upravit');
		}*/
	}
	
	public function carouselWidget(AcceptanceTester $i): void
	{
		/*$i->amOnPage('/admin/web/web/carousel');
		$i->see('Přehled carouselů');
		$i->click('Přidat carousel');
		$i->see('Nový carousel');
		$i->amOnPage('/admin/web/web/carousel');
		
		try {
			$i->see('Upravit');
			$i->click('Upravit');
			$i->see('Carousel:');
		} catch (Throwable $e) {
			$i->dontSee('Upravit');
		}*/
	}
	
	public function galerieWidget(AcceptanceTester $i): void
	{
		/*$i->amOnPage('/admin/web/web/galleries');
		$i->see('Přehled galerii');
		$i->click('Přidat galerii');
		$i->see('Nová galerie');
		$i->amOnPage('/admin/web/web/galleries');
		
		try {
			$i->see('Upravit');
			$i->click('Upravit');
			$i->see('Galerie:');
		} catch (Throwable $e) {
			$i->dontSee('Upravit');
		}
		
		try {
			$i->see('Obrázky');
			$i->click('Obrázky');
			$i->see('Obrázky galerie');
		} catch (Throwable $e) {
			$i->dontSee('Obrázky');
		}*/
	}
	
	public function mapyWidget(AcceptanceTester $i): void
	{
	
	}
	
	public function tabyWidget(AcceptanceTester $i): void
	{
	
	}
	
}
