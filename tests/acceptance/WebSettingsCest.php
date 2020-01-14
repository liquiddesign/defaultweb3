<?php 

class WebSettingsCest
{
    public function _before(AcceptanceTester $I)
    {
    }
	
	public function robotsTxt(AcceptanceTester $i): void
	{
		$i->amOnPage('/robots.txt');
		$i->seeResponseCodeIs(200);
	}
}
