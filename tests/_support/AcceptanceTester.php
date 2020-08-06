<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

   /**
    * Define custom actions here
    */
	
	/**
	 * @var \Nette\DI\Config\Loader
	 */
   private $loader;
	
	/**
	 * @var string []
	 */
   private $data;
   
   public function __construct(\Codeception\Scenario $scenario)
   {
   		parent::__construct($scenario);
   		
   		$this->loader = new \Nette\DI\Config\Loader();
   		$this->data = $this->loader->load(__DIR__. '/../acceptance/data.neon');
   }
	
	
	public function login($name, $password)
	{
		/*$i = $this;
		$i->amOnPage('/admin');
		$i->submitForm('#frm-loginForm', [
			'login' => $name,
			'password' => $password,
		]);
		$i->seeElement('.admin-menu');*/
	}
	
	public function adminLogin(): void
	{
	/*	$i = $this;
		$i->amOnPage('/admin');
		$i->submitForm('#frm-loginForm', [
			'login' => $this->data['admin']['login'],
			'password' => $this->data['admin']['password'],
		]);
		$i->seeElement('.admin-menu');*/
	}
}
