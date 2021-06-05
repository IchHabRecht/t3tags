<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "t3tags".
 *
 * Auto generated 30-09-2020 13:11
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'T3TAGS - TYPO3 Tagging Api',
  'description' => 'Generate tag fields for every record type',
  'category' => 'misc',
  'author' => 'Nicole Cordes',
  'author_email' => 'typo3@cordes.co',
  'author_company' => 'biz-design',
  'state' => 'stable',
  'uploadfolder' => 0,
  'createDirs' => '',
  'clearCacheOnLoad' => 0,
  'version' => '1.1.0',
  'constraints' =>
  array (
    'depends' =>
    array (
      'typo3' => '9.5.0-10.4.99',
    ),
    'conflicts' =>
    array (
    ),
    'suggests' =>
    array (
    ),
  ),
  '_md5_values_when_last_written' => 'a:33:{s:9:"ChangeLog";s:4:"7700";s:7:"LICENSE";s:4:"b234";s:9:"README.md";s:4:"4cff";s:13:"composer.json";s:4:"ea8e";s:13:"composer.lock";s:4:"f9ea";s:21:"ext_conf_template.txt";s:4:"d7ca";s:17:"ext_localconf.php";s:4:"2cee";s:14:"ext_tables.php";s:4:"88a6";s:14:"ext_tables.sql";s:4:"bdfa";s:31:"ext_typoscript_setup.typoscript";s:4:"6aa6";s:16:"phpunit.xml.dist";s:4:"041c";s:24:"sonar-project.properties";s:4:"e6b3";s:37:"Classes/Configuration/TagRegistry.php";s:4:"e284";s:28:"Classes/Domain/Model/Tag.php";s:4:"1283";s:43:"Classes/Domain/Repository/TagRepository.php";s:4:"feb0";s:51:"Classes/Error/Exception/EmptyTableNameException.php";s:4:"e78d";s:49:"Classes/Error/Exception/UnknownTableException.php";s:4:"021a";s:44:"Classes/Form/FieldInformation/StaticText.php";s:4:"5c25";s:45:"Classes/Form/Wizard/SuggestWizardReceiver.php";s:4:"fef4";s:35:"Configuration/TCA/tx_t3tags_tag.php";s:4:"4cae";s:43:"Resources/Private/Language/locallang_be.xlf";s:4:"f4c4";s:44:"Resources/Private/Language/locallang_tca.xlf";s:4:"db0b";s:36:"Resources/Public/Icons/Extension.svg";s:4:"e822";s:55:"Resources/Public/JavaScript/T3tagsGroupSuggestWizard.js";s:4:"fd4a";s:56:"Tests/Functional/Domain/Repository/TagRepositoryTest.php";s:4:"2892";s:44:"Tests/Functional/Fixtures/Database/pages.xml";s:4:"0605";s:49:"Tests/Functional/Fixtures/Database/tt_content.xml";s:4:"8c7d";s:52:"Tests/Functional/Fixtures/Database/tx_t3tags_tag.xml";s:4:"9202";s:55:"Tests/Functional/Fixtures/Database/tx_t3tags_tag_mm.xml";s:4:"1642";s:63:"Tests/Functional/Fixtures/Extensions/t3tags_test/ext_emconf.php";s:4:"c6ba";s:63:"Tests/Functional/Fixtures/Extensions/t3tags_test/ext_tables.sql";s:4:"f28c";s:91:"Tests/Functional/Fixtures/Extensions/t3tags_test/Configuration/TCA/Overrides/tt_content.php";s:4:"85b2";s:85:"Tests/Functional/Fixtures/Extensions/t3tags_test/Resources/Public/Icons/Extension.svg";s:4:"e822";}',
);

