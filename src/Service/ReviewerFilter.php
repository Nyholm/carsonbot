<?php

declare(strict_types=1);


namespace App\Service;

use App\Model\Repository;

/**
 * From a large list of possible reviewers, reduce it to just one.
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ReviewerFilter
{
    private $blocked = ['nyholm'];

    public function suggestReviewer(array $possibleReviewers, Repository $repository, $pullRequestNumber): ?string
    {
        // Dont get block listed
        $possibleReviewers = $this->filterBlocked($possibleReviewers);

        // TODO Dont get people involved in the PR already

        foreach ($possibleReviewers as $reviewer) {
            return $reviewer['username'];
        }

        return null;
    }

    private function filterBlocked(array $possibleReviewers) {
        $output = [];

        foreach ($possibleReviewers as $reviewer) {
            if (empty($reviewer['username'])) {
                continue;
            }

            $username = strtolower($reviewer['username']);
            if (in_array($username, $this->blocked)) {
                continue;
            }

            $output[] = $reviewer;
        }

        return $output;

    }

}
