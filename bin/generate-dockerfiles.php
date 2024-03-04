#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * How to use the script:
 *    ./bin/generate-dockerfiles.php [swoole-version|swoole-branch]
 *    e.g.,
 *    ./bin/generate-dockerfiles.php 4.3.6
 *    ./bin/generate-dockerfiles.php latest
 * Above command will have dockerfiles created for Swoole 4.3.6 under folder images/dockerfiles/.
 */

use Swoole\Docker\Dockerfile;

require_once dirname(__DIR__) . '/vendor/autoload.php';

(new Dockerfile($argv[1]))->render();
