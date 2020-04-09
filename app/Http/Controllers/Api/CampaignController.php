<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCampaignFormRequest;
use App\Repositories\Contracts\CampaignRepositoryInterface;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    protected $campaignRepository;

    public function __construct(CampaignRepositoryInterface $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
    }

    public function index()
    {
        $campaigns = $this->campaignRepository->all();

        return response()->json($campaigns);
    }

    public function store(StoreUpdateCampaignFormRequest $request)
    {
        return $this->campaignRepository->store($request->all());
    }

    public function show($id)
    {
        $campaign = $this->campaignRepository->findById($id);

        if (!$campaign) {
            return response()->json(['success' => false, 'error' => 'Campanha não encontrada.'], 404);
        }

        return response()->json($campaign);
    }

    public function update(StoreUpdateCampaignFormRequest $request, $id)
    {
        $campaign = $this->campaignRepository->findById($id);

        if (!$campaign) {
            return response()->json(['success' => false, 'error' => 'Campanha não encontrada.'], 404);
        }

        return $this->campaignRepository->update($id, $request->all());
    }

    public function destroy($id)
    {
        $campaign = $this->campaignRepository->findById($id);

        if (!$campaign) {
            return response()->json(['success' => false, 'error' => 'Campanha não encontrada.'], 404);
        }

        return $this->campaignRepository->update($id);
    }
}
