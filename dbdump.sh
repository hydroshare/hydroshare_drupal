#!/bin/sh
#
# Script to dump the mysql hydroshare database to sites/default/hydroshare.sql
DUMPFILE=sites/default/hydroshare.sql
DATABASE=drupal_hydroshare
DBUSER=admin
RESULT=0
PASSWD=water
if [ -w $DUMPFILE ]
then
    printf "Dumping database: %s\n" $DATABASE
    mysqldump --skip-extended-insert -u $DBUSER -p$PASSWD $DATABASE > $DUMPFILE
    if [ $? -ne 0 ]
    then
	printf "ERROR: an error occurred while dumping sql database\n"
    fi
else
    printf "ERROR: mysql dumpfile %s does not exist or is not writable\n" $DUMPFILE
    RESULT=1
fi
exit $RESULT
