<?php

namespace Tigusigalpa\YandexGPT\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Tigusigalpa\YandexGPT\Exceptions\ApiException;
use Tigusigalpa\YandexGPT\Exceptions\AuthenticationException;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;
use Tigusigalpa\YandexGPT\YandexGPTClient;

class YandexGPTClientTest extends BaseTestCase
{
    private YandexGPTClient $client;
    private MockHandler $mockHandler;

    public function testGenerateTextSuccess()
    {
        // Mock IAM token response
        $this->mockHandler->append(new Response(200, [], json_encode([
            'iamToken' => 'test_iam_token',
        ])));

        // Mock YandexGPT response
        $this->mockHandler->append(new Response(200, [], json_encode([
            'result' => [
                'alternatives' => [
                    [
                        'message' => [
                            'role' => 'assistant',
                            'text' => 'Привет! Как дела?',
                        ],
                        'status' => 'ALTERNATIVE_STATUS_FINAL',
                    ],
                ],
                'usage' => [
                    'inputTextTokens' => '10',
                    'completionTokens' => '5',
                    'totalTokens' => '15',
                ],
                'modelVersion' => 'yandexgpt-lite/latest',
            ],
        ])));

        $response = $this->client->generateText('Hello!');

        $this->assertArrayHasKey('result', $response);
        $this->assertArrayHasKey('alternatives', $response['result']);
        $this->assertEquals('Hello! How are you?', $response['result']['alternatives'][0]['message']['text']);
    }

    public function testGenerateTextWithInvalidModel()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Invalid model: invalid_model');

        $this->client->generateText('Hello!', 'invalid_model');
    }

    public function testGenerateFromMessagesSuccess()
    {
        // Mock IAM token response
        $this->mockHandler->append(new Response(200, [], json_encode([
            'iamToken' => 'test_iam_token',
        ])));

        // Mock YandexGPT response
        $this->mockHandler->append(new Response(200, [], json_encode([
            'result' => [
                'alternatives' => [
                    [
                        'message' => [
                            'role' => 'assistant',
                            'text' => 'This is an answer on your question',
                        ],
                        'status' => 'ALTERNATIVE_STATUS_FINAL',
                    ],
                ],
            ],
        ])));

        $messages = [
            ['role' => 'user', 'text' => 'Hello!'],
            ['role' => 'assistant', 'text' => 'Hello! How are you?'],
            ['role' => 'user', 'text' => 'Good, and you?'],
        ];

        $response = $this->client->generateFromMessages($messages);

        $this->assertArrayHasKey('result', $response);
        $this->assertEquals('This is an answer on your question', $response['result']['alternatives'][0]['message']['text']);
    }

    public function testGetAvailableModels()
    {
        $models = $this->client->getAvailableModels();

        $this->assertIsArray($models);
        $this->assertContains(YandexGPTModel::YANDEX_GPT_LITE, $models);
        $this->assertContains(YandexGPTModel::YANDEX_GPT, $models);
    }

    public function testGetModelDescriptions()
    {
        $descriptions = $this->client->getModelDescriptions();

        $this->assertIsArray($descriptions);
        $this->assertArrayHasKey(YandexGPTModel::YANDEX_GPT_LITE, $descriptions);
        $this->assertArrayHasKey(YandexGPTModel::YANDEX_GPT, $descriptions);
    }

    public function testSetAndGetFolderId()
    {
        $newFolderId = 'new_folder_id';
        $this->client->setFolderId($newFolderId);

        $this->assertEquals($newFolderId, $this->client->getFolderId());
    }

    public function testAuthenticationError()
    {
        // Mock failed IAM token response
        $this->mockHandler->append(new Response(401, [], json_encode([
            'error' => 'Unauthorized',
        ])));

        $this->expectException(AuthenticationException::class);

        $this->client->generateText('Привет!');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockHandler = new MockHandler();
        $handlerStack = HandlerStack::create($this->mockHandler);
        $httpClient = new Client(['handler' => $handlerStack]);

        $this->client = new YandexGPTClient('test_oauth_token', 'test_folder_id', $httpClient);
    }
}
