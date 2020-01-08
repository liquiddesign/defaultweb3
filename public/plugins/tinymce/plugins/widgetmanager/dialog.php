<!doctype html>
<html lang="cs">
<head>
	<?php
	$rootPath = '../../../../../';
	?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo $rootPath; ?>/public/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $rootPath; ?>/public/admin/css/admin.css">
    <script src="../../../../node_modules/jquery/dist/jquery.min.js"></script>
    <script>
        function insertAndClose(widget) {
            top.tinymce.activeEditor.insertContent(widget);
            top.tinymce.activeEditor.windowManager.close();
        }

    </script>
    <script src="../../../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <title>Widget manager</title>
</head>
<body>
<style>
    .widget-module {
        color: #888;
        display: block;
        font-size: 16px;
        padding: 8px 0;
        border-right: 2px solid #eee;
    }

    .widget-module.active {
        color: #0064CF;
        border-color: #007bff;
    }

    .widget-module:hover {
        color: #0064CF;
        text-transform: none;
        text-decoration: none;
    }

    .module-heading {
        font-size: 18px;
        font-weight: 900;
    }

    .button-add {
        color: white;
        display: block;
        background-color: #007bff;
        font-size: 12px;
        padding: 6px 10px;
    }

    .button-add:hover {
        color: white;
        background-color: #0064CF;
    }
</style>
<?php

use App\Custom\IndexPresenter;
use Nette\Application\UI\Presenter;
use Nette\DI\Config\Loader;

require_once($rootPath . 'vendor/nette/utils/src/Utils/SmartObject.php');
require_once($rootPath . 'vendor/nette/utils/src/Utils/exceptions.php');
require_once($rootPath . 'vendor/nette/utils/src/Utils/StaticClass.php');
require_once($rootPath . 'vendor/nette/utils/src/Utils/Arrays.php');
require_once($rootPath . 'vendor/nette/utils/src/Utils/Validators.php');

require_once($rootPath . 'vendor/nette/di/src/DI/Config/IAdapter.php');
require_once($rootPath . 'vendor/nette/di/src/DI/Config/Helpers.php');
require_once($rootPath . 'vendor/nette/di/src/DI/Statement.php');
require_once($rootPath . 'vendor/nette/neon/src/Neon/Entity.php');
require_once($rootPath . 'vendor/nette/neon/src/Neon/Decoder.php');
require_once($rootPath . 'vendor/nette/neon/src/Neon/Neon.php');
require_once($rootPath . 'vendor/nette/di/src/DI/Config/Adapters/NeonAdapter.php');
require_once($rootPath . 'vendor/nette/di/src/DI/Config/Loader.php');

require_once($rootPath . 'vendor/nette/application/src/Application/Helpers.php');
require_once($rootPath . 'vendor/nette/component-model/src/ComponentModel/IComponent.php');
require_once($rootPath . 'vendor/nette/component-model/src/ComponentModel/Component.php');
require_once($rootPath . 'vendor/nette/component-model/src/ComponentModel/IContainer.php');
require_once($rootPath . 'vendor/nette/component-model/src/ComponentModel/Container.php');
require_once($rootPath . 'vendor/nette/application/src/Application/UI/ISignalReceiver.php');
require_once($rootPath . 'vendor/nette/application/src/Application/UI/IStatePersistent.php');
require_once($rootPath . 'vendor/nette/application/src/Application/UI/IRenderable.php');
require_once($rootPath . 'vendor/nette/application/src/Application/IPresenter.php');

require_once($rootPath . 'vendor/nette/application/src/Application/UI/Component.php');
require_once($rootPath . 'vendor/nette/application/src/Application/UI/Control.php');
require_once($rootPath . 'vendor/nette/application/src/Application/UI/Presenter.php');
//require_once($rootPath . 'app/modules/Web/IndexPresenter.php');

if (\is_file('../../../../../app/config/config.production.neon')) {
	$config = '../../../../../app/config/config.production.neon';
} else {
	if (\is_file('../../../../../app/config/config.local.neon')) {
		$config = '../../../../../app/config/config.local.neon';
	}
}
$host = $_SERVER['SERVER_NAME'];
$url = '';
if ($host === 'localhost') {
	$url = $host . '/defaultweb3';
} else {
	$url = $host;
}
$loader = new Loader();
$configContent = $loader->load($config);

// Připojovací údaje
define('SQL_HOST', 'localhost');
define('SQL_DBNAME', $configContent['storm']['default']['dbname']);
define('SQL_USERNAME', $configContent['storm']['default']['user']);
define('SQL_PASSWORD', $configContent['storm']['default']['password']);

$dsn = 'mysql:dbname=' . SQL_DBNAME . ';host=' . SQL_HOST . ';charset=utf8';
$user = SQL_USERNAME;
$password = SQL_PASSWORD;


try {
	$pdo = new PDO($dsn, $user, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	die('Connection failed: ' . $e->getMessage());
}

$widget = $loader->load('widget.config.neon');

?>
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-4">
            <div class="module-heading">Moduly</div>
        </div>
        <div class="col-8">
            <div class="module-heading">Widgety modulu</div>
        </div>
        <div class="col-12">
            <hr>
        </div>
        <div class="col-4">
            <div class="nav flex-column lqd-menu" id="v-pills-tab" role="tablist" aria-orientation="vertical">
				<?php
				$i = 1;
				foreach ($widget['widget'] as $w) {
					$class = $i == 1 ? 'widget-module active' : 'widget-module';
					$ariaSelected = $i == 1 ? 'true' : 'false';
					echo '<a class="'.$class.'" id="v-pills-'. $w['label'].'-tab" data-toggle="pill" href="#v-pills-'. $w['label'].'" role="tab" aria-controls="v-pills-'. $w['label'].'" aria-selected="'.$ariaSelected.'">'. $w['label'] .'</a>';
					$i++;
				}
				
				// We are able to add custom Controls by adding "modules" in config file
				if (isset($widget['control'])) {
					echo '<a class="widget-module" id="v-pills-system-tab" data-toggle="pill" href="#v-pills-system" role="tab" aria-controls="v-pills-system" aria-selected="false">Systém</a>';
				}
				?>
            </div>
        </div>
        <div class="col-8">
            <div class="tab-content" id="v-pills-tabContent">
				<?php
				$k = 1;
				
				//Pro kadý widget v configu se vytvoří tab-pane z bootstrapu
				foreach ($widget['widget'] as $w){
					$showPane = $k == 1 ? 'true' : 'false';
					$classPane = $k == 1 ? 'tab-pane fade active show' : 'tab-pane fade';
					?>
                    <div class="<?php echo $classPane ?>" id="v-pills-<?php echo $w['label']; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $w['label']; ?>-tab">
                        <div class="list-group">
							<?php
							$i = 1;
							$dotaz = $pdo->query('SELECT id, name FROM '. $w['tableName'].'');
							$count = $dotaz->rowCount();
							if($count != 0){
								foreach ($dotaz as $d) {
									?>

                                    <div class="list-group-item list-group-item-action d-flex align-items-center justify-content-between"><?php echo $d['name']; ?> <button type="submit" class="btn button-add rounded ml-auto" onclick="insertAndClose('[widget]<?php echo $w['link']; ?>=<?php echo $d['id']; ?>[/widget]')">Přidat</button></div>
									<?php
								}
							}
							else {
								?>
                                <p class="text-center">Nejsou žádné položky pro daný widget.</p>
								<?php
							}
							//Výpis všech položek pro konkrétní widget
							?>
                        </div>
                    </div>
					<?php
					$k++;
				}
				
				?>

                <div class="tab-pane fade" id="v-pills-system" role="tabpanel" aria-labelledby="v-pills-system-tab">
					<?php if (isset($widget['control'])) { ?>
                        <div class="list-group">
							<?php foreach ($widget['control'] as $key => $w) { ?>
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center justify-content-between">
										<?php echo $w['name']; ?>
                                        <button type="submit" onclick="insertAndClose('[widget]<?php echo $w['link']; ?>[/widget]')" class=" btn button-add rounded ml-auto">Přidat</button>
                                    </div>
                                    <small><?php if(isset($w['anchor'])){?>
                                            <a href="http://<?php echo $url; echo $w['anchor']; ?>" target="_blank"> <?php echo $w['link-name']; ?></a>
										<?php } ?></small>
                                </div>
							
							<?php } ?>
                        </div>
					<?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>