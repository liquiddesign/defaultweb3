<?php

namespace App\Tools\Scripts;

use App\Tools\Script;
use Storm\Migrator;

class SyncData extends Script
{
	/**
	 * @var \Storm\Migrator
	 */
	private $migrator;
	
	public function __construct(Migrator $migrator)
	{
		$this->migrator = $migrator;
	}
	
	/**
	 * @throws \Nette\Application\ApplicationException
	 */
	public function doSyncData(): void
	{
		/** @var \App\Tools\Scripts\ClearCache $script */
		$script = $this->getScript(ClearCache::class, []);
		$script->doClearCache();
		
		foreach ($this->migrator->getDataPaths($this->getBaseDir()) as $dataPath) {
			if (!\file_exists($dataPath)) {
				continue;
			}
			
			$extension = \pathinfo($dataPath, \PATHINFO_EXTENSION);
			
			if ($extension === 'sql') {
				if ($this->getIO()->askConfirmation("Chcete nahrát SQL soubor $dataPath? (y)")) {
					$this->migrator->loadDataSql($dataPath);
					$this->write("... SQL soubor ($dataPath) byl načten.");
				} else {
					$this->write("... SQL soubor ($dataPath') byl přeskočen.");
				}
			} elseif ($extension === 'json') {
				$this->write("... JSON soubor ($dataPath) byl načten.");
				
				try {
					$this->migrator->loadDataJson($dataPath);
				} catch (\Throwable $exception) {
					$this->writeError('JSON se nepodařilo načíst');
				}
			}
		}
	}
}
