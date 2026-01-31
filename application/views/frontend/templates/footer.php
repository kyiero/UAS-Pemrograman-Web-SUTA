    <footer class="mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-mosque"></i> <?php echo isset($settings['site_name']) ? $settings['site_name'] : 'CMS Pengajian'; ?></h5>
                    <p><?php echo isset($settings['site_description']) ? $settings['site_description'] : ''; ?></p>
                </div>
                <div class="col-md-3">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo base_url(); ?>" class="text-white-50">Home</a></li>
                        <li><a href="<?php echo base_url('articles'); ?>" class="text-white-50">Articles</a></li>
                        <li><a href="<?php echo base_url('schedules'); ?>" class="text-white-50">Schedules</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Categories</h6>
                    <ul class="list-unstyled">
                        <?php if (!empty($categories)): foreach (array_slice($categories, 0, 4) as $cat): ?>
                            <li><a href="<?php echo base_url('category/' . $cat->slug); ?>" class="text-white-50"><?php echo $cat->name; ?></a></li>
                        <?php endforeach; endif; ?>
                    </ul>
                </div>
            </div>
            <hr class="bg-white">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> CMS Pengajian. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
