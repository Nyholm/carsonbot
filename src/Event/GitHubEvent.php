<?php

namespace App\Event;

use App\Model\Repository;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @author Jules Pietri <jules@heahprod.com>
 */
class GitHubEvent extends Event
{
    protected $responseData = [];

    private $data;
    private $repository;

    public function __construct(array $data, Repository $repository)
    {
        $this->data = $data;
        $this->repository = $repository;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * @return Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    public function getResponseData()
    {
        return $this->responseData;
    }

    public function setResponseData(array $responseData)
    {
        foreach ($responseData as $k => $v) {
            $this->responseData[$k] = $v;
        }
    }
}
