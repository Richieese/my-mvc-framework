CREATE DATABASE IF NOT EXISTS rondes_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE rondes_inventory;

DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;

CREATE TABLE products (
    id          INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    name        VARCHAR(255)  NOT NULL,
    sku         VARCHAR(100)  NOT NULL UNIQUE,
    description TEXT,
    price       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock       INT UNSIGNED  NOT NULL DEFAULT 0,
    category    VARCHAR(100)  NOT NULL DEFAULT '',
    created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO products (name, sku, description, price, stock, category, created_at) VALUES
('Wireless Mouse',      'WM-001', 'Ergonomic wireless mouse',   850.00,  45, 'Electronics',     NOW()),
('Mechanical Keyboard', 'KB-002', 'TKL mechanical keyboard',   2500.00,   8, 'Electronics',     NOW()),
('Ballpen Box (12pcs)', 'BP-004', 'Black ballpen, box of 12',    85.00, 200, 'Office Supplies',  NOW()),
('A4 Bond Paper',       'AP-005', '500 sheets, 80gsm',          285.00,  60, 'Office Supplies',  NOW()),
('Office Chair',        'OC-007', 'Adjustable mesh chair',     4500.00,   5, 'Furniture',        NOW());
