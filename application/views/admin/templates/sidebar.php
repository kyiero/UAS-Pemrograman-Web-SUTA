    <div class="sidebar">
        <div class="sidebar-brand">
            <h4><i class="fas fa-mosque"></i> CMS Pengajian</h4>
        </div>
        <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($active_menu == 'dashboard') ? 'active' : ''; ?>" href="<?php echo base_url('admin/dashboard'); ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($active_menu == 'articles') ? 'active' : ''; ?>" href="<?php echo base_url('admin/articles'); ?>">
                        <i class="fas fa-newspaper"></i> Articles
                    </a>
                </li>
                <?php if ($current_user->role === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($active_menu == 'categories') ? 'active' : ''; ?>" href="<?php echo base_url('admin/categories'); ?>">
                        <i class="fas fa-folder"></i> Categories
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($active_menu == 'schedules') ? 'active' : ''; ?>" href="<?php echo base_url('admin/schedules'); ?>">
                        <i class="fas fa-calendar-alt"></i> Schedules
                    </a>
                </li>
                <?php if ($current_user->role === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($active_menu == 'users') ? 'active' : ''; ?>" href="<?php echo base_url('admin/users'); ?>">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item mt-3">
                    <a class="nav-link" href="<?php echo base_url(); ?>" target="_blank">
                        <i class="fas fa-globe"></i> View Site
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('admin/auth/logout'); ?>">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1"><?php echo isset($page_title) ? $page_title : 'Admin Panel'; ?></span>
            <div class="ms-auto">
                <span class="navbar-text">
                    <i class="fas fa-user-circle"></i> <?php echo $current_user->full_name; ?>
                    <span class="badge bg-secondary"><?php echo ucfirst($current_user->role); ?></span>
                </span>
            </div>
        </div>
    </nav>

    <main>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
