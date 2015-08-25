CREATE TABLE ezsi_files
(
  filepath text NOT NULL,
  namehash character(32) NOT NULL,
  mtime integer NOT NULL DEFAULT 0,
  urlalias text NOT NULL,
  siteaccess character varying(100) NOT NULL,
  ttl integer NOT NULL DEFAULT 0,
  blockkeys text NOT NULL,
  CONSTRAINT ezsi_files_pkey PRIMARY KEY (namehash)
);