/**
 * User: federico
 * Date: 26/11/12
 * Time: 18:26
 * Typoscript file
 */

plugin.tx_t3registration_pi1{
   extra.saltedPassword = 1
   usernameField = email
   sendUserEmailAfterAuthorization = 1
   debugLevel = 2
   #fieldConfiguration.first_name.noHTMLEntities = 0
   templateFile = fileadmin/templates/t3registration_template.html
   fieldConfiguration.tx_t3registrationtest_date.config.date.strftime = d.m.Y
   errors.classError = errorT3RegistrationClass
   templateFile = EXT:t3registration_test/res/template_test.html
   fieldConfiguration.tx_phpunit_is_dummy_record.config.type = hidden
   fieldConfiguration.tx_phpunit_is_dummy_record.config.default = 1
 }