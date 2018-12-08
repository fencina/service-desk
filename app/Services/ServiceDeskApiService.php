<?php

namespace App\Services;

use App\Exceptions\ApiException;
use GuzzleHttp\Client;

class ServiceDeskApiService
{
    /**
     * @var ServiceDeskApiConfig
     */
    private $config;

    /**
     * @var Client
     */
    private $guzzleClient;

    public function __construct(Client $guzzleClient, ServiceDeskApiConfig $config)
    {
        $this->guzzleClient = $guzzleClient;
        $this->config = $config;
    }

    private function get($url)
    {
        try {
            $response = $this->guzzleClient->get($url, [
                'auth' => [
                    $this->config->apiUser,
                    $this->config->apiPassword,
                ]
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (\Exception $exception) {
            throw new ApiException();
        }
    }

    public function getIncidentsForHelpDesk($helpDeskId)
    {
        $response = $this->get($this->config->getIncidentsForHelpDeskUrl() . "?helpdesk_id=$helpDeskId");
        return $response->requestIds;
    }

    public function getIncident($id)
    {
        $response = $this->get($this->config->getIncidentUrl() . "?id=$id");
        return $response;
    }
}