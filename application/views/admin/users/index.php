<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Manage Users</h4>
        <a href="<?php echo base_url('admin/users/create'); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Create User</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead><tr><th>#</th><th>Full Name</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php if (!empty($users)): foreach ($users as $i => $user): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $user->full_name; ?></td>
                            <td><?php echo $user->username; ?></td>
                            <td><?php echo $user->email; ?></td>
                            <td><span class="badge bg-info"><?php echo ucfirst($user->role); ?></span></td>
                            <td><?php echo $user->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; ?></td>
                            <td>
                                <a href="<?php echo base_url('admin/users/edit/' . $user->id); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                <a href="<?php echo base_url('admin/users/delete/' . $user->id); ?>" class="btn btn-sm btn-danger delete-confirm"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="7" class="text-center">No users found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
