<?php
/*
 * Settings for after_plugin_row 
 * 
 * @plugin Network Only Plugins Tab
 */

# Busted!
!defined( 'ABSPATH' ) AND exit(
        "<pre>Hi there! I'm just part of a plugin, 
            <h1>&iquest;what exactly are you looking for?" );

$icon = isset( $value['icon'] )  ? stripslashes(  $value['icon'] ) : '';

if( $this->posted_data ):
?>
<div id="setting-error-settings_updated" class="updated settings-error"> 
<p><strong>Settings saved!!.</strong></p></div>
<?php
endif;
?>
<tr id="nopt-tr-settings" class="active">
    
    <th scope="row" class="check-column">&nbsp;</th>
    <td colspan="2">
        <a class="button-secondary" href="#" id="nopt-pluginconflink" title="<?php _e( 'Settings', 'b5f_nopt' ); ?>"><?php _e( 'Open settings', 'b5f_nopt' ); ?></a> 
    </td>
    
</tr>


<tr id="nopt_config_tr">
    
    <td colspan="3">
        <div id="nopt_config_row" class="<?php echo $config_row_class; ?>">
            
            <form method="post" name="post-nopt-form" action="">
                
                <table class="form-table nopt-table">      
                    <!-- ICON TEXT FIELD -->
                    <tr valign="top">
                        <th scope="row">
                            <label for="nopt_config-icon">
                                <?php _e( 'Icon', 'b5f_nopt' ); ?>
                            </label>
                        </th>
                        <td>
                            <input class="large-text wide-fat nopt-icon" type="text" id="nopt_config-icon" name="nopt_config-icon" value="<?php echo $icon; ?>" />
                            <br />
                            <small><?php _e( "This plugin uses <a href='http://fortawesome.github.io/Font-Awesome/cheatsheet/' target='_blank'>Font Awesome</a>, simply copy the icon or its code. This field accepts HTML too.", 'b5f_nopt' ); ?></small>
                        </td>
                    </tr>
                </table>
                <p id="submitbutton">
                    <?php
                    wp_nonce_field( plugin_basename( B5F_MNPT_FILE ), 'noncename_nopt' );
                    submit_button( __( 'Save settings', 'b5f_nopt' ), 'primary', 'nopt_config_submit' );  ?>
                </p>
            </form>
            
        </div>
    </td>
    
</tr>