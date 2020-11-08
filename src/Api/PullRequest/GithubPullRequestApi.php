<?php

namespace App\Api\PullRequest;

use App\Model\Repository;
use Github\Api\Repo;

/**
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class GithubPullRequestApi implements PullRequestApi
{
/**
     * @var Repo
     */
    private $github;
    private $botUsername;

    /**
     * @param Repo $github
     */
    public function __construct(Repo $github, string $botUsername)
    {
        $this->github = $github;
        $this->botUsername = $botUsername;
    }

    /**
     * Trigger start of a "find reviewer" job. The job runs on github actions and will comment on the PR.
     */
    public function findReviewer(Repository $repository, $pullRequestNumber, string $type)
    {
        $this->github->dispatch($this->botUsername, 'carsonbot', 'find-reviewer', [
            'repository' => $repository->getFullName(),
            'pull_request_number' => $pullRequestNumber,
            'type' => $type
        ]);
    }
}
