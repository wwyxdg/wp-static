<?php global $post; ?>
<?php $toc = get_post_meta(get_the_ID(), 'toc', true); ?>

<?php if ($toc): ?>
<div class="col-lg-3 col-xl-3 sidebar-right border-left border-light d-none d-xl-block pl-lg-5">
    <?php
        $matches = array();
        $tag = get_post_meta(get_the_ID(), 'toc_tag', true);
        $r = "@<h$tag.*?>(.*?)<\/h$tag>@";
    ?>
    <?php if (preg_match_all($r, $post->post_content, $matches)): ?>
        <div id="widget-toc" class="page-toc bg-light mb-4">
            <ul class="bg-light">
                <?php foreach($matches[1] as $index => $title): ?>
                    <li class="nav-item <?php echo $index == 0 ? 'active' : '' ?>"><a href="javascript;" data-scrollspy="<?php echo "toc-$index" ?>"><span class="h-1x"><?php echo sanitize_text_field($title) ?></span></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
<?php else: ?>
    <?php get_sidebar() ?>
<?php endif; ?>