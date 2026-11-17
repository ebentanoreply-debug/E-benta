<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Page Not Found | E-Benta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #09171f 0%, #0d2834 100%);
            color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }
        .error-card {
            background: rgba(15, 23, 42, 0.75);
            border-radius: 1.5rem;
            max-width: 580px;
            width: 100%;
            padding: 3rem 2rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4), 0 0 40px rgba(13, 148, 136, 0.15);
            border: 1px solid rgba(13, 148, 136, 0.3);
            text-align: center;
            backdrop-filter: blur(16px);
            position: relative;
            z-index: 10;
        }
        .code-display {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(4.5rem, 12vw, 7rem);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #2dd4bf 0%, #06b6d4 50%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
            letter-spacing: -2px;
        }
        .badge-notfound {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(13, 148, 136, 0.18);
            border: 1px solid rgba(45, 212, 191, 0.35);
            color: #5eead4;
            font-size: 0.82rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0.35rem 0.9rem;
            border-radius: 9999px;
            margin-bottom: 1.25rem;
        }
        h1 {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(1.4rem, 3vw, 1.85rem);
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 0.75rem;
        }
        p {
            color: #94a3b8;
            font-size: 0.98rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .actions-row {
            display: flex;
            gap: 0.85rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            color: #ffffff;
            font-weight: 700;
            padding: 0.8rem 1.6rem;
            border-radius: 0.75rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.35);
            border: none;
            font-size: 0.95rem;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 148, 136, 0.5);
            color: #ffffff;
        }
        .btn-outline {
            background: rgba(255, 255, 255, 0.06);
            color: #e2e8f0;
            font-weight: 700;
            padding: 0.8rem 1.6rem;
            border-radius: 0.75rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
            border: 1px solid rgba(255, 255, 255, 0.15);
            font-size: 0.95rem;
        }
        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: #2dd4bf;
            color: #ffffff;
            transform: translateY(-2px);
        }
        .brand-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }
        .brand-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #2dd4bf;
            box-shadow: 0 0 12px #2dd4bf;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <a href="/" class="brand-link">
            <span class="brand-dot"></span>
            <span>E-BENTA</span>
        </a>
        
        <div class="code-display">404</div>
        <div class="badge-notfound">
            <i class="fas fa-satellite-dish"></i> Resource Not Found
        </div>

        <h1>Lost in the Hardware Loop?</h1>
        <p>
            The listing, offer, or page you are trying to view doesn't exist, has been completed, or may have moved to a new destination.
        </p>

        <div class="actions-row">
            <a href="{{ route('listings.index') }}" class="btn-primary">
                <i class="fas fa-boxes-stacked"></i> Browse Marketplace
            </a>
            <a href="{{ route('home') }}" class="btn-outline">
                <i class="fas fa-home"></i> Return Home
            </a>
            <button onclick="window.history.back()" class="btn-outline" style="cursor: pointer;">
                <i class="fas fa-arrow-left"></i> Go Back
            </button>
        </div>
    </div>
</body>
</html>
