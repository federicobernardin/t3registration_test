<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
$tempColumns = array (
	'tx_t3registrationtest_select' => array (
		'exclude' => 0,		
		'label' => 'LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_select',
		'config' => array (
			'type' => 'select',
			'items' => array (
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_select.I.0', 'value1'),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_select.I.1', 'value2'),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_select.I.2', 'value3'),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_select.I.3', 'value4'),
			),
			'size' => 1,	
			'maxitems' => 1,
		)
	),
    'tx_t3registrationtest_select_foreign' => array (
        'exclude' => 0,
        'label' => 'LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_select_foreign',
        'config' => array (
            'type' => 'select',
            'items' => array (
            ),
            'foreign_table' => 'fe_users',
            'size' => 1,
            'maxitems' => 1,
        )
    ),
	'tx_t3registrationtest_radio' => array (
		'exclude' => 0,		
		'label' => 'LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_radio',
		'config' => array (
			'type' => 'radio',
			'items' => array (
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_radio.I.0', 'valueradio1'),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_radio.I.1', 'valueradio2'),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_radio.I.2', 'valueradio3'),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_radio.I.3', 'valueradio4'),
			),
		)
	),
	'tx_t3registrationtest_check' => array (
		'exclude' => 0,		
		'label' => 'LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_check',
		'config' => array (
			'type' => 'check',
		)
	),
	'tx_t3registrationtest_checkmultiple' => array (
		'exclude' => 0,		
		'label' => 'LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_checkmultiple',
		'config' => array (
			'type' => 'check',
			'cols' => 4,
			'items' => array (
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_checkmultiple.I.0', ''),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_checkmultiple.I.1', ''),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_checkmultiple.I.2', ''),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_checkmultiple.I.3', ''),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_checkmultiple.I.4', ''),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_checkmultiple.I.5', ''),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_checkmultiple.I.6', ''),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_checkmultiple.I.7', ''),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_checkmultiple.I.8', ''),
				array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_checkmultiple.I.9', ''),
			),
		)
	),
    'tx_t3registrationtest_procFunc' => array (
        'exclude' => 0,
        'label' => 'LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_procFunc',
        'config' => array (
            'type' => 'radio',
            'items' => array (
                array('LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_procFunc.I.0', ''),
            ),
            'itemsProcFunc' => 'EXT:test_t3registration/library/class.tx_t3registrationtest_tca.php:tx_t3registrationtest_tca->getProcFunc'
        )
    ),
    'tx_t3registrationtest_date' => array (
        'exclude' => 0,
        'label' => 'LLL:EXT:test_t3registration/locallang_db.xml:backend_layout.tx_t3registrationtest_date',
        'config' => array (
            'type' => 'input',
            'eval' => 'trim,date'
        )
    ),
);


t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('fe_users','tx_t3registrationtest_select;;;;1-1-1, tx_t3registrationtest_radio, tx_t3registrationtest_check, tx_t3registrationtest_checkmultiple,tx_t3registrationtest_procFunc,tx_t3registrationtest_date');
?>