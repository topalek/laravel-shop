<?php

namespace Support\ValueObjects;


use InvalidArgumentException;
use Tests\TestCase;

class PriceTest extends TestCase
{
    public function test_all()
    {
        $price = Price::make(10000);

        $this->assertInstanceOf(Price::class, $price);
        $this->assertEquals(100, $price->value());
        $this->assertEquals(10000, $price->raw());
        $this->assertEquals('RUB', $price->currency());
        $this->assertEquals('₽', $price->symbol());
        $this->assertEquals('100,00 ₽', $price);

        $this->expectException(InvalidArgumentException::class);

        Price::make(-10000);
        Price::make(10000, 'USD');
    }

}
