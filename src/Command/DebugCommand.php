<?php


namespace App\Command;

use App\Api\Issue\IssueApi;
use App\Api\PullRequest\PullRequestApi;
use App\Model\Repository;
use App\Service\ComplementGenerator;
use App\Service\RepositoryProvider;
use App\Service\ReviewerFilter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class DebugCommand extends Command
{
    protected static $defaultName = 'app:debug';
    private $pullRequestApi;

    public function __construct(PullRequestApi $pullRequestApi)
    {
        parent::__construct();
        $this->pullRequestApi = $pullRequestApi;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->pullRequestApi->findReviewer(new Repository('symfony', 'symfony'), 39021, SuggestReviewer::TYPE_DEMAND);

        return 0;
    }
}
