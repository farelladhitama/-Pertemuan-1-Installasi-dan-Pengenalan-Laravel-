<?php
session_start();

// Daftar produk
$products = [
    ["id" => 1, "name" => "Laptop", "price" => 5000000],
    ["id" => 2, "name" => "Smartphone", "price" => 3000000],
    ["id" => 3, "name" => "Headphone", "price" => 500000],
];

// Sistem Routing
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Tambahkan produk ke keranjang
if (isset($_GET['add'])) {
    $_SESSION['cart'][] = $_GET['add'];
}

// Reset keranjang setelah checkout
if ($page == "checkout") {
    $_SESSION['cart'] = [];
}

// Header
echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Sederhana</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; }
        nav a { margin-right: 15px; text-decoration: none; color: blue; }
        h1 { color: #333; }
        ul { list-style-type: square; }
    </style>
</head>
<body>
    <nav>
        <a href="index.php?page=home">Home</a>
        <a href="index.php?page=products">Produk</a>
        <a href="index.php?page=cart">Keranjang</a>
        <a href="index.php?page=checkout">Checkout</a>
    </nav>
    <hr>';

// Halaman
if ($page == "home") {
    echo "<h1>Selamat Datang di E-Commerce Sederhana</h1>";
    echo "<p>Temukan berbagai produk terbaik!</p>";

} elseif ($page == "products") {
    echo "<h1>Daftar Produk</h1><ul>";
    foreach ($products as $product) {
        echo "<li><a href='index.php?page=product-detail&id={$product['id']}'>{$product['name']} - Rp" . number_format($product['price'], 0, ',', '.') . "</a></li>";
    }
    echo "</ul>";

} elseif ($page == "product-detail") {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $product = null;
    foreach ($products as $p) {
        if ($p['id'] == $id) {
            $product = $p;
            break;
        }
    }
    if ($product) {
        echo "<h1>{$product['name']}</h1>";
        echo "<p>Harga: Rp" . number_format($product['price'], 0, ',', '.') . "</p>";
        echo "<a href='index.php?page=cart&add={$product['id']}'>Tambah ke Keranjang</a>";
    } else {
        echo "<p>Produk tidak ditemukan.</p>";
    }

} elseif ($page == "cart") {
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $cartItems = array_count_values($_SESSION['cart']);
    
    echo "<h1>Keranjang Belanja</h1><ul>";
    foreach ($cartItems as $id => $quantity) {
        foreach ($products as $product) {
            if ($product['id'] == $id) {
                echo "<li>{$product['name']} (x{$quantity}) - Rp" . number_format($product['price'] * $quantity, 0, ',', '.') . "</li>";
            }
        }
    }
    echo "</ul><a href='index.php?page=checkout'>Checkout</a>";

} elseif ($page == "checkout") {
    echo "<h1>Checkout Berhasil!</h1>";
    echo "<p>Terima kasih telah berbelanja.</p>";
    echo "<a href='index.php?page=home'>Kembali ke Home</a>";

} else {
    echo "<h1>404 - Halaman tidak ditemukan.</h1>";
}

// Footer
echo '<hr>
    <footer>
        <p>© 2025 E-Commerce Sederhana</p>
    </footer>
</body>
</html>';
?>
