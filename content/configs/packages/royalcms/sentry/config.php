<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array(
    'dsn' => 'https://b2c10a92d0c14f6f96c493d756da054e:5d6b5db85c794cd185671fa8a4c5c807@sentry.io/107014',

    // capture release as git sha
    'release' => trim(exec('git log --pretty="%h" -n1 HEAD')),

    // Capture bindings on SQL queries
    'breadcrumbs.sql_bindings' => true,
);
