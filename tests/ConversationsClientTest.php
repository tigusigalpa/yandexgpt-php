<?php

namespace Tigusigalpa\YandexGPT\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Tigusigalpa\YandexGPT\Exceptions\ApiException;
use Tigusigalpa\YandexGPT\YandexGPTClient;

class ConversationsClientTest extends BaseTestCase
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

    public function testCreateConversation(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode([
            'id' => 'conv_123',
            'object' => 'conversation',
            'metadata' => ['key' => 'value'],
            'created_at' => 1700000000,
        ])));

        $result = $this->client->conversations()->create(['key' => 'value']);

        $this->assertSame('conv_123', $result['id']);
        $this->assertSame('conversation', $result['object']);
        $this->assertSame(['key' => 'value'], $result['metadata']);

        $request = $this->historyContainer[1]['request'];
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('https://ai.api.cloud.yandex.net/v1/conversations', (string) $request->getUri());
        $this->assertSame('Bearer test_iam_token', $request->getHeaderLine('Authorization'));

        $body = json_decode((string) $request->getBody(), true);
        $this->assertSame(['key' => 'value'], $body['metadata']);
    }

    public function testCreateConversationWithItems(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode([
            'id' => 'conv_456',
            'object' => 'conversation',
            'metadata' => null,
            'created_at' => 1700000000,
        ])));

        $items = [
            ['type' => 'message', 'role' => 'user', 'content' => [['type' => 'input_text', 'text' => 'Hello']]]
        ];

        $result = $this->client->conversations()->create(null, $items);

        $this->assertSame('conv_456', $result['id']);

        $request = $this->historyContainer[1]['request'];
        $body = json_decode((string) $request->getBody(), true);
        $this->assertArrayHasKey('items', $body);
        $this->assertCount(1, $body['items']);
    }

    public function testGetConversation(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode([
            'id' => 'conv_123',
            'object' => 'conversation',
            'metadata' => [],
            'created_at' => 1700000000,
        ])));

        $result = $this->client->conversations()->get('conv_123');

        $this->assertSame('conv_123', $result['id']);

        $request = $this->historyContainer[1]['request'];
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('https://ai.api.cloud.yandex.net/v1/conversations/conv_123', (string) $request->getUri());
    }

    public function testUpdateConversation(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode([
            'id' => 'conv_123',
            'object' => 'conversation',
            'metadata' => ['updated' => 'true'],
            'created_at' => 1700000000,
        ])));

        $result = $this->client->conversations()->update('conv_123', ['updated' => 'true']);

        $this->assertSame(['updated' => 'true'], $result['metadata']);

        $request = $this->historyContainer[1]['request'];
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('https://ai.api.cloud.yandex.net/v1/conversations/conv_123', (string) $request->getUri());

        $body = json_decode((string) $request->getBody(), true);
        $this->assertSame(['updated' => 'true'], $body['metadata']);
    }

    public function testDeleteConversation(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode([
            'object' => 'conversation.deleted',
            'deleted' => true,
            'id' => 'conv_123',
        ])));

        $result = $this->client->conversations()->delete('conv_123');

        $this->assertTrue($result['deleted']);
        $this->assertSame('conversation.deleted', $result['object']);

        $request = $this->historyContainer[1]['request'];
        $this->assertSame('DELETE', $request->getMethod());
        $this->assertSame('https://ai.api.cloud.yandex.net/v1/conversations/conv_123', (string) $request->getUri());
    }

    public function testCreateItems(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode([
            'object' => 'list',
            'data' => [
                ['type' => 'message', 'id' => 'item_1', 'role' => 'user', 'status' => 'completed'],
            ],
            'has_more' => false,
            'first_id' => 'item_1',
            'last_id' => 'item_1',
        ])));

        $items = [
            ['type' => 'message', 'role' => 'user', 'content' => [['type' => 'input_text', 'text' => 'Hello']]]
        ];

        $result = $this->client->conversations()->createItems('conv_123', $items);

        $this->assertSame('list', $result['object']);
        $this->assertCount(1, $result['data']);
        $this->assertFalse($result['has_more']);

        $request = $this->historyContainer[1]['request'];
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('https://ai.api.cloud.yandex.net/v1/conversations/conv_123/items', (string) $request->getUri());

        $body = json_decode((string) $request->getBody(), true);
        $this->assertArrayHasKey('items', $body);
    }

    public function testListItems(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode([
            'object' => 'list',
            'data' => [
                ['type' => 'message', 'id' => 'item_1', 'role' => 'user', 'status' => 'completed'],
                ['type' => 'message', 'id' => 'item_2', 'role' => 'assistant', 'status' => 'completed'],
            ],
            'has_more' => false,
            'first_id' => 'item_1',
            'last_id' => 'item_2',
        ])));

        $result = $this->client->conversations()->listItems('conv_123', 10, 'asc');

        $this->assertSame('list', $result['object']);
        $this->assertCount(2, $result['data']);

        $request = $this->historyContainer[1]['request'];
        $this->assertSame('GET', $request->getMethod());
        $uri = (string) $request->getUri();
        $this->assertStringContainsString('conversations/conv_123/items', $uri);
        $this->assertStringContainsString('limit=10', $uri);
        $this->assertStringContainsString('order=asc', $uri);
    }

    public function testListItemsWithPagination(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode([
            'object' => 'list',
            'data' => [],
            'has_more' => false,
            'first_id' => '',
            'last_id' => '',
        ])));

        $this->client->conversations()->listItems('conv_123', 5, 'desc', 'item_10');

        $request = $this->historyContainer[1]['request'];
        $uri = (string) $request->getUri();
        $this->assertStringContainsString('after=item_10', $uri);
        $this->assertStringContainsString('limit=5', $uri);
        $this->assertStringContainsString('order=desc', $uri);
    }

    public function testGetItem(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode([
            'type' => 'message',
            'id' => 'item_1',
            'role' => 'user',
            'status' => 'completed',
            'content' => [['type' => 'input_text', 'text' => 'Hello']],
        ])));

        $result = $this->client->conversations()->getItem('conv_123', 'item_1');

        $this->assertSame('item_1', $result['id']);
        $this->assertSame('message', $result['type']);

        $request = $this->historyContainer[1]['request'];
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame(
            'https://ai.api.cloud.yandex.net/v1/conversations/conv_123/items/item_1',
            (string) $request->getUri()
        );
    }

    public function testDeleteItem(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(200, [], json_encode([
            'id' => 'conv_123',
            'object' => 'conversation',
            'metadata' => [],
            'created_at' => 1700000000,
        ])));

        $result = $this->client->conversations()->deleteItem('conv_123', 'item_1');

        $this->assertSame('conv_123', $result['id']);

        $request = $this->historyContainer[1]['request'];
        $this->assertSame('DELETE', $request->getMethod());
        $this->assertSame(
            'https://ai.api.cloud.yandex.net/v1/conversations/conv_123/items/item_1',
            (string) $request->getUri()
        );
    }

    public function testConversationsClientIsSingleton(): void
    {
        $conversations1 = $this->client->conversations();
        $conversations2 = $this->client->conversations();

        $this->assertSame($conversations1, $conversations2);
    }

    public function testApiErrorHandling(): void
    {
        $this->mockHandler->append(new Response(200, [], json_encode(['iamToken' => 'test_iam_token'])));
        $this->mockHandler->append(new Response(400, [], json_encode([
            'message' => 'Bad Request: invalid conversation_id',
        ])));

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Conversations API error');

        $this->client->conversations()->get('invalid_id');
    }
}
