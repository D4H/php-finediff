<?php

namespace FineDiff\Tests\Granularity;

use ArrayAccess;
use FineDiff\Delimiters;
use FineDiff\Granularity\Character;
use FineDiff\Granularity\GranularityInterface;
use PHPUnit\Framework\TestCase;

class CharacterTest extends TestCase
{
    /**
     * @var GranularityInterface
     */
    protected $granularity;

    /**
     * @var array
     */
    protected $delimiters = [
        Delimiters::PARAGRAPH,
        Delimiters::SENTENCE,
        Delimiters::WORD,
        Delimiters::CHARACTER,
    ];

    public function setUp(): void
    {
        $this->granularity = new Character();
    }

    public function testExtendsAndImplements()
    {
        $this->assertInstanceOf(GranularityInterface::class, $this->granularity);
    }

    public function testGetDelimiters()
    {
        $this->assertEquals($this->granularity->getDelimiters(), $this->delimiters);
    }

    public function testSetDelimiters()
    {
        $arr = array('one', 'two');
        $this->granularity->setDelimiters($arr);
        $this->assertEquals($this->granularity->getDelimiters(), $arr);
    }

    public function testCountable()
    {
        $this->assertCount(count($this->granularity), $this->delimiters);
    }

    public function testArrayAccess()
    {
        // Exists
        for ($i = 0; $i < count($this->delimiters) + 1; $i++) {

            if ($i !== count($this->delimiters)) {
                $this->assertTrue(isset($this->granularity[$i]));
            } else {
                $this->assertFalse(isset($this->granularity[$i]));
            }
        }

        // Get
        for ($i = 0; $i < count($this->delimiters) + 1; $i++) {

            if ($i !== count($this->delimiters)) {
                $this->assertEquals($this->granularity[$i], $this->delimiters[$i]);
            } else {
                $this->assertNull($this->granularity[$i]);
            }
        }

        // Set
        for ($i = 0; $i < count($this->delimiters) + 1; $i++) {

            $rand = mt_rand(0, 1000);

            $this->granularity[$i] = $rand;
            $this->assertEquals($this->granularity[$i], $rand);
        }

        $this->assertEquals(count($this->granularity), count($this->delimiters) + 1);

        // Unset
        unset($this->granularity[ count($this->delimiters) ]);
        $this->assertCount(count($this->granularity), $this->delimiters);
    }
}
