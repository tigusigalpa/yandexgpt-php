# YandexGPT PHP SDK

![YandexGPT PHP SDK](https://github.com/user-attachments/assets/758d8956-0126-4b32-a6ba-afa8c8948188)

[![Latest Version](https://img.shields.io/packagist/v/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
[![PHP Version](https://img.shields.io/packagist/php-v/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
[![License](https://img.shields.io/packagist/l/tigusigalpa/yandexgpt-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/yandexgpt-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/tigusigalpa/yandexgpt-php/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/tigusigalpa/yandexgpt-php/actions)

**Язык:** Русский | [English](README-en.md)

PHP SDK для YandexGPT API и YandexART. Генерация текста, диалоги, изображения, Conversations API. Работает с любым PHP 8.0+ проектом и имеет встроенную поддержку Laravel.

> Для управления облачной инфраструктурой (организации, облака, каталоги) используется [yandex-cloud-client-php](https://github.com/tigusigalpa/yandex-cloud-client-php).

> 📖 **[Полная документация доступна на Wiki](https://github.com/tigusigalpa/yandexgpt-php/wiki)**

## Возможности

- Все модели YandexGPT: Lite, Pro, Alice AI
- Генерация изображений через YandexART
- Conversations API — серверные диалоги
- Режим рассуждений (Chain of Thought)
- Автоматическое управление OAuth/IAM токенами
- Laravel: Service Provider, Facade, конфигурация
- PHP 8.0+, Laravel 8.0+, Guzzle HTTP

---

## Установка

Через Composer:

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

## Настройка

### 1. Получение OAuth токена

Документация: [OAuth-токен](https://yandex.cloud/ru/docs/iam/concepts/authorization/oauth-token)

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

Документация: [Получение IAM-токена для аккаунта на Яндексе](https://yandex.cloud/ru/docs/iam/operations/iam-token/create#exchange-token)

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

Документация: [Создание каталога](https://yandex.cloud/ru/docs/resource-manager/operations/folder/create)

#### 3.4. Назначение ролей на каталог или облако

Документация:

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

- [Быстрый старт YandexGPT](https://yandex.cloud/ru/docs/foundation-models/quickstart/yandexgpt)
- [Аутентификация в API](https://yandex.cloud/ru/docs/iam/concepts/authorization/iam-token)
- [Управление ресурсами](https://yandex.cloud/ru/docs/resource-manager/)
- [API Foundation Models](https://yandex.cloud/ru/docs/foundation-models/concepts/api)
- [Тарифы YandexGPT](https://yandex.cloud/ru/docs/foundation-models/pricing)

---

## Использование

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

Пакет автоматически интегрируется с Laravel.

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

---

## Доступные модели

| Модель           | Константа                         | Контекст | Когда использовать |
|------------------|-----------------------------------|----------|--------------------|
| `yandexgpt-lite` | `YandexGPTModel::YANDEX_GPT_LITE` | 32K      | Простые запросы, чат-боты, FAQ |
| `yandexgpt`      | `YandexGPTModel::YANDEX_GPT`      | 32K      | Контент, анализ, reasoning |
| `aliceai-llm`    | `YandexGPTModel::ALICE_AI`        | 32K      | Диалоги, ассистенты |

Полный список: [Модели генерации в Yandex AI Studio](https://yandex.cloud/ru/docs/ai-studio/concepts/generation/models)

```php
$models = YandexGPT::getAvailableModels();
$descriptions = YandexGPT::getModelDescriptions();
```

---

## Параметры генерации

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

### Режим рассуждений (Reasoning Mode)

Режим рассуждений позволяет модели разбивать задачу на этапы и выполнять последовательную цепочку вычислений для повышения точности ответов. Этот режим особенно полезен для задач, требующих логических рассуждений.

Документация: [Режим рассуждений в генеративных моделях](https://yandex.cloud/ru/docs/ai-studio/concepts/generation/chain-of-thought)

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

## Обработка ошибок

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

## Конфигурация

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

## Примеры

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

## Тестирование

```bash
composer install
composer test
composer test-coverage
```

---

## Troubleshooting

**"Class 'YandexGPTClient' not found"** — `composer show tigusigalpa/yandexgpt-php`, затем `composer dump-autoload`.

**"OAuth токен не настроен"** — проверьте `YANDEX_GPT_OAUTH_TOKEN` в `.env`, затем `php artisan config:clear`.

**401 Unauthorized** — проверьте OAuth токен (действует 1 год) и права доступа к каталогу.

**403 Forbidden** — у пользователя должна быть роль `ai.languageModels.user` на каталоге.

**Connection timeout** — увеличьте `timeout` в `config/yandexgpt.php`.

---

## Conversations API

SDK поддерживает работу с Conversations API для управления диалогами и их элементами на стороне сервера Yandex Cloud.

Документация: [REST: Conversations](https://yandex.cloud/ru/docs/ai-studio/conversations/)

### Доступные методы

| Метод | Описание |
|-------|----------|
| `create()` | Создание нового диалога |
| `get()` | Получение диалога по ID |
| `update()` | Обновление метаданных диалога |
| `delete()` | Удаление диалога |
| `createItems()` | Добавление элементов в диалог |
| `listItems()` | Получение списка элементов диалога |
| `getItem()` | Получение одного элемента диалога |
| `deleteItem()` | Удаление элемента из диалога |

### Управление диалогами

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;

$client = new YandexGPTClient('your_oauth_token', 'your_folder_id');

// Создание диалога с метаданными
$conversation = $client->conversations()->create([
    'title' => 'Техническая поддержка',
    'user_id' => '12345',
]);

$conversationId = $conversation['id'];
echo "Conversation ID: " . $conversationId . "\n";
echo "Created at: " . $conversation['created_at'] . "\n";

// Получение диалога
$conversation = $client->conversations()->get($conversationId);

// Обновление метаданных диалога
$conversation = $client->conversations()->update($conversationId, [
    'title' => 'Обновлённый заголовок',
    'status' => 'active',
]);

// Удаление диалога
$result = $client->conversations()->delete($conversationId);
// $result['deleted'] === true
```

### Управление элементами диалога

```php
use Tigusigalpa\YandexGPT\YandexGPTClient;

$client = new YandexGPTClient('your_oauth_token', 'your_folder_id');
$conversationId = 'conv_123';

// Добавление элементов в диалог
$items = $client->conversations()->createItems($conversationId, [
    [
        'type' => 'message',
        'role' => 'user',
        'content' => [['type' => 'input_text', 'text' => 'Привет! Как дела?']],
    ],
    [
        'type' => 'message',
        'role' => 'assistant',
        'content' => [['type' => 'output_text', 'text' => 'Здравствуйте! Всё отлично, чем могу помочь?']],
    ],
]);

// Получение списка элементов (с пагинацией)
$items = $client->conversations()->listItems($conversationId, 20, 'asc');
foreach ($items['data'] as $item) {
    echo $item['role'] . ': ' . ($item['content'][0]['text'] ?? '') . "\n";
}

// Пагинация: получение следующей страницы
if ($items['has_more']) {
    $nextPage = $client->conversations()->listItems(
        $conversationId,
        20,
        'asc',
        $items['last_id']
    );
}

// Получение одного элемента
$item = $client->conversations()->getItem($conversationId, 'item_123');

// Удаление элемента
$client->conversations()->deleteItem($conversationId, 'item_123');
```

### Использование через Laravel Facade

```php
use Tigusigalpa\YandexGPT\Laravel\Facades\YandexGPT;

// Создание диалога
$conversation = YandexGPT::conversations()->create(['title' => 'Новый диалог']);

// Добавление сообщений
YandexGPT::conversations()->createItems($conversation['id'], [
    [
        'type' => 'message',
        'role' => 'user',
        'content' => [['type' => 'input_text', 'text' => 'Вопрос пользователя']],
    ],
]);

// Получение истории
$history = YandexGPT::conversations()->listItems($conversation['id'], 50, 'asc');
```

---

## Генерация изображений (YandexART)

<p align="center">
  <img src="https://github.com/user-attachments/assets/0e08dee0-6fe2-41bd-ac92-501f53d18166" alt="YandexART Hero Image">
</p>

> Ресурсы:
> - Документация: https://yandex.cloud/ru/docs/ai-studio/quickstart/yandexart
> - [Отправка запроса](https://yandex.cloud/ru/docs/ai-studio/operations/generation/yandexart-request#generate-text)
> - Сайт: https://ya.ru/ai/art

SDK поддерживает генерацию изображений с помощью YandexART. Доступны три метода:

- **generateImageAsync** — отправка запроса на генерацию и получение объекта операции
- **getOperation** — проверка статуса операции по её ID
- **generateImage** — синхронная обёртка с ожиданием результата

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

## Требования

- PHP 8.0 или выше
- Laravel 8.0 или выше (для интеграции с Laravel)
- Guzzle HTTP 7.0 или выше

---

## Лицензия

Этот пакет распространяется под лицензией MIT. Подробности в файле [LICENSE](LICENSE).

---

## Ссылки

- [Wiki — документация и руководства](https://github.com/tigusigalpa/yandexgpt-php/wiki)
- [Документация YandexGPT API](https://yandex.cloud/ru/docs/foundation-models/)
- [Quickstart](https://yandex.cloud/ru/docs/foundation-models/quickstart/yandexgpt)
- [Список моделей](https://yandex.cloud/ru/docs/ai-studio/concepts/generation/models)

---

## Участие в разработке

Мы приветствуем участие в разработке! Пожалуйста, ознакомьтесь с [руководством по участию](CONTRIBUTING.md).

---

## Безопасность

Если вы обнаружили уязвимость в безопасности, пожалуйста, отправьте email на sovletig@gmail.com вместо создания issue.

---

## Автор

[Igor Sazonov](https://github.com/tigusigalpa) — sovletig@gmail.com

