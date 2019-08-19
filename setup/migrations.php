<?php
include __DIR__ . '/bootstrap.php';

use App\Models\ProductGroup;
use Illuminate\Database\Schema\Blueprint;

$schema = $capsule->schema('default');

// cleanup
$schema->dropAllTables();

$schema->create('product_groups', function(Blueprint $table) {
  // Auto-increment id
  $table->increments('id');
  $table->string('name');
  $table->timestamps();
});

$schema->create('products', function (Blueprint $table) {
  $table->increments('id');
  $table->integer('product_group_id');
  $table->string('name');
  $table->integer('price');
  $table->timestamps();
});

$schema->create('orders', function (Blueprint $table) {
  $table->increments('id');
  $table->integer('product_id');
  $table->integer('amount');
  $table->integer('total');
  $table->timestamps();
});
