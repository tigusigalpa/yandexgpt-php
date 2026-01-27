# YandexGPT PHP SDK

![YandexGPT PHP SDK](https://github.com/user-attachments/assets/758d8956-0126-4b32-a6ba-afa8c8948188)

[![Latest Version](https://img.shields.io/packagist/v/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
[![PHP Version](https://img.shields.io/packagist/php-v/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
[![License](https://img.shields.io/packagist/l/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/tigusigalpa/yandexgpt-php/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/tigusigalpa/yandexgpt-php/actions)

**🌐 Язык:** Русский | [English](README-en.md)

**Полнофункциональный PHP SDK для работы с YandexGPT API и YandexART** — современная библиотека для интеграции искусственного интеллекта Yandex Cloud в PHP-приложения и Laravel-проекты. Пакет предоставляет простой и удобный интерфейс для работы с генеративными AI моделями, включая текстовую генерацию, диалоговые системы и создание изображений.

## 📋 Описание

YandexGPT PHP SDK — это мощный инструмент для разработчиков, которые хотят интегрировать возможности искусственного интеллекта Yandex Cloud в свои PHP-приложения. Библиотека поддерживает все основные модели YandexGPT (включая YandexGPT Lite, YandexGPT Pro и Alice AI), а также генерацию изображений через YandexART.

**Ключевые преимущества:**
- ✨ Простая интеграция с любым PHP-проектом (PHP 8.0+)
- 🚀 Нативная поддержка Laravel с Service Provider и Facades
- 🤖 Работа со всеми моделями YandexGPT и YandexART
- 🔐 Автоматическое управление OAuth и IAM токенами
- 💬 Поддержка диалоговых систем и контекстных бесед
- 🎨 Генерация изображений с помощью YandexART
- 🧠 Режим рассуждений (Chain of Thought) для сложных задач
- 📦 Управление облачной инфраструктурой Yandex Cloud
- 🛡️ Обработка ошибок и исключений
- 📚 Подробная документация и примеры

**Сценарии использования:**
- Создание чат-ботов и виртуальных ассистентов
- Генерация контента для сайтов и блогов
- Автоматизация ответов на вопросы клиентов
- SEO-оптимизация текстов и метаописаний
- Анализ и обработка естественного языка
- Создание уникальных изображений для контента
- Разработка AI-powered приложений на Laravel
- Интеграция с CMS и e-commerce платформами

> **Примечание:** Пакет использует [yandex-cloud-client-php](https://github.com/tigusigalpa/yandex-cloud-client-php) для
> управления облачной инфраструктурой Yandex Cloud (организации, облака, каталоги, авторизация).

## 🚀 Возможности

### Основные функции

- 🔌 **Простая интеграция с YandexGPT API** — подключение за 5 минут
- 🔨 **Поддержка YandexART** — генерация изображений по текстовому описанию
- 🔐 **Автоматическое управление OAuth и IAM токенами** — не нужно беспокоиться об обновлении
- 🎯 **Поддержка всех доступных моделей YandexGPT** — Lite, Pro, Alice AI
- 🛠 **Полная интеграция с Laravel** — Service Provider, Facades, конфигурация
- 📝 **Поддержка диалогов и одиночных запросов** — создавайте чат-ботов и AI-ассистентов
- ⚡ **Автоматическое обновление токенов** — бесшовная работа без прерываний
- 🧪 **Покрытие тестами** — надежность и стабильность
- 📚 **Подробная документация** — примеры для всех сценариев использования

### Расширенные возможности

- 🧠 **Режим рассуждений (Chain of Thought)** — для решения сложных логических задач
- 🎨 **Prompt Chaining** — комбинирование YandexGPT и YandexART
- 🔄 **Управление облачной инфраструктурой** — создание каталогов, назначение ролей
- 👥 **IAM и управление пользователями** — полный контроль доступа
- 🌐 **Работа с организациями и облаками** — корпоративное использование
- ⚙️ **Гибкая настройка параметров** — temperature, maxTokens, reasoning options
- 🔍 **Детальная обработка ошибок** — понятные исключения и логирование
- 📊 **Мониторинг использования токенов** — контроль расходов

### Интеграция и совместимость

- ✅ **PHP 8.0+** — современный синтаксис и типизация
- ✅ **Laravel 8.0+** — полная поддержка фреймворка
- ✅ **Composer** — стандартная установка через пакетный менеджер
- ✅ **PSR-совместимость** — следование стандартам PHP
- ✅ **Dependency Injection** — чистая архитектура
- ✅ **Guzzle HTTP Client** — надежные HTTP-запросы

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

📚 **Документация:** [OAuth-токен](https://yandex.cloud/ru/docs/iam/concepts/authorization/oauth-token)

Перейдите по ссылке
для [получения OAuth токена](https://oauth.yandex.ru/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb):

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

📚 **Документация:
** [Получение IAM-токена для аккаунта на Яндексе](https://yandex.cloud/ru/docs/iam/operations/iam-token/create#exchange-token)

IAM токен получается автоматически через SDK с помощью OAuth токена. Токен действует 12 часов и обновляется
автоматически.

**Получение через SDK:**

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

// Создание клиента Yandex Cloud
$cloudClient = new YandexCloudClient('your_oauth_token');

// Получение IAM токена
$iamToken = $cloudClient->getAuthManager()->getIamToken();

echo "IAM Token: " . $iamToken . "\n";
```

**Автоматическое управление токенами через YandexGPTClient:**

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;

// Клиент автоматически получает и обновляет IAM токены
$client = new YandexGPTClient('your_oauth_token', 'your_folder_id');

// Получение Yandex Cloud клиента для управления облаком
$cloudClient = $client->getCloudClient();
$iamToken = $cloudClient->getAuthManager()->getIamToken();
```

**Ручное получение через API:**

```bash
curl -d "{"yandexPassportOauthToken":"YOUR_OAUTH_TOKEN"}" \
  "https://iam.api.cloud.yandex.net/iam/v1/tokens"
```

#### 3.2. Получение Cloud ID

**Документация:** [Получение списка ресурсов Cloud](https://yandex.cloud/ru/docs/resource-manager/api-ref/Cloud/list)

**Через SDK:**

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

**Через Yandex Cloud CLI:**

```bash
yc resource-manager cloud list
```

**Через веб-консоль:** [Yandex Cloud Console](https://console.cloud.yandex.ru/) → выберите облако → скопируйте ID

#### 3.3. Получение Folder ID

**Документация:**
[Получение списка ресурсов Folder в указанном облаке](https://yandex.cloud/ru/docs/resource-manager/api-ref/Folder/list)

**Через SDK:**

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Получение существующих каталогов
$folders = $cloudClient->folders()->list('cloud_id');
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

#### Создание каталога

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

// Создание каталога
$folder = $cloudClient->folders()->create('cloud_id', 'my-ai-folder', 'Каталог для AI проектов');
$folderId = $folder['metadata']['folderId'];

```

📚 **Документация:** [Создание каталога](https://yandex.cloud/ru/docs/resource-manager/operations/folder/create)

#### 3.4. Назначение ролей на каталог или облако

📚 **Документация:**

[Аутентификация в API Yandex AI Studio](https://yandex.cloud/ru/docs/ai-studio/api-ref/authentication)

[Управление доступом в Yandex AI Studio](https://yandex.cloud/ru/docs/ai-studio/security/)

[Назначить роль на каталог или облако](https://yandex.cloud/ru/docs/iam/operations/roles/grant#cloud-or-folder)

[Назначение роли на облако](https://yandex.cloud/ru/docs/resource-manager/api-ref/Cloud/updateAccessBindings)

[Объект Subject для облака](https://yandex.cloud/ru/docs/resource-manager/api-ref/Cloud/updateAccessBindings#yandex.cloud.access.Subject)

[Назначение роли на каталог](https://yandex.cloud/ru/docs/resource-manager/api-ref/Folder/updateAccessBindings)

[Объект Subject для каталога](https://yandex.cloud/ru/docs/resource-manager/api-ref/Folder/updateAccessBindings#yandex.cloud.access.Subject)

[Пошаговые инструкции для Identity and Access Management](https://yandex.cloud/ru/docs/iam/operations/)

[UserAccount API](https://yandex.cloud/ru/docs/iam/api-ref/UserAccount/)

[Identity and Access Management API, REST: YandexPassportUserAccount.GetByLogin](https://yandex.cloud/ru/docs/iam/api-ref/YandexPassportUserAccount/getByLogin)

**Через SDK:**

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

// 1. Получение User ID по логину Yandex
$userInfo = $cloudClient->yandexPassportUserAccounts()->getByLogin('username@yandex.ru');
$userId = $userInfo['id'];

// 2. Получение информации о пользователе по UserAccountId
$userAccount = $cloudClient->userAccounts()->get($userId);

// 3. Назначение роли на каталог
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

// 4. Назначение роли на облако
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

#### 3.5. Полный пример настройки

```php
<?php

use Tigusigalpa\YandexCloudClient\YandexCloudClient;
use Tigusigalpa\YandexGPT\YandexGPTClient;

// 1. Инициализация Yandex Cloud клиента
$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

// 2. Получение списка облаков
$clouds = $cloudClient->clouds()->list();
$cloudId = $clouds[0]['id']; // Берем первое облако

// 3. Создание каталога (если нужно)
$folder = $cloudClient->folders()->create($cloudId, 'ai-projects', 'Каталог для AI');
$folderId = $folder['metadata']['folderId'];

// 4. Получение User ID по логину (если нужно)
$userInfo = $cloudClient->yandexPassportUserAccounts()->getByLogin('username@yandex.ru');
$userId = $userInfo['id'];

// 5. Назначение роли на каталог
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

// Или назначение роли на облако
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

// 6. Использование клиента
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

// Использование модели Alice AI для разговорных задач
$response = $client->generateText(
    'Привет! Расскажи интересную историю',
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

// Получение User ID по логину Yandex
$userId = $authManager->getUserIdByLogin('username@yandex.ru');

// Получение информации о пользователе
$userInfo = $authManager->getUserByLogin('username@yandex.ru');
// или по UserAccountId
$userAccount = $authManager->getUserAccount($userId);

// Назначение роли на каталог
$authManager->assignRoleToFolder(
    $iamToken,
    $folder['id'],
    $userId,
    'ai.languageModels.user',
    'userAccount'  // или 'serviceAccount'
);

// Назначение роли на облако
$authManager->assignRoleToCloud(
    $iamToken,
    'cloud_id',
    $userId,
    'editor',
    'userAccount'
);
```

### Управление пользователями и ролями (IAM)

SDK предоставляет полный набор функций для работы с Identity and Access Management (IAM):

#### Получение информации о пользователях

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

// 1. Получение User ID (Subject ID) по логину Yandex
$userInfo = $cloudClient->yandexPassportUserAccounts()->getByLogin('username@yandex.ru');
$userId = $userInfo['id'];
echo "User ID: " . $userId;

// 2. Получение полной информации о пользователе по логину
/*
Возвращает массив:
[
    'id' => 'aje...',           // Subject ID пользователя
    'yandexPassportUserAccount' => [
        'login' => 'username',
        'defaultEmail' => 'username@yandex.ru'
    ]
]
*/

// 3. Получение информации о пользователе по UserAccountId
$userAccount = $cloudClient->userAccounts()->get($userId);
/*
Возвращает массив с полной информацией об аккаунте
*/
```

#### Назначение ролей на каталог

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

// Назначение роли пользователю на каталог
$cloudClient->folders()->updateAccessBindings(
    'folder_id',              // ID каталога
    [
        [
            'action' => 'ADD',
            'accessBinding' => [
                'roleId' => 'ai.languageModels.user', // Роль
                'subject' => [
                    'id' => 'user_subject_id',        // Subject ID пользователя
                    'type' => 'userAccount'           // Тип субъекта
                ]
            ]
        ]
    ]
);

// Назначение роли сервисному аккаунту
$cloudClient->folders()->updateAccessBindings(
    'folder_id',
    [
        [
            'action' => 'ADD',
            'accessBinding' => [
                'roleId' => 'ai.languageModels.user',
                'subject' => [
                    'id' => 'service_account_id',
                    'type' => 'serviceAccount'        // Для сервисного аккаунта
                ]
            ]
        ]
    ]
);

// Доступные роли для AI:
// - ai.languageModels.user - использование моделей
// - ai.editor - редактирование ресурсов
// - ai.viewer - просмотр ресурсов
// - editor - полный доступ к каталогу
// - viewer - просмотр каталога
```

#### Назначение ролей на облако

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

// Назначение роли на облако
$cloudClient->clouds()->updateAccessBindings(
    'cloud_id',        // ID облака
    [
        [
            'action' => 'ADD',
            'accessBinding' => [
                'roleId' => 'editor',          // Роль для облака
                'subject' => [
                    'id' => 'user_subject_id', // Subject ID пользователя
                    'type' => 'userAccount'    // Тип субъекта
                ]
            ]
        ]
    ]
);

// Доступные роли для облака:
// - admin - администратор облака
// - editor - редактор облака
// - viewer - просмотр облака
// - resource-manager.clouds.owner - владелец облака
```

#### Полный пример: получение пользователя и назначение роли

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

try {
    // 1. Получаем User ID по логину
    $userInfo = $cloudClient->yandexPassportUserAccounts()->getByLogin('username@yandex.ru');
    $userId = $userInfo['id'];
    echo "User ID: {$userId}\n";
    
    // 2. Получаем информацию о пользователе
    $userAccount = $cloudClient->userAccounts()->get($userId);
    echo "User info: " . json_encode($userAccount, JSON_PRETTY_PRINT) . "\n";
    
    // 3. Назначаем роль на каталог
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

## 🤖 Доступные модели YandexGPT

SDK поддерживает все актуальные модели генеративного AI от Yandex Cloud:

| Модель           | Описание                                      | Константа                         | Контекст | Применение |
|------------------|-----------------------------------------------|-----------------------------------|----------|------------|
| `yandexgpt-lite` | Быстрая и экономичная модель                  | `YandexGPTModel::YANDEX_GPT_LITE` | 32K      | Простые запросы, чат-боты, FAQ |
| `yandexgpt`      | Стандартная модель (Pro)                      | `YandexGPTModel::YANDEX_GPT`      | 32K      | Генерация контента, анализ текста |
| `aliceai-llm`    | Alice AI LLM - продвинутая разговорная модель | `YandexGPTModel::ALICE_AI`        | 32K      | Диалоговые системы, ассистенты |

### Выбор модели для вашей задачи

**YandexGPT Lite** — идеальна для:
- Быстрых ответов на простые вопросы
- Чат-ботов с базовым функционалом
- Обработки большого количества запросов
- Экономии бюджета на токенах

**YandexGPT Pro** — рекомендуется для:
- Генерации качественного контента
- SEO-оптимизированных текстов
- Сложных аналитических задач
- Работы с режимом рассуждений

**Alice AI** — оптимальна для:
- Естественных диалогов с пользователями
- Виртуальных ассистентов
- Разговорных интерфейсов
- Персонализированного общения

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

### 🧠 Режим рассуждений (Reasoning Mode)

Режим рассуждений позволяет модели разбивать задачу на этапы и выполнять последовательную цепочку вычислений для повышения точности ответов. Этот режим особенно полезен для задач, требующих логических рассуждений.

📚 **Документация:** [Режим рассуждений в генеративных моделях](https://yandex.cloud/ru/docs/ai-studio/concepts/generation/chain-of-thought)

**Доступные режимы:**
- `DISABLED` - режим рассуждений выключен (по умолчанию)
- `ENABLED_HIDDEN` - режим рассуждений включен, но цепочка рассуждений не возвращается в ответе

**Уровни усилий (effort):**
- `low` - приоритет на скорость и экономию токенов
- `medium` - баланс между скоростью и точностью рассуждений
- `high` - приоритет на более полное и тщательное рассуждение

#### Использование с объектом ReasoningOptions

```php
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;
use Tigusigalpa\YandexGPT\Models\ReasoningOptions;

// Включить режим рассуждений с низким уровнем усилий
$response = YandexGPT::generateText(
    'Решите задачу: если в корзине 5 яблок и 3 груши, сколько всего фруктов?',
    YandexGPTModel::YANDEX_GPT,
    [
        'reasoningOptions' => ReasoningOptions::enabledHidden(ReasoningOptions::EFFORT_LOW)
    ]
);

// Включить режим рассуждений с высоким уровнем усилий
$response = YandexGPT::generateText(
    'Объясните квантовую запутанность простыми словами',
    YandexGPTModel::YANDEX_GPT,
    [
        'reasoningOptions' => ReasoningOptions::enabledHidden(ReasoningOptions::EFFORT_HIGH)
    ]
);

// Отключить режим рассуждений (явно)
$response = YandexGPT::generateText(
    'Привет, как дела?',
    YandexGPTModel::YANDEX_GPT,
    [
        'reasoningOptions' => ReasoningOptions::disabled()
    ]
);
```

#### Использование с массивом

```php
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

// Включить режим рассуждений
$response = YandexGPT::generateText(
    'Какие преимущества использования Docker в разработке?',
    YandexGPTModel::YANDEX_GPT,
    [
        'reasoningOptions' => [
            'mode' => 'ENABLED_HIDDEN',
            'effort' => 'medium'
        ]
    ]
);

// Только режим, без указания уровня усилий
$response = YandexGPT::generateText(
    'Напишите алгоритм сортировки пузырьком',
    YandexGPTModel::YANDEX_GPT,
    [
        'reasoningOptions' => [
            'mode' => 'ENABLED_HIDDEN'
        ]
    ]
);
```

#### Использование с диалогами

```php
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;
use Tigusigalpa\YandexGPT\Models\ReasoningOptions;

$messages = [
    [
        'role' => 'system',
        'text' => 'Ты математический помощник'
    ],
    [
        'role' => 'user',
        'text' => 'Реши уравнение: 2x + 5 = 15'
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

#### Проверка использования токенов рассуждений

При использовании режима рассуждений ответ может содержать информацию о количестве токенов, использованных для рассуждений:

```php
$response = YandexGPT::generateText(
    'Сложная математическая задача...',
    YandexGPTModel::YANDEX_GPT,
    [
        'reasoningOptions' => ReasoningOptions::enabledHidden(ReasoningOptions::EFFORT_HIGH)
    ]
);

// Проверка токенов рассуждений
if (isset($response['result']['alternatives'][0]['reasoningTokens'])) {
    $reasoningTokens = $response['result']['alternatives'][0]['reasoningTokens'];
    echo "Использовано токенов для рассуждений: {$reasoningTokens}\n";
}

echo $response['result']['alternatives'][0]['message']['text'];
```

**Примечание:** Режим рассуждений доступен для модели YandexGPT Pro и может увеличить общее количество токенов запроса.

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

## 📚 Практические примеры использования

### Реальные сценарии применения YandexGPT PHP SDK

#### 1. Чат-бот для Laravel с историей диалога

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

#### 2. Генерация SEO-оптимизированного контента

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

    public function generateProductDescription(array $productData): string
    {
        $prompt = "Создай привлекательное описание товара для интернет-магазина:\n";
        $prompt .= "Название: {$productData['name']}\n";
        $prompt .= "Характеристики: " . implode(', ', $productData['features']) . "\n";
        $prompt .= "Описание должно быть SEO-оптимизированным, содержать ключевые слова и призыв к действию.";

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
        $prompt = "Напиши SEO-оптимизированную статью для блога на тему: '{$topic}'.\n";
        $prompt .= "Обязательно используй ключевые слова: {$keywordsList}.\n";
        $prompt .= "Структура: заголовок H1, введение, 3-4 подзаголовка H2 с контентом, заключение.\n";
        $prompt .= "Длина: 1500-2000 слов.";

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

#### 3. Автоматизация поддержки клиентов

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
            'Информация о компании, продуктах, услугах, политиках возврата и т.д.'
        ];
    }

    public function answerQuestion(string $question, array $conversationHistory = []): string
    {
        $systemPrompt = "Ты — помощник службы поддержки. Используй следующую базу знаний для ответов:\n";
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

#### 4. Анализ тональности и обработка отзывов

```php
<?php

use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

class ReviewAnalyzer
{
    public function analyzeSentiment(string $review): array
    {
        $prompt = "Проанализируй тональность следующего отзыва и верни результат в формате JSON:\n";
        $prompt .= "Отзыв: {$review}\n\n";
        $prompt .= "Формат ответа: {\"sentiment\": \"positive/negative/neutral\", \"score\": 0-10, \"key_points\": [\"пункт1\", \"пункт2\"]}";

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
        $prompt = "Сгенерируй профессиональный ответ на отзыв клиента (тональность: {$sentiment}):\n{$review}";

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

#### 5. Генерация изображений для контента

```php
<?php

use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
use Tigusigalpa\YandexGPT\Models\YandexGPTModel;

class ContentImageGenerator
{
    public function generateArticleImage(string $articleTitle, string $articleSummary): string
    {
        // Сначала генерируем оптимальный промпт для изображения
        $promptGeneration = "Создай детальный промпт для генерации изображения к статье:\n";
        $promptGeneration .= "Заголовок: {$articleTitle}\n";
        $promptGeneration .= "Краткое содержание: {$articleSummary}\n";
        $promptGeneration .= "Промпт должен описывать визуальную концепцию, стиль, цветовую палитру.";

        $textResponse = YandexGPT::generateText(
            $promptGeneration,
            YandexGPTModel::YANDEX_GPT_LITE
        );

        $imagePrompt = $textResponse['result']['alternatives'][0]['message']['text'];

        // Генерируем изображение
        $result = YandexGPT::generateImage($imagePrompt);
        
        // Сохраняем изображение
        $filename = 'article_' . time() . '.jpg';
        $path = storage_path('app/public/images/' . $filename);
        file_put_contents($path, base64_decode($result['image_base64']));

        return $filename;
    }
}
```

---

## 🆚 Сравнение с альтернативами

### YandexGPT PHP SDK vs OpenAI PHP

| Характеристика | YandexGPT PHP SDK | OpenAI PHP |
|----------------|-------------------|------------|
| **Локализация** | Отличная поддержка русского языка | Хорошая, но не нативная |
| **Цена** | Конкурентные цены для РФ рынка | Оплата в валюте |
| **Соответствие законодательству** | Полное соответствие РФ | Требует дополнительных мер |
| **Интеграция с Yandex Cloud** | Нативная | Отсутствует |
| **Генерация изображений** | YandexART встроен | Требует DALL-E |
| **Laravel интеграция** | Service Provider + Facades | Требует дополнительной настройки |
| **Управление инфраструктурой** | Встроенное управление облаком | Отсутствует |

### Преимущества использования YandexGPT для российских проектов

✅ **Соответствие законодательству** — данные хранятся на территории РФ  
✅ **Качество русского языка** — модели обучены на русскоязычных данных  
✅ **Стабильность работы** — не зависит от международных санкций  
✅ **Техподдержка на русском** — документация и поддержка на родном языке  
✅ **Интеграция с экосистемой Yandex** — единая инфраструктура  
✅ **Прозрачное ценообразование** — оплата в рублях  

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

#### Q: Что такое YandexGPT и для чего он нужен?

**A:** YandexGPT — это семейство генеративных языковых моделей от Yandex Cloud, которые могут генерировать тексты, вести диалоги, анализировать информацию и решать различные задачи обработки естественного языка. SDK позволяет легко интегрировать эти возможности в PHP-приложения.

#### Q: Какая модель лучше подходит для моей задачи?

**A:** 
- **YandexGPT Lite** — для простых задач, чат-ботов, FAQ (быстро и экономично)
- **YandexGPT Pro** — для генерации качественного контента, SEO-текстов, сложных задач
- **Alice AI** — для естественных диалогов и разговорных интерфейсов

#### Q: Сколько стоит использование YandexGPT?

**A:** Стоимость зависит от модели и количества токенов. Актуальные цены смотрите в [документации Yandex Cloud](https://yandex.cloud/ru/docs/foundation-models/pricing). YandexGPT Lite — самый экономичный вариант.

#### Q: Можно ли использовать SDK без Laravel?

**A:** Да, SDK полностью работает в любом PHP-проекте (PHP 8.0+). Laravel-интеграция опциональна и предоставляет дополнительные удобства (Facades, Service Provider).

#### Q: Как получить OAuth токен?

**A:** Перейдите по
ссылке: https://oauth.yandex.ru/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb

После авторизации скопируйте токен из URL адреса.

#### Q: Как получить Folder ID?

**A:** Используйте SDK для получения списка каталогов:

```php
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

$cloudClient = new YandexCloudClient('your_oauth_token');

// Laravel:
// use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;
// $cloudClient = YandexGPT::getCloudClient();

$clouds = $cloudClient->clouds()->list();
$folders = $cloudClient->folders()->list($clouds[0]['id']);
```

#### Q: Почему возникает ошибка "OAuth токен не может быть пустым"?

**A:** Убедитесь, что в `.env` файле правильно задан `YANDEX_GPT_OAUTH_TOKEN` без пробелов и кавычек.

```

#### Q: Безопасно ли хранить OAuth токен в .env файле?

**A:** Да, это стандартная практика для Laravel. Убедитесь, что:
- Файл `.env` добавлен в `.gitignore`
- На продакшене используются переменные окружения сервера
- Права доступа к файлу ограничены (chmod 600)

#### Q: Можно ли использовать SDK для коммерческих проектов?

**A:** Да, пакет распространяется под лицензией MIT, что позволяет свободное использование в коммерческих проектах.

#### Q: Поддерживается ли потоковая передача (streaming)?

**A:** В текущей версии потоковая передача не реализована, но планируется в будущих обновлениях.

#### Q: Как ограничить расход токенов?

**A:** Используйте параметр `maxTokens` в опциях генерации:
```php
$response = YandexGPT::generateText(
    'Ваш запрос',
    YandexGPTModel::YANDEX_GPT_LITE,
    [
        'completionOptions' => [
            'maxTokens' => 500  // Ограничение
        ]
    ]
);
```

#### Q: Можно ли использовать несколько каталогов (folders)?

**A:** Да, создавайте отдельные экземпляры клиента для разных каталогов:
```php
$client1 = new YandexGPTClient($oauthToken, $folderId1);
$client2 = new YandexGPTClient($oauthToken, $folderId2);
```

#### Q: Как обрабатывать большие объемы текста?

**A:** Разбивайте текст на части с учетом лимита контекста (32K токенов) или используйте суммаризацию:
```php
$summary = YandexGPT::generateText(
    "Кратко перескажи основные идеи текста: {$longText}",
    YandexGPTModel::YANDEX_GPT
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
> - 🛠️ Документация
    по [отправке запроса](https://yandex.cloud/ru/docs/ai-studio/operations/generation/yandexart-request#generate-text)
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

---

## 🔑 Ключевые слова и теги

`yandexgpt`, `yandex-gpt`, `yandex-cloud`, `yandex-ai`, `yandexart`, `php-sdk`, `laravel`, `laravel-package`, `ai`, `artificial-intelligence`, `machine-learning`, `nlp`, `natural-language-processing`, `chatbot`, `chat-bot`, `gpt`, `language-model`, `text-generation`, `image-generation`, `russian-language`, `php8`, `composer-package`, `api-client`, `yandex-api`, `generative-ai`, `llm`, `large-language-model`, `alice-ai`, `reasoning-mode`, `chain-of-thought`, `prompt-engineering`, `content-generation`, `seo-tools`, `php-library`

## 📊 Статистика и производительность

- ⚡ **Скорость ответа**: YandexGPT Lite — 1-3 секунды
- 🎯 **Точность**: Высокая точность для русскоязычных запросов
- 💾 **Контекст**: До 32K токенов (примерно 24K слов)
- 🔄 **Обновление токенов**: Автоматическое каждые 12 часов
- 📦 **Размер пакета**: Минимальные зависимости, быстрая установка

## 🌟 Отзывы и кейсы использования

### Где используется YandexGPT PHP SDK

- 🛒 **E-commerce**: Генерация описаний товаров, ответы на вопросы покупателей
- 📰 **Медиа и блоги**: Автоматизация создания контента, SEO-оптимизация
- 💼 **Корпоративные системы**: Внутренние чат-боты, обработка документов
- 🎓 **Образование**: Обучающие ассистенты, проверка текстов
- 🏥 **Здравоохранение**: Информационные системы, FAQ-боты
- 🏢 **Бизнес-аналитика**: Анализ отзывов, обработка обращений

## 🚀 Roadmap и планы развития

- [ ] Поддержка потоковой передачи (streaming)
- [ ] Расширенные возможности YandexART
- [ ] Интеграция с другими сервисами Yandex Cloud
- [ ] Кеширование запросов для оптимизации
- [ ] Расширенная аналитика использования токенов
- [ ] Поддержка асинхронных запросов
- [ ] CLI-инструменты для быстрого тестирования
- [ ] Дополнительные адаптеры для популярных CMS

## 📱 Контакты и сообщество

- 📧 **Email**: sovletig@gmail.com
- 🐙 **GitHub**: [tigusigalpa/yandexgpt-php](https://github.com/tigusigalpa/yandexgpt-php)
- 📦 **Packagist**: [tigusigalpa/yandexgpt-php](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
- 📚 **Документация Yandex Cloud**: [foundation-models](https://yandex.cloud/ru/docs/foundation-models/)

## 💡 Полезные ресурсы

### Официальная документация Yandex Cloud
- [YandexGPT API](https://yandex.cloud/ru/docs/foundation-models/concepts/yandexgpt/)
- [YandexART](https://yandex.cloud/ru/docs/ai-studio/quickstart/yandexart)
- [Модели генерации](https://yandex.cloud/ru/docs/ai-studio/concepts/generation/models)
- [Тарифы](https://yandex.cloud/ru/docs/foundation-models/pricing)
- [Лучшие практики](https://yandex.cloud/ru/docs/foundation-models/concepts/yandexgpt/)

### Обучающие материалы
- [Prompt Engineering для YandexGPT](https://yandex.cloud/ru/docs/foundation-models/concepts/yandexgpt/)
- [Примеры использования](https://github.com/tigusigalpa/yandexgpt-php/tree/main/examples)
- [Видеоуроки и вебинары](https://yandex.cloud/ru/training)

---

**YandexGPT PHP SDK** — ваш надежный инструмент для интеграции искусственного интеллекта в PHP-приложения. Начните использовать возможности генеративного AI уже сегодня!

⭐ Если проект оказался полезным, поставьте звезду на GitHub!

