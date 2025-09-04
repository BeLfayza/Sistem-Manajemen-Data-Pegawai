<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Data Pegawai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    /* ===== CSS VARIABLES ===== */
    :root {
      --primary-color: #4f46e5;
      --primary-dark: #3730a3;
      --primary-light: #6366f1;
      --success-color: #10b981;
      --warning-color: #f59e0b;
      --danger-color: #ef4444;
      --info-color: #06b6d4;
      --dark-color: #1e293b;
      --light-color: #f8fafc;
      --border-color: #e2e8f0;
      --text-muted: #64748b;
      --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
      --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
      --border-radius: 0.75rem;
      --border-radius-lg: 1rem;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    body {
      min-height: 100vh;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
    }

    .container-fluid {
      flex: 1 0 auto;
    }

    /* ===== SIDEBAR STYLES ===== */
    .sidebar {
      background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%) !important;
      border-right: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: var(--shadow-lg);
      position: relative;
    }

    .sidebar::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    }

    .sidebar .nav-link {
      color: rgba(255, 255, 255, 0.8) !important;
      transition: var(--transition);
      border-radius: 0.5rem;
      margin: 0.25rem 0.5rem;
      padding: 0.75rem 1rem;
      position: relative;
      overflow: hidden;
    }

    .sidebar .nav-link::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
      transition: left 0.5s;
    }

    .sidebar .nav-link:hover::before {
      left: 100%;
    }

    .sidebar .nav-link:hover {
      background: rgba(255, 255, 255, 0.1) !important;
      color: #fff !important;
      transform: translateX(4px);
    }

    .sidebar .nav-link.active {
      background: var(--primary-color) !important;
      color: #fff !important;
      box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .sidebar .nav-link.logout-link:hover {
      background: var(--danger-color) !important;
      color: #fff !important;
    }

    .sidebar .navbar-brand {
      color: #fff !important;
      font-weight: 700;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    /* ===== MAIN CONTENT ===== */
    main {
      animation: slideInUp 0.6s cubic-bezier(0.23, 1, 0.32, 1);
      background: transparent;
    }

    .main-content-wrapper {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: var(--border-radius-lg);
      box-shadow: var(--shadow-xl);
      border: 1px solid rgba(255, 255, 255, 0.2);
      min-height: calc(100vh - 2rem);
      margin: 1rem;
      padding: 2rem;
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

    /* ===== CARDS ===== */
    .card {
      border: none;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--shadow-md);
      transition: var(--transition);
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
    }

    .card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
    }

    .card-header {
      background: rgba(255, 255, 255, 0.8);
      border-bottom: 1px solid var(--border-color);
      border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0 !important;
    }

    /* ===== BUTTONS ===== */
    .btn {
      border-radius: 0.5rem;
      font-weight: 500;
      transition: var(--transition);
      border: none;
      position: relative;
      overflow: hidden;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.5s;
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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

    /* ===== PAGE HEADER ===== */
    .page-header {
      background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(99, 102, 241, 0.05));
      border-radius: var(--border-radius-lg);
      padding: 2rem;
      border: 1px solid rgba(79, 70, 229, 0.1);
      margin-bottom: 2rem;
    }

    .header-content {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    .header-icon {
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.5rem;
      box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
    }

    .page-title {
      font-size: 2rem;
      font-weight: 700;
      color: var(--dark-color);
      margin: 0;
      line-height: 1.2;
    }

    .page-subtitle {
      color: var(--text-muted);
      margin: 0.5rem 0 0 0;
      font-size: 1rem;
    }

    .header-action {
      box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
      border: none;
      font-weight: 600;
    }

    /* ===== STATISTICS CARDS ===== */
    .stats-card {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      border: none;
      border-radius: var(--border-radius-lg);
      overflow: hidden;
      position: relative;
    }

    .stats-card::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 100px;
      height: 100px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      transform: translate(30px, -30px);
    }

    .stats-card.success {
      background: linear-gradient(135deg, var(--success-color), #059669);
    }

    .stats-card.info {
      background: linear-gradient(135deg, var(--info-color), #0891b2);
    }

    .stats-icon {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      padding: 1rem;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
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