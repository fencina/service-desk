<?php

namespace App\Services;

class ServiceDeskApiConfig
{
    /**
     * @var string
     */
    private $apiUrl;

    /**
     * @var string
     */
    public $apiUser;

    /**
     * @var string
     */
    public $apiPassword;

    const GET_INCIDENTS_FOR_HELP_DESK_URL = 'incidents.by.helpdesk';
    const GET_INCIDENT = 'incident';

    public function __construct()
    {
        $this->apiUrl = env('API_URL');
        $this->apiUser = env('API_USER');
        $this->apiPassword = env('API_PASSWORD');
    }

    public function getIncidentsForHelpDeskUrl()
    {
        return $this->apiUrl.self::GET_INCIDENTS_FOR_HELP_DESK_URL;
    }

    public function getIncidentUrl()
    {
        return $this->apiUrl.self::GET_INCIDENT;
    }
}