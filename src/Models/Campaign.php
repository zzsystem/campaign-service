<?php

namespace CampaignService\Models;

/**
 * Class Campaign
 *
 * A model class representing a campaign.
 */
class Campaign
{
    /**
     * Campaign constructor.
     *
     * @param int $id The campaign ID
     * @param \DateTime $startDate The start date of the campaign
     * @param \DateTime $endDate The end date of the campaign
     * @param array $products The list of products associated with the campaign
     * @param array $blogPosts The list of blog posts associated with the campaign
     */
    public function __construct(
        private int $id,
        private \DateTime $startDate,
        private \DateTime $endDate,
        private array $products = [],
        private array $blogPosts = [],
    ) {
    }

    /**
     * Add a product to the campaign.
     *
     * @param Product $product The product to add
     * @return void
     */
    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    /**
     * Add a blog post to the campaign.
     *
     * @param BlogPost $blogPost The blog post to add
     * @return void
     */
    public function addBlogPost(BlogPost $blogPost): void
    {
        $this->blogPosts[] = $blogPost;
    }

    /**
     * Check if the campaign has any blog posts.
     *
     * @return bool Returns true if the campaign has blog posts, false otherwise
     */
    public function hasBlogPosts(): bool
    {
        return count($this->blogPosts) > 0;
    }

    /**
     * Check if the campaign has any products.
     *
     * @return bool Returns true if the campaign has products, false otherwise
     */
    public function hasProducts(): bool
    {
        return count($this->products) > 0;
    }
}