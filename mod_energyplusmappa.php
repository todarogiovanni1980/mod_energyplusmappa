<?php

defined('_JEXEC') or die;

$doc = JFactory::getDocument();

// Include assets
$doc->addStyleSheet(JURI::root()."modules/mod_energyplusmappa/assets/css/style.css");
$doc->addScript(JURI::root()."modules/mod_energyplusmappa/assets/js/script.js");

require JModuleHelper::getLayoutPath('mod_energyplusmappa', $params->get('layout', 'default'));