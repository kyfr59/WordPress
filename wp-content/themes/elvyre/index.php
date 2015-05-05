<?php
get_header();

global $page_title;

$paged = (get_query_var("paged")) ? get_query_var("paged") : 1;

if (is_year() || is_month() || is_day()) {
    $page_title = __("Archive ", 'pi_framework');
    if (is_year()) {
        $page_title .= __("for ", 'pi_framework') . get_the_date(_x('Y', 'yearly archives date format', 'pi_framework'));
    } else if (is_month()) {
        $page_title .= __("for ", 'pi_framework') . get_the_date(_x('F Y', 'monthly archives date format', 'pi_framework'));
    } else if (is_day()) {
        $page_title .= __("for ", 'pi_framework') . get_the_date();
    }

    if ($paged > 1)
        $page_title .= " - " . __("page", 'pi_framework') . " " . $paged;
}

if (is_tag()) {
    $page_title = __("Tag archive for ", 'pi_framework') . single_tag_title('', false);
    if ($paged > 1)
        $page_title .= " - " . __("page", 'pi_framework') . " " . $paged;
}

if (is_search()) {
    $page_title = __("Search results for ", 'pi_framework') . $_GET["s"];
    if ($paged > 1)
        $page_title .= " - " . __("page", 'pi_framework') . " " . $paged;
}

if (is_category()) {
    $page_title = __("Archive for ", 'pi_framework') . single_cat_title('', false);
    if ($paged > 1)
        $page_title .= " - " . __("page", 'pi_framework') . " " . $paged;
}

if (is_home()) {

    if (is_front_page()) {
        $page_title = get_option('blogname');
        if ($paged > 1)
            $page_title .= " - " . __("page", 'pi_framework') . " " . $paged;
    }else {
        $page_id = ( 'page' == get_option('show_on_front') ? get_option('page_for_posts') : get_the_ID() );
        $page_title = get_post_meta($page_id, 'pg_page_description', true);
        $page_title = empty($page_title) ? wp_title('', false) : $page_title;
    }
}

if (is_author()) {
    $author_clean = get_query_var('author');
    $page_title = __("Author Archive for ", 'pi_framework') . get_the_author_meta('display_name', $author_clean);
    if ($paged > 1)
        $page_title .= " - " . __("page", 'pi_framework') . " " . $paged;
}

if (is_404()) {
    $page_title = __('404 - Not Found', 'pi_framework');
}

if (is_page()) {
    $page_id = get_the_ID();
    $page_title = get_post_meta($page_id, 'pg_page_description', true);
    if (!empty($page_title)) {
        $page_title = get_the_title();
    }
}

// hide page title
$hide_page_title = get_post_meta($page_id, 'pg_hide_title', true);
$hide_page_title = empty($hide_page_title) ? '0' : $hide_page_title;


// check if user is on mobile device
$detect = new Mobile_Detect();

global $wp_query;

?>
<!-- .page-content start -->



<section class="page-content <?php if ($hide_page_title == '1') echo 'no-page-title'; ?>">

<h1 id="last-articles">Derniers articles</h1>

    <!-- .container start -->
    <div class="container">

        <!-- .row start -->
        <div class="row">

            <?php
            query_posts('showposts=5');
            if (have_posts()) :
                // check where should sidebar be placed
                $page_id = get_the_ID();
                $blog_style = $pi_theme_options['blog_style'];

                $page_sidebar = $pi_theme_options['blog_sidebar_position'];
                if ($blog_style == 'blog-post-full' || $blog_style == 'blog-post-masonry-full') {
                    $page_sidebar = false;
                }

                if ($page_sidebar == 'left'):
                    get_sidebar();
                endif;

                $grid_size = ($blog_style == 'blog-post-full' || $blog_style == 'blog-post-masonry-full') ? 12 : 9;

                $ul_classes = array('grid_12', 'blog-posts', 'content-sidebar-' . $page_sidebar, $blog_style);
                if ($blog_style == 'blog-post-masonry-full') {
                    $ul_classes[] = 'isotope';
                    $ul_classes[] = 'full';
                    $ul_id = "blogmasonry";
                } elseif ($blog_style == 'blog-post-masonry') {
                    $ul_classes[] = 'isotope';
                    $ul_classes[] = 'cols';
                    $ul_id = "blogmasonry";
                } else {
                    $ul_id = "classic-blog-layout";
                }

                // get animation classes
                $animation = $pi_theme_options['blog_animation'];
                if ($animation != "disabled") {
                    $ul_classes[] = 'triggerAnimation';
                    $ul_classes[] = 'animated';
                    $ul_classes[] = $animation;
                }
                ?>
                <!-- blog posts container start -->
                <ul id="<?php echo $ul_id; ?>" class="<?php echo join(' ', $ul_classes) ?>">
                    <?php
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    while (have_posts()) : the_post();
                        $format = get_post_format();
                        get_template_part('content', $format);
                    endwhile;
                    ?>
                    
                </ul><!-- blog posts container end -->
                <?php
            else :
                ?>
                <div class="grid_12">
                    <h3><?php _e('Nothing Found', 'pi_framework') ?></h3>
                    <p><?php _e('Sorry, but posts were not found.', 'pi_framework') ?></p>          
                </div>
            <?php endif; ?>


        </div><!-- .row end -->


   
    <div id="jumbotron">
        <a href="http://documents.studens.info/exhibits" class="left">
            <p>
                <strong>Expositions</strong>
                Expositions virtuelles sur l’histoire et l'actualité des engagements étudiants alimentées par les différents travaux de recherches et les ressources accessibles via <em>studens</em>.
            </p>
        </a> 
        <a href="http://documents.studens.info/collections" class="right">
            <p>
                <strong>Collections</strong>
                Corpus de documents numériques, soit issus de fonds d'archives, soit issus de fonds documentaires ou de collections (périodiques, témoignages, cartes postales, ...) de différentes institutions.
                </p>
        </a> 
    </div>

    
    </div><!-- .container end -->

    <div id="thema">
        <p>
            <strong>kézako</strong>
            <span><em>Studens</em> se veut un nouvel outil d'aide à la recherche, un « portail des mémoires étudiantes ». <em>Studens</em>, signifie "en étudiant" en latin (gérondif).</span>
            <a href="http://www.studens.info/kezako/">EN SAVOIR PLUS</a>
        </p>
        <p>
            <strong class="middle">collecter et traiter</strong>
            <span>Les différents partenaires patrimoniaux de ce portail mènent un travail inlassable de collecte et de traitement des archives et ressources documentaires de et sur les engagements étudiants.</span>
            <a href="http://www.studens.info/collecter-et-traiter/">EN SAVOIR PLUS</a>
        </p>
        <p>
            <strong class="right">valoriser et soutenir</strong>
            <span>Les différents partenaires patrimoniaux de ce portail mènent aussi un travail de valorisation des archives et ressources documentaires de et sur les engagements étudiants... Que vous pouvez soutenir !</span>
            <a href="http://www.studens.info/valoriser-et-soutenir/">EN SAVOIR PLUS</a>
        </p>
        <br style="clear:both;"/>
    </div>

    <div id="contact">

    </div>

</section><!-- .page-content end -->
<?php
get_footer();
?>