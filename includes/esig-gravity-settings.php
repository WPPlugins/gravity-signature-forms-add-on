<?php

if (!class_exists('ESIG_GF_SETTINGS')):

    class ESIG_GF_SETTINGS {

        const GF_COOKIE = 'esig-gravity-temp-data';
        const GF_FORM_ID_META = 'esig_gravity_form_id';
        const GF_ENTRY_ID_META = 'esig_gravity_entry_id';
        const GF_DISPLAY_FEED ='esig_gf_display_feed';
        
        public static function get_display_feed($document_id){
            return WP_E_Sig()->meta->get($document_id,  self::GF_DISPLAY_FEED);
        }

        public static function save_display_feed($document_id,$display_feed){
            WP_E_Sig()->meta->add($document_id,  self::GF_DISPLAY_FEED,$display_feed);
        }

        public static function get_temp_settings(){
             if(ESIG_COOKIE(self::GF_COOKIE))
             {
                 return json_decode(stripslashes(ESIG_COOKIE(self::GF_COOKIE)),true);
             }
             return false;
        }
        
        public static function save_temp_settings($value){
            $json = json_encode($value);
            esig_setcookie(self::GF_COOKIE,  $json ,600);
            // for instant cookie load. 
            $_COOKIE[self::GF_COOKIE] = $json;
        }
        
        public static function delete_temp_settings(){
            esig_unsetcookie(self::GF_COOKIE);
        }


        public static function is_gf_esign_required(){
            if(self::get_temp_settings()){
                return true;
            }
            else {
                return false;
            }
        }
        
        public static function save_esig_gf_meta($meta_key, $meta_index, $meta_value) {
            
            $temp_settings = self::get_temp_settings();
            if (!$temp_settings) {
                $temp_settings= array();
                $temp_settings[$meta_key] = array($meta_index => $meta_value);
                // finally save slv settings . 
                self::save_temp_settings($temp_settings);
            } else {
                
                if (array_key_exists($meta_key, $temp_settings)) {
                    $temp_settings[$meta_key][$meta_index] = $meta_value;
                    self::save_temp_settings($temp_settings);
                } else {
                    $temp_settings[$meta_key] = array($meta_index => $meta_value);
                    self::save_temp_settings($temp_settings);
                }
            }
        }
        
        public static function get_esig_gf_meta($meta_key, $meta_index) {
            $temp_settings = self::get_temp_settings();
            
            if (is_array($temp_settings)) {
                if(!array_key_exists($meta_key,$temp_settings)){
                    return false;
                }
                if (array_key_exists($meta_index, $temp_settings[$meta_key])) {
                    return $temp_settings[$meta_key][$meta_index];
                }
            }
            return false;
        }

        
        public static function is_gravity_requested_agreement($document_id){
             $gf_form_id = WP_E_Sig()->meta->get($document_id,  self::GF_FORM_ID_META);
             $gf_entry_id = WP_E_Sig()->meta->get($document_id,  self::GF_ENTRY_ID_META);
             if($gf_form_id && $gf_entry_id){
                 return true;   
             }
             return false;
        }
        
        public static function get_invite_url($invite_hash){
              $document_checksum = WP_E_Sig()->document->document_checksum_by_id(WP_E_Sig()->invite->getdocumentid_By_invitehash($invite_hash));
              return WP_E_Sig()->invite->get_invite_url($invite_hash,$document_checksum);
        }
        
        
    }

    
     
 endif;