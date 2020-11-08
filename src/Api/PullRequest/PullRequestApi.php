<?php

declare(strict_types=1);


namespace App\Api\PullRequest;


use App\Model\Repository;

interface PullRequestApi
{
    public function findReviewer(Repository $repository, $pullRequestNumber, string $type);
}
