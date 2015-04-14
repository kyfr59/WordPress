<?php
/**
 * 
 * The default template for displaying post single.
 * 
 */
// check where should meta be placed
global $blog_style, $pi_theme_options, $is_retina;

$format = get_post_format();

if (!$format) {
    $category_class = 'image';
} elseif ($format == 'video') {
    $category_class = 'video';
} elseif ($format == 'audio') {
    $category_class = 'audio';
} elseif ($format == 'quote') {
    $category_class = 'quote';
} elseif ($format == 'gallery') {
    $category_class = 'image';
    $post_info_container_class = 'with-slider';
} elseif ($format == 'link') {
    $category_class = 'link';
} else {
    $category_class = 'standard';
}

get_template_part('content', $format);
?>
<?php

if ($pi_theme_options['blog_single_show_author'] == '1'):
    $about_the_author = $pi_theme_options['blog_single_author_section_title'];
    $avatar_size = 90;
    $post_author_id = get_the_author_meta('ID');
    $post_author_bio = get_the_author_meta('description');
    $post_author_name = get_the_author_meta('display_name');
    $post_author_website = get_the_author_meta('user_url');
    ?>
    <!-- .post-author start -->
    <!--
    <article class="post-author">
        <h4><?php echo $about_the_author ?></h4>
        
        <div class="img-container">
            <?php echo get_avatar($post_author_id, $avatar_size); ?>
        </div>
        
        <section class="info">
            <a href="#">
                <h6><?php echo $post_author_name ?></h6>
            </a>
            
            <span class="member"><?php echo $post_author_website ?></span>
            
            <p><?php echo $post_author_bio ?></p>            
        </section>
        
    </article>
    -->
    <?php
endif;
//comments_template('', true);
?>
</article><!-- .post-body end -->    
</li><!-- blog post end -->