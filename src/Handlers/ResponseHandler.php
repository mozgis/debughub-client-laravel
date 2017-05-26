<?php
namespace Debughub\Client\Handlers;

use Debughub\Client\Reportable;
use Debughub\Client\Config;


class ResponseHandler implements Reportable
{
    public $response;
    public $views;
    public $headers;
    public $gitBranchName;
    public $response_code;
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }



    public function getData()
    {
        $this->getGitBranchName();

        return [
            'response' => $this->response,
            'views' => $this->views,
            'headers' => headers_list(),
            'git_branch_name' => $this->gitBranchName,
            'response_code' => http_response_code(),
        ];
    }


    protected function getGitBranchName()
    {
        $shellOutput = [];
        exec('git branch | ' . "grep ' * '", $shellOutput);
        foreach ($shellOutput as $line) {
            if (strpos($line, '* ') !== false) {
                $this->gitBranchName = trim(strtolower(str_replace('* ', '', $line)));
            }
        }
        $this->gitBranchName = null;
    }

}
