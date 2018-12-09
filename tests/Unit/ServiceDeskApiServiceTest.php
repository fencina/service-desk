<?php

namespace Tests\Unit;

use App\Exceptions\ApiException;
use App\Services\ServiceDeskApiConfig;
use App\Services\ServiceDeskApiService;
use GuzzleHttp\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceDeskApiServiceTest extends TestCase
{
    /**
     * @var ServiceDeskApiService
     */
    private $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = app(ServiceDeskApiService::class);
    }

    /**
     * @test
     */
    public function get_incidents_for_help_desk_should_return_array()
    {
        $helpDeskIdTest = 11;
        $incidents = $this->service->getIncidentsForHelpDesk($helpDeskIdTest);
        $this->assertInternalType('array', $incidents);
    }

    /**
     * @test
     */
    public function get_incident_should_return_object_with_attributes()
    {
        $incidentIdTest = 206;
        $incident = $this->service->getIncident($incidentIdTest);

        $incidentAttributes = [
            'id',
            'description',
        ];

        $this->assertInternalType('object', $incident);

        foreach ($incidentAttributes as $attr) {
            $this->assertObjectHasAttribute($attr, $incident);
        }
    }

    /**
     * @test
     */
    public function get_should_throw_exception_in_case_of_fail()
    {
        $this->expectException(ApiException::class);

        putenv('API_USER=invalidApiUser');
        $brokenService = new ServiceDeskApiService(new Client(), new ServiceDeskApiConfig());

        $incidentIdTest = 206;
        $brokenService->getIncident($incidentIdTest);
    }
}
