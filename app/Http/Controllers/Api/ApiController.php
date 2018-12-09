<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DetailedIncident;
use App\Http\Resources\SimpleIncident;
use App\Search;
use App\Services\ServiceDeskApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Search as SearchResource;

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


        $incidents = DB::transaction(function () use ($helpDeskId, $textToSearch) {

            Search::store($helpDeskId, $textToSearch);

            $incidents = $this->getAllIncidents($helpDeskId);
            return $this->filterIncidentsByText($incidents, $textToSearch);
        });

        return $detailed ? DetailedIncident::collection(collect($incidents)) : SimpleIncident::collection(collect($incidents));
    }

    public function getMostSearchedTexts(Request $request)
    {
        $validator = Validator::make($request->query(), [
            'helpdesk_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $helpDeskId = $request->query('helpdesk_id') ?? null;

        $query = Search::query();

        if ($helpDeskId) {
            $query->where('help_desk_id', $helpDeskId);
        }

        $query->selectRaw('text, SUM(count) as count')
            ->orderByDesc('count')
            ->groupBy('text')
            ->limit(5);

        return SearchResource::collection($query->get());
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