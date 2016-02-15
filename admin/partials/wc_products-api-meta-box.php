<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://triple3studios.com
 * @since      1.0.0
 *
 * @package    Wc_products
 * @subpackage Wc_products/admin/partials
 */
?>

<input type="hidden" id="wc_products_token" name="wc_products_token" value="<?php echo $token; ?>">

<div id="wc_products_api_results">
    
    <table>
        <tr>
            <td>Product URL</td>
            <td>
                <input type="text" size="80" id="wc_products_pageUrl_input" name="wc_products_pageUrl_input" value="<?php echo $pageUrl; ?>" />
                
                <?php if(!empty($pageUrl)): ?>
                    <a href="<?php echo $pageUrl; ?>" target="_new" class="button button-primary button-large">
                        <span class="dashicons wc_products_search"></span>
                    </a>
                <?php endif; ?>
                
                <input type="button" id="wc_products_diffbot" name="wc_products_diffbot" value="Diffbot!" class="button button-primary button-large" />
                <span class="spinner"></span>
                
            </td>
        </tr>
        <tr>
            <td>Offer Price</td>
            <td><input type="text" id="wc_products_offerPrice_input" name="wc_products_offerPrice_input" value="<?php echo $offerPrice; ?>"/></td>
        </tr>
        <tr>
            <td>Regular Price</td>
            <td><input type="text" id="wc_products_regularPrice_input" name="wc_products_regularPrice_input"  value="<?php echo $regularPrice; ?>" /></td>
        </tr>
    </table>
    
</div>

<div id="wc_products_api_status"></div>