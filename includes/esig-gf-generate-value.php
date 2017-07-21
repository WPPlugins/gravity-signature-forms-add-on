<?php

if (!class_exists('ESIG_GF_VALUE')):

    abstract class ESIG_GF_VALUE {

        public static function generate_value($formid, $field_id, $entry_id) {
            $form = GFAPI::get_form($formid);
            $field = GFFormsModel::get_field($form, $field_id);
            $lead = GFAPI::get_entry($entry_id);
            return self::get_default_value($lead, $field, $form, $field_id);
        }

        public static function get_field_type($formid,$field_id){
             $form = GFAPI::get_form($formid);
             $field = GFFormsModel::get_field($form, $field_id);
             return esigget('type',$field);
        }


        public static function get_html($entries, $field, $field_id, $forms) {
            $html = '';
            if (!empty($field->content)) {
                $content = GFCommon::replace_variables_prepopulate($field->content); // adding support for merge tags
                $content = do_shortcode($content); // adding support for short
                $html .= $content;
            }
            
                $html .= str_replace('{FIELD}','', GF_Fields::get('html')->get_field_content($entries[$field_id], true, $forms));
           
            return $html;
        }
        
        public static function remove_map_it($result){
            return true;
        }

        public static function get_address($lead, $field, $field_id, $form){
                    add_filter("gform_disable_address_map_link",array(__CLASS__,"remove_map_it"),10,1);
                    $value = RGFormsModel::get_lead_field_value($lead, $field);
                    $display_value = GFCommon::get_lead_field_display($field, $value, $lead['currency']);
                    return apply_filters('gform_entry_field_value', $display_value, $field, $lead, $form);
        }
       
        public static function get_default_value($lead, $field, $form, $field_id) {

            //make a condition to check input field
            $type = esigget('type',$field);
            switch ($type):

                case "html":
                    return self::get_html($lead, $field, $field_id, $form);
                case "address":
                    return self::get_address($lead, $field, $field_id, $form);
                default:
                     
                    $value = RGFormsModel::get_lead_field_value($lead, $field);
                    $display_value = GFCommon::get_lead_field_display($field, $value, $lead['currency']);
                    return apply_filters('gform_entry_field_value', $display_value, $field, $lead, $form);
            endswitch;
        }

        public static function display_value($display, $document_id) {

            $display_type = ESIG_GF_SETTINGS::get_display_feed($document_id);
            if ($display_type == "underline") {
                return "<u>" . $display . "</u>";
            } else {
                return $display;
            }
        }

    }

endif;