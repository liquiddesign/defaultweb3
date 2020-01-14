<?php

class PagesCest
{
    public function _before(AcceptanceTester $I)
	{
	
	}
	
	public function error404(AcceptanceTester $i): void
	{
		$i->amOnPage('/shadiuahdsjkansd');
		
		if (!$i->isProduction()) {
			$i->seeResponseCodeIs(500);
		} else {
			$i->seeResponseCodeIs(404);
		}
	}
}
