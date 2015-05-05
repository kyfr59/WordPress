jQuery(function($){
    (function(){
        var selectedVal = $('#page_template').val();
        if(selectedVal == 'portfolio-template.php'){
            $('#pg_portfolio_style, #pg_portfolio_taxonomies').closest('.rwmb-field').show();
            $('#pg_sidebar_description').closest('.rwmb-field').hide();
        }else{
            $('#pg_portfolio_style, #pg_portfolio_taxonomies').closest('.rwmb-field').hide();
            $('#pg_sidebar_description').closest('.rwmb-field').show();
        }
    })();
    $(document).on('change', '#page_template', function(){
        var selectedVal = $(this).val();
        if(selectedVal == 'portfolio-template.php'){
            $('#pg_portfolio_style, #pg_portfolio_taxonomies').closest('.rwmb-field').show();
            $('#pg_sidebar_description').closest('.rwmb-field').hide();
        }else{
            $('#pg_portfolio_style, #pg_portfolio_taxonomies').closest('.rwmb-field').hide();
            $('#pg_sidebar_description').closest('.rwmb-field').show();
        }
    });
});