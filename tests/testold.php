<?php
/**
 * Created by JetBrains PhpStorm.
 * User: federico
 * Date: 21/11/12
 * Time: 16:52
 * To change this template use File | Settings | File Templates.
 */

require_once('bootstrap.php');
require_once('configuration.php');
//require_once(PATH_t3lib . 'core_autoload.php');
//require_once(PATH_t3lib . 'class.t3lib_userauthgroup.php');
//require_once(PATH_t3lib . 'class.t3lib_userauthgroup.php');

$GLOBALS['classRegistry'] = createCoreAndExtensionRegistry();

print_r($GLOBALS['classRegistry']);

spl_autoload_register('splFunction', TRUE, TRUE);

function splFunction($class){
    $class= strtolower($class);
    echo('included class ' .$class . ': ' . $GLOBALS['classRegistry'][$class]);
    require_once($GLOBALS['classRegistry'][$class]);
}
$GLOBALS['TT'] = new t3lib_timeTrackNull();
$GLOBALS['TYPO3_DB'] = t3lib_div::makeInstance('t3lib_DB');
//$GLOBALS['TYPO3_DB']->debugOutput = $TYPO3_CONF_VARS['SYS']['sqlDebug']


$GLOBALS['TSFE'] = t3lib_div::makeInstance('tslib_fe', $GLOBALS['TYPO3_CONF_VARS'], 0, 0);
$GLOBALS['TSFE']->config = array();
$GLOBALS['TSFE']->initTemplate();
$GLOBALS['TSFE']->sys_page = t3lib_div::makeInstance('t3lib_pageSelect');
tslib_eidtools::connectDB();

function createCoreAndExtensionRegistry() {
    $classRegistry = require(PATH_t3lib . 'core_autoload.php');
    // At this point localconf.php was already initialized
    // we have a current extList and extMgm is also known
    $loadedExtensions = array_unique(t3lib_div::trimExplode(',', t3lib_extMgm::getEnabledExtensionList(), TRUE));
    foreach ($loadedExtensions as $extensionKey) {
        $extensionAutoloadFile = t3lib_extMgm::extPath($extensionKey, 'ext_autoload.php');
        if (file_exists($extensionAutoloadFile)) {
            $classRegistry = array_merge($classRegistry, require($extensionAutoloadFile));
        }
    }
    return $classRegistry;
}

foreach($t3libClasses as $item){
    require_once($item);
}


class T3RegistrationTest extends tx_t3registration_pi1{

    public $externalPiVars;

    public $externalConf;

    public $externalFields;

    public function init(){
        parent::init();
        $this->piVars = array_merge($this->piVars,$this->externalPiVars);
        $this->conf = array_merge($this->conf,$this->externalConf);
    }

    public function evaluateTest($value, $evaluationRule, $field = array()){
        return $this->evaluateField($value, $evaluationRule, $field);
    }

}

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'] = array();
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'] = array();
$pippo = new T3RegistrationTest();
$pippo->cObj = new tslib_cObj();
$pippo->cObj->start($tt_contentData);
echo($pippo->main('',array()));