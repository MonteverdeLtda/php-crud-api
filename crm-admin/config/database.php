<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */

/* CONFIGURACION TABLAS y DB */
define("DB_driver", "mysql");
define("DB_host", "localhost");
define("DB_user", "admin_crm-curl");
define("DB_pass", "admin_crm-curl");
define("DB_database", "admin_crm-curl");
define("DB_charset", "utf8");
define("DB_port", "3306");
/* TABLAS */
define('TBL_PERMISSIONS', 'permissions');
define('TBL_T_IDENTIFICATIONS', 'types_identifications');
define('TBL_USERS', 'users_login');
define('TBL_USERS_C_USERNAME', 'username');
define('TBL_USERS_C_PASSWORD', 'password');
define('TBL_USERS_R_C', '');
define('TBL_PICTURES', 'pictures');

/* CONFIGURACION DE LA API */
define("API_openApiBase", '{"info":{"title":"API-REST","version":"2.0.0"}}');
define("API_controllers", 'records,columns,openapi,geojson,cache');
define("API_middlewares", 'cors,dbAuth,authorization,sanitation,ipAddress,pageLimits,validation,multiTenancy,customization'); // => Disabled jwtAuth, xsrf
define("API_dbAuth_mode", 'required');
define("API_dbAuth_usersTable", TBL_USERS);
define("API_dbAuth_usernameColumn", TBL_USERS_C_USERNAME);
define("API_dbAuth_passwordColumn", TBL_USERS_C_PASSWORD);
define("API_dbAuth_returnedColumns", TBL_USERS_R_C);
define("API_xsrf_cookieName", 'CRM-XSRF-TOKEN');
define("API_xsrf_headerName", 'CRM-XSRF-TOKEN');
