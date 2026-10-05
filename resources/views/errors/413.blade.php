<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>413 — Upload Content Too Large | E-Benta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .error-card {
            background: #ffffff;
            border-radius: 1.25rem;
            max-width: 540px;
            width: 100%;
            padding: 2.5rem 2rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08), 0 4px 12px rgba(15, 23, 42, 0.04);
            border: 1px solid rgba(226, 232, 240, 0.8);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .error-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #f59e0b, #ef4444);
        }
        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(239, 68, 68, 0.08);
            color: #ef4444;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.25rem;
            margin-bottom: 1.5rem;
        }
        .status-badge {
            display: inline-block;
            background: #fee2e2;
            color: #b91c1c;
            font-weight: 700;
            font-size: 0.82rem;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            margin-bottom: 0.75rem;
            letter-spacing: 0.5px;
        }
        h1 {
            font-size: 1.65rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.75rem;
            line-height: 1.25;
        }
        p {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        .tips-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 1rem 1.25rem;
            text-align: left;
            margin-bottom: 1.75rem;
            font-size: 0.88rem;
            color: #475569;
        }
        .tips-box strong {
            color: #0f172a;
            display: block;
            margin-bottom: 0.35rem;
        }
        .tips-box ul {
            padding-left: 1.25rem;
            margin: 0;
        }
        .tips-box li {
            margin-bottom: 0.25rem;
        }
        .btn-group {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
            color: #ffffff;
            font-weight: 700;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.65rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            transition: transform 0.15s ease, opacity 0.15s ease;
        }
        .btn-primary:hover {
            opacity: 0.95;
            transform: translateY(-1px);
        }
        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            font-weight: 600;
            text-decoration: none;
            padding: 0.75rem 1.25rem;
            border-radius: 0.65rem;
            border: 1px solid #cbd5e1;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }
        .btn-secondary:hover {
            background: #e2e8f0;
            color: #1e293b;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="icon-circle">
            <i class="fas fa-file-circle-exclamation"></i>
        </div>
        <div>
            <span class="status-badge">HTTP 413 CONTENT TOO LARGE</span>
        </div>
        <h1>Uploaded Photos / File Too Large</h1>
        <p>
            The files you selected exceed the server's single upload limit. High-resolution smartphone cameras often produce raw photos larger than 25MB each.
        </p>

        <div class="tips-box">
            <strong><i class="fas fa-lightbulb text-warning me-1"></i> Quick Tips to Fix:</strong>
            <ul>
                <li>Our updated system automatically compresses photos upon selection.</li>
                <li>If using an older camera mode, try selecting photos in smaller batches.</li>
                <li>Make sure each file is under 25MB.</li>
            </ul>
        </div>

        <div class="btn-group">
            <button onclick="window.history.back()" class="btn-primary">
                <i class="fas fa-arrow-left"></i> Go Back & Try Again
            </button>
            <a href="{{ url('/') }}" class="btn-secondary">
                <i class="fas fa-home"></i> Home
            </a>
        </div>
    </div>
</body>
</html>
