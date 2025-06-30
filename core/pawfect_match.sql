-- Create the database
DROP DATABASE IF EXISTS pawfect_matchdb;
CREATE DATABASE pawfect_matchdb;
USE pawfect_matchdb;

-- 1. USERS TABLE
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('admin', 'user', 'adoption_center') NOT NULL DEFAULT 'user',
    status ENUM('active', 'inactive', 'pending', 'suspended','deleted') NOT NULL DEFAULT 'active',
    is_verified TINYINT(1) NOT NULL DEFAULT 0,
    verify_token VARCHAR(255) DEFAULT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. PETS TABLE
CREATE TABLE pets (
    pet_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL,
    breed VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    age DECIMAL(3,1) NOT NULL,
    date_arrival DATE NOT NULL,
    size ENUM('Small', 'Medium', 'Large', 'Extra Large') NOT NULL,
    weight DECIMAL(5,2) NOT NULL,
    color VARCHAR(100) NOT NULL,
    health_status ENUM('Excellent', 'Good', 'Fair', 'Poor') NOT NULL,
    characteristics TEXT,
    description TEXT NOT NULL,
    health_notes TEXT,
    adoption_center VARCHAR(150) NOT NULL,
    contact_phone VARCHAR(20) NOT NULL,
    contact_email VARCHAR(100) NOT NULL,
    center_address TEXT NOT NULL,
    center_website VARCHAR(255),
    image_path VARCHAR(255),
    status ENUM('available', 'adopted', 'pending') NOT NULL DEFAULT 'available',
    posted_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by) REFERENCES users(user_id) ON DELETE SET NULL
);

--pets table in samriddhi's database 
/*CREATE TABLE pets (
    pet_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('dog', 'cat', 'rabbit', 'other') NOT NULL,
    breed VARCHAR(100),
    age DECIMAL(3,1),
    date_arrival DATE,
    size ENUM('Small', 'Medium', 'Large', 'Extra Large'),
    weight DECIMAL(5,2),
    color VARCHAR(100),
    characteristics TEXT,
    gender ENUM('Male', 'Female') NOT NULL,
    health_status VARCHAR(255),
    image_path VARCHAR(255),
    status ENUM('available', 'adopted', 'pending') NOT NULL DEFAULT 'available',
    posted_by INT,
    description TEXT,
    health_notes TEXT,
    adoption_center VARCHAR(150) NOT NULL,
    contact_phone VARCHAR(20) NOT NULL,
    contact_email VARCHAR(100) NOT NULL,
    center_address TEXT NOT NULL,
    center_website VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by) REFERENCES users(user_id) ON DELETE SET NULL
);*/

-- 3. ADOPTION REQUESTS TABLE
CREATE TABLE adoption_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    pet_id INT NOT NULL,
    request_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (pet_id) REFERENCES pets(pet_id)
);

-- 4. ADOPTION FORM TABLE
CREATE TABLE adoption_form (
    form_id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(20) NOT NULL,
    reason TEXT NOT NULL,
    preferred_date DATE,
    home_type ENUM('house', 'apartment', 'other'),
    has_other_pets BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (request_id) REFERENCES adoption_requests(request_id) ON DELETE CASCADE
);

-- 5. WISHLIST TABLE
CREATE TABLE wishlist (
    wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    pet_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (pet_id) REFERENCES pets(pet_id)
);

-- 6. VOLUNTEERS TABLE
CREATE TABLE volunteers (
    volunteer_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    area ENUM('pet care', 'training', 'fundraising', 'other'),
    availability_days VARCHAR(100),
    status ENUM('pending', 'assigned', 'rejected') DEFAULT 'pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- 7. FEEDBACK TABLE
CREATE TABLE feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    recipient_type ENUM('admin', 'adoption_center') NOT NULL,
    recipient_id INT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(user_id),
    FOREIGN KEY (recipient_id) REFERENCES users(user_id) ON DELETE SET NULL
);

-- 8. TRAINING TIPS TABLE
CREATE TABLE training_tips (
    tip_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    video_link TEXT,
    description TEXT,
    created_by INT,  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL 
);

-- 9. DONATIONS TABLE
CREATE TABLE donations (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(10,2),
    message TEXT,
    donated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- 10. CONTACT MESSAGES TABLE
CREATE TABLE contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL
);

-- 11. adoption_centers Table
CREATE TABLE adoption_centers (
    center_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE NOT NULL,      
    name VARCHAR(150) NOT NULL,
    established_date DATE,
    location TEXT,
    phone VARCHAR(20),
    number_of_employees INT DEFAULT 0,
    description TEXT,
    operating_hours VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);









