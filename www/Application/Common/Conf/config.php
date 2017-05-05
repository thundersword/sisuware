<?php

return array(

    //'配置项'=>'配置值'

    // 'SHOW_PAGE_TRACE' => true,

    'TMPL_L_DELIM'=>'<{',

    'TMPL_R_DELIM'=>'}>',

    'DB_TYPE'               =>  'mysql',     // 数据库类型

    'DB_HOST'               =>  env('MYSQL_PORT_3306_TCP_ADDR', 'mysql'), // 服务器地址

    'DB_NAME'               =>  env('MYSQL_INSTANCE_NAME', 'sisuware'),          // 数据库名

    'DB_USER'               =>  env('MYSQL_USERNAME', 'root'),      // 用户名

    'DB_PWD'                =>  env('MYSQL_PASSWORD', 'root'),   // 密码

    'DB_PORT'               =>  '3306',      // 端口

    'DB_PREFIX'             =>  'sisu_',    // 数据库表前缀

);
