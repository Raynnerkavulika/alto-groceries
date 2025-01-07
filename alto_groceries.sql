CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,               -- Unique user ID
    name VARCHAR(255) NOT NULL,                      -- User's name
    email VARCHAR(255) UNIQUE,                       -- User's email (optional)
    phone VARCHAR(15) UNIQUE,                        -- User's phone number (optional)
    password_hash VARCHAR(255) NOT NULL,             -- Hashed password
    token VARCHAR(255) NOT NULL,        -- Token to associate the verification process
    image VARCHAR(255) DEFAULT NULL,       -- Path to the uploaded profile picture (optional)
    verification_code INT NOT NULL,                  -- Code sent to the user via email
    token_expiry INT NOT NULL,                       -- Token expiry time (timestamp)
    verified TINYINT(1) DEFAULT 0,                   -- 0 = Not verified, 1 = Verified
    user_type VARCHAR(20) DEFAULT user,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp for when the account was created
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Timestamp for updates
);

-- orders table

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    payment_status ENUM('Pending', 'Paid', 'Failed') DEFAULT 'Pending',
    order_status ENUM('Pending', 'Processing', 'Completed', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


-- order items table

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);


--products table

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT NOT NULL,
    category_id INT,
    image_url VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);