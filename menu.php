<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Menu</title>
</head>
<body>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve data from POST request
        $orderPrice = (float)$_POST['order'];
        $quantity = (int)$_POST['quantity'];
        $cashPaid = (float)$_POST['cash'];
        $totalPrice = $orderPrice * $quantity;

        // Check if payment is sufficient
        if ($cashPaid < $totalPrice) {
            echo "<script>alert('Insufficient payment! Please enter the correct amount.'); window.history.back();</script>";
        } else {
            // Calculate change
            $change = $cashPaid - $totalPrice;

            // Display receipt using PHP
            echo "<div id='receipt'>
                    <h2>RECEIPT</h2>
                    <p>Total Price: $$totalPrice</p>
                    <p>You Paid: $$cashPaid</p>
                    <p>CHANGE: $$change</p>
                    <p>Date and Time: " . date('m/d/Y h:i:s a', time()) . "</p>
                  </div>";

            // If there's no change, show a "no change" message
            if ($change == 0) {
                echo "<p>No change to return.</p>";
            }

            // Add a print button to print the receipt
            echo "<button onclick='window.print()'>Print Receipt</button>";
        }
    } else {
        // Show the form if the request method is not POST
?>
    <h1>Menu</h1>
    <table border="1">
        <tr>
            <th>Order</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>Burger</td>
            <td>50</td>
        </tr>
        <tr>
            <td>Fries</td>
            <td>75</td>
        </tr>
        <tr>
            <td>Steak</td>
            <td>150</td>
        </tr>
    </table>

    <!-- The form for selecting orders -->
    <form action="" method="POST">
        <label for="order">Select an order:</label>
        <select id="order" name="order">
            <option value="50">Burger</option>
            <option value="75">Fries</option>
            <option value="150">Steak</option>
        </select>
        
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" value="1">

        <label for="cash">Cash:</label>
        <input type="number" id="cash" name="cash" min="0" step="any">

        <button type="submit">Submit</button>
    </form>

<?php
    }
?>

</body>
</html>
