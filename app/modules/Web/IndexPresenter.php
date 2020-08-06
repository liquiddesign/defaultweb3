<?php

namespace App\Web;

use App\PresenterTrait;
use Lqd\Web\DB\Article;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Presenter;
use Storm\Exception\NotFound;

class IndexPresenter extends Presenter
{
	use PresenterTrait;
	
	public function startup(): void
	{
		//$this->autoCanonicalize = false;
		parent::startup();
	}
	
	/**
	 * @var \Lqd\Web\DB\TextboxRepository
	 * @inject
	 */
	public $textboxRepo;

	
	/**
	 * @throws \Nette\Application\BadRequestException
	 */
	public function actionDefault(): void
	{
		try {
			$this->template->article = $this->stm->getRepository(Article::class)->one('home');
			$this->template->tabTextbox = $this->textboxRepo->one(['id' => '9yhv']);
			$this->template->galleryTextbox = $this->textboxRepo->one(['id' => '0q09']);
			$this->template->sliderTextbox = $this->textboxRepo->one(['id' => 'ojqq']);
		} catch (NotFound $exception) {
			throw new BadRequestException('Article "home" or any textbox "9yhv","0q09","ojqq" not found.');
		}
	}
	
	public function actionTypo(): void
	{
	}
}
