<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Manage Schedules</h4>
        <a href="<?php echo base_url('admin/schedules/create'); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Create Schedule</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead><tr><th>#</th><th>Title</th><th>Ustadz</th><th>Location</th><th>Date & Time</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php if (!empty($schedules)): foreach ($schedules as $i => $sch): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo character_limiter($sch->title, 40); ?></td>
                            <td><?php echo $sch->ustadz; ?></td>
                            <td><?php echo $sch->location; ?></td>
                            <td><?php echo date('d M Y', strtotime($sch->event_date)) . ' ' . date('H:i', strtotime($sch->event_time)); ?></td>
                            <td><?php echo $sch->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; ?></td>
                            <td>
                                <a href="<?php echo base_url('admin/schedules/edit/' . $sch->id); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                <a href="<?php echo base_url('admin/schedules/delete/' . $sch->id); ?>" class="btn btn-sm btn-danger delete-confirm"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="7" class="text-center">No schedules found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
