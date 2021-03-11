<?php

namespace Modelagem\Config;

putenv('DISPLAY_ERRORS_DETAILS=' . true);

putenv('DB_HOST=modelagem_db');
putenv('DB_PORT=3306');
putenv('DB_USER=ufjf');
putenv('DB_PASS=password');
putenv('DB_NAME=modelagem');

putenv('SYS=LICITACAO');
putenv('SYS_NAME=Licitação');

putenv('JWT_SECRET_KEY=superjwtnotsecretkey');
putenv('DATE_FORMAT=Y-m-d H:i:s');
