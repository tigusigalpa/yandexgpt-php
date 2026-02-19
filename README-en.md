# YandexGPT PHP SDK

![YandexGPT PHP SDK](https://github.com/user-attachments/assets/758d8956-0126-4b32-a6ba-afa8c8948188)

[![Latest Version](https://img.shields.io/packagist/v/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
[![PHP Version](https://img.shields.io/packagist/php-v/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
[![License](https://img.shields.io/packagist/l/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
[![Dependencies](https://img.shields.io/packagist/dm/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)

**🌐 Language:** English | [Русский](README.md)

**A full-featured PHP SDK for working with YandexGPT API and YandexART** — a modern library for integrating Yandex Cloud artificial intelligence into PHP applications and Laravel projects. The package provides a simple and convenient interface for working with generative AI models, including text generation, dialogue systems, and image creation.

## 📋 Description

YandexGPT PHP SDK is a powerful tool for developers who want to integrate Yandex Cloud artificial intelligence capabilities into their PHP applications. The library supports all major YandexGPT models (including YandexGPT Lite, YandexGPT Pro, and Alice AI), as well as image generation via YandexART.

**Key Benefits:**
- ✨ Easy integration with any PHP project (PHP 8.0+)
- 🚀 Native Laravel support with Service Provider and Facades
- 🤖 Work with all YandexGPT and YandexART models
- 🔐 Automatic OAuth and IAM token management
- 💬 Support for dialogue systems and contextual conversations
- 🗂️ Conversations API — server-side conversation management
- 🎨 Image generation with YandexART
- 🧠 Reasoning Mode (Chain of Thought) for complex tasks
- 📦 Yandex Cloud infrastructure management
- 🛡️ Error and exception handling
- 📚 Detailed documentation and examples

**Use Cases:**
- Creating chatbots and virtual assistants
- Content generation for websites and blogs
- Automating customer support responses
- SEO optimization of texts and meta descriptions
- Natural language analysis and processing
- Creating unique images for content
- Developing AI-powered Laravel applications
- Integration with CMS and e-commerce platforms

> **Note:** This package uses [yandex-cloud-client-php](https://github.com/tigusigalpa/yandex-cloud-client-php) for
> managing Yandex Cloud infrastructure (organizations, clouds, folders, authorization).

## 🚀 Features

### Core Functions

- 🔌 **Easy YandexGPT API integration** — connect in 5 minutes
- 🔨 **YandexART support** — text-to-image generation
- 🔐 **Automatic OAuth and IAM token management** — no need to worry about renewal
- 🎯 **Support for all available YandexGPT models** — Lite, Pro, Alice AI
- 🛠 **Full Laravel integration** — Service Provider, Facades, configuration
- 📝 **Support for dialogues and single requests** — create chatbots and AI assistants
- ⚡ **Automatic token renewal** — seamless operation without interruptions
- 🧪 **Test coverage** — reliability and stability
- 📚 **Detailed documentation** — examples for all use cases

### Advanced Features

- 🧠 **Reasoning Mode (Chain of Thought)** — for solving complex logical problems
- 🎨 **Prompt Chaining** — combining YandexGPT and YandexART
- 🔄 **Cloud infrastructure management** — folder creation, role assignment
- 👥 **IAM and user management** — full access control
- 🌐 **Work with organizations and clouds** — corporate use
- ⚙️ **Flexible parameter configuration** — temperature, maxTokens, reasoning options
- 🔍 **Detailed error handling** — clear exceptions and logging
- 📊 **Token usage monitoring** — cost control

### Integration and Compatibility

- ✅ **PHP 8.0+** — modern syntax and typing
- ✅ **Laravel 8.0+** — full framework support
- ✅ **Composer** — standard installation via package manager
- ✅ **PSR-compatible** — following PHP standards
- ✅ **Dependency Injection** — clean architecture
- ✅ **Guzzle HTTP Client** — reliable HTTP requests

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

### 1. Getting an OAuth token

📚 **Documentation:** [OAuth-token](https://yandex.cloud/en/docs/iam/concepts/authorization/oauth-token)

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

📚 **Documentation:
** [Getting an IAM token for a Yandex account](https://yandex.cloud/en/docs/iam/operations/iam-token/create#exchange-token)

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

📚 **Documentation:** [Creating a folder](https://yandex.cloud/en/docs/resource-manager/operations/folder/create)

#### 3.4. Assigning roles to folder or cloud

📚 **Documentation:**

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

📚 **Documentation:**

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

### User and Role Management (IAM)

The SDK provides a complete set of functions for working with Identity and Access Management (IAM):

#### Getting user information

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

// 1. Get User ID (Subject ID) by Yandex login
$userInfo = $cloudClient->yandexPassportUserAccounts()->getByLogin('username@yandex.ru');
$userId = $userInfo['id'];
echo "User ID: " . $userId;

// 2. Get full user information by login
/*
Returns array:
[
    'id' => 'aje...',           // User Subject ID
    'yandexPassportUserAccount' => [
        'login' => 'username',
        'defaultEmail' => 'username@yandex.ru'
    ]
]
*/

// 3. Get user information by UserAccountId
$userAccount = $cloudClient->userAccounts()->get($userId);
/*
Returns array with full account information
*/
```

#### Assigning roles to folder

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

// Assign role to user on folder
$cloudClient->folders()->updateAccessBindings(
    'folder_id',              // Folder ID
    [
        [
            'action' => 'ADD',
            'accessBinding' => [
                'roleId' => 'ai.languageModels.user', // Role
                'subject' => [
                    'id' => 'user_subject_id',        // User Subject ID
                    'type' => 'userAccount'           // Subject type
                ]
            ]
        ]
    ]
);

// Assign role to service account
$cloudClient->folders()->updateAccessBindings(
    'folder_id',
    [
        [
            'action' => 'ADD',
            'accessBinding' => [
                'roleId' => 'ai.languageModels.user',
                'subject' => [
                    'id' => 'service_account_id',
                    'type' => 'serviceAccount'        // For service account
                ]
            ]
        ]
    ]
);

// Available roles for AI:
// - ai.languageModels.user - use models
// - ai.editor - edit resources
// - ai.viewer - view resources
// - editor - full folder access
// - viewer - view folder
```

#### Assigning roles to cloud

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

// Assign role to cloud
$cloudClient->clouds()->updateAccessBindings(
    'cloud_id',        // Cloud ID
    [
        [
            'action' => 'ADD',
            'accessBinding' => [
                'roleId' => 'editor',          // Cloud role
                'subject' => [
                    'id' => 'user_subject_id', // User Subject ID
                    'type' => 'userAccount'    // Subject type
                ]
            ]
        ]
    ]
);

// Available roles for cloud:
// - admin - cloud administrator
// - editor - cloud editor
// - viewer - view cloud
// - resource-manager.clouds.owner - cloud owner
```

#### Complete example: get user and assign role

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

try {
    // 1. Get User ID by login
    $userInfo = $cloudClient->yandexPassportUserAccounts()->getByLogin('username@yandex.ru');
    $userId = $userInfo['id'];
    echo "User ID: {$userId}\n";
    
    // 2. Get user information
    $userAccount = $cloudClient->userAccounts()->get($userId);
    echo "User info: " . json_encode($userAccount, JSON_PRETTY_PRINT) . "\n";
    
    // 3. Assign role to folder
    $cloudClient->folders()->updateAccessBindings(
        'your_folder_id',
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
    
    echo "Role assigned successfully!\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

---

## 🤖 Available YandexGPT Models

The SDK supports all current generative AI models from Yandex Cloud:

| Model            | Description                                  | Constant                          | Context | Application |
|------------------|----------------------------------------------|-----------------------------------|---------|-------------|
| `yandexgpt-lite` | Fast and economical model                    | `YandexGPTModel::YANDEX_GPT_LITE` | 32K     | Simple queries, chatbots, FAQ |
| `yandexgpt`      | Standard model (Pro)                         | `YandexGPTModel::YANDEX_GPT`      | 32K     | Content generation, text analysis |
| `aliceai-llm`    | Alice AI LLM - advanced conversational model | `YandexGPTModel::ALICE_AI`        | 32K     | Dialogue systems, assistants |

### Choosing a Model for Your Task

**YandexGPT Lite** — ideal for:
- Quick answers to simple questions
- Chatbots with basic functionality
- Processing large volumes of requests
- Budget-friendly token usage

**YandexGPT Pro** — recommended for:
- Quality content generation
- SEO-optimized texts
- Complex analytical tasks
- Working with reasoning mode

**Alice AI** — optimal for:
- Natural dialogues with users
- Virtual assistants
- Conversational interfaces
- Personalized communication

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

### 🧠 Reasoning Mode

Reasoning mode allows the model to break down tasks into steps and perform sequential chains of computations to improve answer accuracy. This mode is especially useful for tasks requiring logical reasoning.

📚 **Documentation:** [Reasoning mode in generative models](https://yandex.cloud/en/docs/ai-studio/concepts/generation/chain-of-thought)

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

## 📚 Practical Usage Examples

### Real-World YandexGPT PHP SDK Application Scenarios

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

## 🆚 Comparison with Alternatives

### YandexGPT PHP SDK vs OpenAI PHP

| Feature | YandexGPT PHP SDK | OpenAI PHP |
|---------|-------------------|------------|
| **Localization** | Excellent Russian language support | Good, but not native |
| **Pricing** | Competitive prices for Russian market | Payment in foreign currency |
| **Legal Compliance** | Full compliance with Russian legislation | Requires additional measures |
| **Yandex Cloud Integration** | Native | Not available |
| **Image Generation** | YandexART built-in | Requires DALL-E |
| **Laravel Integration** | Service Provider + Facades | Requires additional setup |
| **Infrastructure Management** | Built-in cloud management | Not available |

### Benefits of Using YandexGPT for Russian Projects

✅ **Legal Compliance** — data stored in Russia  
✅ **Russian Language Quality** — models trained on Russian data  
✅ **Stability** — independent of international sanctions  
✅ **Russian Support** — documentation and support in native language  
✅ **Yandex Ecosystem Integration** — unified infrastructure  
✅ **Transparent Pricing** — payment in rubles  

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

#### Q: What is YandexGPT and what is it for?

**A:** YandexGPT is a family of generative language models from Yandex Cloud that can generate text, conduct dialogues, analyze information, and solve various natural language processing tasks. The SDK makes it easy to integrate these capabilities into PHP applications.

#### Q: Which model is best for my task?

**A:** 
- **YandexGPT Lite** — for simple tasks, chatbots, FAQ (fast and economical)
- **YandexGPT Pro** — for quality content generation, SEO texts, complex tasks
- **Alice AI** — for natural dialogues and conversational interfaces

#### Q: How much does YandexGPT cost?

**A:** The cost depends on the model and number of tokens. See current prices in [Yandex Cloud documentation](https://yandex.cloud/en/docs/foundation-models/pricing). YandexGPT Lite is the most economical option.

#### Q: Can I use the SDK without Laravel?

**A:** Yes, the SDK works fully in any PHP project (PHP 8.0+). Laravel integration is optional and provides additional conveniences (Facades, Service Provider).

#### Q: How to get an OAuth token?

**A:** Follow the
link: https://oauth.yandex.com/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb

After authorization, copy the token from the URL.

#### Q: How to get a Folder ID?

**A:** Use the SDK to get a list of folders:

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

$clouds = $cloudClient->clouds()->list();
$folders = $cloudClient->folders()->list($clouds[0]['id']);
```

#### Q: Why do I get the error "OAuth token cannot be empty"?

**A:** Make sure that `YANDEX_GPT_OAUTH_TOKEN` is correctly set in the `.env` file without spaces or quotes.

```

#### Q: Is it safe to store the OAuth token in the .env file?

**A:** Yes, this is standard practice for Laravel. Make sure:
- The `.env` file is added to `.gitignore`
- Production uses server environment variables
- File access permissions are restricted (chmod 600)

#### Q: Can I use the SDK for commercial projects?

**A:** Yes, the package is distributed under the MIT license, which allows free use in commercial projects.

#### Q: Is streaming supported?

**A:** Streaming is not implemented in the current version but is planned for future updates.

#### Q: How to limit token usage?

**A:** Use the `maxTokens` parameter in generation options:
```php
$response = YandexGPT::generateText(
    'Your request',
    YandexGPTModel::YANDEX_GPT_LITE,
    [
        'completionOptions' => [
            'maxTokens' => 500  // Limit
        ]
    ]
);
```

#### Q: Can I use multiple folders?

**A:** Yes, create separate client instances for different folders:
```php
$client1 = new YandexGPTClient($oauthToken, $folderId1);
$client2 = new YandexGPTClient($oauthToken, $folderId2);
```

#### Q: How to handle large volumes of text?

**A:** Split text into parts considering the context limit (32K tokens) or use summarization:
```php
$summary = YandexGPT::generateText(
    "Briefly summarize the main ideas of the text: {$longText}",
    YandexGPTModel::YANDEX_GPT
);
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

## � Conversations API

The SDK supports the Conversations API for managing conversations and their items on the Yandex Cloud server side.

📚 **Documentation:** [REST: Conversations](https://yandex.cloud/ru/docs/ai-studio/conversations/)

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

## �🖼️ Image Generation (YandexART)

<img src="https://github.com/user-attachments/assets/e9fdb285-e575-40ef-b240-824a990e097f" alt="YandexART Hero Image">

> 📚 Resources
> - 📖 Documentation: https://yandex.cloud/en/docs/ai-studio/quickstart/yandexart
> - 🛠️ [Request](https://yandex.cloud/en/docs/ai-studio/operations/generation/yandexart-request#generate-text)
    documentation
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

---

## 🔑 Keywords and Tags

`yandexgpt`, `yandex-gpt`, `yandex-cloud`, `yandex-ai`, `yandexart`, `php-sdk`, `laravel`, `laravel-package`, `ai`, `artificial-intelligence`, `machine-learning`, `nlp`, `natural-language-processing`, `chatbot`, `chat-bot`, `gpt`, `language-model`, `text-generation`, `image-generation`, `conversations-api`, `russian-language`, `php8`, `composer-package`, `api-client`, `yandex-api`, `generative-ai`, `llm`, `large-language-model`, `alice-ai`, `reasoning-mode`, `chain-of-thought`, `prompt-engineering`, `content-generation`, `seo-tools`, `php-library`

## 📊 Statistics and Performance

- ⚡ **Response Speed**: YandexGPT Lite — 1-3 seconds
- 🎯 **Accuracy**: High accuracy for Russian language queries
- 💾 **Context**: Up to 32K tokens (approximately 24K words)
- 🔄 **Token Renewal**: Automatic every 12 hours
- 📦 **Package Size**: Minimal dependencies, fast installation

## 🌟 Reviews and Use Cases

### Where YandexGPT PHP SDK is Used

- 🛒 **E-commerce**: Product description generation, customer support
- 📰 **Media and Blogs**: Content automation, SEO optimization
- 💼 **Corporate Systems**: Internal chatbots, document processing
- 🎓 **Education**: Learning assistants, text verification
- 🏥 **Healthcare**: Information systems, FAQ bots
- 🏢 **Business Analytics**: Review analysis, request processing

## 🚀 Roadmap and Development Plans

- [ ] Streaming support
- [ ] Extended YandexART capabilities
- [ ] Integration with other Yandex Cloud services
- [ ] Request caching for optimization
- [ ] Extended token usage analytics
- [ ] Asynchronous request support
- [ ] CLI tools for quick testing
- [ ] Additional adapters for popular CMS

## 📱 Contacts and Community

- 📧 **Email**: sovletig@gmail.com
- 🐙 **GitHub**: [tigusigalpa/yandexgpt-php](https://github.com/tigusigalpa/yandexgpt-php)
- 📦 **Packagist**: [tigusigalpa/yandexgpt-php](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
- 📚 **Yandex Cloud Documentation**: [foundation-models](https://yandex.cloud/en/docs/foundation-models/)

## 💡 Useful Resources

### Official Yandex Cloud Documentation
- [YandexGPT API](https://yandex.cloud/en/docs/foundation-models/concepts/yandexgpt/)
- [YandexART](https://yandex.cloud/en/docs/ai-studio/quickstart/yandexart)
- [Generation Models](https://yandex.cloud/en/docs/ai-studio/concepts/generation/models)
- [Pricing](https://yandex.cloud/en/docs/foundation-models/pricing)
- [Best Practices](https://yandex.cloud/en/docs/foundation-models/concepts/yandexgpt/)

### Learning Materials
- [Prompt Engineering for YandexGPT](https://yandex.cloud/en/docs/foundation-models/concepts/yandexgpt/)
- [Usage Examples](https://github.com/tigusigalpa/yandexgpt-php/tree/main/examples)
- [Video Tutorials and Webinars](https://yandex.cloud/en/training)

---

**YandexGPT PHP SDK** — your reliable tool for integrating artificial intelligence into PHP applications. Start using generative AI capabilities today!

⭐ If the project was helpful, give it a star on GitHub!

