<?php

use App\Models\ProductGroup;
include __DIR__ . '/bootstrap.php';

$group1 = ProductGroup::create(['name' => 'Group 1']);
ProductGroup::create(['name' => 'Group 2']);
ProductGroup::create(['name' => 'Group 3']);

$product = $group1->products()->create(['name' => 'Product 1', 'price' => 1000]);
$product = $group1->products()->create(['name' => 'Product 2', 'price' => 2000]);
$product = $group1->products()->create(['name' => 'Product 3', 'price' => 3000]);