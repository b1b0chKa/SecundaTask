Чтобы сгенерировать API-ключ, выполните команду:

    php artisan api:generate-api-key


Команда автоматически создаст ключ и сохранит его в файл:

    ./storage/app/private/api_key

Полученный ключ необходимо использовать в заголовках запросов.


Пример обращения к эндпоинту:

    curl -H "X-API-KEY: YOUR_API_KEY" https://localhost/api/buildings
