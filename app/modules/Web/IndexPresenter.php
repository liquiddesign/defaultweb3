<?php

namespace App\Web;

use App\PresenterTrait;
use Lqd\Web\DB\Article;
use Nette\Application\UI\Presenter;

class IndexPresenter extends Presenter
{
	use PresenterTrait;
	
	/**
	 * @var \Lqd\Web\DB\TextboxRepository
	 * @inject
	 */
	public $textboxRepo;
	
	public function actionDetail(): void
	{
	}
	
	public function actionDefault(): void
	{
		$this->template->article = $this->stm->getRepository(Article::class)->one('home');
		$this->template->tabTextbox = $this->textboxRepo->one(['id' => '9yhv']);
		$this->template->galleryTextbox = $this->textboxRepo->one(['id' => '0q09']);
		$this->template->sliderTextbox = $this->textboxRepo->one(['id' => 'ojqq']);
	}
	
	public function actionTypo(): void
	{
	}
}