<?php
// Lista de regalos
$gifts = [
    "Book", "Toy", "Gadget", "Video Game", "Headphones",
    "Smartphone", "Laptop", "Watch", "Shoes", "Wallet",
    "Headset", "Camera", "Drone", "Smart Watch", "Bluetooth Speaker"
];

// Obtener los índices de los regalos desde los parámetros GET
$giftIndices = isset($_GET['gift']) ? $_GET['gift'] : '';
$selectedGifts = [];
$giftCode = null;

if (!empty($giftIndices)) {
    // Convertir los índices en un array
    $indicesArray = explode(',', $giftIndices);
    $indicesArray = array_filter($indicesArray, 'is_numeric');

    // Pasar los índices al script de Python
    $command = escapeshellcmd("py gift_selector.py  " . implode(' ', $indicesArray));
    $output = shell_exec($command);

    // Procesar la respuesta de Python
    if ($output) {
        $response = json_decode($output, true);
        if (isset($response['selectedGifts']) && isset($response['giftCode'])) {
            $selectedGifts = $response['selectedGifts'];
            $giftCode = $response['giftCode'];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Selector</title>
</head>
<body>
    <h1>Available Gifts:</h1>
    <ul>
        <?php foreach ($gifts as $index => $gift): ?>
            <li><?php echo "$index: $gift"; ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Enter gift indices:</h2>
    <form method="GET" action="">
        <input type="text" name="gift" placeholder="Enter indices (e.g., 0,1)" value="<?php echo htmlspecialchars($giftIndices); ?>">
        <button type="submit">Submit</button>
    </form>

    <?php if (!empty($selectedGifts)): ?>
        <h2>Selected Gifts:</h2>
        <p><?php echo implode(', ', $selectedGifts); ?></p>
        <h2>Unique Gift Code:</h2>
        <p><?php echo $giftCode; ?></p>
    <?php endif; ?>
</body>
</html>
