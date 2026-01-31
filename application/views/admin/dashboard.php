<div class="container-fluid">
    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-md-3 mb-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Articles</h6>
                            <h2 class="mb-0"><?php echo $total_articles; ?></h2>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-newspaper fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Published</h6>
                            <h2 class="mb-0"><?php echo $published_articles; ?></h2>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-check-circle fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Categories</h6>
                            <h2 class="mb-0"><?php echo $total_categories; ?></h2>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-folder fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Upcoming Events</h6>
                            <h2 class="mb-0"><?php echo $upcoming_schedules; ?></h2>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-calendar-alt fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Recent Articles -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-newspaper"></i> Recent Articles
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_articles)): ?>
                                    <?php foreach ($recent_articles as $article): ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo base_url('admin/articles/edit/' . $article->id); ?>">
                                                    <?php echo character_limiter($article->title, 50); ?>
                                                </a>
                                            </td>
                                            <td><?php echo $article->category_name; ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $article->status; ?>">
                                                    <?php echo ucfirst($article->status); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('d M Y', strtotime($article->created_at)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No articles yet</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Upcoming Schedules -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-calendar-alt"></i> Upcoming Schedules
                </div>
                <div class="card-body">
                    <?php if (!empty($schedules)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($schedules as $schedule): ?>
                                <div class="list-group-item px-0">
                                    <h6 class="mb-1"><?php echo character_limiter($schedule->title, 40); ?></h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($schedule->event_date)); ?>
                                        <i class="fas fa-clock ms-2"></i> <?php echo date('H:i', strtotime($schedule->event_time)); ?>
                                    </small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">No upcoming schedules</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
