<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Create Category</h4>
        <a href="<?php echo base_url('admin/categories'); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="card">
        <div class="card-body">
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            <?php echo form_open('admin/categories/create'); ?>
                <div class="mb-3"><label>Name *</label><input type="text" class="form-control" name="name" value="<?php echo set_value('name'); ?>" required></div>
                <div class="mb-3"><label>Description</label><textarea class="form-control" name="description" rows="3"><?php echo set_value('description'); ?></textarea></div>
                <div class="mb-3"><label>Icon (FontAwesome class)</label><input type="text" class="form-control" name="icon" value="<?php echo set_value('icon', 'fa-folder'); ?>" placeholder="e.g., fa-folder"></div>
                <div class="mb-3"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" <?php echo set_checkbox('is_active', '1', TRUE); ?>><label class="form-check-label">Active</label></div></div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
