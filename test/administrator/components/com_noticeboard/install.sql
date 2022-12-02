DROP TABLE IF EXISTS `#__noticeboard`;

CREATE TABLE `#__noticeboard` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `description` varchar(700) NOT NULL,

  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


