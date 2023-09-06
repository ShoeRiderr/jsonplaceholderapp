<?php

namespace App\HttpClient;

use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class ApiResponseBase
{
    protected ResponseInterface $response;

    public function toArray(): array
    {
        return json_decode($this->response->getContent(), true);
    }

    public function toJson(): string
    {
        return $this->response->getContent();
    }
}