<?php

namespace App\Command;

use App\Api\Issue\IssueApi;
use App\Service\RepositoryProvider;
use Github\Client;
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

    private $github;

    public function __construct(Client $github)
    {
        parent::__construct();

        $this->github = $github;
    }



    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $x = $this->github->issues()->timeline()->configure()->all('carsonbot-playground', 'symfony', 7);

        return 0;
    }
}
