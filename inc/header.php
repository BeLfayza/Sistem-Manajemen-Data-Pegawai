<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Data Pegawai</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    /* ===== CSS VARIABLES - NEW MODERN DESIGN ===== */
    :root {
      --primary-color: #6366f1;
      --primary-dark: #4f46e5;
      --primary-light: #818cf8;
      --primary-glow: rgba(99, 102, 241, 0.4);
      --success-color: #22c55e;
      --warning-color: #f59e0b;
      --danger-color: #ef4444;
      --info-color: #3b82f6;
      --purple: #a855f7;
      --pink: #ec4899;
      --dark-color: #0f172a;
      --dark-secondary: #1e293b;
      --light-color: #f8fafc;
      --border-color: rgba(226, 232, 240, 0.5);
      --text-muted: #64748b;
      --text-primary: #1e293b;
      --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      --shadow-glow: 0 0 20px rgba(99, 102, 241, 0.3);
      --border-radius: 1rem;
      --border-radius-lg: 1.5rem;
      --border-radius-xl: 2rem;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      --transition-fast: all 0.15s ease-out;
    }

    /* ===== GLOBAL STYLES ===== */
    * {
      box-sizing: border-box;
    }

    html, body {
      height: 100vh;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
      background-size: 400% 400%;
      animation: gradientShift 15s ease infinite;
      position: relative;
    }

    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(168, 85, 247, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 20%, rgba(236, 72, 153, 0.1) 0%, transparent 50%);
      pointer-events: none;
      z-index: 0;
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    body {
      min-height: 100vh;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      position: relative;
      z-index: 1;
    }

    .container-fluid {
      flex: 1 0 auto;
      position: relative;
      z-index: 1;
    }

    /* ===== SIDEBAR STYLES - MODERN GLASSMORPHISM ===== */
    .sidebar {
      background: rgba(15, 23, 42, 0.7) !important;
      backdrop-filter: blur(20px) saturate(180%);
      -webkit-backdrop-filter: blur(20px) saturate(180%);
      border-right: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 
        0 8px 32px 0 rgba(0, 0, 0, 0.37),
        inset 0 0 0 1px rgba(255, 255, 255, 0.1);
      position: relative;
      z-index: 10;
    }

    .sidebar::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, 
        transparent, 
        rgba(99, 102, 241, 0.5), 
        rgba(168, 85, 247, 0.5),
        rgba(99, 102, 241, 0.5),
        transparent
      );
      animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
      0%, 100% { opacity: 0.5; }
      50% { opacity: 1; }
    }

    .sidebar .nav-link {
      color: rgba(255, 255, 255, 0.85) !important;
      transition: var(--transition);
      border-radius: var(--border-radius);
      margin: 0.5rem;
      padding: 0.875rem 1.25rem;
      position: relative;
      overflow: hidden;
      backdrop-filter: blur(10px);
      border: 1px solid transparent;
    }

    .sidebar .nav-link::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, 
        transparent, 
        rgba(255, 255, 255, 0.15), 
        transparent
      );
      transition: left 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar .nav-link::after {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 3px;
      height: 0;
      background: linear-gradient(180deg, var(--primary-color), var(--purple));
      border-radius: 0 3px 3px 0;
      transition: height 0.3s ease;
    }

    .sidebar .nav-link:hover::before {
      left: 100%;
    }

    .sidebar .nav-link:hover {
      background: rgba(255, 255, 255, 0.08) !important;
      color: #fff !important;
      transform: translateX(6px);
      border-color: rgba(99, 102, 241, 0.3);
      box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    }

    .sidebar .nav-link:hover::after {
      height: 60%;
    }

    .sidebar .nav-link.active {
      background: linear-gradient(135deg, 
        rgba(99, 102, 241, 0.3), 
        rgba(168, 85, 247, 0.3)
      ) !important;
      color: #fff !important;
      box-shadow: 
        0 8px 24px rgba(99, 102, 241, 0.4),
        inset 0 0 0 1px rgba(255, 255, 255, 0.2);
      border-color: rgba(99, 102, 241, 0.5);
    }

    .sidebar .nav-link.active::after {
      height: 70%;
    }

    .sidebar .nav-link.logout-link:hover {
      background: linear-gradient(135deg, 
        rgba(239, 68, 68, 0.3), 
        rgba(236, 72, 153, 0.3)
      ) !important;
      color: #fff !important;
      border-color: rgba(239, 68, 68, 0.5);
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .sidebar .navbar-brand {
      color: #fff !important;
      font-weight: 800;
      text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
      letter-spacing: -0.5px;
    }

    /* ===== MAIN CONTENT ===== */
    main {
      animation: slideInUp 0.6s cubic-bezier(0.23, 1, 0.32, 1);
      background: transparent;
    }

    .main-content-wrapper {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(30px) saturate(180%);
      -webkit-backdrop-filter: blur(30px) saturate(180%);
      border-radius: var(--border-radius-xl);
      box-shadow: 
        0 20px 60px rgba(0, 0, 0, 0.3),
        0 0 0 1px rgba(255, 255, 255, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.4);
      border: 1px solid rgba(255, 255, 255, 0.3);
      min-height: calc(100vh - 2rem);
      margin: 1rem;
      padding: 2.5rem;
      position: relative;
      z-index: 1;
    }

    .main-content-wrapper::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, 
        transparent, 
        rgba(99, 102, 241, 0.5), 
        rgba(168, 85, 247, 0.5),
        transparent
      );
      border-radius: var(--border-radius-xl) var(--border-radius-xl) 0 0;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(60px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-30px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* ===== ICONS & FONTS ===== */
    .fas, .far, .fab {
      font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands" !important;
      font-weight: 900;
    }

    /* ===== IMAGES ===== */
    img {
      transition: var(--transition);
    }

    img[src=""] {
      opacity: 0;
    }

    /* ===== USER AVATAR ===== */
    .user-avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 3px solid rgba(255, 255, 255, 0.2);
      transition: var(--transition);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .user-avatar:hover {
      transform: scale(1.05);
      border-color: var(--primary-color);
      box-shadow: 0 12px 35px rgba(79, 70, 229, 0.3);
    }

    .user-avatar-container {
      position: relative;
    }

    /* ===== BRAND LOGO ===== */
    .brand-icon-container {
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
      transition: var(--transition);
    }

    .brand-icon-container:hover {
      transform: scale(1.1) rotate(5deg);
      box-shadow: 0 12px 35px rgba(79, 70, 229, 0.4);
    }

    /* ===== CARDS - MODERN GLASSMORPHISM ===== */
    .card {
      border: none;
      border-radius: var(--border-radius-lg);
      box-shadow: 
        0 8px 32px rgba(0, 0, 0, 0.1),
        0 0 0 1px rgba(255, 255, 255, 0.5);
      transition: var(--transition);
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(20px) saturate(180%);
      -webkit-backdrop-filter: blur(20px) saturate(180%);
      border: 1px solid rgba(255, 255, 255, 0.4);
      overflow: hidden;
      position: relative;
    }

    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, 
        var(--primary-color), 
        var(--purple), 
        var(--pink),
        var(--primary-color)
      );
      background-size: 200% 100%;
      animation: gradientFlow 3s ease infinite;
      opacity: 0;
      transition: opacity 0.3s;
    }

    @keyframes gradientFlow {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .card:hover::before {
      opacity: 1;
    }

    .card:hover {
      transform: translateY(-4px) scale(1.01);
      box-shadow: 
        0 20px 40px rgba(0, 0, 0, 0.15),
        0 0 0 1px rgba(255, 255, 255, 0.6),
        0 0 30px rgba(99, 102, 241, 0.2);
    }

    .card-header {
      background: linear-gradient(135deg, 
        rgba(255, 255, 255, 0.9), 
        rgba(255, 255, 255, 0.7)
      );
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(99, 102, 241, 0.1);
      border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0 !important;
      padding: 1.25rem 1.5rem;
    }

    /* ===== BUTTONS - MODERN WITH GLOW ===== */
    .btn {
      border-radius: var(--border-radius);
      font-weight: 600;
      transition: var(--transition);
      border: none;
      position: relative;
      overflow: hidden;
      letter-spacing: 0.3px;
      text-transform: uppercase;
      font-size: 0.875rem;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, 
        transparent, 
        rgba(255, 255, 255, 0.3), 
        transparent
      );
      transition: left 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn::after {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: var(--border-radius);
      padding: 2px;
      background: linear-gradient(135deg, 
        var(--primary-color), 
        var(--purple), 
        var(--pink)
      );
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      opacity: 0;
      transition: opacity 0.3s;
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn:hover::after {
      opacity: 1;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 
        0 10px 25px rgba(99, 102, 241, 0.4),
        0 0 20px rgba(99, 102, 241, 0.3);
    }

    .btn:active {
      transform: translateY(0);
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
      box-shadow: 
        0 10px 30px rgba(99, 102, 241, 0.5),
        0 0 25px rgba(99, 102, 241, 0.4);
    }

    /* ===== BADGES ===== */
    .badge {
      border-radius: 0.375rem;
      font-weight: 500;
      padding: 0.5rem 0.75rem;
    }

    /* ===== TABLES ===== */
    .table {
      border-radius: var(--border-radius);
      overflow: hidden;
    }

    .table thead th {
      background: rgba(79, 70, 229, 0.05);
      border: none;
      font-weight: 600;
      color: var(--dark-color);
      padding: 1rem;
    }

    .table tbody tr {
      transition: var(--transition);
    }

    .table tbody tr:hover {
      background: rgba(79, 70, 229, 0.02);
      transform: scale(1.01);
    }

    /* ===== FORMS ===== */
    .form-control {
      border-radius: 0.5rem;
      border: 1px solid var(--border-color);
      transition: var(--transition);
      padding: 0.75rem 1rem;
    }

    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .input-group-text {
      background: rgba(79, 70, 229, 0.05);
      border: 1px solid var(--border-color);
      border-radius: 0.5rem 0 0 0.5rem;
    }

    /* ===== LOADING STATES ===== */
    .btn-loading {
      pointer-events: none;
      opacity: 0.8;
      position: relative;
    }

    .btn-loading::after {
      content: '';
      position: absolute;
      width: 16px;
      height: 16px;
      margin: auto;
      border: 2px solid transparent;
      border-top-color: currentColor;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* ===== SCROLLBAR ===== */
    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background: rgba(0, 0, 0, 0.1);
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
      background: var(--primary-color);
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: var(--primary-dark);
    }

    /* ===== PAGE HEADER - MODERN DESIGN ===== */
    .page-header {
      background: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(25px) saturate(180%);
      -webkit-backdrop-filter: blur(25px) saturate(180%);
      border-radius: var(--border-radius-xl);
      padding: 2.5rem;
      border: 1px solid rgba(255, 255, 255, 0.4);
      margin-bottom: 2rem;
      box-shadow: 
        0 10px 40px rgba(0, 0, 0, 0.1),
        0 0 0 1px rgba(255, 255, 255, 0.5),
        inset 0 1px 0 rgba(255, 255, 255, 0.6);
      position: relative;
      overflow: hidden;
    }

    .page-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, 
        var(--primary-color), 
        var(--purple), 
        var(--pink),
        var(--primary-color)
      );
      background-size: 200% 100%;
      animation: gradientFlow 3s ease infinite;
    }

    .header-content {
      display: flex;
      align-items: center;
      gap: 1.5rem;
      position: relative;
      z-index: 1;
    }

    .header-icon {
      width: 70px;
      height: 70px;
      background: linear-gradient(135deg, var(--primary-color), var(--purple));
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.75rem;
      box-shadow: 
        0 10px 30px rgba(99, 102, 241, 0.4),
        0 0 20px rgba(99, 102, 241, 0.3);
      transition: var(--transition);
      position: relative;
    }

    .header-icon::after {
      content: '';
      position: absolute;
      inset: -2px;
      border-radius: 20px;
      padding: 2px;
      background: linear-gradient(135deg, var(--primary-color), var(--purple), var(--pink));
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      opacity: 0;
      transition: opacity 0.3s;
    }

    .header-icon:hover::after {
      opacity: 1;
    }

    .header-icon:hover {
      transform: scale(1.1) rotate(5deg);
      box-shadow: 
        0 15px 40px rgba(99, 102, 241, 0.5),
        0 0 30px rgba(99, 102, 241, 0.4);
    }

    .page-title {
      font-size: 2.25rem;
      font-weight: 800;
      background: linear-gradient(135deg, var(--primary-color), var(--purple));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin: 0;
      line-height: 1.2;
      letter-spacing: -0.5px;
    }

    .page-subtitle {
      color: var(--text-muted);
      margin: 0.5rem 0 0 0;
      font-size: 1.05rem;
      font-weight: 500;
    }

    .header-action {
      box-shadow: 
        0 8px 20px rgba(99, 102, 241, 0.4),
        0 0 15px rgba(99, 102, 241, 0.3);
      border: none;
      font-weight: 600;
    }

    /* ===== STATISTICS CARDS - MODERN GRADIENT ===== */
    .stats-card {
      background: linear-gradient(135deg, var(--primary-color), var(--purple));
      border: none;
      border-radius: var(--border-radius-xl);
      overflow: hidden;
      position: relative;
      box-shadow: 
        0 10px 30px rgba(99, 102, 241, 0.3),
        0 0 20px rgba(99, 102, 241, 0.2);
      transition: var(--transition);
    }

    .stats-card::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
      animation: rotate 10s linear infinite;
    }

    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    .stats-card::after {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: var(--border-radius-xl);
      padding: 2px;
      background: linear-gradient(135deg, 
        rgba(255, 255, 255, 0.3), 
        rgba(255, 255, 255, 0.1),
        rgba(255, 255, 255, 0.3)
      );
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
    }

    .stats-card:hover {
      transform: translateY(-5px) scale(1.02);
      box-shadow: 
        0 20px 40px rgba(99, 102, 241, 0.4),
        0 0 30px rgba(99, 102, 241, 0.3);
    }

    .stats-card.success {
      background: linear-gradient(135deg, var(--success-color), #16a34a);
      box-shadow: 
        0 10px 30px rgba(34, 197, 94, 0.3),
        0 0 20px rgba(34, 197, 94, 0.2);
    }

    .stats-card.info {
      background: linear-gradient(135deg, var(--info-color), #2563eb);
      box-shadow: 
        0 10px 30px rgba(59, 130, 246, 0.3),
        0 0 20px rgba(59, 130, 246, 0.2);
    }

    .stats-icon {
      background: rgba(255, 255, 255, 0.25);
      border-radius: 50%;
      padding: 1.25rem;
      backdrop-filter: blur(15px);
      border: 2px solid rgba(255, 255, 255, 0.3);
      box-shadow: 
        0 8px 20px rgba(0, 0, 0, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.4);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      .main-content-wrapper {
        margin: 0.5rem;
        padding: 1rem;
      }
      
      .user-avatar {
        width: 80px;
        height: 80px;
      }
      
      .sidebar .nav-link {
        margin: 0.125rem 0.25rem;
        padding: 0.5rem 0.75rem;
      }

      .page-header {
        padding: 1.5rem;
      }

      .header-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
      }

      .page-title {
        font-size: 1.5rem;
      }

      .header-action {
        width: 100%;
        margin-top: 1rem;
      }
    }
  </style>
</head>
<body> 