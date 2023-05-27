<?php

namespace CampaignService;

use CampaignService\Models\Campaign;

/**
 * Class CampaignService
 * 
 * A service class for managing campaigns.
 */
class CampaignService
{
    /**
     * @var array The list of started campaigns
     */
    private array $startedCampaigns = [];

    /**
     * CampaignService constructor.
     *
     * @param array $campaigns The initial list of campaigns
     * @param CampaignValidator $validator The campaign validator object
     */
    public function __construct(
        private array $campaigns = [],
        private CampaignValidator $validator = new CampaignValidator(), 
    )
    {
    }

    /**
     * Add a campaign to the list of campaigns.
     *
     * @param Campaign $campaign The campaign to add
     * @return void
     */
    public function addCampaign(Campaign $campaign): void
    {
        $this->campaigns[] = $campaign;
    }

    /**
     * Run the campaign service.
     * 
     * This method validates each campaign and starts the valid ones.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->campaigns as $index => $campaign) {
            if (
                !$this->validator->validateBlogPosts($campaign) ||
                !$this->validator->validateOverlap($this->startedCampaigns, $campaign)
            ) {
                $this->removeCampaign($index);
                continue;
            }

            $this->startCampaign($campaign);
        }
    }

    /**
     * Remove a campaign from the list of campaigns.
     *
     * @param int $index The index of the campaign to remove
     * @return void
     */
    private function removeCampaign(int $index): void
    {
        if (isset($this->campaigns[$index])) {
            unset($this->campaigns[$index]);
        }
    }

    /**
     * Start a campaign and add it to the list of started campaigns.
     *
     * @param Campaign $campaign The campaign to start
     * @return void
     */
    private function startCampaign(Campaign $campaign): void
    {
        $this->startedCampaigns[] = $campaign;
    }
}