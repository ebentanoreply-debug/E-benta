<?php
/**
 * Generate individual HTML files for each table
 * User can open in browser and export to images/PDF
 */

$output_dir = __DIR__ . '/table_images';
if (!is_dir($output_dir)) {
    mkdir($output_dir, 0755, true);
}

$tables = [
    'Users' => [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Auto-incrementing unique identifier'],
        ['', 'name', 'VARCHAR(255)', "User's full name"],
        ['UNIQUE', 'email', 'VARCHAR(255)', 'Email address for login'],
        ['', 'role', "ENUM('seller','buyer','admin')", 'User role. Default: seller'],
        ['', 'password', 'VARCHAR(255)', 'Hashed password'],
        ['', 'business_name', 'VARCHAR(255)', 'Business name (nullable)'],
        ['', 'is_verified', 'BOOLEAN', 'Verification status. Default: false'],
        ['', 'total_impact_score', 'DECIMAL(10,2)', 'Environmental impact score'],
        ['', 'items_processed', 'INT', 'Number of items processed'],
        ['', 'total_weight_diverted', 'DECIMAL(10,2)', 'Weight diverted from landfill (kg)'],
        ['', 'total_co2_saved', 'DECIMAL(10,2)', 'CO2 saved (kg)'],
        ['', 'created_at', 'TIMESTAMP', 'Account creation timestamp'],
        ['', 'updated_at', 'TIMESTAMP', 'Last update timestamp'],
    ],
    'Addresses' => [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'user_id', 'BIGINT', 'User who owns the address'],
        ['', 'label', 'VARCHAR(255)', 'Address label: Home, Office'],
        ['', 'address_line_1', 'VARCHAR(255)', 'Street address'],
        ['', 'city', 'VARCHAR(255)', 'City name'],
        ['', 'postal_code', 'VARCHAR(20)', 'Postal/ZIP code'],
        ['', 'country', 'VARCHAR(255)', 'Default: Philippines'],
        ['', 'is_primary', 'BOOLEAN', 'Default address. Default: false'],
        ['', 'type', "ENUM('pickup','dropoff','both')", 'Address type'],
        ['', 'created_at', 'TIMESTAMP', 'Creation timestamp'],
    ],
    'Listings' => [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'user_id', 'BIGINT', "Seller's user ID"],
        ['', 'category', 'VARCHAR(255)', 'Item category'],
        ['', 'condition', "ENUM('working','minor_damage'...)", 'Item condition'],
        ['', 'description', 'TEXT', 'Item description'],
        ['', 'status', "ENUM('pending','available'...)", 'Listing status'],
        ['FK', 'matched_buyer_id', 'BIGINT', 'Matched buyer (nullable)'],
        ['', 'carbon_footprint', 'DECIMAL(10,2)', 'Carbon footprint'],
        ['SOFT DEL', 'deleted_at', 'TIMESTAMP', 'Soft delete'],
        ['', 'created_at', 'TIMESTAMP', 'Creation timestamp'],
    ],
    'Offers' => [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'listing_id', 'BIGINT', 'Listing ID'],
        ['FK', 'buyer_id', 'BIGINT', "Buyer's user ID"],
        ['', 'bid_amount', 'DECIMAL(10,2)', 'Offered bid amount'],
        ['', 'proposed_method', "ENUM('repair','harvest'...)", 'Processing method'],
        ['', 'status', "ENUM('pending','accepted'...)", 'Offer status'],
        ['', 'responded_at', 'TIMESTAMP', 'Seller response time'],
        ['SOFT DEL', 'deleted_at', 'TIMESTAMP', 'Soft delete'],
        ['', 'created_at', 'TIMESTAMP', 'Creation timestamp'],
    ],
    'Reviews' => [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'reviewer_id', 'BIGINT', 'User leaving review'],
        ['FK', 'reviewee_id', 'BIGINT', 'User being reviewed'],
        ['FK', 'offer_id', 'BIGINT', 'Associated transaction'],
        ['', 'rating', 'INT', '1-5 star rating'],
        ['', 'title', 'VARCHAR(255)', 'Review title'],
        ['', 'is_verified', 'BOOLEAN', 'Verified purchase'],
        ['', 'created_at', 'TIMESTAMP', 'Creation timestamp'],
    ],
    'Impact_Logs' => [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'listing_id', 'BIGINT', 'Listing ID'],
        ['FK', 'seller_id', 'BIGINT', "Seller's user ID"],
        ['FK', 'buyer_id', 'BIGINT', "Buyer's user ID"],
        ['', 'device_category', 'VARCHAR(255)', 'Device category'],
        ['', 'device_weight', 'DECIMAL(5,2)', 'Device weight in kg'],
        ['', 'processing_method', "ENUM('repair','harvest'...)", 'Processing method'],
        ['', 'co2_saved', 'DECIMAL(10,2)', 'CO2 saved'],
        ['', 'landfill_diverted_weight', 'DECIMAL(10,2)', 'Landfill diverted'],
        ['UNIQUE', 'certificate_token', 'VARCHAR(255)', 'Certificate token'],
    ],
    'Device_Types' => [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['UNIQUE', 'name', 'VARCHAR(255)', 'Device type'],
        ['', 'description', 'TEXT', 'Description'],
        ['', 'icon', 'VARCHAR(255)', 'Font Awesome icon'],
    ],
    'Device_Brands' => [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['UNIQUE', 'name', 'VARCHAR(255)', 'Brand name'],
        ['', 'description', 'TEXT', 'Description'],
        ['', 'logo_url', 'VARCHAR(255)', 'Logo URL'],
    ],
    'Device_Models' => [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'device_type_id', 'BIGINT', 'Device type ID'],
        ['FK', 'device_brand_id', 'BIGINT', 'Device brand ID'],
        ['UNIQUE', 'model_name', 'VARCHAR(255)', 'Model name'],
    ],
    'Notifications' => [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'user_id', 'BIGINT', 'Recipient user ID'],
        ['', 'type', 'VARCHAR(255)', 'Type: offer_update'],
        ['', 'title', 'VARCHAR(255)', 'Notification title'],
        ['', 'message', 'TEXT', 'Message content'],
        ['', 'is_read', 'BOOLEAN', 'Read status'],
    ],
    'Email_Verifications' => [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'user_id', 'BIGINT', 'User being verified'],
        ['', 'code', 'VARCHAR(6)', '6-digit code'],
        ['', 'expires_at', 'TIMESTAMP', 'Expiration time'],
        ['', 'used', 'BOOLEAN', 'Code used status'],
    ],
    'Audit_Logs' => [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'user_id', 'BIGINT', 'User who performed action'],
        ['', 'action', 'VARCHAR(255)', 'Action type'],
        ['', 'model_type', 'VARCHAR(255)', 'Model affected'],
        ['', 'description', 'TEXT', 'Description'],
    ],
    'Reports' => [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'user_id', 'BIGINT', 'Reporter user ID'],
        ['', 'reportable_type', 'VARCHAR(255)', 'Type being reported'],
        ['', 'reason', 'ENUM (11 values)', 'Reason for report'],
        ['', 'status', "ENUM('pending','under_review'...)", 'Report status'],
    ],
];

function generateHTML($table_name, $rows) {
    $cells = '';
    foreach ($rows as $i => $row) {
        if ($i === 0) {
            $cells .= '<thead><tr>';
            foreach ($row as $cell) {
                $cells .= '<th>' . htmlspecialchars($cell) . '</th>';
            }
            $cells .= '</tr></thead><tbody>';
        } else {
            $cells .= '<tr>';
            foreach ($row as $cell) {
                $cells .= '<td>' . htmlspecialchars($cell) . '</td>';
            }
            $cells .= '</tr>';
        }
    }
    $cells .= '</tbody>';
    
    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$table_name Table</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 3px solid #0066cc;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #0066cc;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 13px;
            border: 1px solid #004499;
        }
        td {
            padding: 10px 12px;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        tr:hover {
            background: #f0f0f0;
        }
        @media print {
            body { background: white; }
            .container { box-shadow: none; }
            h1 { border-bottom: 2px solid #0066cc; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>$table_name Table</h1>
        <table>
            $cells
        </table>
    </div>
</body>
</html>
HTML;
}

echo "📄 Generating individual HTML files for each table...\n\n";

foreach ($tables as $table_name => $rows) {
    $filename = $output_dir . '/' . str_replace(' ', '_', $table_name) . '.html';
    $html_content = generateHTML($table_name, $rows);
    
    if (file_put_contents($filename, $html_content)) {
        echo "✅ {$table_name}.html created\n";
    } else {
        echo "❌ Error creating {$table_name}.html\n";
    }
}

echo "\n";
echo "📁 All files saved to: table_images/\n";
echo "📖 Access at: http://localhost/E-Benta/table_images/\n\n";
echo "💡 To export as image:\n";
echo "   1. Open table: http://localhost/E-Benta/table_images/TableName.html\n";
echo "   2. Press Ctrl+P (Print dialog)\n";
echo "   3. Save as PDF or use 'Print to Image'\n";
echo "   4. Or Screenshot: Ctrl+PrtScn\n";
?>
