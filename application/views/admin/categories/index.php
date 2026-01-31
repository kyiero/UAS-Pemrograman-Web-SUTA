<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Manage Categories</h4>
        <a href="<?php echo base_url('admin/categories/create'); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Create Category</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead><tr><th>#</th><th>Name</th><th>Slug</th><th>Icon</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php if (!empty($categories)): foreach ($categories as $i => $cat): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $cat->name; ?></td>
                            <td><?php echo $cat->slug; ?></td>
                            <td><i class="fas <?php echo $cat->icon; ?>"></i></td>
                            <td><?php echo $cat->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; ?></td>
                            <td>
                                <a href="<?php echo base_url('admin/categories/edit/' . $cat->id); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                <a href="<?php echo base_url('admin/categories/delete/' . $cat->id); ?>" class="btn btn-sm btn-danger delete-confirm"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="6" class="text-center">No categories found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
