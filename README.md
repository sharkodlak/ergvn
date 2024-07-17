# Retia

Install this application:
make up
make migrate

Import books:
make in
bin/console app:book:import

Use Postman for API utilization:
GET http://localhost/api/v1/books
GET http://localhost/api/v1/books/{book_id}

Stop application:
make down
