# Jinzora initial config script
#
# Author: Ross Carlson
# Date: 9.21.03
# Version: 1.0
#


if [ ! -f settings.php ]; then
    touch settings.php
fi
if [ ! -f users.php ]; then
    touch users.php
fi
chmod 666 users.php
chmod 666 settings.php
chmod 777 -R temp/
chmod 777 -R data/

echo ""
echo "You are now in setup mode."
echo "Please direct your web browser to the directory where you installed Jinzora"
echo "and load index.php - you will then be taken through the complete setup"
echo ""
echo ""

