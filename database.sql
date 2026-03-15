-- NexusCore Database Schema
-- Use this to recreate the database environment

CREATE DATABASE IF NOT EXISTS nexus_core;
USE nexus_core;

DROP TABLE IF EXISTS patients;

CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    status ENUM('active', 'discharged', 'pending') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Initial Seed Data for Testing
INSERT INTO patients (name, status) VALUES 
('John Doe', 'active'), 
('Jane Smith', 'pending'),
('Robert Brown', 'discharged');