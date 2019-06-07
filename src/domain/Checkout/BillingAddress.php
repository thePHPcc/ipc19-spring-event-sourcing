<?php declare(strict_types=1);

namespace Eventsourcing\Checkout;
class BillingAddress
{
    /**
     * @var string
     */
    private $firstname;
    /**
     * @var string
     */
    private $lastname;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $addressLine;
    /**
     * @var string
     */
    private $zip;
    /**
     * @var string
     */
    private $city;
    /**
     * @var string
     */
    private $country;

    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        string $addressLine,
        string $zip,
        string $city,
        string $country
    )
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->addressLine = $addressLine;
        $this->zip = $zip;
        $this->city = $city;
        $this->country = $country;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddressLine(): string
    {
        return $this->addressLine;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
