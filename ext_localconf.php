<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'BLSV.' . $_EXTKEY,
	'Navsoapinterfacetest',
	array(
		'Xml' => 'list, get, show, new, create, edit, update',
		
	),
	// non-cacheable actions
	array(
		'Xml' => 'list, get, show, new, create, edit, update',
		
	)
);

?>