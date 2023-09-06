<?php

namespace App\HttpClient;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class JsonPlaceholderService extends ApiResponseBase
{
    public function __construct(
        private HttpClientInterface $jsonplaceholderClient,
        private LoggerInterface $logger,
    )
    {}

    public function getPosts(): self
    {
        $this->response = $this->jsonplaceholderClient->request('GET', 'posts');

        return $this;
    }

    public function getUsers(): self
    {
        $this->response = $this->jsonplaceholderClient->request('GET', 'users');

        return $this;
    }

    public function prepareDataForInsertToDB()
    {
        try {
            $users = $this->getUsers()->toArray();
            $posts = $this->getPosts()->toArray();
    
            return array_map(function ($post) use ($users) {
                $user = current(array_filter($users, fn ($user) => $user['id'] === $post['userId']));
    
                $post['author_name'] = $user['name'];
    
                return $post;
            }, $posts);
        } catch (Throwable $e) {
            $this->logger->error($e);

            return false;
        }
    }
}