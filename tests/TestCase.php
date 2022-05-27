<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected string $baseUrl = 'http://localhost';

    /**
     * Override of the get method, so we can get visibility of custom TestResponse methods.
     *
     * @param string $uri
     * @param array  $headers
     *
     * @return TestResponse
     */
    public function get($uri, array $headers = []): TestResponse
    {
        return parent::get($uri, $headers);
    }

    /**
     * Create the test response instance from the given response.
     *
     * @param Response $response
     *
     * @return TestResponse
     */
    protected function createTestResponse($response): TestResponse
    {
        return TestResponse::fromBaseResponse($response);
    }
}