# books-api
Basic CRUD Api of books for a Level Test

## Instantiate MySql database
`docker-compose up -d`

## Start server on port 9000
`symfony server:start`

## API Endpoints

| Method | Endpoint               | Action                                                       |
| ------ | ---------------------- | ------------------------------------------------------------ |
| GET    | books                  | Retrieve all books                                           |
| GET    | books/:isbn            | Retrieve book                                                |
| POST   | books                  | Create book                                                  |
| PUT    | books/:isbn            | Update book                                                  |
| DELETE | books/:isbn            | Remove book                                                  |