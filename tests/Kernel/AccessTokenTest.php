<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Kernel;

use PowerWeChat\Kernel\AccessToken;
use PowerWeChat\Kernel\Exceptions\HttpException;
use PowerWeChat\Kernel\Exceptions\InvalidArgumentException;
use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\Kernel\Support\Collection;
use PowerWeChat\Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\SimpleCache\CacheInterface;

class AccessTokenTest extends TestCase
{
    public function testCache()
    {
        $app = \Mockery::mock(ServiceContainer::class)->makePartial();
        $token = \Mockery::mock(AccessToken::class, [$app])->makePartial();

        $this->assertInstanceOf(CacheInterface::class, $token->getCache());

        // prepended cache instance
        $cache = \Mockery::mock(CacheInterface::class);
        $app['cache'] = function () use ($cache) {
            return $cache;
        };
        $token = \Mockery::mock(AccessToken::class.'[setCache]', [$app]);

        $this->assertInstanceOf(CacheInterface::class, $token->getCache());
    }

    public function testGetToken()
    {
        $app = \Mockery::mock(ServiceContainer::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $cache = \Mockery::mock(CacheInterface::class);
        $token = \Mockery::mock(AccessToken::class.'[getCacheKey,getCache,requestToken,setToken,getCredentials]', [$app])
                            ->shouldAllowMockingProtectedMethods();
        $credentials = [
            'foo' => 'foo',
            'bar' => 'bar',
        ];
        $token->allows()->getCredentials()->andReturn($credentials);
        $token->allows()->getCacheKey()->andReturn('mock-cache-key');
        $token->allows()->getCache()->andReturn($cache);

        $tokenResult = [
            'access_token' => 'mock-cached-token',
            'expires_in' => 7200,
        ];

        // no refresh and cached
        $cache->expects()->has('mock-cache-key')->andReturn(true);
        $cache->expects()->get('mock-cache-key')->andReturn($tokenResult);

        $this->assertSame($tokenResult, $token->getToken());

        // no refresh and no cached
        $cache->expects()->has('mock-cache-key')->andReturn(false);
        $cache->expects()->get('mock-cache-key')->never();
        $token->expects()->requestToken($credentials, true)->andReturn($tokenResult)->once();
        $token->expects()->setToken($tokenResult['access_token'], $tokenResult['expires_in'])->once();

        $this->assertSame($tokenResult, $token->getToken());

        // with refresh and cached
        $cache->expects()->has('mock-cache-key')->never();
        $token->expects()->requestToken($credentials, true)->andReturn($tokenResult)->once();
        $token->expects()->setToken($tokenResult['access_token'], $tokenResult['expires_in'])->once();

        $this->assertSame($tokenResult, $token->getRefreshedToken());
    }

    public function testSetToken()
    {
        $app = \Mockery::mock(ServiceContainer::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $cache = \Mockery::mock(CacheInterface::class);
        $token = \Mockery::mock(AccessToken::class.'[getCacheKey,getCache]', [$app])
            ->shouldAllowMockingProtectedMethods();
        $token->allows()->getCacheKey()->andReturn('mock-cache-key');
        $token->allows()->getCache()->andReturn($cache);

        $cache->expects()->set('mock-cache-key', [
            'access_token' => 'mock-token',
            'expires_in' => 7200,
        ], 7200 - 500)->once();
        $result = $token->setToken('mock-token');
        $this->assertSame($token, $result);

        $cache->expects()->set('mock-cache-key', [
            'access_token' => 'mock-token',
            'expires_in' => 7000,
        ], 7000 - 500)->once();
        $result = $token->setToken('mock-token', 7000);
        $this->assertSame($token, $result);
    }

    public function testRefresh()
    {
        $app = \Mockery::mock(ServiceContainer::class);
        $token = \Mockery::mock(AccessToken::class.'[getToken]', [$app])
            ->shouldAllowMockingProtectedMethods();
        $token->expects()->getToken(true)->once();

        $result = $token->refresh();

        $this->assertSame($token, $result);
    }

    public function testRequestToken()
    {
        $app = new ServiceContainer([
            'response_type' => 'collection',
        ]);
        $token = \Mockery::mock(AccessToken::class.'[sendRequest]', [$app])
            ->shouldAllowMockingProtectedMethods();
        $credentials = [
            'foo' => 'foo',
            'bar' => 'bar',
        ];

        // succeed
        $response = new Response(200, [], '{"access_token":"mock-token"}');
        $token->allows()->sendRequest($credentials)->andReturn($response)->once();
        $this->assertSame(['access_token' => 'mock-token'], $token->requestToken($credentials, true));

        // not array
        $response = new Response(200, [], '{"access_token":"mock-token"}');
        $token->allows()->sendRequest($credentials)->andReturn($response)->once();
        $result = $token->requestToken($credentials);
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertSame('mock-token', $result->get('access_token'));

        // erred
        $response = new Response(200, [], '{"error_msg":"mock-error-message"}');
        $token->expects()->sendRequest($credentials)->andReturn($response)->once();

        try {
            $token->requestToken($credentials);
        } catch (\Exception $e) {
            $this->assertInstanceOf(HttpException::class, $e);
            $this->assertSame('Request access_token fail: {"error_msg":"mock-error-message"}', $e->getMessage());
            $this->assertInstanceOf(Collection::class, $e->formattedResponse);
            $this->assertSame('mock-error-message', $e->formattedResponse->get('error_msg'));
        }
    }

    public function testApplyToRequest()
    {
        $app = \Mockery::mock(ServiceContainer::class);
        $token = \Mockery::mock(AccessToken::class.'[getQuery]', [$app])
            ->shouldAllowMockingProtectedMethods();
        $request = new Request('GET', '/foo/bar?appid=12345');
        $token->expects()->getQuery()->andReturn(['access_token' => 'mock-token']);

        $request = $token->applyToRequest($request);
        $this->assertInstanceOf(\GuzzleHttp\Psr7\Request::class, $request);

        $this->assertSame('access_token=mock-token&appid=12345', $request->getUri()->getQuery());
    }

    public function testSendRequest()
    {
        $app = \Mockery::mock(ServiceContainer::class)->makePartial();
        $token = \Mockery::mock(AccessToken::class.'[setHttpClient,request,getEndpoint,sendRequest]', [$app])
            ->shouldAllowMockingProtectedMethods();
        $credentials = [
            'appid' => '123',
            'secret' => 'pa33w0rd',
        ];

        $app['http_client'] = \Mockery::mock(Client::class);

        $token->expects()->sendRequest($credentials)->passthru();
        $token->expects()->getEndpoint()->andReturn('/auth/get-token')->once();
        $token->expects()->setHttpClient($app['http_client'])->andReturnSelf()->once();
        $token->expects()->request('/auth/get-token', 'GET', ['query' => $credentials])
                        ->andReturn(new Response(200, [], 'mock-response'))->once();

        $response = $token->sendRequest($credentials);
        $this->assertSame('mock-response', $response->getBody()->getContents());

        // sub instance
        $token = \Mockery::mock(DummyAccessTokenForTest::class.'[setHttpClient,request,getEndpoint,sendRequest]', [$app])
            ->shouldAllowMockingProtectedMethods();
        $credentials = [
            'appid' => '123',
            'secret' => 'pa33w0rd',
        ];

        $token->expects()->sendRequest($credentials)->passthru();
        $token->expects()->getEndpoint()->andReturn('/auth/get-token')->once();
        $token->expects()->setHttpClient($app['http_client'])->andReturnSelf()->once();
        $token->expects()->request('/auth/get-token', 'post', ['json' => $credentials])
            ->andReturn(new Response(200, [], 'mock-response'))->once();

        $response = $token->sendRequest($credentials);
        $this->assertSame('mock-response', $response->getBody()->getContents());
    }

    public function testGetCacheKey()
    {
        $app = \Mockery::mock(ServiceContainer::class)->makePartial();
        $token = \Mockery::mock(AccessToken::class.'[getCacheKey,getCredentials]', [$app])
            ->shouldAllowMockingProtectedMethods();
        $credentials = [
            'appid' => '123',
            'secret' => 'pa33w0rd',
        ];
        $token->allows()->getCredentials()->andReturn($credentials);
        $token->expects()->getCacheKey()->passthru();

        $this->assertStringEndsWith(md5(json_encode($credentials)), $token->getCacheKey());
    }

    public function testGetQuery()
    {
        $app = \Mockery::mock(ServiceContainer::class)->makePartial();
        $token = \Mockery::mock(AccessToken::class.'[getToken,getQuery]', [$app])
            ->shouldAllowMockingProtectedMethods();

        $token->expects()->getToken()->andReturn(['access_token' => 'mock-token'])->once();
        $token->expects()->getQuery()->passthru();

        $this->assertSame(['access_token' => 'mock-token'], $token->getQuery());

        // sub instance
        $token = \Mockery::mock(DummyAccessTokenForTest::class.'[getToken,getQuery]', [$app])
            ->shouldAllowMockingProtectedMethods();

        $token->expects()->getToken()->andReturn(['foo' => 'mock-token'])->once();
        $token->expects()->getQuery()->passthru();

        $this->assertSame(['foo' => 'mock-token'], $token->getQuery());
    }

    public function testGetEndpoint()
    {
        $app = \Mockery::mock(ServiceContainer::class)->makePartial();
        $token = new DummyAccessTokenForTest($app);

        $this->assertSame('/auth/get-token', $token->getEndpoint());

        $token = \Mockery::mock(AccessToken::class)->makePartial();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No endpoint for access token request.');
        $token->getEndpoint();
    }
}

class DummyAccessTokenForTest extends AccessToken
{
    protected $requestMethod = 'post';

    protected $endpointToGetToken = '/auth/get-token';

    protected $tokenKey = 'foo';

    protected function getCredentials(): array
    {
        return [
            'appid' => 1234,
            'secret' => 'pas33w0rd',
        ];
    }
}
