<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discriminant of a Quadratic Equation</title>
</head>
<body>
    <h1>Discriminant of a quadratic equation</h1>

    <?php
    $discriminant = null; // To store the discriminant value, if calculated

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the values from the form
        $a = $_POST['a'];
        $b = $_POST['b'];
        $c = $_POST['c'];

        // Calculate the discriminant
        $discriminant = ($b * $b) - (4 * $a * $c);
    }
    ?>

    <!-- Form for inputting the quadratic coefficients -->
    <form action="" method="post">
        <label for="a">A</label>
        <input type="number" id="a" name="a" required value="<?php echo isset($a) ? $a : ''; ?>"><br><br>

        <label for="b">B</label>
        <input type="number" id="b" name="b" required value="<?php echo isset($b) ? $b : ''; ?>"><br><br>

        <label for="c">C</label>
        <input type="number" id="c" name="c" required value="<?php echo isset($c) ? $c : ''; ?>"><br><br>

        <input type="submit" value="Submit">
    </form>

    <!-- Display the discriminant result -->
    <?php
    if ($discriminant !== null) {
        echo "<h2>The Discriminant is: $discriminant</h2>";

        // Explain the nature of the roots based on the discriminant
        if ($discriminant > 0) {
            echo "<p>The equation has two real and distinct roots.</p>";
        } elseif ($discriminant == 0) {
            echo "<p>The equation has one real and repeated root.</p>";
        } else {
            echo "<p>The equation has two complex roots.</p>";
        }
    }
    ?>
</body>
</html>
