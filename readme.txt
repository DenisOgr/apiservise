input: /users/id/1234?method=get&a=12&type=json&puk=PUBLIC_KEY&sign
    module: user
    action: view
    method: get
    type  : json||php||xml
    params: array(method=>get,a=12)

sign = md5(/users/id/1234?method=get&a=12&type=json&public_key=PUBLIC_KEY.PRIVATE)

POST /dogs/ — cоздать собаку
GET /dogs/12345 — показать информацию о собаке
PUT /dogs/12345 — редактировать собаку 12345
DELETE /dogs/12345 — удалить


output:
 code: 200(ok) 400 Bad Request  500 Internal server error
 data: 'some data'
 message: 'text errors'

