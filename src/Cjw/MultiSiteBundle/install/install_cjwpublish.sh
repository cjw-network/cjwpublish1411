# install cjwpublish (Multisite Setup) into ezroot

# cd ezroot/
# sh src/Cjw/MultiSiteBundle/install/install_cjwpublish.sh

echo ""
echo "### Installing cjwpublish (MultiSiteSetup) into ezroot"



echo "# Only create and do not override existing files !!!!"
echo "cp -vn src/Cjw/MultiSiteBundle/install/ezroot/* -R ./"

# copy file only if not exists
cp -vn src/Cjw/MultiSiteBundle/install/ezroot/* -R ./

echo "Done"

echo ""

echo "# override web/index.php with cjwpublish logic and backup old web/index.php"
echo "cp -vb src/Cjw/MultiSiteBundle/install/ezroot/web/index.php ./web/index.php"
cp -vb src/Cjw/MultiSiteBundle/install/ezroot/web/index.php ./web/index.php

echo "Done"
