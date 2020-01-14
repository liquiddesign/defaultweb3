<?php

class UsersCest
{
	/**
	 * @var \Nette\DI\Config\Loader
	 */
	private $loader;
	
	/**
	 * @var string[]
	 */
	private $data;
	
	public function _before(AcceptanceTester $I)
	{
		$this->loader = new \Nette\DI\Config\Loader();
		$this->data = $this->loader->load(__DIR__.'/data.neon');
	}
	
	/**
	 * Registration with wrong email
	 * @param \AcceptanceTester $i
	 */
	public function registrationFormWrongEmail(AcceptanceTester $i): void
	{
		if ($i->hasPage('Users:Users:registration')) {
			$i->amOnPage('/registrace');
			$i->submitForm('#frm-registration', array(
				'account[login]' => $this->data['users']['wrongLogin'],
				'account[password]' => $this->data['users']['password'],
				'account[password2]' => $this->data['users']['password'],
				'firstname' => $this->data['users']['firstname'],
				'lastname' => $this->data['users']['lastname'],
			));
			$i->dontSee('Účet úspěšně zaregistrován');
			$i->dontSeeInDatabase('users_user', [
				'firstname' => $this->data['users']['firstname'],
			]);
			$i->dontSeeInDatabase('security_account', [
				'login' => $this->data['users']['login'],
			]);
		}
	}
	
	/**
	 * Success registration
	 * @param \AcceptanceTester $i
	 */
	public function registrationFormSuccess(AcceptanceTester $i): void
	{
		if ($i->hasPage('Users:Users:registration')) {
			$i->amOnPage('/registrace');
			$i->submitForm('#frm-registration', array(
				'account[login]' => $this->data['users']['login'],
				'account[password]' => $this->data['users']['password'],
				'account[password2]' => $this->data['users']['password'],
				'firstname' => $this->data['users']['firstname'],
				'lastname' => $this->data['users']['lastname'],
			));
			$i->see('Účet úspěšně zaregistrován');
			$i->seeInDatabase('users_user', [
				'firstname' => $this->data['users']['firstname'],
			]);
			$i->seeInDatabase('security_account', [
				'login' => $this->data['users']['login'],
			]);
		}
	}
	
	/**
	 * Empty login form
	 * @param \AcceptanceTester $i
	 */
	public function loginFormEmpty(AcceptanceTester $i): void
	{
		if ($i->hasPage('Users:Users:login')) {
			$i->amOnPage('/prihlaseni');
			$i->submitForm('#frm-loginForm', array(
				'login' => '',
				'password' => '',
			));
			
			//Po úspěšném přihlášení je defaultně redirect na profil page
			$i->dontSee($this->data['users']['firstname'] . ' ' . $this->data['users']['lastname']);
		}
	}
	
	/**
	 * Check if acc is active
	 * @param \AcceptanceTester $i
	 */
	public function loginFormActive(AcceptanceTester $i): void
	{
		if ($i->hasPage('Users:Users:login')) {
			$i->amOnPage('/prihlaseni');
			$i->fillField('login', $this->data['users']['login']);
			$i->fillField('password', $this->data['users']['password']);
			$i->click('_submit');
			$i->dontSee('Odhlásit');
		}
	}
	
	/**
	 * Login form success
	 * @param \AcceptanceTester $i
	 */
	public function loginFormSuccess(AcceptanceTester $i): void
	{
		if ($i->hasPage('Users:Users:login')) {
			$i->updateInDatabase('security_account', [
				'active' => 1,
			], [
				'login' => $this->data['users']['login'],
			]);
			$i->amOnPage('/prihlaseni');
			$i->fillField('login', $this->data['users']['login']);
			$i->fillField('password', $this->data['users']['password']);
			$i->click('_submit');
			$i->see('Odhlásit');
		}
	}
	
	/**
	 * Edit user
	 * @param \AcceptanceTester $i
	 */
	public function adminEditUser(AcceptanceTester $i): void
	{
		$i->amOnPage('/admin/users/users/user');
		
		if ($i->hasPage('Users:Users:login')) {
			$i->amOnPage('/admin');
			$i->adminLogin();
			$i->amOnPage('/admin/users/users/user');
			$i->see($this->data['users']['login']);
			$i->click('Upravit');
			$i->see('Uživatel:');
			$i->seeInField('firstname', $this->data['users']['firstname']);
			$i->seeCheckboxIsChecked('#frm-form-active');
		}
	}
}