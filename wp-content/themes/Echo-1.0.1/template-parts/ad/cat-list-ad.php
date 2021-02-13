<?php $echo_option = get_option('echo_option'); ?>
<?php $ad = $echo_option['cat_list_ad']; ?>
<?php if (!empty($ad['type'] && $ad['type'] != 'closed')): ?>
    <div class="list-item d-none d-lg-flex">
        <?php if ($ad['type'] == 'code'): ?>
            <?php echo $ad['code'] ?>
        <?php else: ?>
            <a href="<?php echo esc_url($ad['link']); ?>" target="_blank">
                <img src="<?php echo wp_get_attachment_image_url($ad['image'], 'full'); ?>" alt="">
            </a>
        <?php endif; ?>
    </div>
    <div class="list-item d-lg-none">
        <?php if ($ad['type'] == 'code'): ?>
            <?php echo $ad['code'] ?>
        <?php else: ?>
            <a href="<?php echo esc_url($ad['link']); ?>" target="_blank">
                <img src="<?php echo wp_get_attachment_image_url($ad['image'], 'full'); ?>" alt="">
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>