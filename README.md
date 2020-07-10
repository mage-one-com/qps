# Quick Protection System (QPS)

QPS is a little request inspection module for Magento 1 stores. It receives its configuration via the API of https://mage-one.com/.

# Installation
## with composer

1. Add the repository with the module:

        "repositories": [
            {
                "type": "vcs",
                "url": "git@github.com:mage-one-com/qps.git"
            }
        ],

2. `composer require mage_one_come/qps`

## with modman

    modman clone git@github.com:mage-one-com/qps.git

## manually
[Download zip file](https://github.com/mage-one-com/qps/archive/master.zip) and copy the files from `src` into your magento root directory

# Deinstallation

## with composer
- Remove module from `composer.json` and rerun `composer update mageone/qps`
- Drop the rules table: `DROP TABLE <prefix>mageone_qps_rules;`

## with modman or manually
- Remove the files from your installation
- Drop the rules table: `DROP TABLE <prefix>mageone_qps_rules;`

# How does it work?

## 

# Contribution

Please send your contribution as a pull request against our develop branch.

# Developer

This module is under development by Mage One (https://mage-one.com) a service of Paddox GmbH, Germany (https://mage-one.com/imprint)

# License

QPS is licensed under the MIT License

Copyright 2020 Paddox GmbH, Germany

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.






 
