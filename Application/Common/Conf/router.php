<?php

/**
 * 路由
 */
return array(
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES' => array(
        '/^country\/([A-Za-z0-9_]+)$/' => 'country/index?id=:1',
        '/^city\/([A-Za-z0-9_]+)$/' => 'city/index?id=:1',
        '/^building\/([A-Za-z0-9_]+)$/' => 'building/index?id=:1',
        '/^presale\/([A-Za-z0-9_]+)$/' => 'presale/index?id=:1',
        '/^(cn|en)\/country\/([A-Za-z0-9_]+)$/' => 'country/index?lang=:1&id=:2',
        '/^(cn|en)\/city\/([A-Za-z0-9_]+)$/' => 'city/index?lang=:1&id=:2',
        '/^(cn|en)\/building\/([A-Za-z0-9_]+)$/' => 'building/index?lang=:1&id=:2',
        '/^(cn|en)\/presale\/([A-Za-z0-9_]+)$/' => 'presale/index?lang=:1&id=:2',
        '/^(cn|en)\/city\/presales\/id\/([A-Za-z0-9_]+)$/' => 'city/presales?lang=:1&id=:2',
        '/^(cn|en)\/city\/buildings\/id\/([A-Za-z0-9_]+)$/' => 'city/buildings?lang=:1&id=:2',

        '/^en$/' => ':1?lang=en',
        '/^en\/(.*?)$/' => ':1?lang=en',
        '/^cn$/' => ':1?lang=cn',
        '/^cn\/(.*?)$/' => ':1?lang=cn',

    )
);