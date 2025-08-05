-- Struktur Tabel Admin
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Struktur Tabel Hero
CREATE TABLE hero (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    role VARCHAR(100),
    university VARCHAR(100),
    student_id VARCHAR(50),
    department VARCHAR(100),
    graduation_year INT,
    profile_image VARCHAR(255)
);

-- Struktur Tabel About
CREATE TABLE about (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT
);

-- Struktur Tabel Skills
CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    icon VARCHAR(50),
    level INT
);

-- Struktur Tabel Projects
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    description TEXT,
    tech VARCHAR(255),
    icon VARCHAR(50),
    image VARCHAR(255),
    link_demo VARCHAR(255),
    link_github VARCHAR(255)
);

-- Struktur Tabel Experience
CREATE TABLE experience (
    id INT AUTO_INCREMENT PRIMARY KEY,
    year VARCHAR(50),
    title VARCHAR(100),
    company VARCHAR(100),
    description TEXT,
    skills VARCHAR(255)
);

-- Struktur Tabel Certificates
CREATE TABLE certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    issuer VARCHAR(100),
    description TEXT,
    date VARCHAR(50),
    badge VARCHAR(50),
    icon VARCHAR(50)
);

-- Struktur Tabel Contact
CREATE TABLE contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    whatsapp VARCHAR(50),
    email VARCHAR(100),
    github VARCHAR(100),
    stackoverflow VARCHAR(100),
    codepen VARCHAR(100),
    instagram VARCHAR(100)
);
