CREATE TABLE ezsi_files (
      filepath text NOT NULL,
      namehash char(32) NOT NULL,
      mtime int(11) unsigned NOT NULL DEFAULT '0',
      urlalias text NOT NULL,
      siteaccess varchar(100) NOT NULL,
      ttl int(10) unsigned NOT NULL,
      blockkeys text NOT NULL,
      PRIMARY KEY (namehash)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
