# TodoNotesController

The `TodoNotesController` is a controller class responsible for handling CRUD operations and other actions related to TodoNotes in your application.

## Prerequisites

- Laravel framework
- Database configured

## Installation

1. Clone the repository to your local machine.
2. Install dependencies by running the following command: composer install
3. Configure the database in the `.env` file.
4. Run the database migrations using the following command: php artisan migrate
5. Start the development server: php artisan serve
6. Access the application in your browser at `http://localhost:8000`.

## Usage

The `TodoNotesController` provides the following endpoints:

- `GET /todo-notes` - Retrieve all active TodoNotes.
- `GET /todo-notes/archived` - Retrieve all archived TodoNotes.
- `POST /todo-notes` - Create a new TodoNote.
- `GET /todo-notes/{id}` - Retrieve a specific TodoNote by ID.
- `PUT /todo-notes/{id}` - Update a specific TodoNote by ID.
- `DELETE /todo-notes/{id}` - Delete a specific TodoNote by ID.
- `POST /todo-notes/{id}/archive` - Archive or unarchive a specific TodoNote by ID.

## API Responses

The API responses follow a standard format using the `APIHelper` class. The response structure includes:

- `data` - The main data payload of the response.
- `status` - The HTTP status code of the response.
- `message` - A brief message providing additional context.

### Successful Response

```json
{
    "status_code": 200,
    "status_message": "Success",
    "data": {
    // Response data here
    }
}
```

### Error Response

```json
{
  "status_code": 400,
  "error": {
    // Error details here
  }
}
```

## Error Handling

In case of any errors or exceptions, the API will return an error response with the appropriate HTTP status code and a descriptive error message.

## Customization

You can customize the behavior of the `TodoNotesController` by modifying the constants defined in the constructor of the controller. These constants include:

- `successStatus` - The success HTTP status code.
- `successMsg` - The success message.
- `systemError` - The system error message.
- `systemErrorCode` - The system error HTTP status code.
- `notFoundError` - The "not found" error message.
- `notFoundErrorCode` - The "not found" error HTTP status code.
- `noUserFound` - The "user not found" error message.
- `badRequestCode` - The bad request HTTP status code.

Feel free to update these constants to match your application's requirements.


