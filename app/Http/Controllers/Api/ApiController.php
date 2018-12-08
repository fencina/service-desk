<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DetailedIncident;
use App\Http\Resources\SimpleIncident;
use App\Services\ServiceDeskApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    /**
     * @var ServiceDeskApiService
     */
    private $apiService;

    public function __construct(ServiceDeskApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function getIncidentsForHelpDesk(Request $request)
    {
        $validator = Validator::make($request->query(), [
            'helpdesk_id' => 'required|integer',
            'text_to_search' => 'required|string',
            'detailed' => 'nullable|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $helpDeskId = $request->query('helpdesk_id');
        $textToSearch = $request->query('text_to_search');
        $detailed = $request->query('detailed');


        $incidents = $this->getAllIncidents($helpDeskId);
        $incidents = $this->filterIncidentsByText($incidents, $textToSearch);

        return $detailed ? DetailedIncident::collection(collect($incidents)) : SimpleIncident::collection(collect($incidents));
    }

    private function getAllIncidents($helpDeskId)
    {
        $incidents = [];

        $incidentsIds = $this->apiService->getIncidentsForHelpDesk($helpDeskId);

        foreach ($incidentsIds as $id) {
            $incidents[] = $this->apiService->getIncident($id);
        }

        return $incidents;
    }

    private function filterIncidentsByText($incidents, $text)
    {
        $incidents = array_filter($incidents, function ($incident) use ($text) {
            return strpos($incident->description, $text) !== false;
        });

        return $incidents;
    }
}