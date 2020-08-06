<?php 

class WebSettingsCest
{
	
    public function _before(AcceptanceTester $I, $settings, $test)
    {
			var_dump($test);
		die();
    }
	
	public function robotsTxt(AcceptanceTester $i): void
	{
		
		/*$i->amOnPage('/robots.txt');
		$i->seeResponseCodeIs(200);*/
	}

}
