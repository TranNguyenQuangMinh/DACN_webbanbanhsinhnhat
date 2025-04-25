<?php
session_start(); // Bắt đầu session
include 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Cửa hàng bánh sinh nhật</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<header>
        <h1>Pmoments</h1>
        <nav>
            <a href="index.php">Trang chủ</a>
            <a href="product.php">Sản phẩm</a>
            <a href="cart.php">
                <i class="fas fa-shopping-cart"></i>
            </a>
            <a href="contact.php">Liên hệ</a>
   
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php">Đăng xuất</a> <!-- Hiển thị khi đăng nhập -->
    <?php else: ?>
        <a href="login.php">Đăng nhập/Đăng ký</a> <!-- Hiển thị khi chưa đăng nhập -->
    <?php endif; ?>
        </nav>
    </header>
    <main>
    <h2>Trân trọng từng khoảnh khắc, luôn đồng hành cùng khách hàng</h2>
        <!-- Hero Section với ảnh decor -->
        <section class="hero-section">
            <div class="container">
                <img src="images/decor.jpg" alt="Trang trí cửa hàng" class="hero-image">
            </div>
        </section>

        <!-- Words to Say Section -->
        <section class="words-to-say">
            <div class="container">
                <div class="words-content">
                    <div class="logo">
                        <img src="images/logo.jpg" alt="P Moments Logo" class="logo-image">
                    </div>
                    <div class="message">
                        <p>At P moments, we employ traditional baking methods to create not only tasty but also healthy products. All the ingredients are carefully selected to reserve flavor and texture of each type of bread. We say no to all additives and preservatives.</p>
                        
                        <p>P Moments displays our concept of a green and eco-friendly bakery store. This peaceful corner is where clients can enjoy the finest cakes developed from our R&D kitchen. Or they can indulge in flavorful beverages in a soul-nourishing atmosphere with trees, books and piano melodies.</p>
                        
                        <p>P Moment is created with our sincerest hearts in order to see clients leaving our store with happy smiles on their face.</p>
                    </div>
                </div>
            </div>
        </section>



        <!-- Concept Section -->
        <section class="concept-section">
            <h2 class="section-title">PMOMENTS CONCEPT</h2>
            <h3 class="section-subtitle">EXPERIENCE ANOTHER P MOMENTS</h3>
            
            <div class="concept-grid">
                <div class="concept-item">
                    <img src="images/book.png" alt="Reading a Book">
                    <p>READING A BOOK</p>
                </div>
                <div class="concept-item">
                    <img src="images/tree.png" alt="Planting a Tree">
                    <p>PLANTING A TREE</p>
                </div>
                <div class="concept-item">
                    <img src="images/home.png" alt="Loving Family">
                    <p>LOVING FAMILY</p>
                </div>
                <div class="concept-item">
                    <img src="images/earth.png" alt="Protecting the Earth">
                    <p>PROTECTING THE EARTH</p>
                </div>
                <div class="concept-item">
                    <img src="images/recycle.png" alt="Recovering Resources">
                    <p>RECOVERING RESOURCES</p>
                </div>
            </div>
        </section>

        <!-- Partners Section -->
        <section class="partners-section">
            <h2 class="section-title">OUR PARTNERS</h2>
            <div class="partners-grid">
                <img src="images/rmit.png" alt="RMIT University">
                <img src="images/splus.png" alt="S Plus Coffee">
                <img src="images/harley.png" alt="Harley Davidson">
                <img src="images/nestle.png" alt="Nestle">
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact-section">
            <div class="contact-grid">
                <div class="contact-info">
                    <h3>CONTACT</h3>
                    <p>Phone: 0356088824</p>
                    <p>Email: pmoments.ns@gmail.com</p>
                    <p>Address: 109/29 Nguyen Son - Long Bien - Ha Noi</p>
                    <p>Pmoments</p>
                </div>
                <div class="follow-us">
                    <h3>FOLLOW US</h3>
                    <div class="social-icons">
                        <a href="#"><img src="images/icon-facebook.png" alt="Facebook"></a>
                        <a href="#"><img src="images/icon-instagram.png" alt="Instagram"></a>
                    </div>
                </div>
                <div class="map">
                    <h3>PMOMENTS ON MAP</h3>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.4737883168486!2d105.8753833!3d21.0466323!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135a9a424804f39%3A0xf12345c4ba1a4cda!2sP%20Moments%20Long%20Bi%C3%AAn!5e0!3m2!1svi!2s!4v1644387252242!5m2!1svi!2s" 
                            width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Cửa hàng Bánh Sinh Nhật</p>
    </footer>
</body>
</html>