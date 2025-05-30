-- Users table
CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    google_id VARCHAR(255) DEFAULT NULL,
    shopify_store_url VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active TINYINT(1) DEFAULT 1,
    INDEX idx_email (email),
    INDEX idx_google_id (google_id),
    INDEX idx_is_active (is_active),
    email_verified_at DATETIME DEFAULT NULL
);

-- Password resets table
CREATE TABLE password_resets(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME NOT NULL,
    used_at DATETIME DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_token (token),
    INDEX idx_expires_at (expires_at)
);

-- Categories table for better organization
CREATE TABLE categories(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Themes table
CREATE TABLE themes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT DEFAULT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT DEFAULT NULL,
    price DECIMAL(10, 2) DEFAULT 0.00,
    preview_url VARCHAR(255) DEFAULT NULL,
    theme_zip_path VARCHAR(500) DEFAULT NULL, -- Store file path instead of BLOB
    download_count INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_category_id (category_id),
    INDEX idx_price (price),
    INDEX idx_is_active (is_active),
    INDEX idx_created_at (created_at)
);

-- Sections table
CREATE TABLE sections(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT DEFAULT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT DEFAULT NULL,
    price DECIMAL(10, 2) DEFAULT 0.00,
    preview_url VARCHAR(255) DEFAULT NULL,
    sections_zip_path VARCHAR(500) DEFAULT NULL, -- Store file path instead of BLOB
    download_count INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_category_id (category_id),
    INDEX idx_price (price),
    INDEX idx_is_active (is_active),
    INDEX idx_created_at (created_at)
);

-- Payment methods table
CREATE TABLE payment_methods(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE, -- 'stripe', 'paypal', 'credit_card', etc.
    is_active TINYINT(1) DEFAULT 1
);

-- Orders table with improved structure
CREATE TABLE orders(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_type ENUM('theme', 'section') NOT NULL,
    item_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    payment_method_id INT DEFAULT NULL,
    transaction_id VARCHAR(255) DEFAULT NULL,
    payment_status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    order_status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    completed_at DATETIME DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_item_type_id (item_type, item_id),
    INDEX idx_payment_status (payment_status),
    INDEX idx_order_status (order_status),
    INDEX idx_created_at (created_at),
    INDEX idx_transaction_id (transaction_id)
);

-- Theme access table
CREATE TABLE user_theme_access(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    theme_id INT NOT NULL,
    access_level ENUM('view', 'download', 'admin') DEFAULT 'view',
    granted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (theme_id) REFERENCES themes(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_theme (user_id, theme_id),
    INDEX idx_user_id (user_id),
    INDEX idx_theme_id (theme_id),
    INDEX idx_expires_at (expires_at)
);

-- Section access table
CREATE TABLE user_section_access(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    section_id INT NOT NULL,
    access_level ENUM('view', 'download', 'admin') DEFAULT 'view',
    granted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_section (user_id, section_id),
    INDEX idx_user_id (user_id),
    INDEX idx_section_id (section_id),
    INDEX idx_expires_at (expires_at)
);

-- Reviews table for user feedback
CREATE TABLE reviews(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_type ENUM('theme', 'section') NOT NULL,
    item_id INT NOT NULL,
    rating TINYINT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_item_type_id (item_type, item_id),
    INDEX idx_rating (rating),
    INDEX idx_created_at (created_at),
    UNIQUE KEY unique_user_item_review (user_id, item_type, item_id)
);

-- Download history table
CREATE TABLE downloads(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_type ENUM('theme', 'section') NOT NULL,
    item_id INT NOT NULL,
    order_id INT DEFAULT NULL,
    download_ip VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    downloaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_item_type_id (item_type, item_id),
    INDEX idx_order_id (order_id),
    INDEX idx_downloaded_at (downloaded_at)
);

-- Tags table for better categorization
CREATE TABLE tags(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Theme tags junction table
CREATE TABLE theme_tags(
    theme_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (theme_id, tag_id),
    FOREIGN KEY (theme_id) REFERENCES themes(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

-- Section tags junction table
CREATE TABLE section_tags(
    section_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (section_id, tag_id),
    FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

-- Insert default categories
INSERT INTO categories (name, description) VALUES 
('Supplement', 'Specialized for supplement stores'),
('Cosmetics', 'Specialized for cosmetic stores'),
('Clothes', 'Specialized for clothes stores'),
('Digital Products', 'Specialized for digital stores'),
('Electronics', 'Specialized for electronics stores'),
('Furniture', 'Specialized for furniture stores'),
('Jewelry', 'Specialized for jewelry stores'),
('Books', 'Specialized for book stores');

-- Insert default payment methods
INSERT INTO payment_methods (name) VALUES 
('stripe'),
('paypal'),
('credit_card');

-- Insert common tags
INSERT INTO tags (name) VALUES 
('responsive'),
('mobile-friendly'),
('seo-optimized'),
('fast-loading'),
('customizable'),
('modern'),
('minimal'),
('colorful'),
('dark-mode'),
('accessibility');

