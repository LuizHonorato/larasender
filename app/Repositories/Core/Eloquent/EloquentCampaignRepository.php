<?php


namespace App\Repositories\Core\Eloquent;


use App\Models\Campaign;
use App\Repositories\Contracts\CampaignRepositoryInterface;
use App\Repositories\Core\BaseEloquentRepository;

class EloquentCampaignRepository extends BaseEloquentRepository implements CampaignRepositoryInterface
{
    public function entity()
    {
        return Campaign::class;
    }
}
