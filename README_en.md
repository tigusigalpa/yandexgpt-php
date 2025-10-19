# YandexGPT PHP SDK

<p align="right"><a href="./README.md">Русская версия</a></p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/cf603474-f9db-47ed-8d25-94f177cbed18" alt="YandexGPT PHP SDK Hero Image">
</p>

<p align="center">
    <a href="https://packagist.org/packages/tigusigalpa/yandexgpt-php"><img src="https://img.shields.io/packagist/v/tigusigalpa/yandexgpt-php.svg?style=flat-square" alt="Latest Version on Packagist"></a>
    <a href="https://github.com/tigusigalpa/yandexgpt-php"><img src="https://img.shields.io/badge/github-tigusigalpa%2Fyandexgpt--php-blue.svg?style=flat-square" alt="GitHub Repository"></a>
</p>

A full-featured PHP SDK for the YandexGPT API with Laravel support. The package provides a convenient interface for
integrating with Yandex Cloud AI models.

## 🚀 Features

- 🔌 Easy integration with the YandexGPT API
- 🔨 **YandexART integration**
- 🔐 Automatic management of OAuth and IAM tokens
- 🎯 Support for all available YandexGPT models
- 🛠 Full integration with Laravel (Service Provider, Facades, configuration)
- 📝 Support for dialogues and single requests
- ⚡ Automatic token renewal
- 🧪 Test coverage
- 📚 Detailed documentation

---

## 📦 Installation

### Installation from Packagist (recommended)

Install the package via Composer:

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

## ⚙️ Configuration

### 1. Get an OAuth token

📚 **Documentation:** [OAuth-token](https://yandex.cloud/ru/docs/iam/concepts/authorization/oauth-token)

Follow the link
to [get an OAuth token](https://oauth.yandex.com/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb):

```
https://oauth.yandex.com/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb
```

### 2. Configure the environment

Add to your `.env` file:

```env
YANDEX_GPT_OAUTH_TOKEN=your_oauth_token_here
# get the folder_id via a special request
YANDEX_GPT_FOLDER_ID=your_folder_id_here
YANDEX_GPT_DEFAULT_MODEL=yandexgpt-lite
YANDEX_GPT_TEMPERATURE=0.6
YANDEX_GPT_MAX_TOKENS=2000
```

### 3. Prepare Yandex Cloud

To work with the YandexGPT API, you need to perform several steps in Yandex Cloud. The SDK automates most of them, but
it is important to understand the process:

#### 3.1. Get an IAM token

The IAM token is obtained automatically through the SDK using the OAuth token. The token is valid for 12 hours and is
renewed automatically.

**Get via SDK:**

```php
use Tigusigalpa\YandexGPT\Auth\OAuthTokenManager;

// Create an authentication manager
$authManager = new OAuthTokenManager('your_oauth_token');

// Get an IAM token
$iamToken = $authManager->getIamToken();

echo "IAM Token: " . $iamToken . "\n";
```

**Automatic token management via YandexGPTClient:**

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;

// The client automatically gets and renews IAM tokens
$client = new YandexGPTClient('your_oauth_token', 'your_folder_id');

// Get the authentication manager for manual control
$authManager = $client->getAuthManager();
$iamToken = $authManager->getIamToken();
```

**Manual retrieval via API:**

```bash
curl -d "{\"yandexPassportOauthToken\":\"YOUR_OAUTH_TOKEN\"}" \
  "https://iam.api.cloud.yandex.net/iam/v1/tokens"
```

📚 **Documentation:
** [Getting an IAM token for a Yandex account](https://yandex.cloud/en/docs/iam/operations/iam-token/create#exchange-token)

#### 3.2. Get Cloud ID

**Via SDK:**

```php
use Tigusigalpa\YandexGPT\Auth\OAuthTokenManager;

$authManager = new OAuthTokenManager('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $authManager = YandexGPT::getAuthManager();
$clouds = $authManager->listClouds();

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

📚 **Documentation:** [Getting a cloud ID](https://yandex.cloud/en/docs/resource-manager/operations/cloud/get-id)

#### 3.3. Create a folder

**Via SDK:**

```php
$authManager = new OAuthTokenManager('your_oauth_token');
// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $authManager = YandexGPT::getAuthManager();

// Create a folder
$folder = $authManager->createFolder('cloud_id', 'my-ai-folder', 'Folder for AI projects');
$folderId = $folder['id'];

// Or get existing folders
$folders = $authManager->listFolders('cloud_id');
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

📚 **Documentation:** [Creating a folder](https://yandex.cloud/en/docs/resource-manager/operations/folder/create)

#### 3.4. Assign the ai.languageModels.user role

**Via SDK:**

```php
$authManager = new OAuthTokenManager('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $authManager = YandexGPT::getAuthManager();

// Assign a role to a user
$authManager->assignRole(
    'folder_id',
    'userAccount', // subject type
    'user_id',     // user ID
    'ai.languageModels.user'
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

📚 **Documentation:**

- [Assigning roles](https://yandex.cloud/en/docs/iam/operations/roles/grant)
- [Roles for Yandex Foundation Models](https://yandex.cloud/en/docs/foundation-models/security/)

#### 3.5. Full setup example

```php
<?php

use Tigusigalpa\YandexGPT\Auth\OAuthTokenManager;
use Tigusigalpa\YandexGPT\YandexGPTClient;

// 1. Initialize the authentication manager
$authManager = new OAuthTokenManager('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $authManager = YandexGPT::getAuthManager();

// 2. Get the list of clouds
$clouds = $authManager->listClouds();
$cloudId = $clouds[0]['id']; // Take the first cloud

// 3. Create a folder (if needed)
$folder = $authManager->createFolder($cloudId, 'ai-projects', 'Folder for AI');
$folderId = $folder['id'];

// 4. Assign a role (if needed)
$authManager->assignRole(
    $folderId,
    'userAccount',
    'your_user_id',
    'ai.languageModels.user'
);

// 5. Use the client
$client = new YandexGPTClient('your_oauth_token', $folderId);
$response = $client->generateText('Hello, how are you?');

echo $response['result']['alternatives'][0]['message']['text'];
```

#### 3.6. Useful links

- 📖 [YandexGPT Quickstart](https://yandex.cloud/en/docs/foundation-models/quickstart/yandexgpt)
- 🔑 [API Authentication](https://yandex.cloud/en/docs/iam/concepts/authorization/iam-token)
- 🏗️ [Resource Management](https://yandex.cloud/en/docs/resource-manager/)
- 🤖 [API Foundation Models](https://yandex.cloud/en/docs/foundation-models/concepts/api)
- 💰 [YandexGPT Pricing](https://yandex.cloud/en/docs/foundation-models/pricing)

---

## 💡 Usage

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
```

### Usage with Laravel

#### Integration via Service Provider

The package is automatically integrated with Laravel via a Service Provider, which performs the following functions:

**Automatic registration:**

```php
// In the package's composer.json:
"extra": {
    "laravel": {
        "providers": [
            "Tigusigalpa\\YandexGPT\\Laravel\\YandexGPTServiceProvider"
        ],
        "aliases": {
            "YandexGPT": "Tigusigalpa\\YandexGPT\\Laravel\\Facades\\YandexGPT"
        }
    }
}
```

**What the Service Provider does:**

1. **Register services** (`register()` method):
    - Merges the package configuration with the application configuration
    - Registers `YandexGPTClient` as a singleton in the container
    - Creates an alias for convenient dependency injection

   ```php
   public function register()
   {
       // Merge configuration
       $this->mergeConfigFrom(
           __DIR__ . '/../../config/yandexgpt.php',
           'yandexgpt'
       );

       // Register singleton
       $this->app->singleton('yandexgpt', function ($app) {
           $config = $app['config']['yandexgpt'];

           return new YandexGPTClient(
               $config['oauth_token'],
               $config['folder_id']
           );
       });

       // Create alias
       $this->app->alias('yandexgpt', YandexGPTClient::class);
   }
   ```

2. **Load services** (`boot()` method):
    - Publishes the configuration file for customization

   ```php
   public function boot()
   {
       if ($this->app->runningInConsole()) {
           $this->publishes([
               __DIR__ . '/../../config/yandexgpt.php' => config_path('yandexgpt.php'),
           ], 'yandexgpt-config');
       }
   }
   ```

3. **Define provided services** (`provides()` method):
    - Specifies which services the provider provides

   ```php
   public function provides()
   {
       return ['yandexgpt', YandexGPTClient::class];
   }
   ```

**Publishing the configuration:**

```bash
php artisan vendor:publish --tag=yandexgpt-config
```

After publishing, the configuration file will be available at `config/yandexgpt.php` for customization.

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

// Assign permissions
$authManager->assignRole(
    $iamToken,
    $folder['id'],
    'user_account_id',
    'ai.languageModels.user'
);
```

---

## 🤖 Available models

| Model            | Description               | Constant                          |
|------------------|---------------------------|-----------------------------------|
| `yandexgpt-lite` | Fast and economical model | `YandexGPTModel::YANDEX_GPT_LITE` |
| `yandexgpt`      | Standard model            | `YandexGPTModel::YANDEX_GPT`      |

📚 **Complete list of available models:**
[Generation models in Yandex AI Studio](https://yandex.cloud/en/docs/ai-studio/concepts/generation/models)

```php
// Get all available models
$models = YandexGPT::getAvailableModels();

// Get model descriptions
$descriptions = YandexGPT::getModelDescriptions();
```

---

## 🔧 Generation parameters

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

---

## ⚠️ Error handling

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

## 🛠️ Configuration

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

## 📚 Usage examples

### Chatbot for Laravel

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

### Content generation

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
}
```

---

## 🧪 Testing

### Running package tests

```bash
# Go to the package directory
cd packages/yandexgpt-php

# Install development dependencies
composer install

# Run tests
composer test

# Run tests with coverage
composer test-coverage
```

### Testing in a Laravel project

1. **Create a test controller or use an existing one:**

   ```php
   <?php

   namespace App\Http\Controllers;

   use Tigusigalpa\YandexGPT\YandexGPTClient;
   use Tigusigalpa\YandexGPT\Models\YandexGPTModel;
   use Tigusigalpa\YandexGPT\Exceptions\AuthenticationException;
   use Tigusigalpa\YandexGPT\Exceptions\ApiException;

   class TestYandexGPTController extends Controller
   {
       public function test()
       {
           try {
               $client = new YandexGPTClient(
                   env('YANDEX_GPT_OAUTH_TOKEN'),
                   env('YANDEX_GPT_FOLDER_ID')
               );

               $response = $client->generateText(
                   'Hello! This is a YandexGPT SDK test',
                   YandexGPTModel::YANDEX_GPT_LITE
               );

               return response()->json([
                   'success' => true,
                   'response' => $response['result']['alternatives'][0]['message']['text']
               ]);

           } catch (AuthenticationException $e) {
               return response()->json([
                   'success' => false,
                   'error' => 'Authentication error: ' . $e->getMessage()
               ], 401);
           } catch (ApiException $e) {
               return response()->json([
                   'success' => false,
                   'error' => 'API error: ' . $e->getMessage()
               ], 400);
           }
       }
   }
   ```

2. **Add a route for testing:**

   ```php
   // routes/web.php
   Route::get('/test-yandexgpt', [TestYandexGPTController::class, 'test']);
   ```

3. **Test via a browser or API client:**

   ```bash
   curl http://your-domain.com/test-yandexgpt
   ```

---

## ❓ Troubleshooting and FAQ

### Frequently Asked Questions

#### Q: How to get an OAuth token?

**A:** Follow the
link: https://oauth.yandex.com/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb

After authorization, copy the token from the URL.

#### Q: How to get a Folder ID?

**A:** Use the SDK to get a list of folders:

```php
$authManager = new OAuthTokenManager('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $authManager = YandexGPT::getAuthManager();
$clouds = $authManager->listClouds();
$folders = $authManager->listFolders($clouds[0]['id']);
```

#### Q: Why do I get the error "OAuth token cannot be empty"?

**A:** Make sure that `YANDEX_GPT_OAUTH_TOKEN` is correctly set in the `.env` file without spaces or quotes.

```

### Troubleshooting

#### Error: "Class 'Tigusigalpa\YandexGPT\YandexGPTClient' not found"

**Solution:**

1. Make sure the package is installed: `composer show tigusigalpa/yandexgpt-php`
2. Clear the autoloader: `composer dump-autoload`
3. Check that the package is added to `composer.json`

#### Error: "YandexGPT OAuth token not configured"

**Solution:**

1. Add to the `.env` file:

   ```env
   YANDEX_GPT_OAUTH_TOKEN=your_actual_token_here
   YANDEX_GPT_FOLDER_ID=your_folder_id_here
   ```

2. Clear the configuration cache: `php artisan config:clear`

#### Error: "YandexGPT API error (code 401): Unauthorized"

**Solution:**

1. Check the correctness of the OAuth token
2. Make sure the token has not expired (OAuth tokens are valid for 1 year)
3. Check the access rights to the folder

#### Error: "YandexGPT API error (code 403): Forbidden"

**Solution:**

1. Make sure the user has the `ai.languageModels.user` role
2. Check the correctness of the Folder ID
3. Make sure the folder exists and is accessible

#### Error: "Connection timeout"

**Solution:**

1. Increase the timeout in the configuration:

   ```php
   // config/yandexgpt.php
   'http_options' => [
       'timeout' => 60,
       'connect_timeout' => 30,
   ],
   ```

2. Check your internet connection
3. Make sure there is no firewall blocking

### Debugging

#### Enabling detailed logging

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

// Create an HTTP client with logging
$stack = HandlerStack::create();
$stack->push(Middleware::log(
    app('log')->getLogger(),
    new \GuzzleHttp\MessageFormatter('{method} {uri} HTTP/{version} {req_body} RESPONSE: {code} - {res_body}')
));

$httpClient = new Client(['handler' => $stack]);
$client = new YandexGPTClient('oauth_token', 'folder_id', $httpClient);
```

#### Checking the configuration

```php
// Check all settings
$config = config('yandexgpt');
dd($config);

// Check environment variables
dd([
    'oauth_token' => env('YANDEX_GPT_OAUTH_TOKEN'),
    'folder_id' => env('YANDEX_GPT_FOLDER_ID'),
]);
```

---

## 🖼️ Image Generation (YandexART)

<img src="https://github.com/user-attachments/assets/e9fdb285-e575-40ef-b240-824a990e097f" alt="YandexART Hero Image">

> 📚 Resources
> - 📖 Documentation: https://yandex.cloud/en/docs/ai-studio/quickstart/yandexart
> - 🎨 Website: https://ya.ru/ai/papers/paper-yaart-v1

The SDK supports image generation using YandexART. There are three methods available:

- 📨 **generateImageAsync** — submit a generation request and receive an Operation object
- 🔎 **getOperation** — check the operation status by its ID
- ⏳ **generateImage** — synchronous wrapper that waits for the result

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

## ✅ Requirements

- PHP 8.0 or higher
- Laravel 8.0 or higher (for Laravel integration)
- Guzzle HTTP 7.0 or higher

---

## 📄 License

This package is distributed under the MIT license. See the [LICENSE](LICENSE) file for details.

---

## 🤝 Support

- [YandexGPT API Documentation](https://yandex.cloud/en/docs/foundation-models/)
- [Quickstart](https://yandex.cloud/en/docs/foundation-models/quickstart/yandexgpt)
- [List of models](https://yandex.cloud/en/docs/ai-studio/concepts/generation/models)

---

## 🧑‍💻 Contributing

We welcome contributions! Please see the [contribution guide](CONTRIBUTING.md).

---

## 📜 Changelog

All changes are documented in [CHANGELOG.md](CHANGELOG.md).

---

## 🛡️ Security

If you discover a security vulnerability, please send an email to sovletig@gmail.com instead of creating an issue.

