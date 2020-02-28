<?php
/**
 * @TODO build js file
 * @param $js
 * @return string
 */
function build_js($js) {
    $js_arr = array(
        'vendor/modernizr/modernizr-2.8.3-respond-1.4.2.min.js',
        'vendor/swiper/swiper.min.js',
        'vendor/jquery/jquery.min.js',
        'vendor/jquery/jquery.waypoints.min.js',
        'vendor/qrcode/qrcode.min.js',
        'js/common.js',
    );
    if ($js) {
        if (is_array($js)) {
            foreach ($js as $k => $v) {
                $js_arr[] = $v;
            }
        } else {
            $js_arr[] = $js;
        }
    }

    $tmpl_parse_string = C('TMPL_PARSE_STRING');

    foreach ($js_arr as $k => $v) {
        $v = ($tmpl_parse_string['__PUBLIC__']).'/'.$v.'?_v='.$tmpl_parse_string['__JSVER__'];
        echo "<script type=\"text/javascript\" src=\"{$v}\"></script>\n";
    }
}

/**
 * @TODO build css file
 * @param $css
 * @return string
 */
function build_css($css) {
    $css_arr = array(
        'css/animate.min.css',
        'vendor/swiper/swiper.min.css',
    );
    if ($css) {
        if (is_array($css)) {
            foreach ($css as $k => $v) {
                $css_arr[] = $v;
            }
        } else {
            $css_arr[] = $css;
        }
    }

    $tmpl_parse_string = C('TMPL_PARSE_STRING');

    foreach ($css_arr as $k => $v) {
        $v = ($tmpl_parse_string['__PUBLIC__']).'/'.$v.'?_v='.$tmpl_parse_string['__CSSVER__'];
        echo '<link type="text/css" rel="stylesheet" href="'.$v.'" />'."\n";
    }
}

/**
 * @TODO language url
 * @param $url
 * @param array $vars
 * @return string
 */
function LU($url = '', $vars = array()) {
    $enum = C('ENUM');

    if ($url == '/') {
        return '/'.I('get.lang');
    } else if ($url && I('get.lang') && in_array(I('get.lang'), array_keys($enum['LANG']))) {
        return U('/'.I('get.lang').$url, $vars);
    } else if (empty($url) && isset($vars['lang']) && isset($_SERVER['REQUEST_URI'])) {

        $url = preg_replace("/\/(en|cn)\//", '', $_SERVER['REQUEST_URI']);

        if ($url == '/cn' || $url == '/en') {
            $url = '';
        }

        return str_replace('//', '/', '/'.$vars['lang'].'/'.$url);
    }
    return U($url, $vars);
}

/**
 * @TODO build body class name
 * @param $class_name
 * @return string
 */
function body_class($class_name) {
    $return = '';
    if ($class_name) {
        $return = ' class="';

        if (is_array($class_name)) {
            $return .= implode(' ', $class_name);
        } else {
            $return .= $class_name;
        }

        $return .= '"';
    }
    return $return;
}