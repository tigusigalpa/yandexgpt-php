# YandexGPT PHP SDK

<p align="right"><a href="./README_en.md">English version</a></p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/cf603474-f9db-47ed-8d25-94f177cbed18" alt="YandexGPT PHP SDK Hero Image">
</p>

<p align="center">
    <a href="https://packagist.org/packages/tigusigalpa/yandexgpt-php"><img src="https://img.shields.io/packagist/v/tigusigalpa/yandexgpt-php.svg?style=flat-square" alt="Latest Version on Packagist"></a>
    <a href="https://github.com/tigusigalpa/yandexgpt-php"><img src="https://img.shields.io/badge/github-tigusigalpa%2Fyandexgpt--php-blue.svg?style=flat-square" alt="GitHub Repository"></a>
</p>

Полнофункциональный PHP SDK для работы с YandexGPT API с поддержкой Laravel. Пакет предоставляет удобный интерфейс для
интеграции с AI моделями Yandex Cloud, включая поддержку YandexART.

## 🚀 Возможности

- 🔌 Простая интеграция с YandexGPT API
- 🔨 **Поддержка YandexART**
- 🔐 Автоматическое управление OAuth и IAM токенами
- 🎯 Поддержка всех доступных моделей YandexGPT
- 🛠 Полная интеграция с Laravel (Service Provider, Facades, конфигурация)
- 📝 Поддержка диалогов и одиночных запросов
- ⚡ Автоматическое обновление токенов
- 🧪 Покрытие тестами
- 📚 Подробная документация

---

## 📦 Установка

### Установка из Packagist (рекомендуется)

Установите пакет через Composer:

```bash
composer require tigusigalpa/yandexgpt-php
```

### Локальная разработка

Если вы хотите использовать пакет локально для разработки или тестирования:

#### Способ 1: Через локальный репозиторий

1. **Клонируйте или поместите пакет в папку проекта:**

```bash
# В корне вашего Laravel проекта
mkdir -p packages
cd packages
git clone https://github.com/tigusigalpa/yandexgpt-php.git
# или скопируйте папку с пакетом в packages/yandexgpt-php
```

2. **Добавьте локальный репозиторий в composer.json вашего проекта:**

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

3. **Установите зависимости:**

```bash
composer install
# или если пакет уже был установлен
composer update tigusigalpa/yandexgpt-php
```

#### Способ 2: Через симлинки

1. **Создайте симлинк в vendor:**

```bash
# Удалите существующий пакет (если есть)
rm -rf vendor/tigusigalpa/yandexgpt-php

# Создайте симлинк
ln -s ../../packages/yandexgpt-php vendor/tigusigalpa/yandexgpt-php
```

#### Способ 3: Через VCS репозиторий

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

### Для Laravel

Пакет автоматически регистрируется в Laravel благодаря автодискавери. Опубликуйте конфигурационный файл:

```bash
php artisan vendor:publish --tag=yandexgpt-config
```

---

## ⚙️ Настройка

### 1. Получение OAuth токена

Перейдите по ссылке для получения OAuth токена:

```
https://oauth.yandex.ru/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb
```

### 2. Настройка окружения

Добавьте в ваш `.env` файл:

```env
YANDEX_GPT_OAUTH_TOKEN=your_oauth_token_here
# получите folder_id через специальный запрос
YANDEX_GPT_FOLDER_ID=your_folder_id_here
YANDEX_GPT_DEFAULT_MODEL=yandexgpt-lite
YANDEX_GPT_TEMPERATURE=0.6
YANDEX_GPT_MAX_TOKENS=2000
```

### 3. Подготовка Yandex Cloud

Для работы с YandexGPT API необходимо выполнить несколько шагов в Yandex Cloud. SDK автоматизирует большинство из них,
но важно понимать процесс:

#### 3.1. Получение IAM токена

IAM токен получается автоматически через SDK с помощью OAuth токена. Токен действует 12 часов и обновляется
автоматически.

**Получение через SDK:**

```php
use Tigusigalpa\YandexGPT\Auth\OAuthTokenManager;

// Создание менеджера аутентификации
$authManager = new OAuthTokenManager('your_oauth_token');

// Получение IAM токена
$iamToken = $authManager->getIamToken();

echo "IAM Token: " . $iamToken . "\n";
```

**Автоматическое управление токенами через YandexGPTClient:**

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;

// Клиент автоматически получает и обновляет IAM токены
$client = new YandexGPTClient('your_oauth_token', 'your_folder_id');

// Получение менеджера аутентификации для ручного управления
$authManager = $client->getAuthManager();
$iamToken = $authManager->getIamToken();
```

**Ручное получение через API:**

```bash
curl -d "{\"yandexPassportOauthToken\":\"YOUR_OAUTH_TOKEN\"}" \
  "https://iam.api.cloud.yandex.net/iam/v1/tokens"
```

📚 **Документация:**
[Получение IAM-токена для аккаунта на Яндексе](https://yandex.cloud/ru/docs/iam/operations/iam-token/create)

#### 3.2. Получение Cloud ID

**Через SDK:**

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

**Через Yandex Cloud CLI:**

```bash
yc resource-manager cloud list
```

**Через веб-консоль:** [Yandex Cloud Console](https://console.cloud.yandex.ru/) → выберите облако → скопируйте ID

📚 **Документация:**
[Получение идентификатора облака](https://yandex.cloud/ru/docs/resource-manager/operations/cloud/get-id)

#### 3.3. Создание каталога (Folder)

**Через SDK:**

```php
$authManager = new OAuthTokenManager('your_oauth_token');
// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $authManager = YandexGPT::getAuthManager();

// Создание каталога
$folder = $authManager->createFolder('cloud_id', 'my-ai-folder', 'Каталог для AI проектов');
$folderId = $folder['id'];

// Или получение существующих каталогов
$folders = $authManager->listFolders('cloud_id');
foreach ($folders as $folder) {
    echo "Folder ID: " . $folder['id'] . "\n";
    echo "Name: " . $folder['name'] . "\n";
}
```

**Через Yandex Cloud CLI:**

```bash
# Создание каталога
yc resource-manager folder create --name my-ai-folder --cloud-id YOUR_CLOUD_ID

# Список каталогов
yc resource-manager folder list --cloud-id YOUR_CLOUD_ID
```

📚 **Документация:** [Создание каталога](https://yandex.cloud/ru/docs/resource-manager/operations/folder/create)

#### 3.4. Назначение роли ai.languageModels.user

**Через SDK:**

```php
$authManager = new OAuthTokenManager('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $authManager = YandexGPT::getAuthManager();

// Назначение роли пользователю
$authManager->assignRole(
    'folder_id',
    'userAccount', // тип субъекта
    'user_id',     // ID пользователя
    'ai.languageModels.user'
);
```

**Через Yandex Cloud CLI:**

```bash
# Назначение роли для пользователя
yc resource-manager folder add-access-binding \
  --id YOUR_FOLDER_ID \
  --role ai.languageModels.user \
  --user-account-id YOUR_USER_ID

# Назначение роли для сервисного аккаунта
yc resource-manager folder add-access-binding \
  --id YOUR_FOLDER_ID \
  --role ai.languageModels.user \
  --service-account-id YOUR_SERVICE_ACCOUNT_ID
```

**Через веб-консоль:**

1. Откройте [Yandex Cloud Console](https://console.cloud.yandex.ru/)
2. Выберите каталог
3. Перейдите в раздел "Права доступа"
4. Нажмите "Назначить роли"
5. Выберите пользователя и роль `ai.languageModels.user`

📚 **Документация:**

- [Назначение ролей](https://yandex.cloud/ru/docs/iam/operations/roles/grant)
- [Роли для Yandex Foundation Models](https://yandex.cloud/ru/docs/foundation-models/security/)

#### 3.5. Полный пример настройки

```php
<?php

use Tigusigalpa\YandexGPT\Auth\OAuthTokenManager;
use Tigusigalpa\YandexGPT\YandexGPTClient;

// 1. Инициализация менеджера аутентификации
$authManager = new OAuthTokenManager('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $authManager = YandexGPT::getAuthManager();

// 2. Получение списка облаков
$clouds = $authManager->listClouds();
$cloudId = $clouds[0]['id']; // Берем первое облако

// 3. Создание каталога (если нужно)
$folder = $authManager->createFolder($cloudId, 'ai-projects', 'Каталог для AI');
$folderId = $folder['id'];

// 4. Назначение роли (если нужно)
$authManager->assignRole(
    $folderId,
    'userAccount',
    'your_user_id',
    'ai.languageModels.user'
);

// 5. Использование клиента
$client = new YandexGPTClient('your_oauth_token', $folderId);
$response = $client->generateText('Привет, как дела?');

echo $response['result']['alternatives'][0]['message']['text'];
```

#### 3.6. Полезные ссылки

- 📖 [Быстрый старт YandexGPT](https://yandex.cloud/ru/docs/foundation-models/quickstart/yandexgpt)
- 🔑 [Аутентификация в API](https://yandex.cloud/ru/docs/iam/concepts/authorization/iam-token)
- 🏗️ [Управление ресурсами](https://yandex.cloud/ru/docs/resource-manager/)
- 🤖 [API Foundation Models](https://yandex.cloud/ru/docs/foundation-models/concepts/api)
- 💰 [Тарифы YandexGPT](https://yandex.cloud/ru/docs/foundation-models/pricing)

---

## 💡 Использование

### Базовое использование (без Laravel)

```php
<?php

require_once 'vendor/autoload.php';

use Tigusigalpa\YandexGPT\YandexGPTClient;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

// Создание клиента
$client = new YandexGPTClient('your_oauth_token', 'your_folder_id');

// Простой запрос
$response = $client->generateText(
    'Расскажи о преимуществах PHP',
    YandexGPTModel::YANDEX_GPT_LITE
);

echo $response['result']['alternatives'][0]['message']['text'];
```

### Использование с Laravel

#### Интеграция через Service Provider

Пакет автоматически интегрируется с Laravel через Service Provider, который выполняет следующие функции:

**Автоматическая регистрация:**

```php
// В composer.json пакета указано:
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

**Что делает Service Provider:**

1. **Регистрация сервисов** (`register()` метод):
    - Объединяет конфигурацию пакета с конфигурацией приложения
    - Регистрирует `YandexGPTClient` как singleton в контейнере
    - Создает алиас для удобного внедрения зависимостей

```php
public function register()
{
    // Объединение конфигурации
    $this->mergeConfigFrom(
        __DIR__ . '/../../config/yandexgpt.php',
        'yandexgpt'
    );

    // Регистрация singleton
    $this->app->singleton('yandexgpt', function ($app) {
        $config = $app['config']['yandexgpt'];

        return new YandexGPTClient(
            $config['oauth_token'],
            $config['folder_id']
        );
    });

    // Создание алиаса
    $this->app->alias('yandexgpt', YandexGPTClient::class);
}
```

2. **Загрузка сервисов** (`boot()` метод):
    - Публикует конфигурационный файл для настройки

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

3. **Определение предоставляемых сервисов** (`provides()` метод):
    - Указывает какие сервисы предоставляет провайдер

```php
public function provides()
{
    return ['yandexgpt', YandexGPTClient::class];
}
```

**Публикация конфигурации:**

```bash
php artisan vendor:publish --tag=yandexgpt-config
```

После публикации файл конфигурации будет доступен в `config/yandexgpt.php` для настройки.

#### Через фасад

```php
<?php

use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

// Простой запрос
$response = YandexGPT::generateText('Привет, как дела?');

// С указанием модели и параметров
$response = YandexGPT::generateText(
    'Напиши стихотворение о программировании',
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

#### Через внедрение зависимостей

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

### Работа с диалогами

```php
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;

$messages = [
    [
        'role' => 'system',
        'text' => 'Ты полезный помощник-программист'
    ],
    [
        'role' => 'user',
        'text' => 'Как создать REST API на Laravel?'
    ],
    [
        'role' => 'assistant',
        'text' => 'Для создания REST API в Laravel используйте команду php artisan make:controller...'
    ],
    [
        'role' => 'user',
        'text' => 'А как добавить валидацию?'
    ]
];

$response = YandexGPT::generateFromMessages($messages);
```

### Управление ресурсами Yandex Cloud

```php
<?php

use Tigusigalpa\YandexGPT\YandexGPTClient;

$client = new YandexGPTClient('oauth_token', 'folder_id');
$authManager = $client->getAuthManager();

// Получение IAM токена
$iamToken = $authManager->getIamToken();

// Получение списка облаков
$clouds = $authManager->getClouds($iamToken);

// Создание каталога
$folder = $authManager->createFolder(
    $iamToken,
    'cloud_id',
    'my-yandexgpt-folder',
    'Каталог для работы с YandexGPT'
);

// Назначение прав
$authManager->assignRole(
    $iamToken,
    $folder['id'],
    'user_account_id',
    'ai.languageModels.user'
);
```

---

## 🤖 Доступные модели

| Модель           | Описание                     | Константа                         |
|------------------|------------------------------|-----------------------------------|
| `yandexgpt-lite` | Быстрая и экономичная модель | `YandexGPTModel::YANDEX_GPT_LITE` |
| `yandexgpt`      | Стандартная модель           | `YandexGPTModel::YANDEX_GPT`      |

📚 **Полный список доступных моделей:**
[Модели генерации в Yandex AI Studio](https://yandex.cloud/ru/docs/ai-studio/concepts/generation/models)

```php
// Получение всех доступных моделей
$models = YandexGPT::getAvailableModels();

// Получение описаний моделей
$descriptions = YandexGPT::getModelDescriptions();
```

---

## 🔧 Параметры генерации

```php
$options = [
    'completionOptions' => [
        'stream' => false,           // Потоковая передача (пока не поддерживается)
        'temperature' => 0.6,        // Креативность (0.0 - 1.0)
        'maxTokens' => 2000         // Максимальное количество токенов
    ]
];

$response = YandexGPT::generateText('Ваш запрос', 'yandexgpt-lite', $options);
```

---

## ⚠️ Обработка ошибок

```php
<?php

use Tigusigalpa\YandexGPT\Exceptions\AuthenticationException;
use Tigusigalpa\YandexGPT\Exceptions\ApiException;
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;

try {
    $response = YandexGPT::generateText('Привет!');
} catch (AuthenticationException $e) {
    // Ошибки аутентификации (неверный токен, права доступа)
    Log::error('YandexGPT Auth Error: ' . $e->getMessage());
} catch (ApiException $e) {
    // Ошибки API (неверные параметры, лимиты)
    Log::error('YandexGPT API Error: ' . $e->getMessage());
} catch (Exception $e) {
    // Другие ошибки
    Log::error('YandexGPT Error: ' . $e->getMessage());
}
```

---

## 🛠️ Конфигурация

Полный конфигурационный файл `config/yandexgpt.php`:

```php
<?php

return [
    // OAuth токен
    'oauth_token' => env('YANDEX_GPT_OAUTH_TOKEN'),
    
    // ID каталога
    'folder_id' => env('YANDEX_GPT_FOLDER_ID'),
    
    // Модель по умолчанию
    'default_model' => env('YANDEX_GPT_DEFAULT_MODEL', 'yandexgpt-lite'),
    
    // Параметры по умолчанию
    'default_options' => [
        'temperature' => (float) env('YANDEX_GPT_TEMPERATURE', 0.6),
        'maxTokens' => (int) env('YANDEX_GPT_MAX_TOKENS', 2000),
        'stream' => false,
    ],
    
    // Настройки HTTP клиента
    'http_options' => [
        'timeout' => (int) env('YANDEX_GPT_TIMEOUT', 30),
        'connect_timeout' => (int) env('YANDEX_GPT_CONNECT_TIMEOUT', 10),
    ],
];
```

---

## 📚 Примеры использования

### Чат-бот для Laravel

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
                'error' => 'Произошла ошибка при генерации ответа'
            ], 500);
        }
    }
}
```

### Генерация контента

```php
<?php

use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

class ContentGenerator
{
    public function generateArticle(string $topic, int $length = 1000): string
    {
        $prompt = "Напиши статью на тему '{$topic}'. Длина статьи должна быть примерно {$length} слов. Включи введение, основную часть и заключение.";

        $response = YandexGPT::generateText(
            $prompt,
            YandexGPTModel::YANDEX_GPT,
            [
                'completionOptions' => [
                    'temperature' => 0.7,
                    'maxTokens' => $length * 2 // Примерно 2 токена на слово
                ]
            ]
        );

        return $response['result']['alternatives'][0]['message']['text'];
    }

    public function generateSEODescription(string $content): string
    {
        $prompt = "Создай SEO-описание (meta description) для следующего контента. Описание должно быть до 160 символов:\n\n{$content}";

        $response = YandexGPT::generateText($prompt, YandexGPTModel::YANDEX_GPT_LITE);

        return $response['result']['alternatives'][0]['message']['text'];
    }
}
```

---

## 🧪 Тестирование

### Запуск тестов пакета

```bash
# Переход в директорию пакета
cd packages/yandexgpt-php

# Установка зависимостей для разработки
composer install

# Запуск тестов
composer test

# Запуск тестов с покрытием
composer test-coverage
```

### Тестирование в Laravel проекте

1. **Создайте тестовый контроллер или используйте существующий:**

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
                'Привет! Это тест YandexGPT SDK',
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

2. **Добавьте маршрут для тестирования:**

```php
// routes/web.php
Route::get('/test-yandexgpt', [TestYandexGPTController::class, 'test']);
```

3. **Протестируйте через браузер или API клиент:**

```bash
curl http://your-domain.com/test-yandexgpt
```

---

## ❓ Troubleshooting и FAQ

### Часто задаваемые вопросы

#### Q: Как получить OAuth токен?

**A:** Перейдите по
ссылке: https://oauth.yandex.ru/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb

После авторизации скопируйте токен из URL адреса.

#### Q: Как получить Folder ID?

**A:** Используйте SDK для получения списка каталогов:

```php
$authManager = new OAuthTokenManager('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $authManager = YandexGPT::getAuthManager();
$clouds = $authManager->listClouds();
$folders = $authManager->listFolders($clouds[0]['id']);
```

#### Q: Почему возникает ошибка "OAuth токен не может быть пустым"?

**A:** Убедитесь, что в `.env` файле правильно задан `YANDEX_GPT_OAUTH_TOKEN` без пробелов и кавычек.

#### Q: Как работать с большими текстами?

**A:** Используйте модель `yandexgpt-32k` для работы с контекстом до 32K токенов:

```php
$response = $client->generateText(
    $longText,
    YandexGPTModel::YANDEX_GPT_32K
);
```

### Решение проблем

#### Ошибка: "Class 'Tigusigalpa\YandexGPT\YandexGPTClient' not found"

**Решение:**

1. Убедитесь, что пакет установлен: `composer show tigusigalpa/yandexgpt-php`
2. Очистите автозагрузчик: `composer dump-autoload`
3. Проверьте, что пакет добавлен в `composer.json`

#### Ошибка: "YandexGPT OAuth токен не настроен"

**Решение:**

1. Добавьте в `.env` файл:

```env
YANDEX_GPT_OAUTH_TOKEN=your_actual_token_here
YANDEX_GPT_FOLDER_ID=your_folder_id_here
```

2. Очистите кеш конфигурации: `php artisan config:clear`

#### Ошибка: "Ошибка API YandexGPT (код 401): Unauthorized"

**Решение:**

1. Проверьте правильность OAuth токена
2. Убедитесь, что токен не истек (OAuth токены действуют 1 год)
3. Проверьте права доступа к каталогу

#### Ошибка: "Ошибка API YandexGPT (код 403): Forbidden"

**Решение:**

1. Убедитесь, что у пользователя есть роль `ai.languageModels.user`
2. Проверьте правильность Folder ID
3. Убедитесь, что каталог существует и доступен

#### Ошибка: "Connection timeout"

**Решение:**

1. Увеличьте timeout в конфигурации:

```php
// config/yandexgpt.php
'http_options' => [
    'timeout' => 60,
    'connect_timeout' => 30,
],
```

2. Проверьте интернет-соединение
3. Убедитесь, что нет блокировки файрволом

### Отладка

#### Включение детального логирования

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

// Создание HTTP клиента с логированием
$stack = HandlerStack::create();
$stack->push(Middleware::log(
    app('log')->getLogger(),
    new \GuzzleHttp\MessageFormatter('{method} {uri} HTTP/{version} {req_body} RESPONSE: {code} - {res_body}')
));

$httpClient = new Client(['handler' => $stack]);
$client = new YandexGPTClient('oauth_token', 'folder_id', $httpClient);
```

#### Проверка конфигурации

```php
// Проверка всех настроек
$config = config('yandexgpt');
dd($config);

// Проверка переменных окружения
dd([
    'oauth_token' => env('YANDEX_GPT_OAUTH_TOKEN'),
    'folder_id' => env('YANDEX_GPT_FOLDER_ID'),
]);
```

---

## 🖼️ Генерация изображений (YandexART)

<p align="center">
  <img src="https://github.com/user-attachments/assets/0e08dee0-6fe2-41bd-ac92-501f53d18166" alt="YandexART Hero Image">
</p>

> 📚 Ресурсы
> - 📖 Документация: https://yandex.cloud/ru/docs/ai-studio/quickstart/yandexart
> - 🎨 Сайт: https://ya.ru/ai/art

SDK поддерживает генерацию изображений с помощью YandexART. Доступны три метода:

- 📨 **generateImageAsync** — отправка запроса на генерацию и получение объекта операции
- 🔎 **getOperation** — проверка статуса операции по её ID
- ⏳ **generateImage** — синхронная обёртка с ожиданием результата

Требования доступа:

- Необходимо назначить роль `ai.imageGeneration.user` на каталог (Folder), где будет выполняться генерация изображений
- Для работы текстовых моделей также требуется роль `ai.languageModels.user`

Модель YandexART:

- Используется модель `yandex-art/latest` с URI вида `art://<folder_id>/yandex-art/latest`

Примеры использования

1) Базовая асинхронная генерация:

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;

$client = new YandexGPTClient(env('YANDEX_GPT_OAUTH_TOKEN'), env('YANDEX_GPT_FOLDER_ID'));

// Строка запроса или массив сообщений (см. формат ниже)
$operation = $client->generateImageAsync('Скальный берег у моря на закате, стиль живопись');
$operationId = $operation['id'];

// Проверка статуса операции
$op = $client->getOperation($operationId);
if (!empty($op['done']) && empty($op['error'])) {
    $imageBase64 = $op['response']['image'] ?? null;
    if ($imageBase64) {
        file_put_contents('art.jpg', base64_decode($imageBase64));
    }
}
```

2) Синхронная генерация с ожиданием результата:

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;

$client = new YandexGPTClient(env('YANDEX_GPT_OAUTH_TOKEN'), env('YANDEX_GPT_FOLDER_ID'));

$result = $client->generateImage('Футуристический город ночью, неоновые огни');
file_put_contents('city.jpg', base64_decode($result['image_base64']));
echo '<img src="data:image/png;base64,'.$response['image_base64'].'">';
```

### Пример сгенерированного изображения Омска

![изображение Омска](https://github.com/user-attachments/assets/96b69b45-0d3d-4c17-90c8-e08ace4c7f59)

3) Использование через Laravel Facade:

```php
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;

$result = YandexGPT::generateImage('Тёплый домик у озера зимой, стиль акварель');
file_put_contents('lake.jpg', base64_decode($result['image_base64']));
echo '<img src="data:image/png;base64,'.$response['image_base64'].'">';
```

4) Prompt chaining (YandexGPT → YandexART):

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

$client = new YandexGPTClient(env('YANDEX_GPT_OAUTH_TOKEN'), env('YANDEX_GPT_FOLDER_ID'));

// Сначала генерируем текстовый промпт через YandexGPT
$textResponse = $client->generateText(
    "Сгенерируй краткий, детальный промпт для генерации изображения в стиле цифровой живописи на тему: 'Полет над альпийскими горами'. Укажи стиль, цветовую палитру и ключевые детали.",
    YandexGPTModel::YANDEX_GPT_LITE
);

$generatedPrompt = $textResponse['result']['alternatives'][0]['message']['text'] ?? null;

// Затем передаем получившийся промпт в YandexART
if ($generatedPrompt) {
    $result = $client->generateImage($generatedPrompt);
    file_put_contents('alps.jpg', base64_decode($result['image_base64']));
}
```

Формат сообщений для YandexART

Метод принимает либо строку (один запрос), либо массив сообщений.
Каждое сообщение может быть:

- строкой: 'описание сцены'
- массивом: ['text' => 'описание', 'weight' => 1]

Пример массива сообщений:

```php
$messages = [
    ['text' => 'Горы на рассвете', 'weight' => 1],
    ['text' => 'озеро на переднем плане', 'weight' => 1],
    ['text' => 'стиль импрессионизм', 'weight' => 1],
];
$operation = $client->generateImageAsync($messages);
```

Параметры generationOptions

Параметр generationOptions (необязателен) позволяет задать настройки генерации.
Список доступных опций зависит от API YandexART. Примеры опций:

```php
$generationOptions = [
    // Пример: указание типа изображения и размера (уточните в документации актуальные ключи)
    // @link https://yandex.cloud/ru/docs/ai-studio/quickstart/yandexart#generate-text
    // 'mimeType' => 'image/jpeg',
    // 'size' => ['width' => 1024, 'height' => 1024],
    // 'aspectRatio' => ['widthRatio' => 16, 'heightRatio' => 9],
    // 'seed' => 1863,
];
$operation = $client->generateImageAsync('Описание сцены', $generationOptions);
```

Обработка ошибок

Методы могут выбрасывать исключения ApiException и AuthenticationException.
Проверяйте поле error в ответе операции и наличие поля response.image при успешном завершении.

---

## ✅ Требования

- PHP 8.0 или выше
- Laravel 8.0 или выше (для интеграции с Laravel)
- Guzzle HTTP 7.0 или выше

---

## 📄 Лицензия

Этот пакет распространяется под лицензией MIT. Подробности в файле [LICENSE](LICENSE).

---

## 🤝 Поддержка

- [Документация YandexGPT API](https://yandex.cloud/ru/docs/foundation-models/)
- [Quickstart](https://yandex.cloud/ru/docs/foundation-models/quickstart/yandexgpt)
- [Список моделей](https://yandex.cloud/ru/docs/ai-studio/concepts/generation/models)

---

## 🧑‍💻 Участие в разработке

Мы приветствуем участие в разработке! Пожалуйста, ознакомьтесь с [руководством по участию](CONTRIBUTING.md).

---

## 🛡️ Безопасность

Если вы обнаружили уязвимость в безопасности, пожалуйста, отправьте email на sovletig@gmail.com вместо создания issue.

