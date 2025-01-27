<?php
/**
 * @OA\Schema(
 *     title="Customer",
 *     description="Customer model",
 *     @OA\Property(
 *         property="firstname",
 *         type="string",
 *         description="First name of the customer"
 *     ),
 *     @OA\Property(
 *         property="lastname",
 *         type="string",
 *         description="Last name of the customer"
 *     ),
 *     @OA\Property(
 *         property="dateOfBirth",
 *         type="string",
 *         format="date",
 *         description="Date of birth of the customer (YYYY-MM-DD)"
 *     ),
 *     @OA\Property(
 *         property="PrefixphoneNumber",
 *         type="enum",
 *         description="Prefix phone number of the customer"
 *     ),
 *     @OA\Property(
 *         property="phoneNumber",
 *         type="unsignedBigInt",
 *         description="Phone number of the customer without prefix"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email address of the customer"
 *     ),
 *     @OA\Property(
 *         property="bankAccountNumber",
 *         type="string",
 *         description="Bank account number of the customer"
 *     )
 * )
 */
namespace App\Models\Entities;

use App\Models\Enums\CustomerPrefixPhoneNumberEnum;
use Database\Factories\CustomerFactory;
use Eghamat24\DatabaseRepository\Models\Entity\Entity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Entity
{
    use HasFactory;

    protected int $id;

    protected string $firstName;

    protected string $lastName;

    protected string $dateOfBirth;

    protected CustomerPrefixPhoneNumberEnum $prefixPhoneNumber;

    protected int $phoneNumber;

    protected null|string $email = null;

    protected null|string $bankAccountNumber = null;

    protected null|string $createdAt = null;

    protected null|string $updatedAt = null;
    protected string $fullPhoneNumber;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CustomerFactory::new();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getDateOfBirth(): string
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(string $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getEmail(): null|string
    {
        return $this->email;
    }

    public function setEmail(null|string $email): void
    {
        $this->email = $email;
    }

    public function getBankAccountNumber(): null|string
    {
        return $this->bankAccountNumber;
    }

    public function setBankAccountNumber(null|string $bankAccountNumber): void
    {
        $this->bankAccountNumber = $bankAccountNumber;
    }

    public function getCreatedAt(): null|string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(null|string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): null|string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(null|string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getFullPhoneNumber(): string
    {
        return $this->getPrefixPhoneNumber()->value . $this->getPhoneNumber();
    }

    public function setFullPhoneNumber(string $fullPhoneNumber): void
    {
        $this->fullPhoneNumber = $fullPhoneNumber;
    }

    public function getPrefixPhoneNumber(): CustomerPrefixPhoneNumberEnum
    {
        return $this->prefixPhoneNumber;
    }

    public function setPrefixPhoneNumber(CustomerPrefixPhoneNumberEnum $prefixPhoneNumber): void
    {
        $this->prefixPhoneNumber = $prefixPhoneNumber;
    }

    public function getPhoneNumber(): int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }
}
