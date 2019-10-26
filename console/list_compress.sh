#!/bin/bash

# /**
#  * Geekode php (http://geekode.net/)
#  * @link    https://github.com/remicioluis/geekcode_php
#  * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
#  * @version 2.0
#  */

# #########################################################
# Se encarga de comprimir todos los .js del framework extjs
# #########################################################

PATH_BASE="/sistemas/weburbano"
PATH_SH="/console/"
COMPRESSOR="yuicompressor-2.4.8.jar"

for i in `find /sistemas/weburbano/public_html/js/ext-5.0.1/ -name *.js ! -name jasmine.js ! -name ext-charts.js ! -name Element.js ! -name ext-aria-debug.js ! -name ext-aria.js ! -name bootstrap-data.js ! -name bootstrap-manifest.js`
do
    comando=${PATH_BASE}${PATH_SH}${COMPRESSOR}" "$i" -o "$i" --charset utf-8 --line-break 4000 --type js --nomunge --preserve-semi --disable-optimizations"
    java -jar $comando
    echo "Archivo de salida => "${i}
done
