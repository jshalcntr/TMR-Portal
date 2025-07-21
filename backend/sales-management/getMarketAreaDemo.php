<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require('../dbconn.php');

    if (!isset($conn) || !$conn instanceof mysqli) {
        throw new Exception('MySQLi connection is not properly initialized.');
    }

    $pma_municipalities = [
        'angat',
        'bocaue',
        'balagtas',
        'bustos',
        'bulakan',
        'baliuag',
        'calumpit',
        'dona remedios trinidad',
        'guiguinto',
        'hagonoy',
        'marilao',
        'malolos',
        'meycauayan',
        'norzagaray',
        'obando',
        'plaridel',
        'pandi',
        'paombong',
        'pulilan',
        'santa maria',
        'san ildefonso',
        'san rafael',
        'san miguel',
        'san jose del monte'
    ];

    $market_area_data = [
        'PMA' => 0,
        'OPMA' => 0
    ];

    $query = "SELECT province, municipality, COUNT(*) as count 
              FROM sales_customers_tbl 
              GROUP BY province, municipality";

    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $municipality = strtolower(trim($row['municipality']));
            $province = strtolower(trim($row['province']));

            if (in_array($municipality, $pma_municipalities) && $province === 'bulacan') {
                $market_area_data['PMA'] += (int)$row['count'];
            } else {
                $market_area_data['OPMA'] += (int)$row['count'];
            }
        }
        $result->free();
    } else {
        throw new Exception('Query execution failed: ' . $conn->error);
    }

    echo json_encode([
        'status' => 'success',
        'market_area_counts' => $market_area_data
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

if (isset($conn)) {
    $conn->close();
}
