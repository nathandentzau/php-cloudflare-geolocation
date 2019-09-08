<?php

declare(strict_types = 1);

namespace NathanDentzau\CloudflareGeolocation;

use Symfony\Component\HttpFoundation\Request;

/**
 * Provides a Cloudflare geolocation client.
 *
 * A static data.json file is located in the project root that contains country
 * and continent associations based on the country code provided by Cloudflare.
 */
class CloudflareGeolocation
{
    /**
     * The name of the Cloudflare Connecting IP header.
     */
    public const HEADER_CONNECTING_IP = 'HTTP_CF_CONNECTING_IP';

    /**
     * The name of the Cloudflare IP Country header.
     */
    public const HEADER_IP_COUNTRY = 'HTTP_CF_IPCOUNTRY';

    /**
     * The list of continents.
     *
     * @var \NathanDentzau\CloudflareGeolocation\Continent[]
     */
    protected $continents;

    /**
     * The http request.
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * A "static" cache of the current continent.
     *
     * @var \NathanDentzau\CloudflareGeolocation\Continent
     */
    private $currentContinent;

    /**
     * A "static" cache of the current country.
     *
     * @var \NathanDentzau\CloudflareGeolocation\Country
     */
    private $currentCountry;

    /**
     * Constructor for CloudflareGeolocation.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *   The http request.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->initialize();
    }

    /**
     * Get the user's current continent.
     *
     * @return \NathanDentzau\CloudflareGeolocation\Continent
     *   The current continent. If the user's country cannot be geolocated, a
     *   "fallback" continent is returned.
     */
    public function getCurrentContinent(): Continent
    {
        if (!$this->currentContinent) {
            $this->currentContinent = (function (): Continent {
                foreach ($this->continents as $continent) {
                    foreach ($continent->getCountries() as $country) {
                        if ($country->getCode() === $this->getCurrentCountry()->getCode()) {
                            return $continent;
                        }
                    }
                }

                return new Continent('XX', 'Unknown/reserved');
            })();
        }

        return $this->currentContinent;
    }

    /**
     * Get the user's current country.
     *
     * @return \NathanDentzau\CloudflareGeolocation\Country
     *   The current country. If the user's country cannot be geolocated, a
     *   "fallback" country is returned.
     */
    public function getCurrentCountry(): Country
    {
        if (!$this->currentCountry) {
            $this->currentCountry = (function (?string $countryCode): Country {
                foreach ($this->continents as $continent) {
                    foreach ($continent->getCountries() as $country) {
                        if ($country->getCode() === $countryCode) {
                            return $country;
                        }
                    }
                }

                return new Country('XX', 'Unknown/reserved');
            })($this->request->headers->get(self::HEADER_IP_COUNTRY));
        }

        return $this->currentCountry;
    }

    /**
     * Get the connecting IP address.
     *
     * @return string|null
     *   The connecting/real IP address from Cloudflare or NULL if the header
     *   is not set.
     */
    public function getConnectingIp(): ?string
    {
        return $this->request->headers->get(self::HEADER_CONNECTING_IP);
    }

    /**
     * Initialize the continent list.
     */
    protected function initialize(): void
    {
        $data = (function (): array {
            $data = file_get_contents(__DIR__ . '/../data.json');
            return json_decode($data, TRUE);
        })();

        foreach ($data as $continentCode => $continentData) {
            $continent = new Continent($continentCode, $continentData['name']);
            foreach ($continentData['countries'] as $code => $name) {
                $continent->addCountry(
                    new Country($code, $name)
                );
            }

            $this->continents[] = $continent;
        }
    }
}
