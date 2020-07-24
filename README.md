# Quick Protection System (QPS)

QPS is a request inspection module for Magento 1 stores. It receives its configuration via the API of https://mage-one.com/.

# Important

The Magento cron job needs to run in order to obtain updated rule sets.

# Install
## with composer

1. Add the repository with the module:

        "repositories": [
            {
                "type": "vcs",
                "url": "git@github.com:mage-one-com/qps.git"
            }
        ],

2. `composer require mage_one_com/qps`

## with modman

    modman clone git@github.com:mage-one-com/qps.git

## manually
[Download zip file](https://github.com/mage-one-com/qps/archive/master.zip) and copy the files from `src` into your magento root directory

# Uninstall
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

QPS is licensed under BSD 3-clause License, modified according to german law.

Copyright 2020 Paddox GmbH, Germany

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS". NO CONTRIBUTER SHALL BE LIABLE FOR DAMAGES ARISING FROM CAUSES OTHER THEN THE DETRIMENT TO LIFE, BODY AND HEALTH ONLY TO THE EXTENT SUCH DAMAGES ARISES FROM WILFUL MISCONDUCT, GROSS NEGLIGENCE OR THE CULPABLE VIOLATION OF A FUNDAMENTAL CONTRACTUAL OBLIGATION ON THE PART OF THE CONTRIBUTOR OR ANY VICARIOUS AGENTS. ANY FURTHER LIABILITY FOR DAMAGES SHALL BE EXCLUDED, ESPECIALLY LIABILITY FOR THE LOSS OF DATA AND THE RECOVERY OF THIS DATA IF THIS LOSS COULD HAVE BEEN AVOIDED BY THE SOFTWARE USER THROUGH APPROPRIATE PRECAUTIONARY MEASUERS, IN PARTICULAR BY CREATING DAILY BACKUPS OF ALL DATA. THE PROVISIONS OF THE GERMAN PRODUCT LIABILITY ACT AND OTHER MANDATORY LEGAL STATUTES SHALL REMAIN UNAFFECTED.









 
