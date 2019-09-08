<?php

declare(strict_types = 1);

namespace NathanDentzau\Tests\CloudflareGeolocation;

use NathanDentzau\CloudflareGeolocation\Continent;
use NathanDentzau\CloudflareGeolocation\Country;
use PHPUnit\Framework\TestCase;

class ContinentTest extends TestCase
{
    protected $continent;

    public function setUp(): void
    {
        parent::setUp();

        $this->continent = new Continent('TE', 'test');
    }
    public function testCodeMethods(): void
    {
        $this->continent->setCode('AA');
        $this->assertEquals('AA', $this->continent->getCode());
    }

    public function testNameMethods(): void
    {
        $this->continent->setName("King's Landing");
        $this->assertEquals("King's Landing", $this->continent->getName());
    }

    public function testCountriesMethods(): void
    {
        $this->continent->setCountries([new Country('BA', 'Braavos')]);
        $this->assertCount(1, $this->continent->getCountries());
        $this->assertEquals('BA', $this->continent->getCountries()[0]->getCode());

        $this->continent->addCountry(new Country('DO', 'Dorne'));
        $this->assertCount(2, $this->continent->getCountries());
        $this->assertEquals('DO', $this->continent->getCountries()[1]->getCode());

        $this->continent->setCountries([]);
        $this->assertEmpty($this->continent->getCountries());
    }
}
