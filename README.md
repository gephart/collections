Gephart Collections
===

[![php](https://github.com/gephart/collections/actions/workflows/php.yml/badge.svg?branch=master)](https://github.com/gephart/collections/actions)

Dependencies
---
 - PHP >= 7.4

Instalation
---

```bash
composer require gephart/collections dev-master
```

Using
---

### Collection without a specific type 

```php
$collection = new Gephart\Collections\Collection();

$collection->add("Something"); // Index - 0
$collection->add(123); // Index - 1

$item = $collection->get(1); // 123

$collection->remove(1); // Delete item with index 1

$items = $collection->all(); // [0 => "Something"];
```

### Collection with a specific type 

```php
class SpecificEntity { public $text = ""; }

$item1 = new SpecificEntity();
$item1->text = "first";

$item2 = new SpecificEntity();
$item2->text = "second";

$collection = new Gephart\Collections\Collection(SpecificEntity::class);

$collection->add($item1);
$collection->add($item2);
// Or use method collect(): $collection->collect([$item1, $item2]);

$item = $collection->get(1);
echo $item->text; // "second"
```