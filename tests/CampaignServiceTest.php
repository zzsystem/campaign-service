<?php

use PHPUnit\Framework\TestCase;
use CampaignService\CampaignService;
use CampaignService\Models\Campaign;
use CampaignService\Models\Product;
use CampaignService\Models\BlogPost;

class CampaignServiceTest extends TestCase
{
    /**
     * Test case for when there are no blog posts and products for one campaign.
     */
    public function testNoBlogPostsAndProducts_OneCampaign()
    {
        // Arrange
        $campaign = new Campaign(1, new DateTime('2023-06-01'), new DateTime('2023-06-30'));
        $service = new CampaignService([$campaign]);

        // Act
        $service->run();

        // Assert
        $startedCampaigns = $this->getNonPublicProperty($service, 'startedCampaigns');
        $this->assertCount(1, $startedCampaigns);
    }

    /**
     * Test case for a weekend campaign with a blog post and a weekday campaign with a product.
     */
    public function testWeekendCampaignWithBlogPost_WeekdayCampaignWithProduct()
    {
        // Arrange
        $weekendCampaign = new Campaign(1, new DateTime('2023-06-02'), new DateTime('2023-06-04'));
        $weekdayCampaign = new Campaign(2, new DateTime('2023-06-05'), new DateTime('2023-06-06'));

        $blogPost = new BlogPost(1, 'Blog Post');
        $product = new Product(1, 'Product');

        $weekendCampaign->addBlogPost($blogPost);
        $weekdayCampaign->addProduct($product);

        $service = new CampaignService([$weekendCampaign, $weekdayCampaign]);

        // Act
        $service->run();

        // Assert
        $startedCampaigns = $this->getNonPublicProperty($service, 'startedCampaigns');
        $this->assertCount(1, $startedCampaigns);
        $this->assertNotContains($weekendCampaign, $startedCampaigns);
        $this->assertContains($weekdayCampaign, $startedCampaigns);
    }

    /**
     * Test case for multiple campaigns with overlap.
     */
    public function testMultipleCampaignsWithOverlap()
    {
        // Arrange
        $campaign1 = new Campaign(1, new DateTime('2023-06-01'), new DateTime('2023-06-30'));
        $campaign2 = new Campaign(2, new DateTime('2023-06-15'), new DateTime('2023-07-15'));
        $campaign3 = new Campaign(3, new DateTime('2023-06-26'), new DateTime('2023-06-30'));

        $product = new Product(1, 'Product');
        $blogPost = new BlogPost(1, 'Blog Post');

        $campaign1->addProduct($product);
        $campaign2->addProduct($product);
        $campaign3->addBlogPost($blogPost);

        $service = new CampaignService([$campaign1, $campaign2, $campaign3]);

        // Act
        $service->run();

        // Assert
        $startedCampaigns = $this->getNonPublicProperty($service, 'startedCampaigns');
        $this->assertCount(2, $startedCampaigns);
        $this->assertContains($campaign1, $startedCampaigns);
        $this->assertNotContains($campaign2, $startedCampaigns);
        $this->assertContains($campaign3, $startedCampaigns);
    }

    /**
     * Helper method to get the value of a non-public property.
     *
     * @param object $object The object containing the property.
     * @param string $propertyName The name of the property.
     * @return mixed The value of the property.
     * @throws ReflectionException If the property does not exist or is not accessible.
     */
    private function getNonPublicProperty($object, $propertyName)
    {
        $reflectionClass = new ReflectionClass($object);
        $property = $reflectionClass->getProperty($propertyName);
        $property->setAccessible(true);
        return $property->getValue($object);
    }
}