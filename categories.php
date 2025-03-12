<?php
session_start();
include 'config.php'; // Include your database connection

// Fetch genres from the database
$genres_query = "SELECT genre_name FROM Genres";
$result = $conn->query($genres_query);

$is_logged_in = isset($_SESSION['user_id']);

// Count the total number of items in the cart
$cart_item_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_item_count += $item['quantity'];  // Sum up quantities of all items
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - RowdyBookly</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        <?php include 'css/style.css'; ?>
        .categories-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .category {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 120px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-decoration: none;
            background-color: #f9f9f9;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .category:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .category-icon img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }

        .category p {
            font-size: 16px;
            color: #333;
        }

        .category:hover p {
            color: #0073e6;
        }
    </style>
    <?php include 'navigation-bar.php'; ?>

</head>
<body>
<div class="body0">
    <nav class="breadcrumb">
            <a href="index.php">Home</a>
            <span>&raquo;</span>
            <a href="categories.php"><strong>Categories</strong></a>
        </nav>
    <main class="categories-container">
            <a href="books.php?genre=<?php echo urlencode("All"); ?>" class="category">
                    <span class="category-icon">
                        <img src="icon/everything.png" alt="<?php echo htmlspecialchars('All'); ?>" />
                    </span>
                    <p><?php echo htmlspecialchars('All Book'); ?></p>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php 
                    $genre_name = $row['genre_name'];
                    $icon_name = strtolower(str_replace(' ', '_', $genre_name)) . ".png"; // Generate icon name
                ?>
                <!-- Make category clickable -->
                <a href="books.php?genre=<?php echo urlencode($genre_name); ?>" class="category">
                    <span class="category-icon">
                        <img src="icon/<?php echo htmlspecialchars($icon_name); ?>" alt="<?php echo htmlspecialchars($genre_name); ?>" />
                    </span>
                    <p><?php echo htmlspecialchars($genre_name); ?></p>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No genres found in the database.</p>
        <?php endif; ?>
    </main>
    </div>
    <?php include "cart-overlay.php" ?>
    <footer>
        <p>&copy; 2024 RowdyBookly</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>