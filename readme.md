## DebugHub.com client

The project is under development, not ready for public eyes yet. If you are interested, shoot a email to info@debughub.com

Installation:
For now laravel 5.x only.
1. add this to composer.json
`"debughub/client": "dev-master"`

2. Add service provider to config/app.php file
`Debughub\Client\DebughubServiceProvider::class`

3. create new config file in config dir with content:
`<?php
return [
    'api_key' => '',
    'project_key' => '',
    'git_root' => '',
    'enabled' => true,
    'blacklist_params' => [
        'password'
    ]  
];`
