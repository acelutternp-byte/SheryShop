<?php
// Save contact form messages before displaying the page.
session_start();
require_once __DIR__ . '/includes/database.php';

// Try to prepare the database on every visit, so it appears in phpMyAdmin.
try {
    $database = databaseConnection();
} catch (PDOException $error) {
    $database = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $subject === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['contact_feedback'] = 'Please fill in every field with a valid email address.';
    } elseif ($database === null) {
        $_SESSION['contact_feedback'] = 'Could not connect to MySQL. Start MySQL in XAMPP and refresh the page.';
    } else {
        try {
            $statement = $database->prepare(
                'INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)'
            );
            $statement->execute([$name, $email, $subject, $message]);
            $_SESSION['contact_feedback'] = 'Thank you! Your message has been saved.';
        } catch (PDOException $error) {
            $_SESSION['contact_feedback'] = 'Could not save your message. Start MySQL in XAMPP and try again.';
        }
    }

    header('Location: index.php#contact');
    exit;
}

// Show a one-time message after the form is submitted.
$contactFeedback = $_SESSION['contact_feedback'] ?? '';
unset($_SESSION['contact_feedback']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f8f5ef">
    <title>SheryShop | Handmade Crochet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <!-- Sidebar navigation shared by all the page sections. -->
    <button class="sidebar-toggle btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#siteSidebar" aria-controls="siteSidebar" aria-label="Open navigation">
        <span class="menu-mark" aria-hidden="true"><i></i><i></i><i></i></span>
    </button>
    <aside class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="siteSidebar" aria-labelledby="sidebarTitle">
        <div class="offcanvas-header sidebar-mobile-header">
            <h2 class="offcanvas-title" id="sidebarTitle">Menu</h2>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#siteSidebar" aria-label="Close navigation"></button>
        </div>
        <div class="sidebar-inner">
            <a class="brand" href="#dashboard" aria-label="SheryShop dashboard">
                <img src="https://clipartcraft.com/images/transparent-images-cute-7.png" alt="SheryShop yarn mascot">
                <span>Shery<span class="brand-accent">Shop</span><small>MADE WITH A LITTLE LOVE</small></span>
            </a>
            <p class="sidebar-label">CROCHET SHOP</p>
            <nav class="nav flex-column sidebar-nav" aria-label="Main navigation">
                <a class="nav-link active" href="#dashboard"><span class="nav-glyph">⌂</span>Dashboard</a>
                <a class="nav-link" href="#home"><span class="nav-glyph">✳</span>Home</a>
                <a class="nav-link" href="#services"><span class="nav-glyph">◌</span>Services</a>
                <a class="nav-link" href="#products"><span class="nav-glyph">▦</span>Products</a>
                <a class="nav-link" href="#about"><span class="nav-glyph">♡</span>About us</a>
                <a class="nav-link" href="#contact"><span class="nav-glyph">↗</span>Contact us</a>
            </nav>
            <div class="sidebar-note"><span class="note-stitch" aria-hidden="true">✿</span><p>Small stitches.<br><strong>Big heart.</strong></p><span>Thoughtfully made by hand</span></div>
            <div class="sidebar-footer">© <?= date('Y') ?> SheryShop</div>
        </div>
    </aside>

    <!-- Main dashboard and sections are kept in separate, easy-to-find files. -->
    <main class="page-content">
        <?php include __DIR__ . '/pages/home.php'; ?>
        <?php include __DIR__ . '/pages/services.php'; ?>
        <?php include __DIR__ . '/pages/products.php'; ?>
        <?php include __DIR__ . '/pages/aboutUs.php'; ?>
        <?php include __DIR__ . '/pages/contactUs.php'; ?>
        <!-- Shared page footer. -->
        <footer class="page-footer"><a href="#dashboard">SheryShop <span>✿</span></a><span>HANDMADE WITH CARE, ALWAYS.</span><a href="#dashboard" class="back-top">Back to top ↑</a></footer>
    </main>

    <!-- Bootstrap powers the mobile sidebar. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Close the mobile menu, then scroll to the selected section.
        const sidebar = document.getElementById('siteSidebar');
        sidebar.addEventListener('click', function (event) {
            const link = event.target.closest('.sidebar-nav a');
            if (!link || window.innerWidth >= 992) return;

            event.preventDefault();
            const section = link.getAttribute('href');
            sidebar.addEventListener('hidden.bs.offcanvas', function () {
                window.location.hash = section;
            }, { once: true });
            bootstrap.Offcanvas.getOrCreateInstance(sidebar).hide();
        });
    </script>
</body>
</html>