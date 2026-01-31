<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title . ' - ' . (isset($settings['site_name']) ? $settings['site_name'] : 'CMS Pengajian'); ?></title>
    <meta name="description" content="<?php echo isset($settings['site_description']) ? $settings['site_description'] : ''; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #2c5f4f; --secondary: #1a3a30; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-custom { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--secondary); border-color: var(--secondary); }
        .hero { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; padding: 4rem 0; }
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .card:hover { transform: translateY(-5px); }
        .category-badge { background: var(--primary); color: white; }
        footer { background: #2c3e50; color: white; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="<?php echo base_url(); ?>"><i class="fas fa-mosque"></i> <?php echo isset($settings['site_name']) ? $settings['site_name'] : 'CMS Pengajian'; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url('articles'); ?>">Articles</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url('schedules'); ?>">Schedules</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin'); ?>">Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>
