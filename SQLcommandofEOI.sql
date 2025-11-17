CREATE TABLE eoi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job VARCHAR(100) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    birth DATE NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    address VARCHAR(255) NOT NULL,
    suburb VARCHAR(100) NOT NULL,
    state VARCHAR(50) NOT NULL,
    postcode VARCHAR(10) NOT NULL,
    phonenumber1 VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    
    university VARCHAR(150),
    degree VARCHAR(100),
    year INT,
    skills TEXT,
    description TEXT,
    
    company1 VARCHAR(150),
    position1 VARCHAR(100),
    emdate1 DATE,
    
    reference VARCHAR(100),
    relationship VARCHAR(50),
    phonenumber2 VARCHAR(20),
    responsibility TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
