-- Buat database
CREATE DATABASE IF NOT EXISTS lamurah_store;
USE lamurah_store;

-- Tabel untuk produk game
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    game_name VARCHAR(100) NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel untuk pesanan
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    game_name VARCHAR(100) NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert data sample untuk produk Mobile Legends
INSERT INTO products (game_name, item_name, price) VALUES
('Mobile Legends', '86 Diamond', 20000),
('Mobile Legends', '172 Diamond', 40000),
('Mobile Legends', '257 Diamond', 60000),
('Mobile Legends', '344 Diamond', 80000),
('Mobile Legends', '429 Diamond', 100000),
('Mobile Legends', '514 Diamond', 120000);

-- Insert data sample untuk produk Free Fire
INSERT INTO products (game_name, item_name, price) VALUES
('Free Fire', '70 Diamond', 10000),
('Free Fire', '140 Diamond', 20000),
('Free Fire', '355 Diamond', 50000),
('Free Fire', '720 Diamond', 100000),
('Free Fire', '1450 Diamond', 200000);

-- Insert data sample untuk produk PUBG Mobile
INSERT INTO products (game_name, item_name, price) VALUES
('PUBG Mobile', '60 UC', 15000),
('PUBG Mobile', '325 UC', 75000),
('PUBG Mobile', '660 UC', 150000),
('PUBG Mobile', '1800 UC', 400000),
('PUBG Mobile', '3850 UC', 800000);

-- Insert data sample untuk produk Genshin Impact
INSERT INTO products (game_name, item_name, price) VALUES
('Genshin Impact', '60 Genesis Crystal', 16000),
('Genshin Impact', '330 Genesis Crystal', 79000),
('Genshin Impact', '1090 Genesis Crystal', 249000),
('Genshin Impact', '2240 Genesis Crystal', 499000);