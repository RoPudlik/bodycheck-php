<?php

declare(strict_types=1);

namespace App\Command;

use App\DataFixtures\BodyCheckFixture;
use App\DataFixtures\UserFixture;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RedisFixtureCommand extends Command
{
    protected static $defaultName = 'redis:fixtures:load';
    protected static $defaultDescription = 'Load sample data into the Redis';

    public function __construct(
        private BodyCheckFixture $bodyCheckFixture,
        private UserFixture $userFixture,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription(self::$defaultDescription);
        $this->setName(self::$defaultName);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->bodyCheckFixture->load();
            $this->userFixture->load();
        } catch (Exception $e) {
            $output->writeln(sprintf('Data was not loaded due to %s', $e->getMessage()));
            return Command::FAILURE;
        }

        $output->writeln('Sample data loaded to Redis.');
        return Command::SUCCESS;
    }
}
