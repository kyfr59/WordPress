jQuery(function($){
    (function(){
        var selectedVal = $('#post-formats-select .post-format:checked').val();
        if(selectedVal == '0'){
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url').closest('.rwmb-field').hide();
        } else if(selectedVal == 'video'){
            $('#pt_quote_text, #pt_audio_files, #pt_quote_author, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
        } else if(selectedVal == 'quote'){
            $('#pt_video_url, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
        } else if(selectedVal == 'audio'){
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
        } else if(selectedVal == 'gallery'){
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
        }else if(selectedVal == 'link'){
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
        }
    })();
    
    $('#post-formats-select .post-format').change(function(){
        var selectedVal = $(this).val();
        if(selectedVal == '0'){
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url').closest('.rwmb-field').hide();
            $('.rwmb-heading-wrapper h4').closest('.rwmb-field').show();
        } else if(selectedVal == 'video'){
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
            $('#pt_video_url').closest('.rwmb-field').show();
        } else if(selectedVal == 'quote'){
            $('#pt_video_url, #pt_quote_text, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
            $('#pt_quote_text, #pt_quote_author').closest('.rwmb-field').show();
        } else if(selectedVal == 'audio'){
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
            $('#pt_audio_files').closest('.rwmb-field').show();
        } else if(selectedVal == 'gallery'){
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
            $('#pt_gallery_images_description').closest('.rwmb-field').show();
        } else if(selectedVal == 'link'){
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description').closest('.rwmb-field').hide();
            $('#pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').show();
        }
    });
});