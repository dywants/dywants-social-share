<?php
/*
  Plugin Name: Share Socials Posts
  Plugin URI: https://dywants.com/outils/plugins
  Description: Links to Posts in social media
  Author: BAYONG Cyrille Thibaut
  Author URI: https://dywants.com/blog/author
  Version: 1.0.0
*/

// enqueue css stylesheet
function dywants_social_share_post() {
    wp_enqueue_style('social-share-post', plugins_url('assets/css/share-button-socials-style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'dywants_social_share_post');


function wp_social_buttons($content) {
    global $post;
    if(is_singular() || is_home()){

        // $pathImg = WP_PLUGIN_URL . '/dywants-socials-share-buttons/assets/img';

        $plugin = plugins_url();

        // $chemin_plugin = plugin_dir_path( __FILE__ );
        // $pathImg = str_replace(ABSPATH, '/', $chemin_plugin) . '/assets/img';

        $root_path = $_SERVER['DOCUMENT_ROOT'];
        $plugin_path = plugin_dir_path( __FILE__ );
        $pathImg = str_replace( $root_path, '', $plugin_path ) . 'assets/img';
        
        // Get current page URL
        $postUrl = urlencode(get_permalink());

        // Get current page title
//        $titlePost = str_replace( ' ', '%20', get_the_title());
        $titlePost = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');

        // Get Post Thumbnail for pinterest
        $imgPost = get_the_post_thumbnail_src(get_the_post_thumbnail());

        // Construct sharing URL without using any script
        $twitterURL = 'https://twitter.com/intent/tweet?text='.$titlePost.'&amp;url='.$postUrl.'&amp;via=dywants';
        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$postUrl;
//        $bufferURL = 'https://bufferapp.com/add?url='.$postUrl.'&amp;text='.$titlePost;
        $whatsappURL = 'whatsapp://send?text='.$titlePost . ' ' . $postUrl;
        $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$postUrl.'&amp;title='.$titlePost;

//        if(!empty($sb_thumb)) {
//            $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$sb_url.'&amp;media='.$sb_thumb[0].'&amp;description='.$sb_title;
//        }
//        else {
//            $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$sb_url.'&amp;description='.$sb_title;
//        }

        // Based on popular demand added Pinterest too
//        $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$sb_url.'&amp;media='.$sb_thumb[0].'&amp;description='.$sb_title;

        // Add sharing button at the end of page/page content
        $content .= '<div class="relative pattern"><nav class="hidden z-20 md:flex shrink-0 grow-0 flex-row justify-around gap-4 border-t border-gray-200 bg-white/50 p-2.5 shadow-lg backdrop-blur-lg fixed top-2/4 -translate-y-2/4 left-6 min-h-[auto] min-w-[64px] flex-col rounded-lg border">';
        $content .= '<a href="'.$facebookURL.'" target="_blank" rel="nofollow" class=" flex aspect-square min-h-[32px] w-16 flex-col items-center justify-center gap-1 rounded-md p-1.5 bg-indigo-50 text-indigo-600"><img src="'.$pathImg.'/facebook.png" alt=""></a>';
        $content .= '<a href="'.$linkedInURL.'" target="_blank" rel="nofollow" class=" flex aspect-square min-h-[32px] w-16 flex-col items-center justify-center gap-1 rounded-md p-1.5 bg-indigo-50 text-indigo-600"><img src="'.$pathImg.'/linkedin.png" alt=""></a>';
        $content .= '<a href="'.$twitterURL.'" target="_blank" rel="nofollow" class=" flex aspect-square min-h-[32px] w-16 flex-col items-center justify-center gap-1 rounded-md p-1.5 bg-indigo-50 text-indigo-600"><img src="'.$pathImg.'/twitter.png" alt=""></a>';
        $content .= '<a href="'.$whatsappURL.'" target="_blank" rel="nofollow" class=" flex aspect-square min-h-[32px] w-16 flex-col items-center justify-center gap-1 rounded-md p-1.5 bg-indigo-50 text-indigo-600"><img src="'.$pathImg.'/whatsapp.png" alt=""></a>';
        $content .= '<span class="flex h-16 w-16 flex-col items-center justify-center gap-1 text-fuchsia-900 dark:text-gray-400">Share</span>';
        $content .= '</nav></div>';

        return $content;

    }
    return $content;
};
// Enable the_content if you want to automatically show social buttons below your post.
add_filter( 'the_content', 'wp_social_buttons');