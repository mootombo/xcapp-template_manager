<?php

namespace OCA\template_manager;

\OCP\Util::addStyle('template_manager', 'style');
\OCP\Util::addScript('template_manager', 'settings');

$tmpl = new \OCP\Template('template_manager', 'part.admin');

return $tmpl->fetchPage();
