#!/bin/sh
#
# Script to restore the hydroshare database from the sql dump file
DUMPFILE=sites/default/hydroshare.sql
DATABASE=drupal_hydroshare
DBUSER=admin
RESULT=0
PASSWD=water
if [ -r $DUMPFILE ]
then
    printf "Dropping current database: %s\n" $DATABASE
    mysql -u $DBUSER -p$PASSWD -e "drop database $DATABASE"
    if [ $? -ne 0 ]
    then
	printf "ERROR: an error occurred while dropping the existing database: %s\n" $DATABASE
	RESULT=2
    else 
	printf "Recreating database: %s\n" $DATABASE
	mysql -u $DBUSER -p$PASSWD -e "create database $DATABASE"
	if [ $? -ne 0 ]
	then
	    printf "ERROR: an error occurred while recreating the hydroshare database: %s\n" $DATABASE
	    RESULT=3
	else
	    printf "Importing sql dump file: %s\n" $DUMPFILE
	    mysql -u $DBUSER -p$PASSWD $DATABASE < $DUMPFILE
	    if [ $? -ne 0 ]
	    then
		printf "ERROR: an error occurred while importing the sql dump: %s\n" $DUMPFILE
		RESULT=1
	    fi
	fi
    fi
else
    printf "ERROR: sql dumpfile \"%s\" does not exist or is not readable\n" $DUMPFILE
    RESULT=1
fi
exit $RESULT

