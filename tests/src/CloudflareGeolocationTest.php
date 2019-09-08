<?php

declare(strict_types = 1);

namespace NathanDentzau\Tests\CloudflareGeolocation;

use NathanDentzau\CloudflareGeolocation\CloudflareGeolocation;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class CloudflareGeolocationTest extends TestCase
{
    protected $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->request = $this->createMock(Request::class);
        $this->request->headers = $this->createMock(ParameterBag::class);
    }

    /**
     * @dataProvider countryDataProvider
     */
    public function testGetCurrentContinent(
        ?string $ipCountry,
        string $countryCode,
        string $countryName,
        string $continentCode,
        string $continentName
    ): void {
        $this->request->headers
            ->expects($this->once())
            ->method('get')
            ->with(CloudflareGeolocation::HEADER_IP_COUNTRY)
            ->willReturn($ipCountry);

        $geolocation = new CloudflareGeolocation($this->request);
        $continent = $geolocation->getCurrentContinent();
        $this->assertEquals($continentCode, $continent->getCode());
        $this->assertEquals($continentName, $continent->getName());
    }

    /**
     * @dataProvider countryDataProvider
     */
    public function testGetCurrentCountry(
        ?string $ipCountry,
        string $countryCode,
        string $countryName
    ): void {
        $this->request->headers
            ->expects($this->once())
            ->method('get')
            ->with(CloudflareGeolocation::HEADER_IP_COUNTRY)
            ->willReturn($ipCountry);

        $geolocation = new CloudflareGeolocation($this->request);
        $country = $geolocation->getCurrentCountry();
        $this->assertEquals($countryCode, $country->getCode());
        $this->assertEquals($countryName, $country->getName());
    }

    public function countryDataProvider(): array
    {
        return [
            ['US', 'US', 'United States', 'NA', 'North America'],
            ['00', 'XX', 'Unknown/reserved', 'XX', 'Unknown/reserved'],
            [NULL, 'XX', 'Unknown/reserved', 'XX', 'Unknown/reserved'],
        ];
    }

    /**
     * @dataProvider connectingIpDataProvider
     */
    public function testGetConnectingIp(?string $connectingIp): void
    {
        $this->request->headers
            ->expects($this->once())
            ->method('get')
            ->with(CloudflareGeolocation::HEADER_CONNECTING_IP)
            ->willReturn($connectingIp);

        $geolocation = new CloudflareGeolocation($this->request);
        $this->assertEquals($connectingIp, $geolocation->getConnectingIp());
    }

    public function connectingIpDataProvider(): array {
        return [
            ['127.0.0.1'],
            [NULL],
        ];
    }
}
