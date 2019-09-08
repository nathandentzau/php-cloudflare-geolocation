<?php

declare(strict_types = 1);

namespace NathanDentzau\CloudflareGeolocation;

/**
 * Provides an object representing a continent.
 */
class Continent
{
    /**
     * The continent two character code.
     *
     * @var string
     */
    protected $code;

    /**
     * The continent name
     *
     * @var string
     */
    protected $name;

    /**
     * The list of countries in the continent.
     *
     * @var \NathanDentzau\CloudflareGeolocation\Country[]
     */
    protected $countries;

    /**
     * Contructor for Contient.
     *
     * @param string $code
     *   The continent two character code.
     * @param string $name
     *   The continent name.
     * @param \NathanDentzau\CloudflareGeolocation\Country[] $countries
     *   The list of countries in the continent.
     */
    public function __construct(string $code, string $name, array $countries = [])
    {
        $this->code = $code;
        $this->name = $name;
        $this->countries = $countries;
    }

    /**
     * Get the continent code.
     *
     * @return string
     *   The continent two character code.
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Set the continent code.
     *
     * @param string $code
     *   The continent two character code.
     *
     * @return self
     *   Returns itself for a fluid interface.
     */
    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get the continent name.
     *
     * @return string
     *   The continent name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the continent name.
     *
     * @param string $name
     *   The continent name.
     *
     * @return self
     *   Returns itself for a fluid interface.
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the continent's countries.
     *
     * @return \NathanDentzau\CloudflareGeolocation\Country[]
     *   The list of countries in the continent.
     */
    public function getCountries(): array
    {
        return $this->countries;
    }

    /**
     * Add a country to the continent.
     *
     * @param \NathanDentzau\CloudflareGeolocation\Country $country
     *   The country.
     *
     * @return self
     *   Returns itself for a fluid interface.
     */
    public function addCountry(Country $country): self
    {
        $this->countries[] = $country;
        return $this;
    }

    /**
     * Set the countries.
     *
     * @param \NathanDentzau\CloudflareGeolocation\Country[] $countries
     *   The list of countries in the continent.
     *
     * @return self
     *   Returns itself for a fluid interface.
     */
    public function setCountries(array $countries): self
    {
        if (empty($countries)) {
            $this->countries = [];
            return $this;
        }

        foreach ($countries as $country) {
            $this->addCountry($country);
        }

        return $this;
    }
}
