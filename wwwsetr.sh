#!/bin/sh
chown -R alex:www-data ./ 
find ./ -type f -exec chmod 664 {} \;
find ./ -type d -exec chmod 775 {} \;
