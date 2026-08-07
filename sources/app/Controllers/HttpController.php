<?php

class HttpController
{
    private HttpException $e;

    public function __construct(HttpException $e)
    {
        $this->e = $e;
    }
}