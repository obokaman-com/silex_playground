<?php
// configure your app for the production environment
$app['twig.path']      = [__DIR__ . '/../../src/OboPlayground/Infrastructure/UI/views'];
$app['twig.options']   = ['cache' => __DIR__ . '/../cache/twig'];
