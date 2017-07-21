

<!--<div id="esig-gravity-addon-fallback-modal" style="display: none;"> -->

        <?php if(!class_exists('GFForms')) : ?>
        
        
        <div class="error"><span class="icon-esig-alert"></span><h4>Gravity Forms plugin is not installed. Please install Gravity Form version 1.9.2 or greater - <a href="http://aprv.me/1TAspLi">Get it here now</a></h4></div>
        
        
        <?php endif ; 
        
        if(!function_exists("WP_E_Sig")):

        ?>
        
          <div class="error"> <h4>WP E-Signature is not installed. &nbsp; It is required to run the Gravity Forms Signature add-on. &nbsp;Get your business license now  - <a href="https://www.approveme.com/?utm_source=wprepo&utm_medium=link&utm_campaign=gravityforms">http://aprv.me</a></h4></div>
        
        <?php 
        endif; 
        
        if(!class_exists('ESIG_SAD_Admin')) :
        
        ?>
        <div class="error"><span class="icon-esig-alert"></span><h4>WP E-Signature <a href="https://www.approveme.com/downloads/stand-alone-documents/?utm_source=wprepo&utm_medium=link&utm_campaign=gravityforms" target="_blank">"Stand Alone Documents"</a> Add-on is not installed. Please install WP E-Signature Stand Alone Documents - version 1.2.5 or greater.  </h4></div>
        
        <?php endif; 
        
        ?>

<!-- </div>-->