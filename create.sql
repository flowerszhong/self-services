CREATE TABLE `consume` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `student_id` int(20) DEFAULT NULL,
  `fee` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `students` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(20) DEFAULT NULL,
  `user_name` varchar(11) DEFAULT NULL,
  `user_email` varchar(60) DEFAULT NULL,
  `pwd` varchar(20) DEFAULT NULL,
  `md5_id` varchar(200) DEFAULT NULL,
  `user_level` int(2) DEFAULT NULL,
  `tel` int(16) DEFAULT NULL,
  `department` varchar(40) DEFAULT NULL,
  `major` varchar(40) DEFAULT NULL,
  `sub_major` varchar(50) DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `class` int(11) DEFAULT NULL,
  `log_ip` varchar(40) DEFAULT NULL,
  `approved` tinyint(1) DEFAULT '0',
  `reg_date` datetime DEFAULT NULL,
  `activation_code` int(11) DEFAULT NULL,
  `banned` tinyint(1) DEFAULT '0',
  `ckey` varchar(100) DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  `net_id` varchar(100) DEFAULT NULL,
  `net_pwd` varchar(40) DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `net_id` varchar(400) DEFAULT NULL,
  `net_pwd` varchar(40) DEFAULT NULL,
  `student_id` int(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `used` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;