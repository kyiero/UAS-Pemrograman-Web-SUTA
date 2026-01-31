<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h2 class="mb-4">All Articles</h2>
            <div class="row">
                <?php if (!empty($articles)): foreach ($articles as $article): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <?php if ($article->image): ?>
                                <img src="<?php echo base_url($article->image); ?>" class="card-img-top" alt="<?php echo $article->title; ?>" style="height: 180px; object-fit: cover;">
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
                    <div class="col-12"><p class="text-muted">No articles found.</p></div>
                <?php endif; ?>
            </div>
            <?php if (!empty($pagination)): ?><div class="mt-4"><?php echo $pagination; ?></div><?php endif; ?>
        </div>
        <div class="col-lg-4">
            <h5 class="mb-3">Categories</h5>
            <div class="list-group">
                <?php if (!empty($categories)): foreach ($categories as $cat): ?>
                    <a href="<?php echo base_url('category/' . $cat->slug); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="fas <?php echo $cat->icon; ?>"></i> <?php echo $cat->name; ?></span>
                        <span class="badge bg-primary rounded-pill"><?php echo $cat->article_count; ?></span>
                    </a>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</div>
