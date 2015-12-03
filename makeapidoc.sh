#!/bin/sh
#phpdoc run -d public_html/libs -t public_html/doc/apidoc
#phpdoc run -d public_html/_inc -t public_html/doc/oldapidoc
#apigen --source public_html/libs/ \
#	--exclude public_html/libs/Mail/*  \
#	--destination public_html/doc/apidoc2/  \
#	--autocomplete classes,constants,functions,methods,properties,classconstants \
#	--deprecated yes \
#	--todo yes \
#	--source-code yes
#apigen --config old_apigen_doc.neon \
#	--template-config /usr/share/php/data/ApiGen/templates/bootstrap/config.neon

#apigen --config internal_apigen_doc.neon \
#	--template-config /usr/share/php/data/ApiGen/templates/bootstrap/config.neon

apigen --config model_apigen_doc.neon \
	--template-config /usr/share/php/data/ApiGen/templates/bootstrap/config.neon
