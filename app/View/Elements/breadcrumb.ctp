<?php if (!empty($breadcrumb)): ?>
    <?php echo $this->start('breadcrumb'); ?>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <?php foreach ($breadcrumb as $v): ?>
                <li>
                    <a href="<?php echo $v['url'] ?>"><?php echo $v['title'] ?></a>
                    <i class="fa fa-circle"></i>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php echo $this->end(); ?>
<?php endif;
?>