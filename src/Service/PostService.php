<?php

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use Psr\Log\LoggerInterface;
use Throwable;

class PostService
{
    public function __construct(
        private LoggerInterface $logger,
        private PostRepository $postRepository
    ) {
    }

    public function insertOrUpdateMany(array $data): bool
    {
        try {
            $dataChunk = array_chunk($data, 500);

            foreach ($dataChunk as $dataRecords) {
                foreach ($dataRecords as $post) {
                    $postEntity =
                        $this->postRepository->findOneBy(['title' => $post['title'], 'authorName' => $post['author_name']])
                        ?? new Post;

                    $postEntity->setTitle($post['title']);
                    $postEntity->setAuthorName($post['author_name']);
                    $postEntity->setBody($post['body']);

                    $this->postRepository->persist($postEntity);
                }

                $this->postRepository->flush();
            }

            return true;
        } catch (Throwable $e) {
            $this->logger->error($e);

            return false;
        }
    }
}
