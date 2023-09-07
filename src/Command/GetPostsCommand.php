<?php

namespace App\Command;

use App\HttpClient\JsonPlaceholderService;
use App\Service\PostService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:get-posts',
    description: 'Add a short description for your command',
)]
class GetPostsCommand extends Command
{
    public function __construct(
        private JsonPlaceholderService $jsonPlaceholderService,
        private PostService $postService
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('getPosts');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $posts = $this->jsonPlaceholderService->prepareDataForInsertToDB();

        if (!$posts) {
            return $this->onFail($io);
        }

        $result = $this->postService->insertOrUpdateMany($posts);

        if (!$result) {
            return $this->onFail($io);
        }

        $io->success('Posts fetched and saved successfuly.');

        return Command::SUCCESS;
    }

    private function onFail(SymfonyStyle $io)
    {
        $io->error('Error occured durring fetching and saving the posts.');

        return Command::FAILURE;
    }
}
