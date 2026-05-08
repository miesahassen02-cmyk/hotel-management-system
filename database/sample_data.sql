-- Sample data for Hotel Management System

INSERT INTO users (username, password, email, role, full_name, phone) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@hms.com', 'admin', 'System Admin', '1234567890'),
('receptionist1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'rec@hms.com', 'receptionist', 'John Receptionist', '1234567891'),
('customer1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cust@hms.com', 'customer', 'Jane Customer', '1234567892'),
('manager1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mgr@hms.com', 'manager', 'Bob Manager', '1234567893'),
('housekeeping1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hk@hms.com', 'housekeeping', 'Alice Housekeeper', '1234567894'),
('accountant1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'acc@hms.com', 'accountant', 'Charlie Accountant', '1234567895');

INSERT INTO rooms (room_number, room_type, price, description) VALUES
('101', 'single', 100.00, 'Single room with basic amenities'),
('102', 'double', 150.00, 'Double room with city view'),
('201', 'suite', 250.00, 'Luxury suite with balcony'),
('202', 'deluxe', 200.00, 'Deluxe room with extra facilities');
