# Ronde's Inventory System

A lightweight inventory system built on a custom PHP MVC framework using PHP 8.4.12, PSR-4 autoloading, dependency injection, and middleware support.

The project was created to better understand how MVC frameworks work internally without relying on Laravel or Symfony.

---

# Features

* Custom MVC architecture
* PSR-4 autoloading via Composer
* Reflection-based dependency injection container
* Repository pattern
* Middleware pipeline support
* Server-side validation
* Custom routing and dispatching
* MySQL and SQLite driver support

---

# Routes

| Method | Route                     | Description     |
| ------ | ------------------------- | --------------- |
| GET    | `/`                       | Dashboard       |
| GET    | `/products`               | View products   |
| GET    | `/products/create`        | Product form    |
| POST   | `/products`               | Create product  |
| GET    | `/products/{id}/edit`     | Edit product    |
| POST   | `/products/{id}/update`   | Update product  |
| POST   | `/products/{id}/delete`   | Delete product  |
| GET    | `/categories`             | View categories |
| GET    | `/categories/create`      | Category form   |
| POST   | `/categories`             | Create category |
| POST   | `/categories/{id}/delete` | Delete category |

---

# Project Structure

```txt id="g63cf0"
my-mvc-framework/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   └── Middleware/
├── core/
│   ├── Http/
│   ├── Database/
│   ├── View/
│   ├── Validation/
│   ├── Container/
│   └── Application.php
├── config/
├── public/
├── routes/
├── storage/
├── composer.json
├── database.sql
└── README.md
```

---

# Architecture

* `public/index.php` acts as the front controller
* Router resolves routes and parameters
* Dispatcher executes controller actions
* Controllers handle HTTP requests and responses
* Repositories manage database operations
* Views are rendered through a custom view engine

The framework separates routing, dispatching, validation, and persistence into dedicated components to keep responsibilities isolated and maintainable.

---

# Middleware

Middleware is registered through the dispatcher pipeline.

Current middleware:

| Middleware                | Purpose                     |
| ------------------------- | --------------------------- |
| `RequestLoggerMiddleware` | Logs request method and URI |

Example log output:

```txt id="u6o08j"
[2025-06-01 10:42:01] GET /
[2025-06-01 10:42:15] GET /products/create
```
