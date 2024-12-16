CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,               -- Unique user ID
    name VARCHAR(255) NOT NULL,                      -- User's name
    email VARCHAR(255) UNIQUE,                       -- User's email (optional)
    phone VARCHAR(15) UNIQUE,                        -- User's phone number (optional)
    password_hash VARCHAR(255) NOT NULL,             -- Hashed password
    verification_token VARCHAR(255) NOT NULL,        -- Token to associate the verification process
    profile_picture VARCHAR(255) DEFAULT NULL,       -- Path to the uploaded profile picture (optional)
    verification_code INT NOT NULL,                  -- Code sent to the user via email
    token_expiry INT NOT NULL,                       -- Token expiry time (timestamp)
    verified TINYINT(1) DEFAULT 0,                   -- 0 = Not verified, 1 = Verified
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp for when the account was created
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Timestamp for updates
);
