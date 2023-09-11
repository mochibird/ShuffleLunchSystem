<?php

class Response
{
    protected $content;
    protected $statusCode;
    protected $statusText;

    public function send(): void
    {
        header('HTTP1.1/' . $this->statusCode . ' ' . $this->statusCode);
        echo $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setStatusCode(string $statusCode, string $statusText): void
    {
        $this->statusCode = $statusCode;
        $this->statusText = $statusText;
    }
}
