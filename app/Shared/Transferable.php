<?php

namespace App\Shared;

use App\Enums\Category;
use App\Models\Customer;
use App\Models\Order;

class Transferable
{

    /**
     */
    public function __construct(
        private readonly mixed $data,
        private readonly ?Category $category = null,
        private readonly ?Customer $customer = null,
        private readonly ?Order $order = null,
        private readonly mixed $certificate = null,
    ) {
    }

    public static function make(
        mixed $data,
        Category $category = null,
        Customer $customer = null,
        Order $order = null,
        mixed $certificate = null,
    ): Transferable {
        return new self($data, $category, $customer, $order, $certificate);
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
    public function getCustomer(): Customer
    {
        return $this->customer;
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
