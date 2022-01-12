<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;

abstract class BaseClient
{
    protected string $requestMethod = 'GET';
    protected string $body;
    protected string $requestUrlSlug = '';
    protected string $requestBaseUrl;

    abstract protected function setConfig(): void;

    abstract protected function getRequestHeaders(): array;

    /**
     * @param $type | GET|POST|PUT|DELETE|PATCH
     * @return $this
     */

    public function setRequestMethod($type): BaseClient
    {
        $this->requestMethod = $type;
        return $this;
    }

    /**
     * @param string $contentType
     * @return mixed
     */

    protected function request($contentType = 'application/json')
    {
        $http = Http::withHeaders($this->getRequestHeaders());
        $uri = "{$this->requestBaseUrl}/{$this->requestUrlSlug}";
        if ('post' == strtolower($this->requestMethod)) {
            $http->withBody($this->body, $contentType);
            $response = $http->post($uri);
        } else {
            $response = $http->get($uri);
        }

        return $response->body();
    }
}
