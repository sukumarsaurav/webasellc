CREATE DATABASE weblink_db;
USE weblink_db;

CREATE TABLE contact_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    icon_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE portfolio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE blog_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    slug VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS blog;
CREATE TABLE blog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    excerpt TEXT,
    image_path VARCHAR(255),
    author VARCHAR(100) NOT NULL,
    category_id INT,
    status ENUM('draft', 'published') DEFAULT 'published',
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES blog_categories(id)
);

INSERT INTO blog_categories (name, slug) VALUES
('Web Development', 'web-development'),
('Design', 'design'),
('Marketing', 'marketing'),
('Technology', 'technology');

INSERT INTO blog (title, slug, content, excerpt, image_path, author, category_id) VALUES
('10 Essential Web Development Tools for 2024', 
'10-essential-web-development-tools-2024',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat...',
'Discover the must-have web development tools that will boost your productivity in 2024.',
'/src/images/blog/web-dev-tools.jpg',
'John Doe',
1),

('The Future of UI/UX Design',
'future-of-ui-ux-design',
'Nulla facilisi. Mauris efficitur sapien in dolor bibendum, at consequat massa fermentum. Proin egestas, ipsum in tempor sagittis, sem mi aliquam lorem, nec ultricies justo lectus ut sapien...',
'Explore the upcoming trends in UI/UX design and how they will shape the future of web design.',
'/src/images/blog/ui-ux-future.jpg',
'Jane Smith',
2),

('Digital Marketing Strategies That Work',
'digital-marketing-strategies-work',
'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula...',
'Learn about effective digital marketing strategies that can help grow your business.',
'/src/images/blog/digital-marketing.jpg',
'Mike Johnson',
3);