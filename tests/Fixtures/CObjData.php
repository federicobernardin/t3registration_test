<?php
/**
 * Created by JetBrains PhpStorm.
 * User: federico
 * Date: 21/11/12
 * Time: 17:05
 * To change this template use File | Settings | File Templates.
 */

$tt_contentData = array (
    'uid' => '598',
    'pid' => '339',
    't3ver_oid' => '0',
    't3ver_id' => '0',
    't3ver_wsid' => '0',
    't3ver_label' => '',
    't3ver_state' => '0',
    't3ver_stage' => '0',
    't3ver_count' => '0',
    't3ver_tstamp' => '0',
    't3ver_move_id' => '0',
    't3_origuid' => '0',
    'tstamp' => '1352283479',
    'crdate' => '1327511199',
    'cruser_id' => '2',
    'hidden' => '0',
    'sorting' => '300',
    'CType' => 'list',
    'header' => 'T3 Registration with Double Optin',
    'header_position' => '',
    'bodytext' => '',
    'image' => '',
    'imagewidth' => '0',
    'imageorient' => '0',
    'imagecaption' => '',
    'imagecols' => '1',
    'imageborder' => '0',
    'media' => '',
    'layout' => '0',
    'deleted' => '0',
    'cols' => '0',
    'records' => '',
    'pages' => '',
    'starttime' => '0',
    'endtime' => '0',
    'colPos' => '0',
    'subheader' => '',
    'spaceBefore' => '0',
    'spaceAfter' => '0',
    'fe_group' => '',
    'header_link' => '',
    'imagecaption_position' => '',
    'image_link' => NULL,
    'image_zoom' => '0',
    'image_noRows' => '0',
    'image_effects' => '0',
    'image_compression' => '0',
    'altText' => '',
    'titleText' => '',
    'longdescURL' => '',
    'header_layout' => '0',
    'text_align' => '',
    'text_face' => '0',
    'text_size' => '0',
    'text_color' => '0',
    'text_properties' => '0',
    'menu_type' => '0',
    'list_type' => 't3registration_pi1',
    'table_border' => '0',
    'table_cellspacing' => '0',
    'table_cellpadding' => '0',
    'table_bgColor' => '0',
    'select_key' => '',
    'sectionIndex' => '1',
    'linkToTop' => '0',
    'filelink_size' => '0',
    'section_frame' => '0',
    'date' => '0',
    'splash_layout' => '0',
    'multimedia' => '',
    'image_frames' => '0',
    'recursive' => '0',
    'imageheight' => '0',
    'rte_enabled' => '0',
    'sys_language_uid' => '0',
    'tx_impexp_origuid' => '598',
    'pi_flexform' => '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="showtype">
                    <value index="vDEF">auto</value>
                </field>
                <field index="userFolder">
                    <value index="vDEF">340</value>
                </field>
                <field index="confirmationPage">
                    <value index="vDEF"></value>
                </field>
                <field index="passwordGeneration">
                    <value index="vDEF">0</value>
                </field>
                <field index="contactEmailMode">
                    <value index="vDEF">html,text</value>
                </field>
                <field index="debuggingMode">
                    <value index="vDEF">0</value>
                </field>
            </language>
        </sheet>
        <sheet index="templateSheet">
            <language index="lDEF">
                <field index="useAnotherTemplateInChangeProfileMode">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
        <sheet index="emailSheet">
            <language index="lDEF">
                <field index="emailFrom">
                    <value index="vDEF">info@t3registration.com</value>
                </field>
                <field index="emailFromName">
                    <value index="vDEF">T3Registration Test site</value>
                </field>
                <field index="emailAdmin">
                    <value index="vDEF"></value>
                </field>
            </language>
        </sheet>
        <sheet index="fieldsSheet">
            <language index="lDEF">
                <field index="fields">
                    <el index="el">
                        <section index="1">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">first_name</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="2">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">last_name</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="3">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">email</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF">email,uniqueInPid,required</value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="4">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">password</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF">required</value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="5">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_t3registrationtest_select</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="6">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_t3registrationtest_radio</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="7">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_t3registrationtest_check</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">1</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="8">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_t3registrationtest_checkmultiple</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="9">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">image</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="10">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_t3registrationtest_procFunc</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="11">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_t3registrationtest_date</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="12">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_phpunit_is_dummy_record</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">1</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                    </el>
                </field>
            </language>
        </sheet>
        <sheet index="testSheet">
            <language index="lDEF">
                <field index="enableTemplateTest">
                    <value index="vDEF">0</value>
                </field>
                <field index="stepToTest">
                    <value index="vDEF">registration</value>
                </field>
                <field index="testXMLFile">
                    <value index="vDEF"></value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>',
    'l18n_parent' => '0',
    'l18n_diffsource' => 'a:19:{s:5:"CType";N;s:6:"colPos";N;s:16:"sys_language_uid";N;s:6:"header";N;s:13:"header_layout";N;s:15:"header_position";N;s:4:"date";N;s:11:"header_link";N;s:9:"list_type";N;s:11:"pi_flexform";N;s:11:"spaceBefore";N;s:10:"spaceAfter";N;s:13:"section_frame";N;s:6:"hidden";N;s:12:"sectionIndex";N;s:9:"linkToTop";N;s:9:"starttime";N;s:7:"endtime";N;s:8:"fe_group";N;}',
    'tx_templavoila_ds' => '',
    'tx_templavoila_to' => '0',
    'tx_templavoila_flex' => NULL,
    'tx_templavoila_pito' => '0',
    'tx_phpunit_is_dummy_record' => '0',
    'xtemplate' => '',
    'xflextemplate' => '',
    'xft_files' => '',
    'tx_dam_images' => '0',
    'tx_dam_files' => '0',
    'ce_flexform' => NULL,
    'tx_damttcontent_files' => '0',
    'tx_perfectlightbox_activate' => '0',
    'tx_perfectlightbox_imageset' => '0',
    'tx_perfectlightbox_presentation' => '0',
    'tx_perfectlightbox_slideshow' => '0',
    'currentValue_kidjls9dksoje' => 'T3 Registration with Double Optin',
);

$tt_contentDataWithUsergroup = $tt_contentData;
$tt_contentDataWithUsergroup['pi_flexform'] = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="showtype">
                    <value index="vDEF">auto</value>
                </field>
                <field index="userFolder">
                    <value index="vDEF">340</value>
                </field>
                <field index="confirmationPage">
                    <value index="vDEF"></value>
                </field>
                <field index="passwordGeneration">
                    <value index="vDEF">0</value>
                </field>
                <field index="contactEmailMode">
                    <value index="vDEF">html,text</value>
                </field>
                <field index="debuggingMode">
                    <value index="vDEF">0</value>
                </field>
            </language>
        </sheet>
        <sheet index="templateSheet">
            <language index="lDEF">
                <field index="useAnotherTemplateInChangeProfileMode">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
        <sheet index="emailSheet">
            <language index="lDEF">
                <field index="emailFrom">
                    <value index="vDEF">info@t3registration.com</value>
                </field>
                <field index="emailFromName">
                    <value index="vDEF">T3Registration Test site</value>
                </field>
                <field index="emailAdmin">
                    <value index="vDEF"></value>
                </field>
            </language>
        </sheet>
        <sheet index="fieldsSheet">
            <language index="lDEF">
                <field index="fields">
                    <el index="el">
                        <section index="1">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">first_name</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="2">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">last_name</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="3">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">email</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF">email,uniqueInPid,required</value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="4">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">password</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF">required</value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="5">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_t3registrationtest_select</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="6">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_t3registrationtest_radio</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="7">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_t3registrationtest_check</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">1</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="8">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_t3registrationtest_checkmultiple</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="9">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">image</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="10">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_t3registrationtest_procFunc</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="11">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_t3registrationtest_date</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">0</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="12">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">tx_phpunit_is_dummy_record</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">1</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                        <section index="13">
                            <itemType index="databaseField">
                                <el>
                                    <field index="field">
                                        <value index="vDEF">usergroup</value>
                                    </field>
                                    <field index="name">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="evaluation">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="regexp">
                                        <value index="vDEF"></value>
                                    </field>
                                    <field index="hideInChangeProfile">
                                        <value index="vDEF">1</value>
                                    </field>
                                </el>
                            </itemType>
                            <itemType index="_TOGGLE">0</itemType>
                        </section>
                    </el>
                </field>
            </language>
        </sheet>
        <sheet index="testSheet">
            <language index="lDEF">
                <field index="enableTemplateTest">
                    <value index="vDEF">0</value>
                </field>
                <field index="stepToTest">
                    <value index="vDEF">registration</value>
                </field>
                <field index="testXMLFile">
                    <value index="vDEF"></value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';