Gephart Collections
===

[![Build Status](https://travis-ci.org/gephart/collections.svg?branch=master)](https://travis-ci.org/gephart/collections)

Dependencies
---
 - PHP >= 7.1

Instalation
---

```bash
composer require gephart/collections dev-master
```

Using
---

### Collection without a specific type 

```
$collection = new Gephart\Collections\Collection();

$collection->add("Something"); // Index - 0
$collection->add(123); // Index - 1

$item = $collection->get(1); // 123

$collection->remove(1); // Delete item with index 1

$items = $collection->all(); // [0 => "Something"];
```

### Collection with a specific type 

```
class SpecificEntity { public $text = ""; }

$item1 = new SpecificEntity();
$item1->text = "first";

$item2 = new SpecificEntity();
$item2->text = "second";

$collection = new Gephart\Collections\Collection(SpecificEntity::class);

$collection->add($item1);
$collection->add($item2);
// Or use method collect(): $collection->collect([$item1, $item2]);

$item = $collection->get(1); // 123
echo $item->text; // "second"
```