<?php

function smarty_gettext_strarg($str)
{
    $tr = array();
    $p = 0;

    for ($i = 1; $i < func_num_args(); $i++) {
        $arg = func_get_arg($i);

        if (is_array($arg)) {
            foreach ($arg as $aarg) {
                $tr['%' . ++$p] = $aarg;
            }
        } else {
            $tr['%' . ++$p] = $arg;
        }
    }

    return strtr($str, $tr);
}

function smarty_block_t($params, $text, &$smarty)
{
    $text = stripslashes($text);

    // set escape mode
    if (isset($params['escape'])) {
        $escape = $params['escape'];
        unset($params['escape']);
    }

    // set plural version
    if (isset($params['plural'])) {
        $plural = $params['plural'];
        unset($params['plural']);

        // set count
        if (isset($params['count'])) {
            $count = $params['count'];
            unset($params['count']);
        }
    }

    require_once "Ec/Lang.php";
    $text = Ec_Lang::getInstance()->translate($text);


    if (count($params)) {
        $text = smarty_gettext_strarg($text, $params);
    }

    if (!isset($escape) || $escape == 'html') {
        $text = nl2br(htmlspecialchars($text));
    } elseif (isset($escape)) {
        switch ($escape) {
            case 'javascript':
            case 'js':
                // javascript escape
                $text = str_replace('\'', '\\\'', stripslashes($text));
                break;
            case 'url':
                // url escape
                $text = urlencode($text);
                break;
        }
    }

    return $text;
}