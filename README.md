## Установка
``composer require kaetan/api-client``
## Использование
Получение списка комментариев:
```
$client = new \Kaetan\ApiClient\Client();
$comments = $client->comments->getComments();
```
Добавление комментария:
```
$client = new \Kaetan\ApiClient\Client();
$result = $client->comments->postComment(
    name: 'Интересные дела 86',
    text: 'Холодный климат часто является помехой для начинающего медитатора.'
);
```
Обновление комментария:
```
$client = new \Kaetan\ApiClient\Client();
$result = $client->comments->updateComment(
    id: 57,
    name: 'Интересные дела 57',
    text: 'Когда искатель сидит в позе торжественного медитатора, то, как правило он притворяется.'
);
```