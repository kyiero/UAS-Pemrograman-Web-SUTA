<div class="container py-5">
    <h2 class="mb-4"><i class="fas <?php echo $category->icon; ?>"></i> <?php echo $category->name; ?></h2>
    <?php if ($category->description): ?>
        <p class="lead text-muted"><?php echo $category->description; ?></p>
    <?php endif; ?>
    
    <div class="row">
        <?php if (!empty($articles)): foreach ($articles as $article): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if ($article->image): ?>
                        <img src="<?php echo base_url($article->image); ?>" class="card-img-top" alt="<?php echo $article->title; ?>" style="height: 180px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
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
            <div class="col-12"><p class="text-muted">No articles in this category yet.</p></div>
        <?php endif; ?>
    </div>
    <?php if (!empty($pagination)): ?><div class="mt-4"><?php echo $pagination; ?></div><?php endif; ?>
</div>
