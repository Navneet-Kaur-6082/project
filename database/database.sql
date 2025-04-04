CREATE DATABASE shelfy_db;
USE shelfy_db;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    address TEXT,
    role ENUM('customer', 'admin') DEFAULT 'customer',
   created_at DATE DEFAULT CURRENT_DATE
    );


CREATE TABLE books (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    description TEXT,
    cover_image VARCHAR(255) NOT NULL DEFAULT '/project/imgs/',
    created_at DATE DEFAULT CURRENT_DATE
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10,2) NOT NULL,
    order_status ENUM('Pending', 'Shipped', 'Delivered', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    book_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
);

CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    book_id INT,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
);

CREATE TABLE order_tracking (
    tracking_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    status ENUM('Processing', 'Shipped', 'Out for Delivery', 'Delivered') DEFAULT 'Processing',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
);

CREATE TABLE inventory_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT,
    book_id INT,
    action ENUM('Added', 'Updated', 'Deleted'),
    quantity_changed INT,
    log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
);

INSERT INTO users (name, email, password, phone, address, role) VALUES
('Alice Johnson', 'alice@example.com', 'password123', '1234567890', '123 Elm St, NY', 'customer'),
('Bob Smith', 'bob@example.com', 'password123', '9876543210', '456 Maple St, CA', 'customer'),
('Charlie Brown', 'charlie@example.com', 'password123', '5556667777', '789 Oak St, TX', 'admin'),
('David White', 'david@example.com', 'password123', '1112223333', '321 Pine St, FL', 'customer'),
('Eve Black', 'eve@example.com', 'password123', '4445556666', '654 Birch St, IL', 'admin'),
('Frank Green', 'frank@example.com', 'password123', '7778889999', '987 Cedar St, WA', 'customer'),
('Grace Blue', 'grace@example.com', 'password123', '6667778888', '741 Willow St, NV', 'customer'),
('Hank Orange', 'hank@example.com', 'password123', '9990001111', '852 Fir St, OR', 'customer'),
('Ivy Purple', 'ivy@example.com', 'password123', '2223334444', '369 Spruce St, AZ', 'admin'),
('Jack Yellow', 'jack@example.com', 'password123', '3334445555', '159 Redwood St, CO', 'customer');

INSERT INTO books (title, author, category, price, stock, description, cover_image) VALUES
('The Great Gatsby', 'F. Scott Fitzgerald', 'Romance', 10.99, 20, 'A classic novel set in the 1920s.', '/project/imgs/the-great-gatsby.jpeg'),
('1984', 'George Orwell', 'Novel', 12.50, 15, 'A novel about totalitarian surveillance.', '/project/imgs/1984.jpeg'),
('To Kill a Mockingbird', 'Harper Lee', 'Novel', 9.99, 25, 'A novel about racial injustice.', '/project/imgs/mockingbird.jpeg'),
('Moby-Dick', 'Herman Melville', 'Fiction', 15.00, 10, 'A story of obsession with a white whale.', '/project/imgs/mobydick.jpeg'),
('Pride and Prejudice', 'Jane Austen', 'Romance', 8.99, 30, 'A romantic novel about social standing.', '/project/imgs/pride-and-prejudice.jpeg'),
('The Catcher in the Rye', 'J.D. Salinger', 'Fiction', 11.75, 18, 'A novel about teenage alienation.', '/project/imgs/catcher.png'),
('Brave New World', 'Aldous Huxley', 'Novel', 14.99, 12, 'A vision of a dystopian future.', '/project/imgs/bravenew.jpeg'),
('The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 13.50, 22, 'A prelude to the Lord of the Rings.', '/project/imgs/hobbit.jpeg'),
('War and Peace', 'Leo Tolstoy', 'Historical', 20.00, 8, 'A novel about Napoleonic wars.', '/project/imgs/warpeace.jpeg'),
('The Odyssey', 'Homer', 'Historical', 18.99, 14, 'An ancient Greek epic poem.', '/project/imgs/odyssey.jpeg');

INSERT INTO orders (user_id, total_price, order_status) VALUES
(1, 21.98, 'Shipped'),
(2, 12.50, 'Pending'),
(3, 30.99, 'Delivered'),
(4, 20.00, 'Pending'),
(5, 25.50, 'Cancelled'),
(6, 18.99, 'Delivered'),
(7, 13.50, 'Pending'),
(8, 9.99, 'Shipped'),
(9, 15.00, 'Pending'),
(10, 10.99, 'Delivered');

INSERT INTO order_items (order_id, book_id, quantity, price) VALUES
(1, 1, 2, 21.98),
(2, 2, 1, 12.50),
(3, 3, 3, 30.99),
(4, 4, 1, 20.00),
(5, 5, 2, 25.50),
(6, 6, 1, 18.99),
(7, 7, 1, 13.50),
(8, 8, 1, 9.99),
(9, 9, 1, 15.00),
(10, 10, 1, 10.99);

INSERT INTO cart (user_id, book_id, quantity) VALUES
(1, 1, 1),
(2, 3, 2),
(3, 5, 1),
(4, 7, 1),
(5, 9, 2),
(6, 2, 1),
(7, 4, 1),
(8, 6, 1),
(9, 8, 1),
(10, 10, 1);

INSERT INTO order_tracking (order_id, status) VALUES
(1, 'Shipped'),
(2, 'Processing'),
(3, 'Delivered'),
(4, 'Processing'),
(5, 'Cancelled'),
(6, 'Delivered'),
(7, 'Processing'),
(8, 'Shipped'),
(9, 'Processing'),
(10, 'Delivered');

INSERT INTO inventory_logs (admin_id, book_id, action, quantity_changed) VALUES
(3, 1, 'Added', 20),
(5, 2, 'Added', 15),
(3, 3, 'Updated', 10),
(9, 4, 'Deleted', -1),
(5, 5, 'Updated', 5),
(3, 6, 'Added', 18),
(9, 7, 'Updated', 8),
(5, 8, 'Added', 22),
(3, 9, 'Updated', 4),
(9, 10, 'Deleted', -2);
