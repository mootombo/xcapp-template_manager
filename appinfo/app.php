<?php

use OCP\AppFramework\App;

$app = new App('template_manager');
$container = $app->getContainer();

$l = \OCP\Util::getL10N('template_manager');

\OCP\App::registerAdmin('template_manager', 'templates/admin.settings');

$urlGenerator = $container->query('OCP\IURLGenerator');
$l10n = $container->query('OCP\IL10N');
