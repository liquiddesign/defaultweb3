<?php

namespace App\Tools\Renderer;

use Lqd\CMS\Paging\Renderer\IRenderer;

class Pagination implements IRenderer
{
	/**
	 * @var string[]
	 */
	public $wrappers = [
		'container' => 'ul class="mt-2 pagination"',
		'link' => 'a class="page-link"',
		'item' => 'li class="page-item"',
		'.active' => 'active',
		'separator' => 'li class="page-item"',
		'separator_text' => '...',
		'prev' => 'a class="page-link"',
		'prev_text' => 'Předchozí',
		'next' => 'a class="page-link"',
		'next_text' => 'Další',
	];
	
	/**
	 * Pagination constructor.
	 * @param string[]|null $wrappers
	 */
	public function __construct(?array $wrappers = null)
	{
		$this->wrappers = $wrappers ?? $this->wrappers;
		
		return;
	}
	
	/**
	 * @return string[]|null
	 */
	public function getWrappers(): array
	{
		return $this->wrappers;
	}
}
