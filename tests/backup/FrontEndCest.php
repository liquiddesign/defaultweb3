<?php

class FrontEndCest
{
	public function _before(AcceptanceTester $I)
	{
	
	}
	
	public function logoRedirect(AcceptanceTester $i): void
	{
		/*$i->amOnPage('/');
		$i->seeElement('.menu-logo');
		$i->click('.menu-logo');
		$i->seeInCurrentUrl('/');*/
	}
	
	public function contactForm(AcceptanceTester $i): void
	{
		/*$i->amOnPage('/kontakt');
		$i->see('Kontaktujte nás');
		$i->fillField('firstname', 'LQD Firma');
		$i->fillField('email', 'codeception@lqd.cz');
		$i->fillField('message', 'Pozdrav z kontaktního formuláře');
		$i->click('Odeslat');
		$i->see('Zpráva byla úspěšně odeslána');*/
	}
}
