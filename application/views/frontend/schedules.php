<div class="container py-5">
    <h2 class="mb-4"><i class="fas fa-calendar-alt"></i> Jadwal Kajian</h2>
    
    <div class="row">
        <?php if (!empty($schedules)): foreach ($schedules as $schedule): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><?php echo $schedule->title; ?></h5>
                    </div>
                    <div class="card-body">
                        <?php if ($schedule->description): ?>
                            <p class="card-text"><?php echo $schedule->description; ?></p>
                        <?php endif; ?>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fas fa-chalkboard-teacher text-primary"></i> <strong>Ustadz:</strong> <?php echo $schedule->ustadz; ?></li>
                            <li class="mb-2"><i class="fas fa-map-marker-alt text-primary"></i> <strong>Location:</strong> <?php echo $schedule->location; ?></li>
                            <li class="mb-2"><i class="fas fa-calendar text-primary"></i> <strong>Date:</strong> <?php echo date('l, d F Y', strtotime($schedule->event_date)); ?></li>
                            <li class="mb-2"><i class="fas fa-clock text-primary"></i> <strong>Time:</strong> <?php echo date('H:i', strtotime($schedule->event_time)); ?></li>
                            <?php if ($schedule->duration): ?>
                                <li><i class="fas fa-hourglass-half text-primary"></i> <strong>Duration:</strong> <?php echo $schedule->duration; ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No upcoming schedules at the moment. Please check back later.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
