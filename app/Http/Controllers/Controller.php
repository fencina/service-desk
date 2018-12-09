<?php

namespace App\Http\Controllers;

use App\Services\ServiceDeskApiService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var ServiceDeskApiService
     */
    private $apiService;

    public function __construct(ServiceDeskApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index(Request $request)
    {
        return view('index');
    }

    public function get(Request $request)
    {
        return $this->apiService->getAllIncidents($request->query('help_desk_id'));
    }
}
