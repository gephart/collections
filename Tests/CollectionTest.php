<?php

use Gephart\Collections\Collection;
use Gephart\Collections\Exception\InvalidTypeException;

require_once __DIR__ . '/../vendor/autoload.php';


class CollectionTest extends \PHPUnit\Framework\TestCase
{
    private Collection $collection;

    private Collection $collection_non_type;

    public function setUp(): void
    {
        $this->collection = new Collection(stdClass::class);
        $this->collection_non_type = new Collection();
    }

    public function testNonTypeCollection()
    {
        $this->collection_non_type->add(1);
        $this->collection_non_type->add("test");

        $this->assertEquals(count($this->collection_non_type), 2);
    }

    public function testAdd()
    {
        $this->collection->add(new stdClass());
        $this->collection->add(new stdClass());

        $this->assertEquals(count($this->collection), 2);
    }

    public function testAddBadException()
    {
        $wasException = false;
        try {
            $this->collection->add(1);
        } catch (InvalidTypeException $exception) {
            $wasException = true;
        }

        $this->assertTrue($wasException);
    }

    public function testGet()
    {
        $item = new stdClass();
        $item->title = "Test";

        $this->collection->add($item);

        $getsItem = $this->collection->get(0);

        $this->assertEquals($getsItem->title, "Test");
    }

    public function testAll()
    {
        $this->collection->collect([new stdClass(), new stdClass()]);

        $items = $this->collection->all();

        $this->assertEquals(count($items), 2);
    }

    public function testCollect()
    {
        $this->collection->collect([new stdClass(), new stdClass()]);

        $this->assertEquals(count($this->collection), 2);
    }

    public function testRemove()
    {
        $this->collection->collect([new stdClass(), new stdClass()]);
        $this->collection->remove(1);

        $this->assertEquals(count($this->collection), 1);
    }

    public function testMap()
    {
        [$left, $right] = $this->collection_non_type
            ->collect(["a", "b"])
            ->map(function (string $item) {
                return $item . "c";
            })
            ->all();

        $this->assertEquals($left, "ac");
        $this->assertEquals($right, "bc");
    }

    public function testFilter()
    {
        $count = $this->collection_non_type
            ->collect(["a", "b"])
            ->filter(function (string $item) {
                return $item === "b";
            })
            ->count();

        $this->assertEquals($count, 1);
    }

    public function testSort()
    {
        $items = $this->collection_non_type
            ->collect(["c", "a", "b"])
            ->sort(function (string $a, string $b) {
                return $a < $b;
            })
            ->all();

        $this->assertEquals($items, ["c", "b", "a"]);
    }

    public function testEach()
    {
        $count = 0;

        $this->collection_non_type
            ->collect(["a", "b"])
            ->each(function (string $item, int $key) use (&$count) {
                if ($key == 0) {
                    $this->assertEquals($item, "a");
                    $count++;
                } elseif ($key == 1) {
                    $this->assertEquals($item, "b");
                    $count++;
                }
                return true;
            });

        $this->assertEquals($count, 2);
    }

    public function testEachBreak()
    {
        $count = 0;

        $this->collection_non_type
            ->collect(["a", "b"])
            ->each(function(string $item, int $key) use (&$count) {
                $count++;

                if ($item == "a") {
                    return false;
                }
                return true;
            });

        $this->assertEquals($count, 1);
    }
}
