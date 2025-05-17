CREATE TABLE IF NOT EXISTS otp_verification (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idpelanggan INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    otp_code VARCHAR(6) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expired_at TIMESTAMP,
    is_verified TINYINT(1) DEFAULT 0,
    FOREIGN KEY (idpelanggan) REFERENCES tablepelanggan(idpelanggan)
);

ALTER TABLE tablepelanggan ADD COLUMN is_verified TINYINT(1) DEFAULT 0;