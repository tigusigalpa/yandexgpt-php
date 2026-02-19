# YandexGPT PHP SDK

![YandexGPT PHP SDK](https://github.com/user-attachments/assets/758d8956-0126-4b32-a6ba-afa8c8948188)

[![Latest Version](https://img.shields.io/packagist/v/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
[![PHP Version](https://img.shields.io/packagist/php-v/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
[![License](https://img.shields.io/packagist/l/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
[![Dependencies](https://img.shields.io/packagist/dm/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)

**Language:** English | [Русский](README.md)

PHP SDK for YandexGPT API and YandexART. Text generation, dialogues, images, Conversations API. Works with any PHP 8.0+ project and has built-in Laravel support.

> For cloud infrastructure management (organizations, clouds, folders) see [yandex-cloud-client-php](https://github.com/tigusigalpa/yandex-cloud-client-php).

## Features

- All YandexGPT models: Lite, Pro, Alice AI
- Image generation via YandexART
- Conversations API — server-side conversations
- Reasoning mode (Chain of Thought)
- Automatic OAuth/IAM token management
- Laravel: Service Provider, Facade, configuration
- PHP 8.0+, Laravel 8.0+, Guzzle HTTP

---

## Installation

Via Composer:

```bash
composer require tigusigalpa/yandexgpt-php
```

### Local Development

If you want to use the package locally for development or testing:

#### Method 1: Via local repository

1. **Clone or place the package in your project folder:**

   ```bash
   # In the root of your Laravel project
   mkdir -p packages
   cd packages
   git clone https://github.com/tigusigalpa/yandexgpt-php.git
   # or copy the package folder to packages/yandexgpt-php
   ```

2. **Add the local repository to your project's composer.json:**

   ```json
   {
       "repositories": [
           {
               "type": "path",
               "url": "./packages/yandexgpt-php"
           }
       ],
       "require": {
           "tigusigalpa/yandexgpt-php": "@dev"
       }
   }
   ```

3. **Install the dependencies:**

   ```bash
   composer install
   # or if the package was already installed
   composer update tigusigalpa/yandexgpt-php
   ```

#### Method 2: Via symlinks

1. **Create a symlink in vendor:**

   ```bash
   # Remove the existing package (if any)
   rm -rf vendor/tigusigalpa/yandexgpt-php

   # Create a symlink
   ln -s ../../packages/yandexgpt-php vendor/tigusigalpa/yandexgpt-php
   ```

#### Method 3: Via VCS repository

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/tigusigalpa/yandexgpt-php.git"
        }
    ],
    "require": {
        "tigusigalpa/yandexgpt-php": "dev-main"
    }
}
```

### For Laravel

The package is automatically registered in Laravel thanks to auto-discovery. Publish the configuration file:

```bash
php artisan vendor:publish --tag=yandexgpt-config
```

---

## Configuration

### 1. Getting an OAuth token

Documentation: [OAuth-token](https://yandex.cloud/en/docs/iam/concepts/authorization/oauth-token)

Follow the link
to [get an OAuth token](https://oauth.yandex.com/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb):

```
https://oauth.yandex.com/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb
```

### 2. Environment configuration

Add to your `.env` file:

```env
YANDEX_GPT_OAUTH_TOKEN=your_oauth_token_here
# get folder_id via special request
YANDEX_GPT_FOLDER_ID=your_folder_id_here
YANDEX_GPT_DEFAULT_MODEL=yandexgpt-lite
YANDEX_GPT_TEMPERATURE=0.6
YANDEX_GPT_MAX_TOKENS=2000
```

### 3. Yandex Cloud preparation

To work with the YandexGPT API, you need to perform several steps in Yandex Cloud. The SDK automates most of them, but
it is important to understand the process:

#### 3.1. Getting an IAM token

Documentation: [Getting an IAM token for a Yandex account](https://yandex.cloud/en/docs/iam/operations/iam-token/create#exchange-token)

The IAM token is obtained automatically through the SDK using the OAuth token. The token is valid for 12 hours and is
renewed automatically.

**Getting via SDK:**

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

// Create Yandex Cloud client
$cloudClient = new YandexCloudClient('your_oauth_token');

// Get an IAM token
$iamToken = $cloudClient->getAuthManager()->getIamToken();

echo "IAM Token: " . $iamToken . "\n";
```

**Automatic token management via YandexGPTClient:**

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;

// The client automatically gets and renews IAM tokens
$client = new YandexGPTClient('your_oauth_token', 'your_folder_id');

// Get Yandex Cloud client for cloud management
$cloudClient = $client->getCloudClient();
$iamToken = $cloudClient->getAuthManager()->getIamToken();
```

**Manual retrieval via API:**

```bash
curl -d "{\"yandexPassportOauthToken\":\"YOUR_OAUTH_TOKEN\"}" \
  "https://iam.api.cloud.yandex.net/iam/v1/tokens"
```

#### 3.2. Getting Cloud ID

**Documentation:** [Getting a list of Cloud resources](https://yandex.cloud/en/docs/resource-manager/api-ref/Cloud/list)

**Via SDK:**

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();
$clouds = $cloudClient->clouds()->list();

foreach ($clouds as $cloud) {
    echo "Cloud ID: " . $cloud['id'] . "\n";
    echo "Name: " . $cloud['name'] . "\n";
}
```

**Via Yandex Cloud CLI:**

```bash
yc resource-manager cloud list
```

**Via web console:** [Yandex Cloud Console](https://console.cloud.yandex.com/) → select a cloud → copy the ID

#### 3.3. Getting Folder ID

**Documentation:
** [Getting a list of Folder resources in the specified cloud](https://yandex.cloud/en/docs/resource-manager/api-ref/Folder/list)

**Via SDK:**

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Get existing folders
$folders = $cloudClient->folders()->list('cloud_id');
foreach ($folders as $folder) {
    echo "Folder ID: " . $folder['id'] . "\n";
    echo "Name: " . $folder['name'] . "\n";
}
```

**Via Yandex Cloud CLI:**

```bash
# Create a folder
yc resource-manager folder create --name my-ai-folder --cloud-id YOUR_CLOUD_ID

# List folders
yc resource-manager folder list --cloud-id YOUR_CLOUD_ID
```

#### Creating a folder

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

// Create a folder
$folder = $cloudClient->folders()->create('cloud_id', 'my-ai-folder', 'Folder for AI projects');
$folderId = $folder['metadata']['folderId'];

```

Documentation: [Creating a folder](https://yandex.cloud/en/docs/resource-manager/operations/folder/create)

#### 3.4. Assigning roles to folder or cloud

Documentation:

[Authentication in Yandex AI Studio API](https://yandex.cloud/en/docs/ai-studio/api-ref/authentication)

[Access management in Yandex AI Studio](https://yandex.cloud/en/docs/ai-studio/security/)

[Assign a role to a folder or cloud](https://yandex.cloud/en/docs/iam/operations/roles/grant#cloud-or-folder)

[Assigning a role to a cloud](https://yandex.cloud/en/docs/resource-manager/api-ref/Cloud/updateAccessBindings)

[Subject object for cloud](https://yandex.cloud/en/docs/resource-manager/api-ref/Cloud/updateAccessBindings#yandex.cloud.access.Subject)

[Assigning a role to a folder](https://yandex.cloud/en/docs/resource-manager/api-ref/Folder/updateAccessBindings)

[Subject object for folder](https://yandex.cloud/en/docs/resource-manager/api-ref/Folder/updateAccessBindings#yandex.cloud.access.Subject)

[Step-by-step instructions for Identity and Access Management](https://yandex.cloud/en/docs/iam/operations/)

[UserAccount API](https://yandex.cloud/en/docs/iam/api-ref/UserAccount/)

[Identity and Access Management API, REST: YandexPassportUserAccount.GetByLogin](https://yandex.cloud/en/docs/iam/api-ref/YandexPassportUserAccount/getByLogin)

**Via SDK:**

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

// 1. Get User ID by Yandex login
$userInfo = $cloudClient->yandexPassportUserAccounts()->getByLogin('username@yandex.ru');
$userId = $userInfo['id'];

// 2. Get user information by UserAccountId
$userAccount = $cloudClient->userAccounts()->get($userId);

// 3. Assign role to folder
$cloudClient->folders()->updateAccessBindings(
    'folder_id',
    [
        [
            'action' => 'ADD',
            'accessBinding' => [
                'roleId' => 'ai.languageModels.user',
                'subject' => [
                    'id' => $userId,
                    'type' => 'userAccount'
                ]
            ]
        ]
    ]
);

// 4. Assign role to cloud
$cloudClient->clouds()->updateAccessBindings(
    'cloud_id',
    [
        [
            'action' => 'ADD',
            'accessBinding' => [
                'roleId' => 'viewer',
                'subject' => [
                    'id' => $userId,
                    'type' => 'userAccount'
                ]
            ]
        ]
    ]
);
```

**Via Yandex Cloud CLI:**

```bash
# Assign a role to a user
yc resource-manager folder add-access-binding \
  --id YOUR_FOLDER_ID \
  --role ai.languageModels.user \
  --user-account-id YOUR_USER_ID

# Assign a role to a service account
yc resource-manager folder add-access-binding \
  --id YOUR_FOLDER_ID \
  --role ai.languageModels.user \
  --service-account-id YOUR_SERVICE_ACCOUNT_ID
```

**Via web console:**

1. Open [Yandex Cloud Console](https://console.cloud.yandex.com/)
2. Select a folder
3. Go to the "Access rights" section
4. Click "Assign roles"
5. Select a user and the `ai.languageModels.user` role

Documentation:

- [Assigning roles](https://yandex.cloud/en/docs/iam/operations/roles/grant)
- [Roles for Yandex Foundation Models](https://yandex.cloud/en/docs/foundation-models/security/)

#### 3.5. Full setup example

```php
<?php

use Tigusigalpa\YandexCloudClient\YandexCloudClient;
use Tigusigalpa\YandexGPT\YandexGPTClient;

// 1. Initialize Yandex Cloud client
$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

// 2. Get the list of clouds
$clouds = $cloudClient->clouds()->list();
$cloudId = $clouds[0]['id']; // Take the first cloud

// 3. Create a folder (if needed)
$folder = $cloudClient->folders()->create($cloudId, 'ai-projects', 'Folder for AI');
$folderId = $folder['metadata']['folderId'];

// 4. Get User ID by login (if needed)
$userInfo = $cloudClient->yandexPassportUserAccounts()->getByLogin('username@yandex.ru');
$userId = $userInfo['id'];

// 5. Assign role to folder
$cloudClient->folders()->updateAccessBindings(
    $folderId,
    [
        [
            'action' => 'ADD',
            'accessBinding' => [
                'roleId' => 'ai.languageModels.user',
                'subject' => ['id' => $userId, 'type' => 'userAccount']
            ]
        ]
    ]
);

// Or assign role to cloud
$cloudClient->clouds()->updateAccessBindings(
    $cloudId,
    [
        [
            'action' => 'ADD',
            'accessBinding' => [
                'roleId' => 'editor',
                'subject' => ['id' => $userId, 'type' => 'userAccount']
            ]
        ]
    ]
);

// 6. Use the client
$client = new YandexGPTClient('your_oauth_token', $folderId);
$response = $client->generateText('Hello, how are you?');

echo $response['result']['alternatives'][0]['message']['text'];
```

#### 3.6. Useful links

- [YandexGPT Quickstart](https://yandex.cloud/en/docs/foundation-models/quickstart/yandexgpt)
- [API Authentication](https://yandex.cloud/en/docs/iam/concepts/authorization/iam-token)
- [Resource Management](https://yandex.cloud/en/docs/resource-manager/)
- [API Foundation Models](https://yandex.cloud/en/docs/foundation-models/concepts/api)
- [YandexGPT Pricing](https://yandex.cloud/en/docs/foundation-models/pricing)

---

## Usage

### Basic usage (without Laravel)

```php
<?php

require_once 'vendor/autoload.php';

use Tigusigalpa\YandexGPT\YandexGPTClient;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

// Create a client
$client = new YandexGPTClient('your_oauth_token', 'your_folder_id');

// Simple request
$response = $client->generateText(
    'Tell me about the benefits of PHP',
    YandexGPTModel::YANDEX_GPT_LITE
);

echo $response['result']['alternatives'][0]['message']['text'];

// Using Alice AI model for conversational tasks
$response = $client->generateText(
    'Hello! Tell me an interesting story',
    YandexGPTModel::ALICE_AI,
    [
        'completionOptions' => [
            'temperature' => 0.7,
            'maxTokens' => 2000
        ]
    ]
);

echo $response['result']['alternatives'][0]['message']['text'];
```

### Usage with Laravel

#### Via facade

```php
<?php

use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

// Simple request
$response = YandexGPT::generateText('Hello, how are you?');

// With specified model and parameters
$response = YandexGPT::generateText(
    'Write a poem about programming',
    YandexGPTModel::YANDEX_GPT,
    [
        'completionOptions' => [
            'temperature' => 0.8,
            'maxTokens' => 1000
        ]
    ]
);

echo $response['result']['alternatives'][0]['message']['text'];
```

#### Via dependency injection

```php
<?php

use Tigusigalpa\YandexGPT\YandexGPTClient;

class ChatController extends Controller
{
    public function __construct(private YandexGPTClient $yandexGPT)
    {
    }

    public function generateResponse(Request $request)
    {
        $response = $this->yandexGPT->generateText($request->input('message'));
        
        return response()->json([
            'response' => $response['result']['alternatives'][0]['message']['text']
        ]);
    }
}
```

### Working with dialogues

```php
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;

$messages = [
    [
        'role' => 'system',
        'text' => 'You are a helpful programmer assistant'
    ],
    [
        'role' => 'user',
        'text' => 'How to create a REST API in Laravel?'
    ],
    [
        'role' => 'assistant',
        'text' => 'To create a REST API in Laravel, use the command php artisan make:controller...'
    ],
    [
        'role' => 'user',
        'text' => 'And how to add validation?'
    ]
];

$response = YandexGPT::generateFromMessages($messages);
```

### Managing Yandex Cloud resources

```php
<?php

use Tigusigalpa\YandexGPT\YandexGPTClient;

$client = new YandexGPTClient('oauth_token', 'folder_id');
$authManager = $client->getAuthManager();

// Get an IAM token
$iamToken = $authManager->getIamToken();

// Get the list of clouds
$clouds = $authManager->getClouds($iamToken);

// Create a folder
$folder = $authManager->createFolder(
    $iamToken,
    'cloud_id',
    'my-yandexgpt-folder',
    'Folder for working with YandexGPT'
);

// Get User ID by Yandex login
$userId = $authManager->getUserIdByLogin('username@yandex.ru');

// Get user information
$userInfo = $authManager->getUserByLogin('username@yandex.ru');
// or by UserAccountId
$userAccount = $authManager->getUserAccount($userId);

// Assign role to folder
$authManager->assignRoleToFolder(
    $iamToken,
    $folder['id'],
    $userId,
    'ai.languageModels.user',
    'userAccount'  // or 'serviceAccount'
);

// Assign role to cloud
$authManager->assignRoleToCloud(
    $iamToken,
    'cloud_id',
    $userId,
    'editor',
    'userAccount'
);
```

---

## Available Models

| Model            | Constant                          | Context | Use case |
|------------------|-----------------------------------|---------|----------|
| `yandexgpt-lite` | `YandexGPTModel::YANDEX_GPT_LITE` | 32K     | Simple queries, chatbots, FAQ |
| `yandexgpt`      | `YandexGPTModel::YANDEX_GPT`      | 32K     | Content, analysis, reasoning |
| `aliceai-llm`    | `YandexGPTModel::ALICE_AI`        | 32K     | Dialogues, assistants |

Full list: [Generation models in Yandex AI Studio](https://yandex.cloud/en/docs/ai-studio/concepts/generation/models)

```php
$models = YandexGPT::getAvailableModels();
$descriptions = YandexGPT::getModelDescriptions();
```

---

## Generation parameters

```php
$options = [
    'completionOptions' => [
        'stream' => false,           // Streaming (not yet supported)
        'temperature' => 0.6,        // Creativity (0.0 - 1.0)
        'maxTokens' => 2000         // Maximum number of tokens
    ]
];

$response = YandexGPT::generateText('Your request', 'yandexgpt-lite', $options);
```

### Reasoning Mode

Reasoning mode allows the model to break down tasks into steps and perform sequential chains of computations to improve answer accuracy. This mode is especially useful for tasks requiring logical reasoning.

Documentation: [Reasoning mode in generative models](https://yandex.cloud/en/docs/ai-studio/concepts/generation/chain-of-thought)

**Available modes:**
- `DISABLED` - reasoning mode is disabled (default)
- `ENABLED_HIDDEN` - reasoning mode is enabled, but the reasoning chain is not returned in the response

**Effort levels:**
- `low` - priority on speed and token economy
- `medium` - balance between speed and reasoning accuracy
- `high` - priority on more complete and thorough reasoning

#### Using ReasoningOptions object

```php
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;
use Tigusigalpa\YandexGPT\Models\ReasoningOptions;

// Enable reasoning mode with low effort level
$response = YandexGPT::generateText(
    'Solve the problem: if there are 5 apples and 3 pears in a basket, how many fruits are there in total?',
    YandexGPTModel::YANDEX_GPT,
    [
        'reasoningOptions' => ReasoningOptions::enabledHidden(ReasoningOptions::EFFORT_LOW)
    ]
);

// Enable reasoning mode with high effort level
$response = YandexGPT::generateText(
    'Explain quantum entanglement in simple terms',
    YandexGPTModel::YANDEX_GPT,
    [
        'reasoningOptions' => ReasoningOptions::enabledHidden(ReasoningOptions::EFFORT_HIGH)
    ]
);

// Disable reasoning mode (explicitly)
$response = YandexGPT::generateText(
    'Hello, how are you?',
    YandexGPTModel::YANDEX_GPT,
    [
        'reasoningOptions' => ReasoningOptions::disabled()
    ]
);
```

#### Using array

```php
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

// Enable reasoning mode
$response = YandexGPT::generateText(
    'What are the advantages of using Docker in development?',
    YandexGPTModel::YANDEX_GPT,
    [
        'reasoningOptions' => [
            'mode' => 'ENABLED_HIDDEN',
            'effort' => 'medium'
        ]
    ]
);

// Mode only, without specifying effort level
$response = YandexGPT::generateText(
    'Write a bubble sort algorithm',
    YandexGPTModel::YANDEX_GPT,
    [
        'reasoningOptions' => [
            'mode' => 'ENABLED_HIDDEN'
        ]
    ]
);
```

#### Using with dialogs

```php
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;
use Tigusigalpa\YandexGPT\Models\ReasoningOptions;

$messages = [
    [
        'role' => 'system',
        'text' => 'You are a math assistant'
    ],
    [
        'role' => 'user',
        'text' => 'Solve the equation: 2x + 5 = 15'
    ]
];

$response = YandexGPT::generateFromMessages(
    $messages,
    YandexGPTModel::YANDEX_GPT,
    [
        'reasoningOptions' => ReasoningOptions::enabledHidden(ReasoningOptions::EFFORT_MEDIUM),
        'completionOptions' => [
            'temperature' => 0.3,
            'maxTokens' => 1000
        ]
    ]
);
```

#### Checking reasoning token usage

When using reasoning mode, the response may contain information about the number of tokens used for reasoning:

```php
$response = YandexGPT::generateText(
    'Complex mathematical problem...',
    YandexGPTModel::YANDEX_GPT,
    [
        'reasoningOptions' => ReasoningOptions::enabledHidden(ReasoningOptions::EFFORT_HIGH)
    ]
);

// Check reasoning tokens
if (isset($response['result']['alternatives'][0]['reasoningTokens'])) {
    $reasoningTokens = $response['result']['alternatives'][0]['reasoningTokens'];
    echo "Reasoning tokens used: {$reasoningTokens}\n";
}

echo $response['result']['alternatives'][0]['message']['text'];
```

**Note:** Reasoning mode is available for the YandexGPT Pro model and may increase the total number of request tokens.

---

## Error handling

```php
<?php

use Tigusigalpa\YandexGPT\Exceptions\AuthenticationException;
use Tigusigalpa\YandexGPT\Exceptions\ApiException;
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;

try {
    $response = YandexGPT::generateText('Hello!');
} catch (AuthenticationException $e) {
    // Authentication errors (invalid token, access rights)
    Log::error('YandexGPT Auth Error: ' . $e->getMessage());
} catch (ApiException $e) {
    // API errors (invalid parameters, limits)
    Log::error('YandexGPT API Error: ' . $e->getMessage());
} catch (Exception $e) {
    // Other errors
    Log::error('YandexGPT Error: ' . $e->getMessage());
}
```

---

## Configuration file

Full configuration file `config/yandexgpt.php`:

```php
<?php

return [
    // OAuth token
    'oauth_token' => env('YANDEX_GPT_OAUTH_TOKEN'),
    
    // Folder ID
    'folder_id' => env('YANDEX_GPT_FOLDER_ID'),
    
    // Default model
    'default_model' => env('YANDEX_GPT_DEFAULT_MODEL', 'yandexgpt-lite'),
    
    // Default parameters
    'default_options' => [
        'temperature' => (float) env('YANDEX_GPT_TEMPERATURE', 0.6),
        'maxTokens' => (int) env('YANDEX_GPT_MAX_TOKENS', 2000),
        'stream' => false,
    ],
    
    // HTTP client settings
    'http_options' => [
        'timeout' => (int) env('YANDEX_GPT_TIMEOUT', 30),
        'connect_timeout' => (int) env('YANDEX_GPT_CONNECT_TIMEOUT', 10),
    ],
];
```

---

## Examples

#### 1. Laravel Chatbot with Conversation History

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

class ChatBotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'array'
        ]);

        $messages = $request->input('history', []);
        $messages[] = [
            'role' => 'user',
            'text' => $request->input('message')
        ];

        try {
            $response = YandexGPT::generateFromMessages(
                $messages,
                YandexGPTModel::YANDEX_GPT_LITE
            );

            $botResponse = $response['result']['alternatives'][0]['message']['text'];
            
            $messages[] = [
                'role' => 'assistant',
                'text' => $botResponse
            ];

            return response()->json([
                'success' => true,
                'response' => $botResponse,
                'history' => $messages
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while generating the response'
            ], 500);
        }
    }
}
```

#### 2. SEO-Optimized Content Generation

```php
<?php

use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

class ContentGenerator
{
    public function generateArticle(string $topic, int $length = 1000): string
    {
        $prompt = "Write an article on the topic '{$topic}'. The article should be approximately {$length} words long. Include an introduction, main body, and conclusion.";

        $response = YandexGPT::generateText(
            $prompt,
            YandexGPTModel::YANDEX_GPT,
            [
                'completionOptions' => [
                    'temperature' => 0.7,
                    'maxTokens' => $length * 2 // Approximately 2 tokens per word
                ]
            ]
        );

        return $response['result']['alternatives'][0]['message']['text'];
    }

    public function generateSEODescription(string $content): string
    {
        $prompt = "Create an SEO description (meta description) for the following content. The description should be up to 160 characters:\n\n{$content}";

        $response = YandexGPT::generateText($prompt, YandexGPTModel::YANDEX_GPT_LITE);

        return $response['result']['alternatives'][0]['message']['text'];
    }

    public function generateProductDescription(array $productData): string
    {
        $prompt = "Create an attractive product description for an online store:\n";
        $prompt .= "Name: {$productData['name']}\n";
        $prompt .= "Features: " . implode(', ', $productData['features']) . "\n";
        $prompt .= "The description should be SEO-optimized, contain keywords and a call to action.";

        $response = YandexGPT::generateText(
            $prompt,
            YandexGPTModel::YANDEX_GPT,
            [
                'completionOptions' => [
                    'temperature' => 0.6,
                    'maxTokens' => 500
                ]
            ]
        );

        return $response['result']['alternatives'][0]['message']['text'];
    }

    public function generateBlogPost(string $topic, array $keywords): array
    {
        $keywordsList = implode(', ', $keywords);
        $prompt = "Write an SEO-optimized blog article on the topic: '{$topic}'.\n";
        $prompt .= "Be sure to use keywords: {$keywordsList}.\n";
        $prompt .= "Structure: H1 title, introduction, 3-4 H2 subheadings with content, conclusion.\n";
        $prompt .= "Length: 1500-2000 words.";

        $response = YandexGPT::generateText(
            $prompt,
            YandexGPTModel::YANDEX_GPT,
            [
                'completionOptions' => [
                    'temperature' => 0.7,
                    'maxTokens' => 3000
                ],
                'reasoningOptions' => ReasoningOptions::enabledHidden(ReasoningOptions::EFFORT_MEDIUM)
            ]
        );

        $content = $response['result']['alternatives'][0]['message']['text'];
        $metaDescription = $this->generateSEODescription($content);

        return [
            'content' => $content,
            'meta_description' => $metaDescription,
            'keywords' => $keywords
        ];
    }
}
```

#### 3. Customer Support Automation

```php
<?php

use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

class CustomerSupportBot
{
    private array $knowledgeBase;

    public function __construct()
    {
        $this->knowledgeBase = [
            'Information about company, products, services, return policies, etc.'
        ];
    }

    public function answerQuestion(string $question, array $conversationHistory = []): string
    {
        $systemPrompt = "You are a support assistant. Use the following knowledge base for answers:\n";
        $systemPrompt .= implode("\n", $this->knowledgeBase);

        $messages = [
            ['role' => 'system', 'text' => $systemPrompt],
            ...$conversationHistory,
            ['role' => 'user', 'text' => $question]
        ];

        $response = YandexGPT::generateFromMessages(
            $messages,
            YandexGPTModel::ALICE_AI,
            [
                'completionOptions' => [
                    'temperature' => 0.5,
                    'maxTokens' => 1000
                ]
            ]
        );

        return $response['result']['alternatives'][0]['message']['text'];
    }
}
```

#### 4. Sentiment Analysis and Review Processing

```php
<?php

use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

class ReviewAnalyzer
{
    public function analyzeSentiment(string $review): array
    {
        $prompt = "Analyze the sentiment of the following review and return the result in JSON format:\n";
        $prompt .= "Review: {$review}\n\n";
        $prompt .= "Response format: {\"sentiment\": \"positive/negative/neutral\", \"score\": 0-10, \"key_points\": [\"point1\", \"point2\"]}";

        $response = YandexGPT::generateText(
            $prompt,
            YandexGPTModel::YANDEX_GPT,
            [
                'completionOptions' => [
                    'temperature' => 0.3,
                    'maxTokens' => 500
                ]
            ]
        );

        $result = $response['result']['alternatives'][0]['message']['text'];
        return json_decode($result, true) ?? [];
    }

    public function generateResponse(string $review, string $sentiment): string
    {
        $prompt = "Generate a professional response to a customer review (sentiment: {$sentiment}):\n{$review}";

        $response = YandexGPT::generateText(
            $prompt,
            YandexGPTModel::YANDEX_GPT,
            [
                'completionOptions' => [
                    'temperature' => 0.7,
                    'maxTokens' => 300
                ]
            ]
        );

        return $response['result']['alternatives'][0]['message']['text'];
    }
}
```

#### 5. Content Image Generation

```php
<?php

use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

class ContentImageGenerator
{
    public function generateArticleImage(string $articleTitle, string $articleSummary): string
    {
        // First, generate an optimal prompt for the image
        $promptGeneration = "Create a detailed prompt for generating an image for an article:\n";
        $promptGeneration .= "Title: {$articleTitle}\n";
        $promptGeneration .= "Summary: {$articleSummary}\n";
        $promptGeneration .= "The prompt should describe the visual concept, style, color palette.";

        $textResponse = YandexGPT::generateText(
            $promptGeneration,
            YandexGPTModel::YANDEX_GPT_LITE
        );

        $imagePrompt = $textResponse['result']['alternatives'][0]['message']['text'];

        // Generate the image
        $result = YandexGPT::generateImage($imagePrompt);
        
        // Save the image
        $filename = 'article_' . time() . '.jpg';
        $path = storage_path('app/public/images/' . $filename);
        file_put_contents($path, base64_decode($result['image_base64']));

        return $filename;
    }
}
```

---

## Testing

```bash
composer install
composer test
composer test-coverage
```

---

## Troubleshooting

**"Class 'YandexGPTClient' not found"** — `composer show tigusigalpa/yandexgpt-php`, then `composer dump-autoload`.

**"OAuth token not configured"** — check `YANDEX_GPT_OAUTH_TOKEN` in `.env`, then `php artisan config:clear`.

**401 Unauthorized** — check your OAuth token (valid for 1 year) and folder access rights.

**403 Forbidden** — the user must have the `ai.languageModels.user` role on the folder.

**Connection timeout** — increase `timeout` in `config/yandexgpt.php`.

---

## Conversations API

The SDK supports the Conversations API for managing conversations and their items on the Yandex Cloud server side.

Documentation: [REST: Conversations](https://yandex.cloud/ru/docs/ai-studio/conversations/)

### Available Methods

| Method | Description |
|--------|-------------|
| `create()` | Create a new conversation |
| `get()` | Retrieve a conversation by ID |
| `update()` | Update conversation metadata |
| `delete()` | Delete a conversation |
| `createItems()` | Add items to a conversation |
| `listItems()` | List conversation items |
| `getItem()` | Retrieve a single conversation item |
| `deleteItem()` | Delete an item from a conversation |

### Managing Conversations

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;

$client = new YandexGPTClient('your_oauth_token', 'your_folder_id');

// Create a conversation with metadata
$conversation = $client->conversations()->create([
    'title' => 'Technical Support',
    'user_id' => '12345',
]);

$conversationId = $conversation['id'];
echo "Conversation ID: " . $conversationId . "\n";
echo "Created at: " . $conversation['created_at'] . "\n";

// Retrieve a conversation
$conversation = $client->conversations()->get($conversationId);

// Update conversation metadata
$conversation = $client->conversations()->update($conversationId, [
    'title' => 'Updated Title',
    'status' => 'active',
]);

// Delete a conversation
$result = $client->conversations()->delete($conversationId);
// $result['deleted'] === true
```

### Managing Conversation Items

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;

$client = new YandexGPTClient('your_oauth_token', 'your_folder_id');
$conversationId = 'conv_123';

// Add items to a conversation
$items = $client->conversations()->createItems($conversationId, [
    [
        'type' => 'message',
        'role' => 'user',
        'content' => [['type' => 'input_text', 'text' => 'Hello! How are you?']],
    ],
    [
        'type' => 'message',
        'role' => 'assistant',
        'content' => [['type' => 'output_text', 'text' => 'Hi! I am doing great, how can I help?']],
    ],
]);

// List items (with pagination)
$items = $client->conversations()->listItems($conversationId, 20, 'asc');
foreach ($items['data'] as $item) {
    echo $item['role'] . ': ' . ($item['content'][0]['text'] ?? '') . "\n";
}

// Pagination: get the next page
if ($items['has_more']) {
    $nextPage = $client->conversations()->listItems(
        $conversationId,
        20,
        'asc',
        $items['last_id']
    );
}

// Retrieve a single item
$item = $client->conversations()->getItem($conversationId, 'item_123');

// Delete an item
$client->conversations()->deleteItem($conversationId, 'item_123');
```

### Using via Laravel Facade

```php
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;

// Create a conversation
$conversation = YandexGPT::conversations()->create(['title' => 'New Conversation']);

// Add messages
YandexGPT::conversations()->createItems($conversation['id'], [
    [
        'type' => 'message',
        'role' => 'user',
        'content' => [['type' => 'input_text', 'text' => 'User question']],
    ],
]);

// Get history
$history = YandexGPT::conversations()->listItems($conversation['id'], 50, 'asc');
```

---

## Image Generation (YandexART)

<img src="https://github.com/user-attachments/assets/e9fdb285-e575-40ef-b240-824a990e097f" alt="YandexART Hero Image">

> Resources:
> - Documentation: https://yandex.cloud/en/docs/ai-studio/quickstart/yandexart
> - [Request documentation](https://yandex.cloud/en/docs/ai-studio/operations/generation/yandexart-request#generate-text)
> - Website: https://ya.ru/ai/papers/paper-yaart-v1

The SDK supports image generation using YandexART. There are three methods available:

- **generateImageAsync** — submit a generation request and receive an Operation object
- **getOperation** — check the operation status by its ID
- **generateImage** — synchronous wrapper that waits for the result

Access requirements:

- You must assign the `ai.imageGeneration.user` role to the Folder where image generation will be performed
- For text models, the `ai.languageModels.user` role is also required

YandexART model:

- Uses `yandex-art/latest` with URI `art://<folder_id>/yandex-art/latest`

Usage examples

1) Basic asynchronous generation:

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;

$client = new YandexGPTClient(env('YANDEX_GPT_OAUTH_TOKEN'), env('YANDEX_GPT_FOLDER_ID'));

// Prompt string or an array of messages (see format below)
$operation = $client->generateImageAsync('Rocky sea shore at sunset, painting style');
$operationId = $operation['id'];

// Check operation status
$op = $client->getOperation($operationId);
if (!empty($op['done']) && empty($op['error'])) {
    $imageBase64 = $op['response']['image'] ?? null;
    if ($imageBase64) {
        file_put_contents('art.jpg', base64_decode($imageBase64));
    }
}
```

2) Synchronous generation with result waiting:

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;

$client = new YandexGPTClient(env('YANDEX_GPT_OAUTH_TOKEN'), env('YANDEX_GPT_FOLDER_ID'));

$result = $client->generateImage('Futuristic city at night, neon lights');
file_put_contents('city.jpg', base64_decode($result['image_base64']));
echo '<img src="data:image/png;base64,'.$response['image_base64'].'">';
```

### Example of a generated image of Omsk

![Omsk city](https://github.com/user-attachments/assets/96b69b45-0d3d-4c17-90c8-e08ace4c7f59)

3) Using Laravel Facade:

```php
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;

$result = YandexGPT::generateImage('Cozy cabin by the lake in winter, watercolor style');
file_put_contents('lake.jpg', base64_decode($result['image_base64']));
echo '<img src="data:image/png;base64,'.$response['image_base64'].'">';
```

4) Prompt chaining (YandexGPT → YandexART):

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

$client = new YandexGPTClient(env('YANDEX_GPT_OAUTH_TOKEN'), env('YANDEX_GPT_FOLDER_ID'));

// First, generate a text prompt with YandexGPT
$textResponse = $client->generateText(
    "Generate a concise, detailed prompt for an image in digital painting style on the theme: 'Flight over the Alpine mountains'. Specify the style, color palette, and key details.",
    YandexGPTModel::YANDEX_GPT_LITE
);

$generatedPrompt = $textResponse['result']['alternatives'][0]['message']['text'] ?? null;

// Then pass the resulting prompt to YandexART
if ($generatedPrompt) {
    $result = $client->generateImage($generatedPrompt);
    file_put_contents('alps.jpg', base64_decode($result['image_base64']));
}
```

Message format for YandexART

The method accepts either a string (single prompt) or an array of messages.
Each message can be:

- a string: 'scene description'
- an array: ['text' => 'description', 'weight' => 1]

Example of a messages array:

```php
$messages = [
    ['text' => 'Mountains at sunrise', 'weight' => 1],
    ['text' => 'a lake in the foreground', 'weight' => 1],
    ['text' => 'impressionism style', 'weight' => 1],
];
$operation = $client->generateImageAsync($messages);
```

generationOptions parameters

The generationOptions parameter (optional) allows you to set generation settings.
The list of available options depends on the YandexART API. Example options:

```php
$generationOptions = [
    // Example: specify image type and size (check the docs for up-to-date keys)
    // @link https://yandex.cloud/en/docs/ai-studio/quickstart/yandexart#generate-image
    // 'mimeType' => 'image/jpeg',
    // 'size' => ['width' => 1024, 'height' => 1024],
    // 'aspectRatio' => ['widthRatio' => 16, 'heightRatio' => 9],
    // 'seed' => 1863,
];
$operation = $client->generateImageAsync('Scene description', $generationOptions);
```

Error handling

Methods may throw ApiException and AuthenticationException.
Check the error field in the operation response and the presence of response.image when completed successfully.

---

## Requirements

- PHP 8.0 or higher
- Laravel 8.0 or higher (for Laravel integration)
- Guzzle HTTP 7.0 or higher

---

## License

This package is distributed under the MIT license. See the [LICENSE](LICENSE) file for details.

---

## Links

- [YandexGPT API Documentation](https://yandex.cloud/en/docs/foundation-models/)
- [Quickstart](https://yandex.cloud/en/docs/foundation-models/quickstart/yandexgpt)
- [List of models](https://yandex.cloud/en/docs/ai-studio/concepts/generation/models)

---

## Contributing

We welcome contributions! Please see the [contribution guide](CONTRIBUTING.md).

---

## Changelog

All changes are documented in [CHANGELOG.md](CHANGELOG.md).

---

## Security

If you discover a security vulnerability, please send an email to sovletig@gmail.com instead of creating an issue.

---

## Author

[Igor Sazonov](https://github.com/tigusigalpa) — sovletig@gmail.com

