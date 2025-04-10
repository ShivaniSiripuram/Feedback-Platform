<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
$name = $_SESSION['name'];
$products = ['Smartphone', 'Smartwatch', 'Bluetooth Speaker'];
$product_images = [
    'Smartphone' => 'elegant-smartphone-composition.jpg',
    'Smartwatch' => '3725815.jpg',
    'Bluetooth Speaker' => 'composition-smart-speaker-table.jpg'
];
$categories = ['Product Features', 'Product Pricing', 'Product Usability'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Feedback</title>
    <style>
        body {
            font-family: Arial;
            margin: 20px;
        }
        h2 {
            text-align: center;
        }
        .container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .product-block {
            flex: 1 1 300px;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            max-width: 350px;
        }
        .product-block img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        select, textarea, input[type=number] {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 12px;
            border-radius: 4px;
            border: 1px solid #aaa;
        }
        button {
            padding: 10px 20px;
            cursor: pointer;
        }
        .feedback-section {
            margin-top: 20px;
        }
        .feedback-entry {
            margin-bottom: 10px;
            padding-left: 10px;
            border-left: 3px solid #ccc;
        }
        .stars {
            color: orange;
        }
        h3 {
            margin-top: 20px;
            color: #444;
        }
        .category-title {
            margin-top: 10px;
            font-weight: bold;
            text-decoration: underline;
        }
        .star-rating {
    direction: rtl;
    display: flex;
    justify-content: flex-start;
}
.star-rating input[type="radio"] {
    display: none;
}
.star-rating label {
    font-size: 24px;
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s;
}
.star-rating input[type="radio"]:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: orange;
}

    </style>
</head>
<body>

<h2>Welcome, <?= htmlspecialchars($name) ?>!</h2>
<p style="text-align:center;">Submit your feedback</p>

<?php
$conn = new mysqli("localhost", "root", "", "feedback_platform");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<div class="container">
<?php foreach ($products as $product): ?>
    <div class="product-block">
        <img src="<?= htmlspecialchars($product_images[$product]) ?>" alt="<?= htmlspecialchars($product) ?>">

        <form action="submit_feedback.php" method="post">
            <input type="hidden" name="product_name" value="<?= htmlspecialchars($product) ?>">
            
            <label>Product:</label>
            <input type="text" value="<?= htmlspecialchars($product) ?>" disabled>

            <label for="category">Feedback Category:</label>
            <select name="category" required>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="rating">Rating:</label>
<div class="star-rating">
    <?php for ($i = 5; $i >= 1; $i--): ?>
        <input type="radio" id="star<?= $i ?>_<?= $product ?>" name="rating" value="<?= $i ?>" required>
        <label for="star<?= $i ?>_<?= $product ?>">★</label>
    <?php endfor; ?>
</div>

            <label for="comment">Your Comments:</label>
            <textarea name="comment" rows="3" required></textarea>

            <button type="submit">Submit Feedback</button>
        </form>

        <div class="feedback-section">
            <h3>Feedback</h3>
            <?php foreach ($categories as $cat): ?>
                <div class="category-title"><?= htmlspecialchars($cat) ?>:</div>
                <?php
                $stmt = $conn->prepare("SELECT user_name, rating, comment FROM product_feedback WHERE product_name = ? AND category = ? ORDER BY submitted_at DESC");
                $stmt->bind_param("ss", $product, $cat);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 0) {
                    echo "<p style='color: #888; margin-left:10px;'>No feedback yet.</p>";
                } else {
                    while ($row = $result->fetch_assoc()) {
                        $stars = str_repeat("★", $row['rating']) . str_repeat("☆", 5 - $row['rating']);
                        echo "<div class='feedback-entry'>";
                        echo "<strong>" . htmlspecialchars($row['user_name']) . "</strong><br>";
                        echo "<span class='stars'>{$stars}</span><br>";
                        echo htmlspecialchars($row['comment']);
                        echo "</div>";
                    }
                }
                $stmt->close();
                ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?php $conn->close(); ?>

<p style="text-align:center;"><a href="logout.php">Logout</a></p>

</body>
</html>
