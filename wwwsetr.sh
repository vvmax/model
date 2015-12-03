#!/bin/sh
chown -R alex:www-data ./ 
find ./ -type f -exec chmod 664 {} \;
find ./ -type d -exec chmod 775 {} \;
chmod 774 wwwsetr.sh
chmod 774 makeapidoc.sh
