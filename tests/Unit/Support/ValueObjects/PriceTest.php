<?php

namespace Tests\Unit\Support\ValueObjects;


use PHPUnit\Framework\TestCase;
use Support\ValueObjects\Price;

class PriceTest extends TestCase
{
    public function test_it_all(): void
    {
        $price = Price::make(10000);

        $this->assertInstanceOf(Price::class, $price);
        $this->assertEquals(100, $price->value());
        $this->assertEquals(10000, $price->raw());
        $this->assertEquals('RUB', $price->currency());
        $this->assertEquals('₽', $price->symbol());
        $this->assertEquals('100,00 ₽', $price);

        $this->expectException(\InvalidArgumentException::class);

        Price::make(-10000);
        Price::make(10000, 'not support currency');
    }
}
