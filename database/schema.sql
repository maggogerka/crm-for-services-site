CREATE DATABASE IF NOT EXISTS crm_for_services
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE crm_for_services;

CREATE TABLE IF NOT EXISTS leads (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(80) NOT NULL,
    direction VARCHAR(120) NOT NULL,
    contact VARCHAR(120) NOT NULL,
    work_format ENUM('solo', 'team') NOT NULL,
    preferred_contact ENUM('telegram', 'phone') NOT NULL,
    client_comment TEXT NULL,
    admin_comment TEXT NULL,
    status ENUM('new', 'contacted', 'demo_sent', 'demo_completed', 'negotiation', 'prepaid', 'setup', 'active', 'rejected') NOT NULL DEFAULT 'new',
    consented_at DATETIME NOT NULL,
    ip_hash CHAR(64) NOT NULL,
    user_agent VARCHAR(255) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_leads_status_created (status, created_at),
    INDEX idx_leads_ip_created (ip_hash, created_at),
    INDEX idx_leads_contact (contact)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
