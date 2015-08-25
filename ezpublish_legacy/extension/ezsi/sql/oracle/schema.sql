CREATE TABLE ezsi_files (
    filepath VARCHAR2(4000) NOT NULL,
    namehash CHAR(32) PRIMARY KEY,
    mtime INTEGER DEFAULT 0 NOT NULL,
    urlalias VARCHAR2(4000), -- must be nullable for when the urlalias corresponds to site root
    siteaccess VARCHAR2(100) NOT NULL,
    ttl INTEGER NOT NULL,
    blockkeys VARCHAR2(4000) NOT NULL);
