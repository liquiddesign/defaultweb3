<?php

namespace App\Tools\Scripts;

use App\Tools\Script;
use Lqd\Blog\DB\Blog;
use Lqd\News\DB\News;
use Lqd\Pages\DB\Page;
use Lqd\Security\Authenticator;
use Lqd\Security\DB\Account;
use Lqd\Security\DB\Permission;
use Lqd\Users\DB\User;
use Lqd\Web\DB\Article;
use Lqd\Web\DB\MenuItem;
use Nette\DI\Config\Loader;
use Storm\Connection;

class ClearTest extends Script
{
	/**
	 * @var \Storm\Connection
	 */
	private $stm;
	
	/**
	 * @var string[]
	 */
	private $data;
	
	private $loader;
	
	public function __construct(Connection $stm)
	{
		$this->loader = new Loader();
		$this->data = $this->loader->load(__DIR__ .'/../../../tests/acceptance/data.neon');
		$this->stm = $stm;
	}
	
	public function doClearUsers(): void
	{
		$userAccount = $this->stm->getRepository(Account::class)->many()->where('login', $this->data['users']['login'])->fetch();
		$userUsers = $this->stm->getRepository(User::class)->many()->where('fk_account', $userAccount)->fetch();
		
		if ($userUsers) {
			$userUsers->account->delete();
			$userUsers->delete();
		}
		
		$this->write('Users: Odstraňuji testovací data.');
	}
	
	public function doClearArticles(): void
	{
		$menuItem = $this->stm->getRepository(MenuItem::class)->many()->where('name', $this->data['web']['name'])->fetch();
		
		if ($menuItem) {
			$page = $this->stm->getRepository(Page::class)->one($menuItem->fk_page);
			$article = $this->stm->getRepository(Article::class)->many()->where('name', $this->data['web']['name'])->fetch();
			$menuItem->delete();
			$page->delete();
			$article->delete();
		}
		
		$menuItem = $this->stm->getRepository(MenuItem::class)->many()->where('name', $this->data['web']['secret']['name'])->fetch();
		
		if ($menuItem) {
			$page = $this->stm->getRepository(Page::class)->one($menuItem->fk_page);
			$article = $this->stm->getRepository(Article::class)->many()->where('name', $this->data['web']['secret']['name'])->fetch();
			$menuItem->delete();
			$page->delete();
			$article->delete();
		}
		
		$this->write('Web: Odstraňuji testovací data.');
	}
	
	public function doClearBlog(): void
	{
		$post = $this->stm->getRepository(Blog::class)->many()->where('name', $this->data['blog']['name'])->fetch();
		$page = $this->stm->getRepository(Page::class)->many()->where('url', 'b/'. $this->data['blog']['url'])->fetch();
		
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
		$account = $this->stm->getRepository(Account::class)->many()->where('login', 'codecept')->fetch();
		
		if ($account) {
			$user = $this->stm->getRepository(\Lqd\Admin\DB\User::class)->many()->where('fk_account', $account->uuid)->fetch();
			$user->delete();
			$account->delete();
		}
		
		$perm = $this->stm->getRepository(Permission::class)->one('admin');
		
		if ($perm) {
			$perm->delete();
		}
		
		$this->write('Admin: Odstraňuji testovací data.');
	}
	
	public function doClearNews(): void
	{
		$newsPage = $this->stm->getRepository(Page::class)->many()->where('url', 'n/' . $this->data['news']['url'])->fetch();
		$news = $this->stm->getRepository(News::class)->many()->where('name', $this->data['news']['name'])->fetch();
		
		
		if ($newsPage) {
			$news->delete();
			$newsPage->delete();
		}
		$this->write('News: Odstraňuji testovací data.');
	}
}
