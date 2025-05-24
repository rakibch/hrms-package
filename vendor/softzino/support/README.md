# Support Repository

This project provides a robust `Repository` class to abstract and manage data access logic in your Laravel applications. It is designed to promote clean architecture, separation of concerns, and ease of testing.

## Features
- Encapsulates data access logic
- Promotes code reusability and maintainability
- Easily extendable for different data sources (e.g., database, API)
- Facilitates unit testing by decoupling business logic from data storage

## Installation

### Install dependencies using Composer:
   ```bash
   composer require softzino/support
   ```

## Usage

### Basic Example

```php
namespace App\Repositories;

use Softzino\Support\Repository;

class UserRepository extends Repository {
    // Custom methods for user data
}

$repository = new UserRepository();

// Fetch all records
data = $repository->all();

// Find a record by ID
$record = $repository->find($id);

// Create a new record
$new = $repository->create(['field' => 'value']);

// Update a record
$updated = $repository->update($id, ['field' => 'new value']);

// Delete a record
$repository->delete($id);
```

## Filtering Examples

### Using basic filtering
```php
$userRepository->filter([
    'name' => 'John',
    'age'  => 30
])->all();
// Comparison operators
$userRepository->usingFilter([
    'created_at' => ['>=', '2023-01-01']
])->all();

// LIKE operator
$userRepository->usingFilter([
    'name' => ['like', '%john%']
])->all();

// IN operator
$userRepository->usingFilter([
    'id' => ['in', [1, 2, 3]]
])->all();

// BETWEEN operator
$userRepository->usingFilter([
    'price' => ['between', [100, 500]]
])->all();
```

### Using eloquent-filtering package (requires indexzer0/eloquent-filtering)
```php
$userRepository->usingFilter([
    [
        'target' => 'name',
        'type'   => '$eq',
        'value'  => 'John'
    ],
    [
        'target' => 'age',
        'type'   => '$gt',
        'value'  => 30
    ]
])->all();
```
reference: https://docs.eloquentfiltering.com/v2/introduction/eloquent-filtering

## Contributing
Contributions are welcome! Please fork the repository and submit a pull request.

## License
This project is open-source and available under the [MIT License](LICENSE).