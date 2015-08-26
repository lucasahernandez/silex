<?php
require_once __DIR__.'/../../vendor/autoload.php';

$app = new Silex\Application();
// production environment - false; test environment - true
$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
	'host'      => 'localhost',
        'dbname'    => 'moderator',
        'user'      => 'root',
	'password'  => 'S7g4r',
    ),
    'db.dbal.class_path'    => __DIR__.'/../../vendor/doctrine-dbal/lib',
    'db.common.class_path'  => __DIR__.'/../../vendor/doctrine-common/lib',
));

$app->get('/', function () use ($app) {
  $sql = "SELECT id,user,customer,context,timestamp FROM Moderator ORDER by timestamp LIMIT 100";
  $moderator = $app['db']->fetchAll($sql);
  return json_encode($moderator);
});

$app->get('/{id}', function ($id) use ($app) {
  $sql = "SELECT id, user,customer,context,timestamp FROM Moderator WHERE id = ? ORDER BY timestamp";
  $mod = $app['db']->fetchAssoc($sql, array((int) $id));
  return json_encode($mod);
})->assert('id', '\d+');

$app->get('/{date_from}/{date_to}', function ($date_from,$date_to) use ($app) {
if($date_from<$date_to){
$sql = "SELECT id, user,customer,context,timestamp FROM Moderator WHERE timestamp BETWEEN STR_TO_DATE('{$date_from}', '%Y-%m-%d') AND STR_TO_DATE('{$date_to}', '%Y-%m-%d') ORDER BY timestamp";
}
if($date_from==$date_to){
$sql = "SELECT id, user,customer,context,timestamp FROM Moderator WHERE timestamp LIKE '".$date_from."%' ORDER BY timestamp";
}
$mode = $app['db']->fetchAll($sql);
return json_encode($mode);
});

$app->run();
?>
