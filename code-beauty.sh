#!/bin/sh

# Run PHP code beautifier
vendor/bin/phpcbf ./app ./tests > /dev/null
rc=$?
if [ $rc != 0 ]
then 
	echo "\nCode not optimal, run PHP Codebeautifier first (composer run fix)\n"
	exit $rc
else
	echo "\nCode beautifier says :)\n"
fi

# Run PHP Mess Detector
vendor/bin/phpmd app,tests text codesize,unusedcode --exclude app/Console/*,app/Exceptions/*,app/Providers/*
rc=$?
if [ $rc != 0 ]
then 
	echo "\nUh oooh.. PHP mess detector detected something..\n"
	exit $rc
else
	echo "\nMess Detector says :)\n"
fi