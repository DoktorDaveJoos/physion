<?php

namespace App\Shared;

use App\Enums\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;

readonly class Transferable
{

    /**
     */
    public function __construct(
        private mixed $data,
        private ?Category $category = null,
        private ?Customer $customer = null,
        private ?User $user = null,
        private ?Order $order = null,
        private mixed $certificate = null,
    ) {
    }

    public static function make(
        mixed $data,
        Category $category = null,
        Customer $customer = null,
        User $user =null,
        Order $order = null,
        mixed $certificate = null,
    ): Transferable {
        return new self($data, $category, $customer, $user, $order, $certificate);
    }

    public static function fromData(mixed $data): Transferable
    {
        return self::make($data);
    }

    public static function fromCategory(mixed $data, Category $category): Transferable
    {
        return self::make($data, $category);
    }

    public static function fromCustomer(mixed $data, Category $category, Customer $customer): Transferable
    {
        return self::make($data, $category, $customer);
    }

    public static function fromUser(mixed $data, Category $category, User $user): Transferable
    {
        return self::make($data, $category, null, $user);
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer ?? null;
    }

    public function getUser(): ?User
    {
        return $this->user ?? null;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @return mixed
     */
    public function getCertificate(): mixed
    {
        return $this->certificate;
    }

}
