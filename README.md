Apiservise
==========

Тестовое задание.
## 1. Архитектура.
В основе паттерн Singelton.
Модульная система. Каждый модуль поддерживает REST-дизайн.
Экшены в модулях:
     * GET  users/{id} - get one user
     * GET  users      - get list of users
     * POST users      - create new user
     * PUT users/{id}  - update user
     * DELET users/{id}- delete user

 Если клиент не поддерживает некоторые типы запросов(PUT, DELETE),
 тип запроса можно передать в параметре method

Резульат возвращается в форматах
 *JSON
 *XML
 *Serialize(php)

Для выбора провайдера результата используется паттерн Factory Method.

## 2. Безопасность.
1. Идентификация/Аутификация клиентов по приватному и пуьличному ключу.
2. Цифровая подпись (сигнатура) для проверки целостности данных.
3. Ограниченный доступ к экшенам. Экшен можно использовать:
    - экшен входит в REST-дизайн
    -экшен разрешен к конфиге настроек модуля.
4. Сериализация входящих параметров.

## 3. Параметры запроса.

    input: /users/id/1234?method=get&a=12&type=json&puk=PUBLIC_KEY&sign

module: user
method: get||post||put||delete
type  : json||php||xml

Обязательные параметры:
puk - публичный ключ
sign - сигнатура.

Формирование сигнатуры.

    md5(/users/id/1234?method=get&a=12&type=json&puk=PUBLIC_KEY.PRIVATE_KEY)

## 4. Параметры ответа:
Все ответы возвращают status 200 OK. Но реальный статус, пишется в теле ответа.

Форма ответа:

    code: 200(ok) || 400 Bad Request || 500 Internal server error
    data: 'some data'
    message: 'text errors'


