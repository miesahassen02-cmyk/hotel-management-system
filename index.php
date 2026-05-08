<?php
require_once 'includes/auth.php';
if (isLoggedIn()) {
    redirectTo(normalizeRole($_SESSION['role']) . '/dashboard.php');
}
?>
<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero-banner text-center mb-5">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold mb-3">Welcome to <?php echo htmlspecialchars(SITE_NAME); ?></h1>
            <p class="lead mb-4">Experience luxury and comfort in the heart of the city. Your perfect stay awaits.</p>
            <div class="d-flex justify-content-center gap-3">
                <a class="btn btn-primary btn-lg" href="register.php">Book Your Stay</a>
                <a class="btn btn-outline-light btn-lg" href="#rooms">Explore Rooms</a>
            </div>
        </div>
        <div class="col-lg-6">
            <img src="<?php echo SITE_URL; ?>assets/images/photo_2026-05-05_03-32-14.jpg" alt="Hotel Exterior" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: cover;">
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="mb-5">
    <h2 class="text-center mb-4">Why Choose Us?</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">🏨 Luxury Accommodations</h5>
                    <p class="card-text">Spacious rooms with modern amenities and stunning views.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">🍽️ Fine Dining</h5>
                    <p class="card-text">Multiple restaurants offering cuisine from around the world.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">🏊‍♂️ Premium Amenities</h5>
                    <p class="card-text">Swimming pool, fitness center, spa, and 24/7 concierge service.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Room Types Section -->
<section id="rooms" class="mb-5">
    <h2 class="text-center mb-4">Our Room Types</h2>
    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="card h-100">
                <img src="assets/images/photo_5_2026-05-03_22-37-54.jpg" alt="Single Room" class="card-img-top">
                <div class="card-body text-center">
                    <h5 class="card-title">Single Room</h5>
                    <p class="card-text">Perfect for solo travelers seeking comfort and convenience.</p>
                    <p class="text-dark fw-bold">$100/night</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100">
                <img src="assets/images/photo_2026-05-05_03-52-55.jpg" alt="Double Room" class="card-img-top">
                <div class="card-body text-center">
                    <h5 class="card-title">Double Room</h5>
                    <p class="card-text">Ideal for couples with city views and modern furnishings.</p>
                    <p class="text-dark fw-bold">$150/night</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100">
                <img src="assets/images/photo_2026-05-05_03-46-45.jpg" alt="Deluxe Room" class="card-img-top">
                <div class="card-body text-center">
                    <h5 class="card-title">Deluxe Room</h5>
                    <p class="card-text">Enhanced comfort with extra facilities and premium amenities.</p>
                    <p class="text-dark fw-bold">$200/night</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100">
                <img src="assets/images/photo_3_2026-05-03_22-37-54.jpg" alt="Suite" class="card-img-top">
                <div class="card-body text-center">
                    <h5 class="card-title">Suite</h5>
                    <p class="card-text">Luxury suite with balcony and top-tier service.</p>
                    <p class="text-dark fw-bold">$250/night</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="text-center mb-5">
    <a class="btn btn-primary btn-lg me-3" href="login.php">Login</a>
    <a class="btn btn-secondary btn-lg" href="register.php">Register</a>
</div>

<?php include 'includes/footer.php'; ?>
