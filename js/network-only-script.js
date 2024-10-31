/**
 * Script actions 
 * 
 * @plugin Network Only Plugins Tab
 */
jQuery(document).ready( function($)
{	
    /* Remove separator */
    $('.nopt-icon').each(function(){
	var par_text = $(this).parent().html();
	var rep = par_text.replace('|','');
        $(this).parent().html(rep);
    });
    
    /* Toggle settings */
    $('#nopt-pluginconflink').click(function(e)
    { 
        e.preventDefault(); 
        if( $('#nopt_config_row').is(':visible') )
            $(this).text(nopt_ajax_vars.open_btn);
        else
            $(this).text(nopt_ajax_vars.close_btn);
        
        $('#nopt_config_row').slideToggle(); 
    });
});