<?php

namespace Tigusigalpa\YandexGPT {
    // Override sleep in the SDK namespace to avoid real delays during polling tests
    function sleep(int $seconds): void {}
}

namespace Tigusigalpa\YandexGPT\Tests {

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Tigusigalpa\YandexGPT\Exceptions\ApiException;
use Tigusigalpa\YandexGPT\YandexGPTClient;

class YandexARTClientTest extends BaseTestCase
{
    private YandexGPTClient $client;
    private MockHandler $mockHandler;
    private array $historyContainer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockHandler = new MockHandler();
        $this->historyContainer = [];
        $handlerStack = HandlerStack::create($this->mockHandler);
        $handlerStack->push(Middleware::history($this->historyContainer));
        $httpClient = new Client(['handler' => $handlerStack]);
        $this->client = new YandexGPTClient('test_oauth_token', 'test_folder_id', $httpClient);
    }

    public function testNormalizeArtMessagesStringAndArray(): void
    {
        // IAM token response once (cached afterward)
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        // Async responses for two calls
        $this->mockHandler->append(new Response(200, [], json_encode(['id' => 'op-1'])));
        $this->mockHandler->append(new Response(200, [], json_encode(['id' => 'op-2'])));

        // Call with string prompt
        $this->client->generateImageAsync('Simple prompt');
        // Call with mixed array messages
        $messages = [
            'First string',
            ['text' => 'Explicit weight', 'weight' => 2],
            ['text' => 'Default weight'],
        ];
        $this->client->generateImageAsync($messages);

        $this->assertCount(3, $this->historyContainer, 'Expected IAM + 2 async requests recorded');

        // First async request body
        $firstRequest = $this->historyContainer[1]['request'];
        $firstBody = json_decode((string) $firstRequest->getBody(), true);
        $this->assertSame('https://llm.api.cloud.yandex.net/foundationModels/v1/imageGenerationAsync', (string) $firstRequest->getUri());
        $this->assertArrayHasKey('messages', $firstBody);
        $this->assertSame([['text' => 'Simple prompt', 'weight' => 1]], $firstBody['messages']);

        // Second async request body
        $secondRequest = $this->historyContainer[2]['request'];
        $secondBody = json_decode((string) $secondRequest->getBody(), true);
        $this->assertArrayHasKey('messages', $secondBody);
        $this->assertSame('First string', $secondBody['messages'][0]['text']);
        $this->assertSame(1, $secondBody['messages'][0]['weight']);
        $this->assertSame('Explicit weight', $secondBody['messages'][1]['text']);
        $this->assertSame(2, $secondBody['messages'][1]['weight']);
        $this->assertSame('Default weight', $secondBody['messages'][2]['text']);
        $this->assertSame(1, $secondBody['messages'][2]['weight']);
    }

    public function testGenerateImageAsyncSendsCorrectRequest(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode(['id' => 'op-123'])));

        $operation = $this->client->generateImageAsync('Rocky shore at sunset');
        $this->assertArrayHasKey('id', $operation);
        $this->assertSame('op-123', $operation['id']);

        $request = $this->historyContainer[1]['request'];
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame(YandexGPTClient::IMAGE_GENERATION_ASYNC_ENDPOINT, (string) $request->getUri());
        $this->assertSame('Bearer test_iam_token', $request->getHeaderLine('Authorization'));
        $this->assertSame('application/json', $request->getHeaderLine('Content-Type'));
        $body = json_decode((string) $request->getBody(), true);
        $this->assertSame('art://test_folder_id/yandex-art/latest', $body['modelUri']);
        $this->assertSame('Rocky shore at sunset', $body['messages'][0]['text']);
        $this->assertSame(1, $body['messages'][0]['weight']);
    }

    public function testGenerateImagePollingSuccess(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode(['id' => 'op-xyz'])));
        // First poll: not done yet
        $this->mockHandler->append(new Response(200, [], json_encode(['id' => 'op-xyz', 'done' => false])));
        // Second poll: done with image
        $imageBase64 = base64_encode('hello');
        $this->mockHandler->append(new Response(200, [], json_encode([
            'id' => 'op-xyz',
            'done' => true,
            'response' => ['image' => $imageBase64],
        ])));

        $result = $this->client->generateImage('Prompt', [], null, 1, 5);
        $this->assertSame('op-xyz', $result['operationId']);
        $this->assertSame($imageBase64, $result['image_base64']);

        // Requests: 1 IAM + 1 async + 2 polls
        $this->assertCount(4, $this->historyContainer);
        $this->assertSame('GET', $this->historyContainer[2]['request']->getMethod());
        $this->assertStringContainsString('/operations/op-xyz', (string) $this->historyContainer[2]['request']->getUri());
        $this->assertSame('GET', $this->historyContainer[3]['request']->getMethod());
    }

    public function testGenerateImagePollingTimeout(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode(['id' => 'op-timeout'])));
        // Two polls not done; with pollInterval=1 and maxWait=2 -> timeout
        $this->mockHandler->append(new Response(200, [], json_encode(['id' => 'op-timeout', 'done' => false])));
        $this->mockHandler->append(new Response(200, [], json_encode(['id' => 'op-timeout', 'done' => false])));

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('YandexART operation timed out');
        $this->client->generateImage('Prompt', [], null, 1, 2);
    }

    public function testGenerateImagePollingError(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode(['id' => 'op-error'])));
        // One poll: done but error
        $this->mockHandler->append(new Response(200, [], json_encode([
            'id' => 'op-error',
            'done' => true,
            'error' => ['message' => 'oops'],
        ])));

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('YandexART operation error: oops');
        $this->client->generateImage('Prompt', [], null, 1, 5);
    }
}
}