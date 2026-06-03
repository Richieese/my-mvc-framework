# SOLID Design Justification

**Project:** Ronde's Inventory System — Custom PHP MVC Framework

---

# Single Responsibility Principle

Each class in the framework focuses on a single task.

| Class               | Responsibility                           |
| ------------------- | ---------------------------------------- |
| `Router`            | Stores and resolves routes               |
| `Dispatcher`        | Executes controller actions              |
| `Request`           | Wraps request data from PHP superglobals |
| `Response`          | Handles HTTP responses                   |
| `Engine`            | Renders view files                       |
| `Validator`         | Validates form input                     |
| `ProductController` | Handles product-related requests         |
| `ProductRepository` | Handles database queries for products    |

For example, controllers never write SQL directly, and repositories never render views. This keeps the code easier to maintain and update.

---

# Open/Closed Principle

The framework is designed so new functionality can be added without changing existing code.

The database layer uses a `DatabaseDriver` interface implemented by drivers like:

* `MySQLDriver`
* `SQLiteDriver`

Adding another driver, such as PostgreSQL, only requires creating a new class that implements the same interface and updating the container binding.

The existing connection logic does not need to change.

---

# Liskov Substitution Principle

Classes that implement the same contract can be swapped without affecting the rest of the application.

For example:

* `MySQLDriver`
* `SQLiteDriver`

both implement `DatabaseDriver` and return a valid PDO connection.

Repositories also follow the same pattern. Any repository implementing `Findable` can safely be used wherever read operations are expected.

---

# Interface Segregation Principle

The database layer separates read and write operations into smaller interfaces instead of using one large interface.

| Interface     | Purpose          |
| ------------- | ---------------- |
| `Findable`    | Read operations  |
| `Persistable` | Write operations |

This prevents classes from being forced to implement methods they do not need.

For example, a read-only repository could implement only `Findable` without needing empty `delete()` or `update()` methods.

---

# Dependency Inversion Principle

Controllers depend on interfaces instead of concrete repository classes.

Example:

```php
private readonly ProductRepositoryInterface $products
```

instead of:

```php
private readonly ProductRepository $products
```

The dependency injection container resolves the actual implementation through bindings defined in `config/app.php`.

Because of this, repositories can be swapped or replaced without changing controller logic.

---

The framework applies SOLID principles mainly to keep responsibilities separated, reduce coupling, and make components easier to extend and maintain.
