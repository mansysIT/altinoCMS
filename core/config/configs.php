<?php

if(!defined('DS')) define('DS', '/');

$AbsoluteURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
$AbsoluteURL .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
$slash = substr($AbsoluteURL, -1);
$NewURL = $slash != '/' ? $AbsoluteURL.'/' : $AbsoluteURL;

define('SERVER_ADDRESS', $NewURL);

/**
 * USTAWIENIA KOMPRESORA CSS
 * @param   cscript_comressor_enabled   bool        Kompresja włączona/wyłączona: true | false
 */

$configs['cscript_comressor_enabled']                          = true;

$configs['cscript_filter_import_imports']                      = false;
$configs['cscript_filter_remove_comments']                     = true;
$configs['cscript_filter_remove_empty_rulesets']               = true;
$configs['cscript_filter_remove_empty_at_blocks']              = true;
$configs['cscript_filter_convert_level_3at_keyframes']         = false;
$configs['cscript_filter_convert_level_3properties']           = false;
$configs['cscript_filter_variables']                           = true;
$configs['cscript_filter_remove_last_delaration_semi_colon']   = true;

$configs['cscript_plugin_variables']                           = true;
$configs['cscript_plugin_convert_font_weight']                 = true;
$configs['cscript_plugin_convert_hsl_colors']                  = true;
$configs['cscript_plugin_convert_rgb_colors']                  = true;
$configs['cscript_plugin_convert_named_colors']                = true;
$configs['cscript_plugin_compress_color_values']               = true;
$configs['cscript_plugin_compress_unit_values']                = false;
$configs['cscript_plugin_compress_expression_values']          = false;

/**
 * USTAWIENIA KOMPRESORA JAVASCRIPT
 * @param   jscript_comressor_enabled   bool        Kompresja włączona/wyłączona: true | false
 * @param   jscript_comressor_type      string      Nazwa modułu kompresującego kod JS: jShrink | JavaScriptPacker. 
 * Po wybraniu jShrink opcje: 'jscript_encoding', 'jscript_fast_decode', 'jscript_special_chars' nie mają zastosowania.
 * @param   jscript_encoding            int         Kodowanie: 0 - Brak | 10 - Numeric | 62 - Normal | 95 - High ASCII
 * @param   jscript_fast_decode         bool        Kompresja w locie: true | false
 * @param   jscript_special_chars       bool        Kompresja z uwzględnieniem znaków specjalnych: true | false
 */

$configs['jscript_comressor_enabled'] = true;

$configs['jscript_comressor_type'] = "jShrink";
$configs['jscript_encoding'] = 62;
$configs['jscript_fast_decode'] = true;
$configs['jscript_special_chars'] = false;

/**
 * USTAWIENIA JĘZYKOWE
 */
 
$configs['default_session_var'] = 'lang';
$configs['default_lang'] = 'pl';

/**
 * USTAWIENIA SYSTEMU - PODSTAWOWE
 */
 
$configs['default_controller'] = "home";

/**
 * USTAWIENIA SYSTEMU - ZAAWANSOWANE
 */

$configs['no_lang_action'] = "SET_ERROR_TEXT";						// SET_404, SET_ERROR_TEXT
$configs['no_lang_error_text'] = "Brak dostępnego tłumaczenia";
$configs['default_meta_tags_index'] = "default";
$configs['default_session_auth_var'] = 'login';
$configs['default_session_admin_auth_var'] = 'admin_login';
$configs['default_session_admin_priv_var'] = 'admin_priv';

/**
 * USTAWIENIA SYSTEMU - ŚCIEŻKI KATALOGÓW
 */
 
$configs['images_catalog_name'] = "images";
$configs['javascript_catalog_name'] = "js";
$configs['stylesheet_catalog_name'] = "css";
$configs['fonts_catalog_name'] = "fonts";

$configs['controller_path'] = "application".DS."controllers".DS;
$configs['model_path'] = "application".DS."models".DS;
$configs['view_path'] = "application".DS."views".DS;
$configs['media_path'] = "application".DS."media".DS;
$configs['module_path'] = "application".DS."library".DS;

$configs['app_images_path'] = "application".DS."media".DS.$configs['images_catalog_name'].DS;
$configs['app_javascript_path'] = "application".DS."media".DS.$configs['javascript_catalog_name'].DS;
$configs['app_stylesheet_path'] = "application".DS."media".DS.$configs['stylesheet_catalog_name'].DS;
$configs['app_fonts_path'] = "application".DS."media".DS.$configs['fonts_catalog_name'].DS;

$configs['helper_path'] = "core".DS."helpers".DS;
$configs['library_path'] = "core".DS."library".DS;
$configs['driver_path'] = "core".DS."drivers".DS;

/**
 * USTAWIENIA SYSTEMU - BAZA DANYCH
 */

$configs['db_host'] = "localhost";
$configs['db_user'] = "root";
$configs['db_pass'] = "";
$configs['db_name'] = "bouw_BD";

?>