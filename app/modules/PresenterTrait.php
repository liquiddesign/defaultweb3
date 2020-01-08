<?php

namespace App;

use Lqd\Catalog\DB\Category;
use Lqd\Web\Control\Carousel;
use Lqd\Email\Control\ContactForm;
use Lqd\Modules\PresenterTrait as ModulePresenterTrait;
use Lqd\Pages\PresenterTrait as PagesPresenterTrait;
use Lqd\Poll\Control\Poll;
use Lqd\Translator\PresenterTrait as TranslatorPresenterTrait;
use Lqd\Web\Control\Breadcrumb;
use Lqd\Web\Control\Factory\Testimonial;
use Lqd\Web\Control\Faq;
use Lqd\Web\Control\Gallery;
use Lqd\Web\Control\Map;
use Lqd\Web\Control\Menu;
use Lqd\Web\Control\Tab;
use Lqd\Web\Control\Textboxes;
use Lqd\Web\Control\Video;
use Lqd\Web\DB\Textbox;

trait PresenterTrait
{
	use ModulePresenterTrait;
	use TranslatorPresenterTrait {
		TranslatorPresenterTrait::startup as protected translatorStartup;
		TranslatorPresenterTrait::beforeRender as protected translatorBeforeRender;
	}
	use PagesPresenterTrait {
		PagesPresenterTrait::beforeRender as protected pagesBeforeRender;
	}
	
	/**
	 * Storm
	 * @inject
	 * @var \Storm\Connection
	 */
	public $stm;
	
	/**
	 * @var int
	 */
	public $numberOfMapWidgets = 0;
	
	/**
	 * @var bool
	 */
	public $showProducers = false;
	
	public function startup(): void
	{
		parent::startup();
		
		\Lqd\Common\Filters::$currency = $this->context->parameters['currency'];
		\Lqd\Common\Filters::$currency_locale = $this->context->parameters['currency_locale'];
		
		$this->translatorStartup();
	}
	
	public function beforeRender(): void
	{
		$this->pagesBeforeRender();
		$this->translatorBeforeRender();
		
		$httpRequest = $this->getHttpRequest();
		$uri = $httpRequest->getUrl();
		$this->template->noindex = false;
		
		foreach ($this->context->parameters['noindex'] as $url) {
			if (\strrpos($uri->host, $url) !== false) {
				$this->template->noindex = true;
				
				break;
			}
		}
		
		$this->template->wwwUrl = $this->context->parameters['wwwUrl'];
		$this->template->pubUrl = $this->context->parameters['pubUrl'];
		$this->template->nodeUrl = $this->template->pubUrl . '/node_modules';
		$this->template->userUrl = $this->context->parameters['userUrl'];
		$this->template->ts = $this->context->parameters['ts'];
		$this->template->settings = $this->stm->getRepository(\Lqd\Web\DB\Settings::class)->many()->first();
		$this->template->langs = $this->translator->getAvailableLanguages();
		$this->template->footer = $this->stm->getRepository(Textbox::class)->one(['id' => 'w4vk']);
		$this->template->productCategories = $this->stm->getRepository(Category::class)->many()->where('hidden', false)->orderBy(['priority']);
		$this->template->showProducers = $this->showProducers = isset($this->context->parameters['showProducers']) ? $this->context->parameters['showProducers'] : false;
		
		return;
	}
	
	public function createComponentMenu(): Menu
	{
		return $this->context->getByType(\Lqd\Web\Control\Factory\Menu::class)->create('main');
	}
	
	public function createComponentVideo(): Video
	{
		return $this->context->getByType(\Lqd\Web\Control\Factory\Video::class)->create();
	}
	
	public function createComponentTabs(): Tab
	{
		return $this->context->getByType(\Lqd\Web\Control\Factory\Tab::class)->create();
	}
	
	public function createComponentGallery(): Gallery
	{
		return $this->context->getByType(\Lqd\Web\Control\Factory\Gallery::class)->create();
	}
	
	public function createComponentMaps(): Map
	{
		return $this->context->getByType(\Lqd\Web\Control\Factory\Map::class)->create();
	}
	
	public function createComponentCarousel(): Carousel
	{
		return $this->context->getByType(\Lqd\Web\Control\Factory\Carousel::class)->create();
	}
	
	public function createComponentContactForm(): ContactForm
	{
		return $this->context->getByType(\Lqd\Email\Control\Factory\IContactForm::class)->create();
	}
	
	public function createComponentTextboxes(): Textboxes
	{
		return $this->context->getByType(\Lqd\Web\Control\Factory\Textboxes::class)->create();
	}
	
	public function createComponentSliderControl(): \Lqd\Web\Control\Slider
	{
		return $this->context->getByType(\Lqd\Web\Control\Factory\Slider::class)->create();
	}
	
	public function createComponentBreadcrumb(): Breadcrumb
	{
		$factory = $this->context->getByType(\Lqd\Web\Control\Factory\Breadcrumb::class);
		$breadcrumb = $factory->create();
		$breadcrumb->setSkipLastLink(true);
		
		$breadcrumb->addLevel('Úvod', $this->link(':Web:Index:default'));
		
		return $breadcrumb;
	}
	
	public function createComponentFaq(): Faq
	{
		return $this->context->getByType(\Lqd\Web\Control\Factory\Faq::class)->create();
	}
	
	public function createComponentTestimonial(): \Lqd\Web\Control\Testimonial
	{
		return $this->context->getByType(Testimonial::class)->create();
	}
	
	public function createComponentPoll(): Poll
	{
		return $this->context->getByType(\Lqd\Poll\Control\Factory\Poll::class)->create();
	}
}
