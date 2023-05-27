<?php

namespace CampaignService\Models;

/**
 * Class BlogPost
 *
 * A model class representing a blog post.
 */
class BlogPost
{
    /**
     * BlogPost constructor.
     *
     * @param int $id The blog post ID
     * @param string $name The name of the blog post
     */
    public function __construct(
        private int $id,
        private string $name,
    ) {
    }

    /**
     * Get the ID of the blog post.
     *
     * @return int The blog post ID
     */
    public function getId() {
        return $this->id;
    }
}