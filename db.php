<?php
if (PHP_SAPI != 'cli') {
  exit('em um terminal digite: php db.php');
}

require __DIR__ . '/vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
$dependencies = require __DIR__ . '/src/dependencies.php';
$container = $dependencies($app);

$db = $container->get('db');
$schema = $db->schema();

$table = 'produtos';
$schema->dropIfExists($table);
$schema->create($table, function($table)
{
  $table->increments('id');
  $table->string('titulo', 100);
  $table->text('descricao');
  $table->decimal('preco', 11, 2);
  $table->string('fabricante');
  $table->timestamps();
});

//insert data
require 'data.php';
foreach ($data as $product) {
  $db->table($table)->insert([$product]);
}