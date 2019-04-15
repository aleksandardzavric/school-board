<?php

  require_once 'database.php';
  require_once 'config/database.php';

  new Database($config['db']);
