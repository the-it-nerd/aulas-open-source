<?php
return [
    'cache' => [
        'frontend' => [
            'default' => [
                'backend' => 'Cm_Cache_Backend_Redis',
                'backend_options' => [
                    'server' => 'redis',
                    'port' => '6379',
                    'database' => 1,
                    '_useLua' => true,
                    'use_lua' => false
                ],
                'id_prefix' => 'f53_'
            ],
            'page_cache' => [
                'backend' => 'Cm_Cache_Backend_Redis',
                'backend_options' => [
                    'server' => 'redis',
                    'port' => '6379',
                    'database' => 2
                ],
                'id_prefix' => 'f53_'
            ]
        ],
        'graphql' => [
            'id_salt' => 'tsfRiBkYDWaNWMehqXTekP5IfktUQIr8'
        ],
        'allow_parallel_generation' => false
    ],
    'MAGE_MODE' => 'developer',
    'cron' => [
        'enabled' => 0
    ],
    'remote_storage' => [
        'driver' => 'file'
    ],
    'backend' => [
        'frontName' => 'admin'
    ],
    'config' => [
        'async' => 0
    ],
    'queue' => [
        'consumers_wait_for_messages' => 0
    ],
    'crypt' => [
        'key' => 'base64hV4+agYEaldnMH4zrTurnZRP16X0AHaf8qw45vgW26Q='
    ],
    'db' => [
        'connection' => [
            'default' => [
                'host' => 'db',
                'username' => 'magento2',
                'dbname' => 'magento2',
                'password' => 'magento2',
                'model' => 'mysql4',
                'engine' => 'innodb',
                'initStatements' => 'SET NAMES utf8;',
                'active' => '1',
                'driver_options' => [
                    1014 => false
                ]
            ],
            'indexer' => [
                'host' => 'db',
                'username' => 'magento2',
                'dbname' => 'magento2',
                'password' => 'magento2'
            ]
        ],
        'table_prefix' => ''
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'session' => [
        'save' => 'redis',
        'redis' => [
            'host' => 'redis',
            'port' => '6379',
            'database' => 0,
            'disable_locking' => 1
        ]
    ],
    'lock' => [
        'provider' => 'db',
        'config' => [
            'prefix' => ''
        ]
    ],
    'directories' => [
        'document_root_is_pub' => true
    ],
    'cache_types' => [
        'config' => 1,
        'layout' => 1,
        'block_html' => 1,
        'collections' => 1,
        'reflection' => 1,
        'db_ddl' => 1,
        'compiled_config' => 1,
        'eav' => 1,
        'customer_notification' => 1,
        'config_integration' => 1,
        'config_integration_api' => 1,
        'graphql_query_resolver_result' => 1,
        'full_page' => 1,
        'config_webservice' => 1,
        'translate' => 1
    ],
    'downloadable_domains' => [
        'magento2.docker'
    ],
    'install' => [
        'date' => 'Fri, 11 Apr 2025 01:20:34 +0000'
    ],
    'static_content_on_demand_in_production' => 0,
    'force_html_minification' => 1,
    'cron_consumers_runner' => [
        'cron_run' => false,
        'max_messages' => 10000,
        'consumers' => [

        ],
        'multiple_processes' => [

        ]
    ],
    'system' => [
        'default' => [
            'catalog' => [
                'search' => [
                    'engine' => 'opensearch',
                    'opensearch_server_hostname' => 'opensearch',
                    'opensearch_server_port' => '9200'
                ]
            ]
        ]
    ],
    'http_cache_hosts' => [
        [
            'host' => 'varnish'
        ]
    ]
];
