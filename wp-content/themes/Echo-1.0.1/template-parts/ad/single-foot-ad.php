<?php $echo_option = get_option('echo_option'); ?>
<?php $ad = $echo_option['single_foot_ad']; ?>
<?php if (!empty($ad['type'] && $ad['type'] != 'closed')): ?>
    <div class="paid-share mt-5 d-none d-lg-block">
        <?php if ($ad['type'] == 'code'): ?>
            <?php echo $ad['code_pc'] ?>
        <?php else: ?>
                <a href="<?php echo esc_url($ad['link']); ?>" target="_blank"><img src="<?php echo wp_get_attachment_image_url($ad['image_pc'], 'full'); ?>"></a>
        <?php endif; ?>
    </div>
    <div class="paid-share mt-4 d-lg-none">
        <?php if ($ad['type'] == 'code'): ?>
            <?php echo $ad['code_mobile'] ?>
        <?php else: ?>
                <a href="<?php echo esc_url($ad['link']); ?>" target="_blank"><img src="<?php echo wp_get_attachment_image_url($ad['image_mobile'], 'full'); ?>"></a>
        <?php endif; ?>
    </div>
<?php endif; ?>