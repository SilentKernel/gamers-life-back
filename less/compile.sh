#! /bin/bash
rm -f ../src/QuoteCMS/CoreBundle/Resources/public/css/0_base_bootstrap.css && 
lessc maker.less > ../src/QuoteCMS/CoreBundle/Resources/public/css/0_base_bootstrap.css
