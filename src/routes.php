<?php

// ROUTAGE STATIQUE
Core\Router::connect("/", ["controller" => "app", "action" => "index"]);
Core\Router::connect("/register", ["controller" => "user", "action" => "add"]);
Core\Router::connect('/user/{id}', ['controller' => 'user', 'action' => 'show']);
Core\Router::connect('/show', ['controller' => 'user', 'action' => 'article']);