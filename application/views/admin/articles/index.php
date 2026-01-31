<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Manage Articles</h4>
        <a href="<?php echo base_url('admin/articles/create'); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Article
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="40%">Title</th>
                            <th width="15%">Category</th>
                            <th width="10%">Author</th>
                            <th width="10%">Status</th>
                            <th width="10%">Views</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($articles)): ?>
                            <?php foreach ($articles as $index => $article): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td>
                                        <strong><?php echo character_limiter($article->title, 60); ?></strong>
                                        <?php if ($article->is_featured): ?>
                                            <span class="badge bg-warning text-dark">Featured</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $article->category_name; ?></td>
                                    <td><?php echo $article->author_name; ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $article->status; ?>">
                                            <?php echo ucfirst($article->status); ?>
                                        </span>
                                    </td>
                                    <td><?php echo $article->views; ?></td>
                                    <td>
                                        <a href="<?php echo base_url('admin/articles/edit/' . $article->id); ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo base_url('admin/articles/delete/' . $article->id); ?>" class="btn btn-sm btn-danger delete-confirm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No articles found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if (!empty($pagination)): ?>
                <div class="mt-3">
                    <?php echo $pagination; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
