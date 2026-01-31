<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Edit Schedule</h4>
        <a href="<?php echo base_url('admin/schedules'); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="card">
        <div class="card-body">
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            <?php echo form_open('admin/schedules/edit/' . $schedule->id); ?>
                <div class="row">
                    <div class="col-md-6"><div class="mb-3"><label>Title *</label><input type="text" class="form-control" name="title" value="<?php echo set_value('title', $schedule->title); ?>" required></div></div>
                    <div class="col-md-6"><div class="mb-3"><label>Ustadz *</label><input type="text" class="form-control" name="ustadz" value="<?php echo set_value('ustadz', $schedule->ustadz); ?>" required></div></div>
                </div>
                <div class="mb-3"><label>Description</label><textarea class="form-control" name="description" rows="3"><?php echo set_value('description', $schedule->description); ?></textarea></div>
                <div class="row">
                    <div class="col-md-6"><div class="mb-3"><label>Location *</label><input type="text" class="form-control" name="location" value="<?php echo set_value('location', $schedule->location); ?>" required></div></div>
                    <div class="col-md-6"><div class="mb-3"><label>Duration</label><input type="text" class="form-control" name="duration" value="<?php echo set_value('duration', $schedule->duration); ?>" placeholder="e.g., 90 menit"></div></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><div class="mb-3"><label>Event Date *</label><input type="date" class="form-control" name="event_date" value="<?php echo set_value('event_date', $schedule->event_date); ?>" required></div></div>
                    <div class="col-md-6"><div class="mb-3"><label>Event Time *</label><input type="time" class="form-control" name="event_time" value="<?php echo set_value('event_time', $schedule->event_time); ?>" required></div></div>
                </div>
                <div class="mb-3"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" <?php echo set_checkbox('is_active', '1', ($schedule->is_active == 1)); ?>><label class="form-check-label">Active</label></div></div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
