<?php

declare(strict_types = 1);

namespace NathanDentzau\Tests\CloudflareGeolocation;

use NathanDentzau\CloudflareGeolocation\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    protected $country;

    public function setUp(): void
    {
        parent::setUp();

        $this->country = new Country('TE', 'Test');
    }

    public function testCodeMethods(): void
    {
        $this->country->setCode('WE');
        $this->assertEquals('WE', $this->country->getCode());
    }

    public function testNameMethods(): void
    {
        $this->country->setName('Westeros');
        $this->assertEquals('Westeros', $this->country->getName());
    }
}
