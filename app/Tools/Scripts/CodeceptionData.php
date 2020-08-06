<?php

namespace App\Tools\Scripts;

use App\Tools\Script;
use Lqd\Security\Authenticator;
use Nette\DI\Config\Loader;
use Storm\Connection;

class CodeceptionData extends Script
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
	public $loader;
	
	public function __construct(Connection $stm)
	{
		$this->loader = new Loader();
		$this->data = $this->loader->load(__DIR__ . '/../../../tests/acceptance/data.neon');
		$this->stm = $stm;
	}
	
	public function doAddSupervisor(): void
	{
		$account = $this->stm->getRepository(\Lqd\Security\DB\Account::class)->create();
		$account->uuid = $this->data['admin']['uuid'];
		$account->login = $this->data['admin']['login'];
		$account->password = Authenticator::setCredentialTreatment($this->data['admin']['password']);
		$account->active = 1;
		$account->setValue('fk_role', $this->data['admin']['fk_role']);
		$this->stm->getRepository(\Lqd\Security\DB\Account::class)->add($account);
		$supervisor = $this->stm->getRepository(\Lqd\Admin\DB\User::class)->create(['fk_account' => $account->getPK()]);
		$supervisor->fullname = $this->data['admin']['fullname'];
		$this->stm->getRepository(\Lqd\Admin\DB\User::class)->add($supervisor);
		$permission = $this->stm->getRepository(\Lqd\Security\DB\Permission::class)->create(['fk_role' => 'admin']);
		$permission->resource = ':Admin:Admin:Users';
		$permission->uuid = 'admin';
		$this->stm->getRepository(\Lqd\Security\DB\Permission::class)->add($permission);
		$this->write('Super user created');
	}
}
