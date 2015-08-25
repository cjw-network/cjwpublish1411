eZ Publish nginx configuration
==============================

For information on if nginx is supported with your version of eZ Publish, consult with the online documentation on http://doc.ez.no.


Prerequisite
------------
- A working FPM setup (either using network or unix socket).
- nginx must be installed.


Configuration
------------
- Copy the provided etc/nginx/ez_params.d folder in your /etc/nginx/ folder (or symlink it if you are in a development environment).
- Copy the provided example file etc/nginx/sites-available/mysite.com into /etc/nginx/sites-available/yoursite.com
- Edit it and adapt the configuration to suit your needs.
- Create a symlink of /etc/nginx/sites-available/yoursite.com into /etc/nginx/sites-enabled/yoursite.com
- restart nginx

Additional Hints
----------------
- this configuration is adapted from github origional located in
  https://github.com/ezsystems/ezpublish-community/blob/master/doc/nginx/etc/nginx/
  for dirks osx-based environment
- also adapted from jans corrections for gabriels development machine
- using network based FPM
- many different directory structure models are in the air, we use here the apache style, following resources for you to read:
   - http://www.rackspace.com/knowledge_center/article/ubuntu-and-debian-nginx-virtual-hosts
   - http://www.cyberciti.biz/faq/install-nginx-centos-rhel-6-server-rpm-using-yum-command/
   - http://stackoverflow.com/questions/17413526/nginx-missing-sites-available-directory
   - https://www.linode.com/docs/websites/nginx/basic-nginx-configuration
- 3 site configurations are available:
   - *.conf  : native access
   - *e.conf : native access? (i dont know, what it should do)
   - *l.conf : pure legacy access
- the ez_pure_legacy_rewrite_params.conf in jac_params.d folder in combination with *l.conf emulate the optimized
  current configurations from jac live server


Additional Personal Configuration Steps
---------------------------------------
For the optimal configuration you require the cjw multisite bundle.

- modify your base directories
    ( set $base_dir '/Volumes/Macintosh SSD/mnt/daten/htdocs-lighttpd/jac14051'; )
- modify your FPM: socket or network and the valid port
    ( fastcgi_pass    127.0.0.1:9053; )
- modify your listen port
    ( listen       8081; )
- modify your server name with your own regex
    ( server_name	~(^|\.)(jac14051)\..*$; )
- modify your log directory
    ( access_log	/usr/local/var/log/nginx/jac14051_dev.access.log; )
	( error_log	/usr/local/var/log/nginx/jac14051_dev.error.log error; )
- modify your bind oder host settings with your own domain structure
    ( ... *.your-domain.local     IN      A       127.0.0.1 )