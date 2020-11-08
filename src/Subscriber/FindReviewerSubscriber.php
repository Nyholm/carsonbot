<?php

namespace App\Subscriber;

use App\Api\Milestone\MilestoneApi;
use App\Api\PullRequest\PullRequestApi;
use App\Command\SuggestReviewer;
use App\Event\GitHubEvent;
use App\GitHubEvents;
use App\Service\SymfonyVersionProvider;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class FindReviewerSubscriber implements EventSubscriberInterface
{

    private $pullRequestApi;
    private $botUsername;

    public function __construct(PullRequestApi $pullRequestApi, string $botUsername)
    {

        $this->pullRequestApi = $pullRequestApi;
        $this->botUsername = $botUsername;
    }

    public function onPullRequest(GitHubEvent $event)
    {
        $data = $event->getData();
        if (!in_array($data['action'], ['opened', 'ready_for_review']) || ($data['pull_request']['draft'] ?? false)) {
            return;
        }

        $repository = $event->getRepository();
        // TODO set scheduled task to run in 24 hours
        // We want to check if the PR has no activity, then suggest a reviewer.
    }

    /**
     * When somebody make a comment on an issue or pull request.
     * If it includes the bot name and "review" on the same line, then try to find reviewer.
     */
    public function onComment(GitHubEvent $event)
    {
        $data = $event->getData();
        if ($data['action'] !== 'created') {
            return;
        }

        if (false === strpos($data['comment']['body'], $this->botUsername)) {
            return;
        }

        // Search for "review"
        $lines = explode(PHP_EOL, $data['comment']['body']);
        foreach ($lines as $line) {
            if (false === strpos($line, $this->botUsername)) {
                continue;
            }

            if (false === strpos($line, "review")) {
                continue;
            }

            $number = $data['issue']['number'];
            $this->pullRequestApi->findReviewer($event->getRepository(), $number, SuggestReviewer::TYPE_DEMAND);
            $event->setResponseData([
                'issue' => $number,
                'suggest-review' => true
            ]);
            return;
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            GitHubEvents::PULL_REQUEST => 'onPullRequest',
            GitHubEvents::ISSUE_COMMENT => 'onComment',
        ];
    }
}
