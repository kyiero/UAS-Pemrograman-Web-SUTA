<div class="hero">
    <div class="container text-center">
        <h1 class="display-4"><i class="fas fa-mosque"></i> <?php echo isset($settings['site_name']) ? $settings['site_name'] : 'CMS Pengajian'; ?></h1>
        <p class="lead"><?php echo isset($settings['site_description']) ? $settings['site_description'] : 'Portal Kajian Islam dan Pengajian'; ?></p>
    </div>
</div>

<?php if (!empty($featured_articles)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4"><i class="fas fa-star"></i> Featured Articles</h2>
        <div class="row">
            <?php foreach ($featured_articles as $article): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if ($article->image): ?>
                            <img src="<?php echo base_url($article->image); ?>" class="card-img-top" alt="<?php echo $article->title; ?>" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <span class="badge category-badge mb-2"><?php echo $article->category_name; ?></span>
                            <h5 class="card-title"><?php echo character_limiter($article->title, 50); ?></h5>
                            <p class="card-text text-muted"><?php echo character_limiter(strip_tags($article->excerpt), 80); ?></p>
                            <a href="<?php echo base_url('article/' . $article->slug); ?>" class="btn btn-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="py-5">
    <div class="container">
        <h2 class="mb-4"><i class="fas fa-newspaper"></i> Recent Articles</h2>
        <div class="row">
            <?php if (!empty($recent_articles)): foreach ($recent_articles as $article): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if ($article->image): ?>
                            <img src="<?php echo base_url($article->image); ?>" class="card-img-top" alt="<?php echo $article->title; ?>" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <span class="badge category-badge mb-2"><?php echo $article->category_name; ?></span>
                            <h5 class="card-title"><?php echo character_limiter($article->title, 50); ?></h5>
                            <p class="card-text text-muted"><?php echo character_limiter(strip_tags($article->excerpt), 80); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?php echo base_url('article/' . $article->slug); ?>" class="btn btn-primary btn-sm">Read More</a>
                                <small class="text-muted"><i class="fas fa-eye"></i> <?php echo $article->views; ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No articles available yet.</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo base_url('articles'); ?>" class="btn btn-primary">View All Articles</a>
        </div>
    </div>
</section>

<?php if (!empty($upcoming_schedules)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4"><i class="fas fa-calendar-alt"></i> Upcoming Schedules</h2>
        <div class="row">
            <?php foreach ($upcoming_schedules as $schedule): ?>
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $schedule->title; ?></h5>
                            <p class="card-text"><?php echo character_limiter($schedule->description, 100); ?></p>
                            <ul class="list-unstyled mb-0">
                                <li><i class="fas fa-chalkboard-teacher"></i> <strong>Ustadz:</strong> <?php echo $schedule->ustadz; ?></li>
                                <li><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> <?php echo $schedule->location; ?></li>
                                <li><i class="fas fa-calendar"></i> <strong>Date:</strong> <?php echo date('d M Y', strtotime($schedule->event_date)); ?> at <?php echo date('H:i', strtotime($schedule->event_time)); ?></li>
                                <?php if ($schedule->duration): ?><li><i class="fas fa-clock"></i> <strong>Duration:</strong> <?php echo $schedule->duration; ?></li><?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo base_url('schedules'); ?>" class="btn btn-primary">View All Schedules</a>
        </div>
    </div>
</section>
<?php endif; ?>
