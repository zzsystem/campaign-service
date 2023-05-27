<?php

namespace CampaignService\Models;

/**
 * Class Product
 *
 * A model class representing a product.
 */
class Product
{
    /**
     * Product constructor.
     *
     * @param int $id The product ID
     * @param string $name The name of the product
     */
    public function __construct(
        private int $id,
        private string $name,
    ) {
    }

    /**
     * Get the ID of the product.
     *
     * @return int The product ID
     */
    public function getId() {
        return $this->id;
    }
}