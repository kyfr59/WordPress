<?php
/**
 * Custom front-page.php template
 *
 * Used to display the homepage of your
 * WordPress site.
 *
 * @link http://themes.required.ch/?p=606
 */

get_header(); 
?>

<!-- slider -->
<div>
    <link href="wp-content/themes/elvyre/css/slider.css" media="screen" rel="stylesheet" type="text/css" >
    <?php if ( function_exists( 'show_simpleresponsiveslider' ) ) show_simpleresponsiveslider(); ?>
</div>
<!-- /slider -->

<section class="page-content <?php if ($hide_page_title == '1') echo 'no-page-title'; ?>">

<style>
#last-articles h1 {
    position: relative;
    height:176px;
    font-size:20px;
    color:black;
    font-weight:bold;
    text-align:center;
    padding-top:85px;
    background:url('img/last-articles-background.png') 454px top no-repeat;
}

#last-articles > ul {
	/*border:1px solid red !important;*/
}

#last-articles li.blog-post {
	border:1px solid red;
	margin:0;
	width:210px;
}

#last-articles .post-info {
	padding-left:0px;
}

#last-articles .post-body {
	padding-left:0px;
}

#last-articles .post-media-container img {
	border:1px solid red;
	width:210px;
	
}

</style>

<div id="last-articles">

<h1>Derniers articles</h1>

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

</div><<!-- /last-articles -->
        


   <!--
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
-->
    
    

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

