<?php
    /**
     * Created by JetBrains PhpStorm.
     * User: federico
     * Date: 07/08/12
     * Time: 10:37
     * To change this template use File | Settings | File Templates.
     */
class tx_t3registrationtest_tca {

    public function getProcFunc($config) {
        global $TCA;

        t3lib_div::loadTCA('fe_users');
        foreach ($TCA['fe_users']['columns'] as $key => $item) {
            $config['items'][] = array($key, $key);
        }


        return $config;
    }
}
