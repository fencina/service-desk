<?php

namespace Tests\Unit;

use App\Services\ServiceDeskApiConfig;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceDeskConfigTest extends TestCase
{
    /**
     * @var ServiceDeskApiConfig
     */
    private $config;

    public function setUp()
    {
        parent::setUp();
        $this->config = new ServiceDeskApiConfig();
    }

    /**
     * @test
     */
    public function assert_correct_incidents_for_help_desk_endpoint_url()
    {
        $this->assertEquals(env('API_URL').ServiceDeskApiConfig::GET_INCIDENTS_FOR_HELP_DESK_URL, $this->config->getIncidentsForHelpDeskUrl());
    }

    /**
     * @test
     */
    public function assert_correct_get_incident_endpoint_url()
    {
        $this->assertEquals(env('API_URL').ServiceDeskApiConfig::GET_INCIDENT, $this->config->getIncidentUrl());
    }
}
