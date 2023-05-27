<?php

namespace CampaignService;

use CampaignService\Models\Campaign;

/**
 * Class CampaignValidator
 *
 * A validator class for validating campaigns.
 */
class CampaignValidator
{
    /**
     * Validate the blog posts of a campaign.
     *
     * @param Campaign $campaign The campaign to validate
     * @return bool Returns true if the blog posts are valid, false otherwise
     */
    public function validateBlogPosts(Campaign $campaign): bool
    {
        if ($campaign->hasBlogPosts()) {
            return !$campaign->includesWeekend();
        }

        return true;
    }

    /**
     * Validate the overlap of a campaign with started campaigns.
     *
     * @param array $startedCampaigns The list of started campaigns
     * @param Campaign $campaign The campaign to validate
     * @return bool Returns true if there is no overlap or if the campaign is valid, false otherwise
     */
    public function validateOverlap(array $startedCampaigns, Campaign $campaign): bool
    {
        if ($matchedCampaign = $this->hasAnotherCampaignThatDate($campaign, $startedCampaigns)) {
            return !$campaign->hasOverlappingElements($matchedCampaign);
        }

        return true;
    }

    /**
     * Check if there is another campaign with overlapping dates.
     *
     * @param Campaign $campaign The campaign to check
     * @param array $startedCampaigns The list of started campaigns
     * @return Campaign|bool Returns the matched campaign if there is overlap, false otherwise
     */
    private function hasAnotherCampaignThatDate(Campaign $campaign, array $startedCampaigns): Campaign|bool
    {
        if (count($startedCampaigns) > 0) {
            foreach ($startedCampaigns as $startedCampaign) {
                if (
                    $startedCampaign->getStartDate() <= $campaign->getEndDate() &&
                    $campaign->getStartDate() <= $startedCampaign->getEndDate()
                ) {
                    return $startedCampaign;
                }
            }
        }

        return false;
    }
}