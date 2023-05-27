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

    /**
     * Check if the campaign includes any weekend days.
     *
     * @return bool Returns true if the campaign includes weekend days, false otherwise
     */
    public function includesWeekend(): bool
    {
        return $this->startDate->diff($this->endDate)->format('%a') + $this->startDate->format('w') > 6;
    }

    /**
     * Get the start date of the campaign.
     *
     * @return \DateTime The start date of the campaign
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * Get the end date of the campaign.
     *
     * @return \DateTime The end date of the campaign
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * Get the IDs of the products associated with the campaign.
     *
     * @return array The list of product IDs
     */
    public function getProductIds(): array
    {
        return array_map(fn(Product $product) => $product->getId(), $this->products);
    }

    /**
     * Get the IDs of the blog posts associated with the campaign.
     *
     * @return array The list of blog post IDs
     */
    public function getBlogPostIds(): array
    {
        return array_map(fn(BlogPost $blogPost) => $blogPost->getId(), $this->blogPosts);
    }

    /**
     * Check if the campaign has any overlapping elements with another campaign.
     *
     * @param Campaign $otherCampaign The other campaign to check against
     * @return bool Returns true if there are any overlapping elements, false otherwise
     */
    public function hasOverlappingElements(Campaign $otherCampaign): bool
    {
        $sharedProducts = array_intersect($this->getProductIds(), $otherCampaign->getProductIds());
        $sharedBlogPosts = array_intersect($this->getBlogPostIds(), $otherCampaign->getBlogPostIds());

        return !empty($sharedProducts) || !empty($sharedBlogPosts);
    }
}