<?php

namespace App\Tools\Scripts;

use App\Tools\Script;
use Lqd\Blog\DB\Blog;
use Lqd\News\DB\News;
use Lqd\Pages\DB\Page;
use Lqd\Security\DB\Account;
use Lqd\Security\DB\Permission;
use Lqd\Users\DB\User;
use Lqd\Web\DB\Article;
use Lqd\Web\DB\MenuItem;
use Nette\DI\Config\Loader;
use Storm\Connection;
use Storm\Exception\NotFound;

class ClearTest extends Script
{
	/**
	 * @var \Storm\Connection
	 */
	private $stm;
	
	/**
	 * @var string[][]|string[][][]
	 */
	private $data;
	
	/**
	 * @var \Nette\DI\Config\Loader
	 */
	private $loader;
	
	public function __construct(Connection $stm)
	{
		$this->loader = new Loader();
		$this->data = $this->loader->load(__DIR__ . '/../../../tests/acceptance/data.neon');
		$this->stm = $stm;
	}
	
	public function doClearUsers(): void
	{
		$userAccount = $this->stm->getRepository(Account::class)->many()->where('login', $this->data['users']['login'])->first();
		$userUsers = $this->stm->getRepository(User::class)->many()->where('fk_account', $userAccount)->first();
		
		if ($userUsers) {
			$userUsers->account->delete();
			$userUsers->delete();
		}
		
		$this->write('Users: Odstraňuji testovací data.');
	}
	
	public function doClearArticles(): void
	{
		$menuItem = $this->stm->getRepository(MenuItem::class)->many()->where('name', $this->data['web']['name'])->first();
		
		if ($menuItem) {
			try {
				$page = $this->stm->getRepository(Page::class)->one($menuItem->getValue('fk_page'));
				$article = $this->stm->getRepository(Article::class)->many()->where('name', $this->data['web']['name'])->first();
				$menuItem->delete();
				$page->delete();
				$article->delete();
			} catch (NotFound $exception) {
			}
		}
		
		$menuItem = $this->stm->getRepository(MenuItem::class)->many()->where('name', $this->data['web']['secret']['name'])->first();
		
		if ($menuItem) {
			try {
				$page = $this->stm->getRepository(Page::class)->one($menuItem->getValue('fk_page'));
				$article = $this->stm->getRepository(Article::class)->many()->where('name', $this->data['web']['secret']['name'])->first();
				$menuItem->delete();
				$page->delete();
				$article->delete();
			} catch (NotFound $exception) {
			}
		}
		
		$this->write('Web: Odstraňuji testovací data.');
	}
	
	public function doClearBlog(): void
	{
		$post = $this->stm->getRepository(Blog::class)->many()->where('name', $this->data['blog']['name'])->first();
		$page = $this->stm->getRepository(Page::class)->many()->where('url', 'b/' . $this->data['blog']['url'])->first();
		
		if ($page) {
			$page->delete();
		}
		
		if ($post) {
			$post->delete();
		}
		
		$this->write('Blog: Odstraňuji testovací data.');
	}
	
	public function doClearSuperuser(): void
	{
		$account = $this->stm->getRepository(Account::class)->many()->where('login', 'codecept')->first();
		
		if ($account) {
			$user = $this->stm->getRepository(\Lqd\Admin\DB\User::class)->many()->where('fk_account', $account->uuid)->first();
			$user->delete();
			$account->delete();
		}
		
		try {
			$perm = $this->stm->getRepository(Permission::class)->one('admin');
			
			if ($perm) {
				$perm->delete();
			}
		} catch (NotFound $exception) {
		}
		
		$this->write('Admin: Odstraňuji testovací data.');
	}
	
	public function doClearNews(): void
	{
		$newsPage = $this->stm->getRepository(Page::class)->many()->where('url', 'n/' . $this->data['news']['url'])->first();
		$news = $this->stm->getRepository(News::class)->many()->where('name', $this->data['news']['name'])->first();
		
		if ($newsPage) {
			$news->delete();
			$newsPage->delete();
		}
		
		$this->write('News: Odstraňuji testovací data.');
	}
}
