<?php

/*
 * Loading JSON file with IconsFont icons
 * @return array
 */
if (!function_exists('pi_icons_font_names')) {

    function pi_icons_font_names() {

        // get icon list from database
        $icons_font = get_option('pi_icons_font_list');
        $icons_font = apply_filters('pi_icons_font_list', $icons_font);

        // if record is empty, parse the file and store it to database
        if (empty($icons_font)) {
            $icons_font = array();
            $tmp_icons_list = array();
            //$url = TEMPLATEURL . "/includes/iconsfont/IconFont.dev.json";
            $url = "http://pixel-industry.com/dummy_wp/elvyre/wp-content/themes/elvyre/includes/iconsfont/IconFont.dev.json";

            // get the file and parse it
            if (function_exists('curl_version')) {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $json_data = curl_exec($curl);
                curl_close($curl);
            } else if (file_get_contents(__FILE__) && ini_get('allow_url_fopen')) {
                $json_data = file_get_contents($url);
            }

            $json_data = json_decode($json_data, true);
            $icon_prefix = $json_data['preferences']['fontPref']['prefix'];

            // loop through the file and store to array
            foreach ($json_data['icons'] as $index => $icon) {
                $icon_name = str_replace(' ', '-', $icon['tags'][0]);
                $icon_name = $icon_prefix . $icon_name;
                if (isset($tmp_icons_list[$icon_name])) {
                    $current_count = $tmp_icons_list[$icon_name];
                    $name = $icon_name . '-' . ($current_count + 1);

                    $icons_font[$name] = $name;

                    $tmp_icons_list[$icon_name] = $tmp_icons_list[$icon_name] + 1;
                } else {
                    $icons_font[$icon_name] = $icon_name;
                    $tmp_icons_list[$icon_name] = 1;
                }
            }
            update_option('pi_icons_font_list', $icons_font);
        }
        
        // remove icons list from database
        //update_option('pi_icons_font_list', '');

        return $icons_font;
    }

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function pi_get_font_awesome_names() {

    $icons = array(
        'desktop' => 'desktop',
        'glass' => 'glass',
        'music' => 'music',
        'search' => 'search',
        'envelope' => 'envelope',
        'heart' => 'heart',
        'star' => 'star',
        'star-empty' => 'star-empty',
        'user' => 'user',
        'film' => 'film',
        'th-large' => 'th-large',
        'th' => 'th',
        'th-list' => 'th-list',
        'ok' => 'ok',
        'remove' => 'remove',
        'zoom-in' => 'zoom-in',
        'zoom-out' => 'zoom-out',
        'off' => 'off',
        'signal' => 'signal',
        'cog' => 'cog',
        'trash' => 'trash',
        'home' => 'home',
        'file' => 'file',
        'time' => 'time',
        'road' => 'road',
        'download-alt' => 'download-alt',
        'download' => 'download',
        'upload' => 'upload',
        'inbox' => 'inbox',
        'play-circle' => 'play-circle',
        'repeat' => 'repeat',
        'refresh' => 'refresh',
        'list-alt' => 'list-alt',
        'lock' => 'lock',
        'flag' => 'flag',
        'headphones' => 'headphones',
        'volume-off' => 'volume-off',
        'volume-down' => 'volume-down',
        'volume-up' => 'volume-up',
        'qrcode' => 'qrcode',
        'barcode' => 'barcode',
        'tag' => 'tag',
        'tags' => 'tags',
        'book' => 'book',
        'bookmark' => 'bookmark',
        'print' => 'print',
        'camera' => 'camera',
        'font' => 'font',
        'bold' => 'bold',
        'italic' => 'italic',
        'text-height' => 'text-height',
        'text-width' => 'text-width',
        'align-left' => 'align-left',
        'align-center' => 'align-center',
        'align-right' => 'align-right',
        'align-justify' => 'align-justify',
        'list' => 'list',
        'indent-left' => 'indent-left',
        'indent-right' => 'indent-right',
        'facetime-video' => 'facetime-video',
        'picture' => 'picture',
        'pencil' => 'pencil',
        'map-marker' => 'map-marker',
        'adjust' => 'adjust',
        'tint' => 'tint',
        'edit' => 'edit',
        'share' => 'share',
        'check' => 'check',
        'move' => 'move',
        'step-backward' => 'step-backward',
        'fast-backward' => 'fast-backward',
        'backward' => 'backward',
        'play' => 'play',
        'pause' => 'pause',
        'stop' => 'stop',
        'forward' => 'forward',
        'fast-forward' => 'fast-forward',
        'step-forward' => 'step-forward',
        'eject' => 'eject',
        'chevron-left' => 'chevron-left',
        'chevron-right' => 'chevron-right',
        'plus-sign' => 'plus-sign',
        'minus-sign' => 'minus-sign',
        'remove-sign' => 'remove-sign',
        'ok-sign' => 'ok-sign',
        'question-sign' => 'question-sign',
        'info-sign' => 'info-sign',
        'screenshot' => 'screenshot',
        'remove-circle' => 'remove-circle',
        'ok-circle' => 'ok-circle',
        'ban-circle' => 'ban-circle',
        'arrow-left' => 'arrow-left',
        'arrow-right' => 'arrow-right',
        'arrow-up' => 'arrow-up',
        'arrow-down' => 'arrow-down',
        'share-alt' => 'share-alt',
        'resize-full' => 'resize-full',
        'resize-small' => 'resize-small',
        'plus' => 'plus',
        'minus' => 'minus',
        'asterisk' => 'asterisk',
        'exclamation-sign' => 'exclamation-sign',
        'gift' => 'gift',
        'leaf' => 'leaf',
        'fire' => 'fire',
        'eye-open' => 'eye-open',
        'eye-close' => 'eye-close',
        'warning-sign' => 'warning-sign',
        'plane' => 'plane',
        'calendar' => 'calendar',
        'random' => 'random',
        'comment' => 'comment',
        'magnet' => 'magnet',
        'chevron-up' => 'chevron-up',
        'chevron-down' => 'chevron-down',
        'retweet' => 'retweet',
        'shopping-cart' => 'shopping-cart',
        'folder-close' => 'folder-close',
        'folder-open' => 'folder-open',
        'resize-vertical' => 'resize-vertical',
        'resize-horizontal' => 'resize-horizontal',
        'bar-chart' => 'bar-chart',
        'twitter-sign' => 'twitter-sign',
        'facebook-sign' => 'facebook-sign',
        'camera-retro' => 'camera-retro',
        'key' => 'key',
        'cogs' => 'cogs',
        'comments' => 'comments',
        'thumbs-up' => 'thumbs-up',
        'thumbs-down' => 'thumbs-down',
        'star-half' => 'star-half',
        'heart-empty' => 'heart-empty',
        'signout' => 'signout',
        'linkedin-sign' => 'linkedin-sign',
        'pushpin' => 'pushpin',
        'external-link' => 'external-link',
        'signin' => 'signin',
        'trophy' => 'trophy',
        'github-sign' => 'github-sign',
        'upload-alt' => 'upload-alt',
        'lemon' => 'lemon',
        'phone' => 'phone',
        'check-empty' => 'check-empty',
        'bookmark-empty' => 'bookmark-empty',
        'phone-sign' => 'phone-sign',
        'twitter' => 'twitter',
        'facebook' => 'facebook',
        'github' => 'github',
        'unlock' => 'unlock',
        'credit-card' => 'credit-card',
        'rss' => 'rss',
        'hdd' => 'hdd',
        'bullhorn' => 'bullhorn',
        'bell' => 'bell',
        'certificate' => 'certificate',
        'hand-right' => 'hand-right',
        'hand-left' => 'hand-left',
        'hand-up' => 'hand-up',
        'hand-down' => 'hand-down',
        'circle-arrow-left' => 'circle-arrow-left',
        'circle-arrow-right' => 'circle-arrow-right',
        'circle-arrow-up' => 'circle-arrow-up',
        'circle-arrow-down' => 'circle-arrow-down',
        'globe' => 'globe',
        'wrench' => 'wrench',
        'tasks' => 'tasks',
        'filter' => 'filter',
        'briefcase' => 'briefcase',
        'fullscreen' => 'fullscreen',
        'group' => 'group',
        'link' => 'link',
        'cloud' => 'cloud',
        'beaker' => 'beaker',
        'cut' => 'cut',
        'copy' => 'copy',
        'paper-clip' => 'paper-clip',
        'save' => 'save',
        'sign-blank' => 'sign-blank',
        'reorder' => 'reorder',
        'list-ul' => 'list-ul',
        'list-ol' => 'list-ol',
        'strikethrough' => 'strikethrough',
        'underline' => 'underline',
        'table' => 'table',
        'magic' => 'magic',
        'truck' => 'truck',
        'pinterest' => 'pinterest',
        'pinterest-sign' => 'pinterest-sign',
        'google-plus-sign' => 'google-plus-sign',
        'google-plus' => 'google-plus',
        'money' => 'money',
        'caret-down' => 'caret-down',
        'caret-up' => 'caret-up',
        'caret-left' => 'caret-left',
        'caret-right' => 'caret-right',
        'columns' => 'columns',
        'sort' => 'sort',
        'sort-down' => 'sort-down',
        'sort-up' => 'sort-up',
        'envelope-alt' => 'envelope-alt',
        'linkedin' => 'linkedin',
        'undo' => 'undo',
        'legal' => 'legal',
        'dashboard' => 'dashboard',
        'comment-alt' => 'comment-alt',
        'comments-alt' => 'comments-alt',
        'bolt' => 'bolt',
        'sitemap' => 'sitemap',
        'umbrella' => 'umbrella',
        'paste' => 'paste',
        'user-md' => 'user-md'
    );
    ksort($icons);

    return $icons;
}

function pi_get_pixons_names() {
    $prefix = 'pixons-';

    $icons = array(
        $prefix . 'amazon' => $prefix . 'amazon',
        $prefix . 'android' => $prefix . 'android',
        $prefix . 'aol' => $prefix . 'aol',
        $prefix . 'apple' => $prefix . 'apple',
        $prefix . 'behance' => $prefix . 'behance',
        $prefix . 'bing' => $prefix . 'bing',
        $prefix . 'blogger' => $prefix . 'blogger',
        $prefix . 'buzz' => $prefix . 'buzz',
        $prefix . 'delicious' => $prefix . 'delicious',
        $prefix . 'deviantart' => $prefix . 'deviantart',
        $prefix . 'digg' => $prefix . 'digg',
        $prefix . 'dribbble' => $prefix . 'dribbble',
        $prefix . 'dropbox' => $prefix . 'dropbox',
        $prefix . 'drupal' => $prefix . 'drupal',
        $prefix . 'ember' => $prefix . 'ember',
        $prefix . 'envato' => $prefix . 'envato',
        $prefix . 'evernote' => $prefix . 'evernote',
        $prefix . 'facebook-1' => $prefix . 'facebook-1',
        $prefix . 'facebook-2' => $prefix . 'facebook-2',
        $prefix . 'feedburner' => $prefix . 'feedburner',
        $prefix . 'forrst' => $prefix . 'forrst',
        $prefix . 'flickr' => $prefix . 'flickr',
        $prefix . 'foursquare' => $prefix . 'foursquare',
        $prefix . 'github' => $prefix . 'github',
        $prefix . 'github-2' => $prefix . 'github-2',
        $prefix . 'google_plus' => $prefix . 'google_plus',
        $prefix . 'grooveshark' => $prefix . 'grooveshark',
        $prefix . 'html5' => $prefix . 'html5',
        $prefix . 'instagram' => $prefix . 'instagram',
        $prefix . 'lastfm' => $prefix . 'lastfm',
        $prefix . 'linkedin' => $prefix . 'linkedin',
        $prefix . 'metacafe' => $prefix . 'metacafe',
        $prefix . 'mixx' => $prefix . 'mixx',
        $prefix . 'myspace' => $prefix . 'myspace',
        $prefix . 'newsvine' => $prefix . 'newsvine',
        $prefix . 'paypal' => $prefix . 'paypal',
        $prefix . 'picasa' => $prefix . 'picasa',
        $prefix . 'pinterest' => $prefix . 'pinterest',
        $prefix . 'plixi' => $prefix . 'plixi',
        $prefix . 'plurk' => $prefix . 'plurk',
        $prefix . 'posterous' => $prefix . 'posterous',
        $prefix . 'reddit' => $prefix . 'reddit',
        $prefix . 'rss' => $prefix . 'rss',
        $prefix . 'sharethis' => $prefix . 'sharethis',
        $prefix . 'skype' => $prefix . 'skype',
        $prefix . 'soundcloud' => $prefix . 'soundcloud',
        $prefix . 'stumbleupon' => $prefix . 'stumbleupon',
        $prefix . 'technorati' => $prefix . 'technorati',
        $prefix . 'tumblr' => $prefix . 'tumblr',
        $prefix . 'tux' => $prefix . 'tux',
        $prefix . 'twitter-1' => $prefix . 'twitter-1',
        $prefix . 'twitter-2' => $prefix . 'twitter-2',
        $prefix . 'vimeo' => $prefix . 'vimeo',
        $prefix . 'wordpress' => $prefix . 'wordpress',
        $prefix . 'xing' => $prefix . 'xing',
        $prefix . 'yahoo' => $prefix . 'yahoo',
        $prefix . 'yelp' => $prefix . 'yelp',
        $prefix . 'youtube' => $prefix . 'youtube',
        $prefix . 'zerply' => $prefix . 'zerply',
        $prefix . 'zootool' => $prefix . 'zootool'
    );
    ksort($icons);

    return $icons;
}

?>
