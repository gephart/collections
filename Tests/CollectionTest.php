<?php

use Gephart\Collections\Collection;
use Gephart\Collections\Exception\BadTypeException;

require_once __DIR__ . '/../vendor/autoload.php';


class CollectionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var Collection
     */
    private $collection_non_type;

    public function setUp()
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
        $was_exception = false;
        try {
            $this->collection->add(1);
        } catch (BadTypeException $exception) {
            $was_exception = true;
        }

        $this->assertTrue($was_exception);
    }

    public function testGet()
    {
        $item = new stdClass();
        $item->title = "Test";

        $this->collection->add($item);

        $gets_item = $this->collection->get(0);

        $this->assertEquals($gets_item->title, "Test");
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
}
