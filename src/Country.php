<?php

declare(strict_types = 1);

namespace NathanDentzau\CloudflareGeolocation;

/**
 * Provides an object presenting a country.
 */
class Country
{
    /**
     * The two character country code.
     *
     * @var string
     */
    protected $code;

    /**
     * The country name.
     *
     * @var string
     */
    protected $name;

    /**
     * Constructor for Country.
     *
     * @param string $code
     *   The two character country code.
     * @param string $name
     *   The country name.
     */
    public function __construct(string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * Get the country code.
     *
     * @return string
     *   The two character country code.
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Set the country code.
     *
     * @param string $code
     *   The two character country code.
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
     * Get the country name.
     *
     * @return string
     *   The country name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the country name.
     *
     * @param string $name
     *   The country name.
     *
     * @return self
     *   Returns itself for a fluid interface.
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
