#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
	tx_t3registrationtest_select varchar(255) DEFAULT '' NOT NULL,
	tx_t3registrationtest_radio varchar(255) DEFAULT '' NOT NULL,
	tx_t3registrationtest_check tinyint(3) DEFAULT '0' NOT NULL,
	tx_t3registrationtest_checkmultiple int(11) DEFAULT '0' NOT NULL
	tx_t3registrationtest_select_foreign varchar(255) DEFAULT '' NOT NULL,
	tx_t3registrationtest_procFunc varchar(255) DEFAULT '' NOT NULL,
  tx_t3registrationtest_date int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_t3registration_test_users'
#
CREATE TABLE tx_t3registration_test_users (
  uid int(11) unsigned NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  username varchar(50) DEFAULT '' NOT NULL,
  password varchar(60) DEFAULT '' NOT NULL,
  usergroup tinytext,
  disable tinyint(4) unsigned DEFAULT '0' NOT NULL,
  starttime int(11) unsigned DEFAULT '0' NOT NULL,
  endtime int(11) unsigned DEFAULT '0' NOT NULL,
  name varchar(80) DEFAULT '' NOT NULL,
  first_name varchar(50) DEFAULT '' NOT NULL,
  middle_name varchar(50) DEFAULT '' NOT NULL,
  last_name varchar(50) DEFAULT '' NOT NULL,
  address varchar(255) DEFAULT '' NOT NULL,
  telephone varchar(20) DEFAULT '' NOT NULL,
  fax varchar(20) DEFAULT '' NOT NULL,
  email varchar(80) DEFAULT '' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  lockToDomain varchar(50) DEFAULT '' NOT NULL,
  deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
  uc blob,
  title varchar(40) DEFAULT '' NOT NULL,
  zip varchar(10) DEFAULT '' NOT NULL,
  city varchar(50) DEFAULT '' NOT NULL,
  country varchar(40) DEFAULT '' NOT NULL,
  www varchar(80) DEFAULT '' NOT NULL,
  company varchar(80) DEFAULT '' NOT NULL,
  image tinytext,
  TSconfig text,
  fe_cruser_id int(10) unsigned DEFAULT '0' NOT NULL,
  lastlogin int(10) unsigned DEFAULT '0' NOT NULL,
  is_online int(10) unsigned DEFAULT '0' NOT NULL,
  tx_t3registrationtest_select varchar(255) DEFAULT '' NOT NULL,
  tx_t3registrationtest_radio varchar(255) DEFAULT '' NOT NULL,
  tx_t3registrationtest_check tinyint(3) DEFAULT '0' NOT NULL,
  tx_t3registrationtest_checkmultiple int(11) DEFAULT '0' NOT NULL
  tx_t3registrationtest_select_foreign varchar(255) DEFAULT '' NOT NULL,
  tx_t3registrationtest_procFunc varchar(255) DEFAULT '' NOT NULL,
  tx_t3registrationtest_date int(11) unsigned DEFAULT '0' NOT NULL,
  PRIMARY KEY (uid),
  KEY parent (pid,username),
  KEY username (username),
  KEY is_online (is_online)
);