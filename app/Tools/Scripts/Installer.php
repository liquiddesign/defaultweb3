<?php

namespace App\Tools\Scripts;

use App\Tools\Script;
use Lqd\Userfiles\Userfiles;
use Nette\Neon\Neon;
use Storm\Connection;
use Storm\Migrator;

class Installer extends Script
{
	/**
	 * @var \Storm\Connection
	 */
	private $stm;
	
	/**
	 * @var \Lqd\Userfiles\Userfiles
	 */
	private $userfiles;
	
	/**
	 * @var string
	 */
	private $projectName = '';
	
	/**
	 * @var mixed[]|mixed[][]
	 */
	private $config = [];
	
	/**
	 * @var mixed[]|mixed[][]
	 */
	private $localConfig = [];
	
	/**
	 * @var string
	 */
	private $projectState = '';
	
	private const CONFIGDIR = 'app/config';
	
	public function __construct(Userfiles $userfiles)
	{
		$this->userfiles = $userfiles;
	}
	
	/**
	 * Login to database
	 * @throws \Nette\Application\ApplicationException
	 * return void
	 */
	public function doDatabaseLogin(): void
	{
		$this->projectName = $dbName = \basename($this->getBaseDir());
		
		$this->write('Liquid Design s.r.o. - Defaultweb3');
		$this->write('(v závorce konfigurací, uvidíte defaultní hodnotu - stačí dát jen enter)');
		
		$this->config = [
			'parameters' => [
				'langs' => [],
			],
			'modules' => [],
		];
		
		do {
			$pdoException = false;
			$user = $this->getIO()->ask("Zadejte uživatele databáze ('root'):", 'root');
			$password = $this->getIO()->ask("Zadejte heslo databáze (''):", '');
			$this->write("Zvolený název databáze dle adresáře: $dbName");
			$host = 'localhost';
			
			try {
				$this->stm = new Connection("mysql:host=$host;charset=utf8", $user, $password, [
					\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
				]);
			} catch (\PDOException $x) {
				$pdoException = true;
				$this->writeError('Nepodařilo se připojit k databázi.');
				
				if ($x->getCode() === 1045) {
					$this->getIO()->ask('Zadali jste špatné přihlašovací údaje. Pro nové zadání stiskněte Enter.');
				} else {
					$this->getIO()->ask('Zkontrolujte zda máte spuštěný server (např. WAMP). Po spuštění stiskněte Enter');
				}
			}
		} while ($pdoException);
		
		$this->localConfig = [
			'storm' => [
				'default' => [
					'host' => $host,
					'user' => $user,
					'password' => $password,
					'dbname' => $this->projectName,
				],
			],
		];
	}
	
	/**
	 * Create config
	 * @throws \Nette\Application\ApplicationException
	 * return void
	 */
	public function doCrateConfig(): void
	{
		$config = 'config.custom.neon';
		
		if (\is_file($this->getBaseDir() . '/' . self::CONFIGDIR . '/' . $config)) {
			$this->projectState = 'start';
			$this->write("Config $config již existuje. Přeskakuji konfiguraci.");
			
			return;
		} else {
			$this->projectState = 'create';
		}
		
		if ($this->getIO()->askConfirmation('Bude web vícejazyčný? (n)', false)) {
			$answer = $this->getIO()->ask('Napište jazyky (dvoupísmené) oddělené čárkou (cz,en):', 'cz,en');
			$this->config['parameters'] = ['langs' => \explode(',', $answer),];
		} else {
			$this->config['parameters'] = ['langs' => \explode(',', 'cz'),];
		}
		
		$debugPassword = $this->getIO()->ask("Zadejte heslo pro cookie nette-debug (''):", '');
		
		if ($debugPassword) {
			$this->config['parameters']['lqd_ip'] = $debugPassword . '@' . $this->config['parameters']['lqd_ip'];
		}
		
		$this->config['modules'][] = 'admin';
		$this->config['modules'][] = 'web';
		$this->config['modules'][] = 'email';
		
		
		/*if ($this->getIO()->askConfirmation("Povolit modul 'eshop'? (n)", false)) {
			$this->config['includes'][] = '../../vendor/lqdlib/eshop/config.neon';
			$this->config['modules'][] = 'eshop';
		}*/
		
		//if ($this->getIO()->askConfirmation("Povolit modul 'catalog'? (n)", false)) {
			$this->config['includes'][] = '../../vendor/lqdlib/catalog/config.neon';
			$this->config['modules'][] = 'catalog';
		//}
		
		if ($this->getIO()->askConfirmation("Povolit modul 'ankety'? (n)", false)) {
			$this->config['includes'][] = '../../vendor/lqdlib/poll/config.neon';
			$this->config['modules'][] = 'poll';
		}
		
		$this->config['modules'][] = 'news';
		$this->config['modules'][] = 'blog';
		$this->config['modules'][] = 'users';
		
		\file_put_contents($this->getBaseDir() . '/' . self::CONFIGDIR . '/' . $config, Neon::encode($this->config, Neon::BLOCK), Neon::BLOCK);
	}
	
	/**
	 * Create config
	 * return void
	 */
	public function doCrateLocalConfig(): void
	{
		$config = 'config.local.neon';
		
		if (\is_file($this->getBaseDir() . '/' . self::CONFIGDIR . '/' . $config)) {
			$this->write("Config $config již existuje. Přeskakuji konfiguraci.");
			
			return;
		}
		
		\file_put_contents($this->getBaseDir() . '/' . self::CONFIGDIR . '/' . $config, Neon::encode($this->localConfig, Neon::BLOCK), Neon::BLOCK);
	}
	
	/**
	 * Create database
	 * @throws \Storm\Exception\InvalidInput
	 * @throws \Nette\Application\ApplicationException
	 * return void
	 */
	public function doCreateDatabase(): void
	{
		$dbName = $this->projectName;
		
		try {
			$this->stm->useDatabase($dbName);
		} catch (\PDOException $x) {
			$this->stm->createDatabase($dbName);
			$this->stm->useDatabase($dbName);
		}
		
		if (!$this->stm->isDatabaseEmpty()) {
			$this->write("Databáze $dbName není prázdná. Přeskakuji import dat.");
			
			return;
		}
		
		$this->getContainer()->addService('storm.default', $this->stm);
		$migrator = $this->getContainer()->getByType(Migrator::class);
		
		if (isset($this->config['includes'])) {
			foreach ($this->config['includes'] as $include) {
				$aux = Neon::decode(\file_get_contents($this->getBaseDir() . '/' . self::CONFIGDIR . '/' . $include));
				
				if (!isset($aux['storm']['default']['migrator']['structure'])) {
					continue;
				}
				
				foreach ($aux['storm']['default']['migrator']['structure'] as $model) {
					$migrator->addModel($model);
				}
			}
		}
		
		if (isset($this->config['parameters']['langs'])) {
			$this->stm->setAvailableLangs($this->config['parameters']['langs']);
		}
		
		/* vytvářím projekt */
		if ($this->projectState === 'create') {
			$answer = $this->getIO()->select('Zvolte způsob vytvoření databáze: (0)', [
				0 => 'Automaticky vytvořit strukturu databáze a importovat základní data',
				1 => 'Nevytvářet strukturu databáze (vytvořím si sám)',
			], '0');
			
			if ($answer === '0') {
				$this->write('Vytvářím strukturu databáze');
				/* create DB structure */
				$this->stm->query($migrator->getSyncString($this->getContainer()->parameters['composer']->getPrefixesPsr4()));
				$this->write('Importuji základní data');
				/** @var \App\Tools\Scripts\SyncData $script */
				$script = $this->getScript(SyncData::class, []);
				$script->doSyncData();
				$this->write('Struktura vytvořena a základní data importována');
			} else {
				$this->getIO()->ask('Proveďte import databáze (potom stiskněte Enter)');
			}
		} else { /* přebírám projekt */
			$answer = $this->getIO()->select('Zvolte způsob nahrání databáze: (0)', [
				0 => 'Importovat databázi ručně',
				1 => 'Importovat automaticky ze souboru nebo URL',
			], '0');
			
			if ($answer === '0') {
				$this->getIO()->ask("Vytvořte databázi $dbName Proveďte import databáze (potom stiskněte Enter)");
			} else {
				$argument = $this->getIO()->ask('Zajdete soubor k importu nebo doménu pro SQL dump (prázdné=vypíše seznam)');
				/** @var \App\Tools\Scripts\ImportDatabase $script */
				$script = $this->getScript(ImportDatabase::class, [$argument]);
				$script->doImportDatabase();
			}
		}
	}
	
	public function doCreateDirectories(): void
	{
		$this->userfiles->createDirectories($this->getBaseDir());
	}
	
	public function doCopyGithook(): void
	{
		\copy($this->getBaseDir() . '/temp/installer/pre-commit', $this->getBaseDir() . '/.git/hooks/pre-commit');
	}
	
	public function doCreateCodeceptConfig(): void
	{
		$host = $this->projectName;
		$basicConfig = <<<EOF
# Codeception Test Suite Configuration
#
# Suite for acceptance tests.
# Perform tests in browser using the WebDriver or PhpBrowser.
# If you need both WebDriver and PHPBrowser tests - create a separate suite.

actor: AcceptanceTester
modules:
    enabled:
        - PhpBrowser:
            url: http://{$this->localConfig['storm']['default']['host']}/{$host}
        - \Helper\Acceptance
        - Db:
            dsn: 'mysql:host={$this->localConfig['storm']['default']['host']};dbname={$host}'
            user: '{$this->localConfig['storm']['default']['user']}'
            password: '{$this->localConfig['storm']['default']['password']}'
    step_decorators: ~
EOF;
		
		\file_put_contents($this->getBaseDir() . '/tests/acceptance.suite.yml', $basicConfig);
	}
}
