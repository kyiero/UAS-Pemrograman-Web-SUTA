<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <article class="card mb-4">
                <?php if ($article->image): ?>
                    <img src="<?php echo base_url($article->image); ?>" class="card-img-top" alt="<?php echo $article->title; ?>">
                <?php endif; ?>
                <div class="card-body">
                    <span class="badge category-badge mb-2"><?php echo $article->category_name; ?></span>
                    <h1 class="card-title"><?php echo $article->title; ?></h1>
                    <div class="text-muted mb-3">
                        <i class="fas fa-user"></i> <?php echo $article->author_name; ?> | 
                        <i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($article->created_at)); ?> | 
                        <i class="fas fa-eye"></i> <?php echo $article->views; ?> views
                    </div>
                    <div class="article-content">
                        <?php echo $article->content; ?>
                    </div>
                </div>
            </article>
            
            <?php if (!empty($related_articles)): ?>
                <h4 class="mb-3">Related Articles</h4>
                <div class="row">
                    <?php foreach ($related_articles as $rel): if ($rel->id != $article->id): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <?php if ($rel->image): ?>
                                    <img src="<?php echo base_url($rel->image); ?>" class="card-img-top" alt="<?php echo $rel->title; ?>" style="height: 120px; object-fit: cover;">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h6 class="card-title"><?php echo character_limiter($rel->title, 40); ?></h6>
                                    <a href="<?php echo base_url('article/' . $rel->slug); ?>" class="btn btn-sm btn-primary">Read</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; endforeach; ?>
                </div>
            <?php endif; ?>
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
