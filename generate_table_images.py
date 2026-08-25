#!/usr/bin/env python3
"""
Generate PNG images from E-Benta Data Dictionary tables
Requires: pip install pillow reportlab html2image
"""

import os
from pathlib import Path

# Try to use html2image first, then fall back to a simple method
try:
    from html2image import HtmlImageConverter
    USE_HTML2IMAGE = True
except ImportError:
    USE_HTML2IMAGE = False

# Data for each table
TABLES_DATA = {
    'Users': [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Auto-incrementing unique identifier'],
        ['', 'name', 'VARCHAR(255)', "User's full name"],
        ['UNIQUE', 'email', 'VARCHAR(255)', 'Email address for login'],
        ['', 'role', "ENUM('seller','buyer','admin')", 'User role. Default: seller'],
        ['', 'email_verified_at', 'TIMESTAMP', 'Email verification timestamp (nullable)'],
        ['', 'password', 'VARCHAR(255)', 'Hashed password'],
        ['', 'business_name', 'VARCHAR(255)', 'Business name (nullable)'],
        ['', 'is_verified', 'BOOLEAN', 'Verification status. Default: false'],
        ['', 'total_impact_score', 'DECIMAL(10,2)', 'Environmental impact score'],
        ['', 'items_processed', 'INT', 'Number of items processed'],
        ['', 'total_weight_diverted', 'DECIMAL(10,2)', 'Weight diverted from landfill (kg)'],
        ['', 'total_co2_saved', 'DECIMAL(10,2)', 'CO2 saved (kg)'],
        ['', 'google_id', 'VARCHAR(255)', 'Google OAuth ID (nullable)'],
        ['', 'created_at', 'TIMESTAMP', 'Account creation timestamp'],
        ['', 'updated_at', 'TIMESTAMP', 'Last update timestamp'],
    ],
    'Addresses': [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'user_id', 'BIGINT', 'User who owns address'],
        ['', 'label', 'VARCHAR(255)', 'Address label: Home, Office, etc.'],
        ['', 'address_line_1', 'VARCHAR(255)', 'Street address'],
        ['', 'city', 'VARCHAR(255)', 'City name'],
        ['', 'postal_code', 'VARCHAR(20)', 'Postal/ZIP code'],
        ['', 'country', 'VARCHAR(255)', "Default: Philippines"],
        ['', 'latitude', 'DECIMAL(10,8)', 'GPS latitude (nullable)'],
        ['', 'longitude', 'DECIMAL(11,8)', 'GPS longitude (nullable)'],
        ['', 'is_primary', 'BOOLEAN', 'Default address. Default: false'],
        ['', 'type', "ENUM('pickup','dropoff','both')", 'Address type'],
        ['', 'created_at', 'TIMESTAMP', 'Creation timestamp'],
        ['', 'updated_at', 'TIMESTAMP', 'Last update timestamp'],
    ],
    'Listings': [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'user_id', 'BIGINT', "Seller's user ID"],
        ['', 'category', 'VARCHAR(255)', 'Item category (nullable)'],
        ['', 'condition', "ENUM('working','minor_damage',...)", 'Item condition'],
        ['', 'description', 'TEXT', 'Item description'],
        ['', 'estimated_weight', 'DECIMAL(5,2)', 'Weight in kg (nullable)'],
        ['', 'intended_action', "ENUM('sell','donate','recycle')", 'Intended action'],
        ['', 'suggested_price', 'DECIMAL(10,2)', 'Suggested price (nullable)'],
        ['', 'status', "ENUM('pending','available',...)", 'Listing status'],
        ['FK', 'matched_buyer_id', 'BIGINT', 'Matched buyer (nullable)'],
        ['', 'carbon_footprint', 'DECIMAL(10,2)', 'Carbon footprint (nullable)'],
        ['SOFT DEL', 'deleted_at', 'TIMESTAMP', 'Soft delete timestamp (nullable)'],
        ['', 'created_at', 'TIMESTAMP', 'Creation timestamp'],
        ['', 'updated_at', 'TIMESTAMP', 'Last update timestamp'],
    ],
    'Offers': [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'listing_id', 'BIGINT', 'Listing ID'],
        ['FK', 'buyer_id', "BIGINT", "Buyer's user ID"],
        ['', 'bid_amount', 'DECIMAL(10,2)', 'Offered bid amount'],
        ['', 'proposed_method', "ENUM('repair','harvest',...)", 'Processing method'],
        ['', 'proposed_pickup_date', 'DATETIME', 'Proposed pickup date'],
        ['', 'status', "ENUM('pending','accepted',...)", 'Offer status'],
        ['', 'responded_at', 'TIMESTAMP', 'When seller responded (nullable)'],
        ['SOFT DEL', 'deleted_at', 'TIMESTAMP', 'Soft delete timestamp (nullable)'],
        ['', 'created_at', 'TIMESTAMP', 'Creation timestamp'],
        ['', 'updated_at', 'TIMESTAMP', 'Last update timestamp'],
    ],
    'Reviews': [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'reviewer_id', 'BIGINT', 'User leaving review'],
        ['FK', 'reviewee_id', 'BIGINT', 'User being reviewed'],
        ['FK', 'offer_id', 'BIGINT', 'Associated transaction'],
        ['', 'rating', 'INT', '1-5 star rating'],
        ['', 'title', 'VARCHAR(255)', 'Review title'],
        ['', 'comment', 'TEXT', 'Review comment (nullable)'],
        ['', 'review_type', "ENUM('buyer','seller')", 'Reviewer type'],
        ['', 'is_verified', 'BOOLEAN', 'Verified purchase. Default: false'],
        ['', 'created_at', 'TIMESTAMP', 'Creation timestamp'],
        ['', 'updated_at', 'TIMESTAMP', 'Last update timestamp'],
    ],
    'Impact_Logs': [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'listing_id', 'BIGINT', 'Listing ID'],
        ['FK', 'seller_id', 'BIGINT', "Seller's user ID"],
        ['FK', 'buyer_id', "BIGINT", "Buyer's user ID"],
        ['FK', 'offer_id', 'BIGINT', 'Associated offer (nullable)'],
        ['', 'device_category', 'VARCHAR(255)', 'Device category'],
        ['', 'device_weight', 'DECIMAL(5,2)', 'Device weight in kg'],
        ['', 'processing_method', "ENUM('repair','harvest',...)", 'Processing method'],
        ['', 'co2_saved', 'DECIMAL(10,2)', 'CO2 saved in kg'],
        ['', 'landfill_diverted_weight', 'DECIMAL(10,2)', 'Landfill weight diverted (kg)'],
        ['', 'materials_recovered_weight', 'DECIMAL(10,2)', 'Materials recovered (kg) (nullable)'],
        ['', 'gold_recovered', 'DECIMAL(5,4)', 'Gold recovered (nullable)'],
        ['UNIQUE', 'certificate_token', 'VARCHAR(255)', 'Certificate token (nullable)'],
        ['', 'status', "ENUM('pending','verified','certified')", 'Status'],
        ['SOFT DEL', 'deleted_at', 'TIMESTAMP', 'Soft delete timestamp (nullable)'],
    ],
    'Device_Types': [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['UNIQUE', 'name', 'VARCHAR(255)', 'Device type: Laptop, Smartphone, etc.'],
        ['', 'description', 'TEXT', 'Description (nullable)'],
        ['', 'icon', 'VARCHAR(255)', 'Font Awesome icon class (nullable)'],
        ['', 'created_at', 'TIMESTAMP', 'Creation timestamp'],
        ['', 'updated_at', 'TIMESTAMP', 'Last update timestamp'],
    ],
    'Device_Brands': [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['UNIQUE', 'name', 'VARCHAR(255)', 'Brand name: Apple, Samsung, Dell, etc.'],
        ['', 'description', 'TEXT', 'Description (nullable)'],
        ['', 'logo_url', 'VARCHAR(255)', 'Brand logo URL (nullable)'],
        ['', 'created_at', 'TIMESTAMP', 'Creation timestamp'],
        ['', 'updated_at', 'TIMESTAMP', 'Last update timestamp'],
    ],
    'Device_Models': [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'device_type_id', 'BIGINT', 'Device type ID'],
        ['FK', 'device_brand_id', 'BIGINT', 'Device brand ID'],
        ['UNIQUE', 'model_name', 'VARCHAR(255)', 'Model: iPhone 13 Pro, Galaxy S21, etc.'],
        ['', 'description', 'TEXT', 'Model specifications (nullable)'],
        ['', 'created_at', 'TIMESTAMP', 'Creation timestamp'],
        ['', 'updated_at', 'TIMESTAMP', 'Last update timestamp'],
    ],
    'Notifications': [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'user_id', 'BIGINT', 'Recipient user ID'],
        ['', 'type', 'VARCHAR(255)', 'Type: offer_update, listing_status, etc.'],
        ['', 'title', 'VARCHAR(255)', 'Notification title'],
        ['', 'message', 'TEXT', 'Message content'],
        ['', 'is_read', 'BOOLEAN', 'Read status. Default: false'],
        ['', 'read_at', 'TIMESTAMP', 'Read timestamp (nullable)'],
        ['', 'created_at', 'TIMESTAMP', 'Creation timestamp'],
        ['', 'updated_at', 'TIMESTAMP', 'Last update timestamp'],
    ],
    'Email_Verifications': [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'user_id', 'BIGINT', 'User being verified'],
        ['', 'code', 'VARCHAR(6)', '6-digit verification code'],
        ['', 'expires_at', 'TIMESTAMP', 'Code expiration time'],
        ['', 'used', 'BOOLEAN', 'Code used status. Default: false'],
        ['', 'created_at', 'TIMESTAMP', 'Creation timestamp'],
        ['', 'updated_at', 'TIMESTAMP', 'Last update timestamp'],
    ],
    'Audit_Logs': [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'user_id', 'BIGINT', 'User who performed action (nullable)'],
        ['', 'action', 'VARCHAR(255)', 'Action: login, create_listing, etc.'],
        ['', 'model_type', 'VARCHAR(255)', 'Model affected: Listing, Offer, etc.'],
        ['', 'model_id', 'BIGINT', 'ID of affected resource (nullable)'],
        ['', 'description', 'TEXT', 'Human-readable description'],
        ['', 'old_values', 'JSON', 'Previous values (nullable)'],
        ['', 'new_values', 'JSON', 'New values (nullable)'],
        ['', 'ip_address', 'VARCHAR(45)', 'User IP address (nullable)'],
        ['', 'created_at', 'TIMESTAMP', 'Log creation timestamp'],
    ],
    'Reports': [
        ['Keys', 'Field Name', 'Data Type', 'Description'],
        ['PK', 'id', 'BIGINT', 'Unique identifier'],
        ['FK', 'user_id', 'BIGINT', 'Reporter user ID'],
        ['', 'reportable_type', 'VARCHAR(255)', 'Type being reported'],
        ['', 'reportable_id', 'BIGINT', 'ID of resource being reported'],
        ['', 'reason', 'ENUM (11 values)', 'Reason: scam_fraud, offensive_language, etc.'],
        ['', 'description', 'TEXT', 'Report description (nullable)'],
        ['', 'status', "ENUM('pending','under_review',...)", 'Status'],
        ['FK', 'reviewed_by', 'BIGINT', 'Admin reviewer (nullable)'],
        ['', 'action_taken', "ENUM('none','warning_sent',...)", 'Action taken (nullable)'],
        ['', 'created_at', 'TIMESTAMP', 'Report submission timestamp'],
    ],
}

def generate_html_table(table_name, rows):
    """Generate HTML table from data"""
    html = f"""
    <html>
    <head>
        <meta charset="UTF-8">
        <title>E-Benta - {table_name}</title>
        <style>
            body {{
                font-family: Arial, sans-serif;
                padding: 20px;
                background: #f5f5f5;
            }}
            h1 {{
                font-size: 18px;
                color: #333;
                margin-bottom: 15px;
            }}
            table {{
                width: 100%;
                border-collapse: collapse;
                background: white;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }}
            th {{
                background: #0066cc;
                color: white;
                padding: 12px;
                text-align: left;
                font-weight: bold;
                border: 1px solid #0052a3;
                font-size: 12px;
            }}
            td {{
                padding: 10px 12px;
                border: 1px solid #ddd;
                font-size: 11px;
            }}
            tr:nth-child(even) {{
                background: #f9f9f9;
            }}
            tr:hover {{
                background: #f0f0f0;
            }}
        </style>
    </head>
    <body>
        <h1>E-Benta - {table_name} Table</h1>
        <table>
    """
    
    for i, row in enumerate(rows):
        if i == 0:
            html += '<thead><tr>'
            for cell in row:
                html += f'<th>{cell}</th>'
            html += '</tr></thead><tbody>'
        else:
            html += '<tr>'
            for cell in row:
                html += f'<td>{cell}</td>'
            html += '</tr>'
    
    html += '</tbody></table></body></html>'
    return html

def main():
    output_dir = Path(r'c:\xampp\htdocs\E-Benta\table_images')
    output_dir.mkdir(exist_ok=True)
    
    print("🖼️  Generating table images...\n")
    
    if USE_HTML2IMAGE:
        hti = HtmlImageConverter(custom_objects={'async': True})
        
        for table_name, rows in TABLES_DATA.items():
            html_content = generate_html_table(table_name, rows)
            filename = f'{table_name.replace(" ", "_")}.png'
            filepath = output_dir / filename
            
            try:
                hti.convert_html_string(html_content, output_path=str(filepath))
                print(f'✅ {table_name}.png created')
            except Exception as e:
                print(f'❌ Error creating {table_name}: {e}')
    else:
        print('⚠️  html2image not installed.')
        print('\n📋 To generate images, install required package:')
        print('   pip install html2image')
        print('\n💡 Alternative: Use browser to print tables to PDF:')
        print('   1. Open DATA_DICTIONARY.html in browser')
        print('   2. Press Ctrl+P to print')
        print('   3. Select "Save as PDF" or take screenshots')
        print('\n📁 HTML files created for manual conversion:')
        
        for table_name, rows in TABLES_DATA.items():
            html_content = generate_html_table(table_name, rows)
            filename = f'{table_name.replace(" ", "_")}.html'
            filepath = output_dir / filename
            
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(html_content)
            print(f'✅ {filename} created in table_images folder')

if __name__ == '__main__':
    main()
