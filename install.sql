CREATE TABLE IF NOT EXISTS `prefix_hookets` (
  `hooket_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hooket_active`  BOOL NOT NULL DEFAULT '0',
  `hooket_name` varchar(200) NOT NULL,
  `hooket_hook_name` varchar(200) NOT NULL,
  `hooket_type` enum('code','text','template') default 'code',
  `hooket_priority` int(11) NOT NULL DEFAULT 100,
  `hooket_text` text,
  `hooket_description` varchar(250),
  PRIMARY KEY (`hooket_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
