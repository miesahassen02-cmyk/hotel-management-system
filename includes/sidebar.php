<?php
$role = normalizeRole($_SESSION['role'] ?? '');
$currentPage = basename($_SERVER['PHP_SELF']);

function navItem($url, $label, $currentPage) {
    $active = basename($url) === $currentPage ? ' active' : '';
    return "<a href=\"" . SITE_URL . "$url\" class=\"list-group-item list-group-item-action$active\">$label</a>";
}
?>
<div class="col-md-3 mb-4">
    <div class="list-group">
        <?php echo navItem('index.php', 'Home', $currentPage); ?>
        <?php echo navItem($role . '/dashboard.php', 'Dashboard', $currentPage); ?>
        <?php if ($role === 'admin'): ?>
            <?php echo navItem('admin/manage_users.php', 'Manage Users', $currentPage); ?>
            <?php echo navItem('admin/manage_rooms.php', 'Manage Rooms', $currentPage); ?>
            <?php echo navItem('admin/manage_prices.php', 'Manage Prices', $currentPage); ?>
            <?php echo navItem('admin/reports.php', 'Reports', $currentPage); ?>
            <?php echo navItem('admin/settings.php', 'Settings', $currentPage); ?>
        <?php elseif ($role === 'receptionist'): ?>
            <?php echo navItem('receptionist/booking.php', 'Booking / Reservation', $currentPage); ?>
            <?php echo navItem('receptionist/checkin.php', 'Check-in', $currentPage); ?>
            <?php echo navItem('receptionist/checkout.php', 'Check-out', $currentPage); ?>
            <?php echo navItem('receptionist/customers.php', 'Customer Management', $currentPage); ?>
            <?php echo navItem('receptionist/room_availability.php', 'Room Availability', $currentPage); ?>
        <?php elseif ($role === 'customer'): ?>
            <?php echo navItem('customer/search_rooms.php', 'Search Rooms', $currentPage); ?>
            <?php echo navItem('customer/book_room.php', 'Book Room', $currentPage); ?>
            <?php echo navItem('customer/booking_history.php', 'Booking History', $currentPage); ?>
            <?php echo navItem('customer/payments.php', 'Payments', $currentPage); ?>
            <?php echo navItem('customer/profile.php', 'Profile', $currentPage); ?>
        <?php elseif ($role === 'manager'): ?>
            <?php echo navItem('manager/reports.php', 'Reports', $currentPage); ?>
            <?php echo navItem('manager/occupancy.php', 'Occupancy', $currentPage); ?>
            <?php echo navItem('manager/staff_monitor.php', 'Staff Monitor', $currentPage); ?>
        <?php elseif ($role === 'housekeeping'): ?>
            <?php echo navItem('housekeeping/room_status.php', 'Room Status', $currentPage); ?>
            <?php echo navItem('housekeeping/cleaning_schedule.php', 'Cleaning Schedule', $currentPage); ?>
            <?php echo navItem('housekeeping/maintenance_request.php', 'Maintenance Request', $currentPage); ?>
        <?php elseif ($role === 'accountant'): ?>
            <?php echo navItem('accountant/invoices.php', 'Invoices', $currentPage); ?>
            <?php echo navItem('accountant/payments.php', 'Payments', $currentPage); ?>
            <?php echo navItem('accountant/financial_reports.php', 'Financial Reports', $currentPage); ?>
            <?php echo navItem('accountant/expenses.php', 'Expenses', $currentPage); ?>
        <?php endif; ?>
    </div>
</div>
