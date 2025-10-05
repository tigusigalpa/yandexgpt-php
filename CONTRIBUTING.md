# 🤝 Руководство по участию в разработке

Спасибо за интерес к проекту YandexGPT PHP SDK! Мы рады любому вкладу в развитие пакета.

## 📋 Как внести вклад

### 🐛 Сообщение об ошибках

Если вы нашли ошибку:

1. **Проверьте существующие issues** - возможно, проблема уже известна
2. **Создайте новый issue** с подробным описанием:
   - Версия PHP и Laravel
   - Шаги для воспроизведения
   - Ожидаемое и фактическое поведение
   - Логи ошибок (если есть)

### 💡 Предложение новых функций

Для предложения новой функциональности:

1. **Создайте issue** с тегом `enhancement`
2. **Опишите проблему**, которую решает функция
3. **Предложите решение** с примерами использования
4. **Дождитесь обсуждения** перед началом разработки

## 🔧 Процесс разработки

### 1. Подготовка окружения

```bash
# Форкните репозиторий и клонируйте его
git clone https://github.com/your-username/yandexgpt-php.git
cd yandexgpt-php

# Установите зависимости
composer install

# Создайте ветку для вашей функции
git checkout -b feature/your-feature-name
```

### 2. Настройка для тестирования

```bash
# Скопируйте файл окружения
cp .env.example .env

# Добавьте ваши тестовые токены
YANDEX_GPT_OAUTH_TOKEN=your_test_token
YANDEX_GPT_FOLDER_ID=your_test_folder_id
```

### 3. Разработка

- **Следуйте PSR-12** стандарту кодирования
- **Добавляйте типы** для всех параметров и возвращаемых значений
- **Пишите тесты** для новой функциональности
- **Обновляйте документацию** при необходимости

### 4. Тестирование

```bash
# Запуск всех тестов
composer test

# Запуск тестов с покрытием
composer test-coverage

# Проверка стиля кода
composer lint
```

## 📝 Стандарты кодирования

### PHP Code Style

```php
<?php

namespace Tigusigalpa\YandexGPT;

class ExampleClass
{
    private string $property;

    public function __construct(string $property)
    {
        $this->property = $property;
    }

    public function getProperty(): string
    {
        return $this->property;
    }
}
```

### Документация кода

```php
/**
 * Generate text using YandexGPT API
 *
 * @param string $prompt Text prompt for generation
 * @param string $model Model to use for generation
 * @param array $options Additional options
 * @return array API response
 * @throws ApiException When API request fails
 */
public function generateText(string $prompt, string $model = 'yandexgpt-lite', array $options = []): array
{
    // Implementation
}
```

## 🧪 Написание тестов

### Структура тестов

```php
<?php

namespace Tigusigalpa\YandexGPT\Tests;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testExampleFunction(): void
    {
        // Arrange
        $input = 'test input';
        
        // Act
        $result = $this->someFunction($input);
        
        // Assert
        $this->assertEquals('expected output', $result);
    }
}
```

### Покрытие тестами

- **Новые функции** должны иметь тесты
- **Исправления ошибок** должны включать регрессионные тесты
- **Стремитесь к 80%+** покрытию кода

## 📚 Документация

### README обновления

При добавлении новых функций обновите:

- Примеры использования
- Список доступных методов
- Конфигурационные параметры

### Комментарии в коде

```php
// Хорошо: объясняет "почему"
// Используем кэширование IAM токена для избежания лишних запросов
$this->cachedToken = $iamToken;

// Плохо: объясняет "что"
// Присваиваем токен переменной
$this->cachedToken = $iamToken;
```

## 🚀 Pull Request

### Чеклист перед отправкой

- [ ] Код соответствует стандартам проекта
- [ ] Все тесты проходят
- [ ] Добавлены тесты для новой функциональности
- [ ] Обновлена документация
- [ ] Коммиты имеют понятные сообщения

### Шаблон PR

```markdown
## Описание
Краткое описание изменений

## Тип изменений
- [ ] Исправление ошибки
- [ ] Новая функция
- [ ] Критическое изменение
- [ ] Обновление документации

## Тестирование
- [ ] Тесты проходят локально
- [ ] Добавлены новые тесты

## Чеклист
- [ ] Код следует стандартам проекта
- [ ] Обновлена документация
```

## 🔍 Процесс ревью

1. **Автоматические проверки** должны пройти
2. **Ревью кода** от мейнтейнеров
3. **Тестирование** на разных версиях PHP/Laravel
4. **Мерж** после одобрения

## 📞 Связь

- **GitHub Issues** - для багов и предложений
- **GitHub Discussions** - для общих вопросов
- **Email** - sovletig@gmail.com для приватных вопросов

## 📄 Лицензия

Участвуя в проекте, вы соглашаетесь с тем, что ваш вклад будет лицензирован под MIT License.

---

Спасибо за ваш вклад в развитие YandexGPT PHP SDK! 🎉
