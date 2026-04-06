<?php

const pageDir = __DIR__ . '/tpls/components/page/';
const TPL_HEA = pageDir . 'header.tpl';
const TPL_FOO = pageDir . 'footer.tpl';

const TPL_PLACEHOLDER_PATTERN = '{{::%s::}}';

require_once __DIR__ . '/utils.php';

function getHtml(string $fileName, array $data): string
{
    if (!is_readable($fileName))
    {
        echo "The file " . $fileName . " is not readable";
        exit();
    }

    $html = file_get_contents($fileName);
    if ($html === false)
    {
        echo "Error to open " . $fileName;
        exit();
    }

    foreach ($data as $key => $value)
    {
        $placeholder = sprintf(TPL_PLACEHOLDER_PATTERN, $key);
        $html = str_replace($placeholder, (string)$value, $html);
    }
    return $html;
}

function showTPL(string $page, string $content)
{
    $arr = getArrayData($page);

    $html = getHtml(TPL_HEA, $arr);
    $html .= $content;
    $html .= getHtml(TPL_FOO, []);

    echo $html;
    exit();
}