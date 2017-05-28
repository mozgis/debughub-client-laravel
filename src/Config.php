<?php

namespace Debughub\Client;


class Config
{
    private $apiKey;
    private $projectKey;
    private $endpoint;
    private $gitRoot;
    private $blacklistParams;
    private $enabled;

    public function setApiKey($key)
    {
        $this->apiKey = $key;
    }
    public function setProjectKey($key)
    {
        $this->projectKey = $key;
    }
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }
    public function setGitRoot($gitRoot)
    {
        $this->gitRoot = $gitRoot;
    }
    public function setBlacklistParams($params)
    {
        $this->blacklistParams = $params;
    }
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }
    public function getProjectKey()
    {
        return $this->projectKey;
    }
    public function getEndpoint()
    {
        return $this->endpoint;
    }
    public function getGitRoot()
    {
        return $this->gitRoot;
    }
    public function getBlacklistParams()
    {
        return $this->blacklistParams;
    }
    public function getEnabled()
    {
        return $this->enabled;
    }

}
