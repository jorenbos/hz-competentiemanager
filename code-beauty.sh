#!/bin/sh

bold=$(tput bold)
red=`tput setaf 1`
green=`tput setaf 2`
normal=$(tput sgr0)

# Run PHP code beautifier
vendor/bin/phpcbf ./app ./tests --tab-width=4 --standard=MySource > /dev/null
rc=$?
if [ $rc != 0 ]
then 
	echo "\n${red}${bold}Code not optimal, run PHP Codebeautifier first (composer run fix)"
	echo "\nIf you see this error locally, the errors have been fixed for you just now :)${normal}\n"
	exit $rc
else
	echo "\n${green}${bold}Code beautifier says :)${normal}\n"
fi

# Run PHP Mess Detector
vendor/bin/phpmd app,tests text codesize,unusedcode --exclude app/Console/*,app/Exceptions/*,app/Providers/*
rc=$?
if [ $rc != 0 ]
then 
	echo "\n${red}${bold}Uh oooh.. PHP mess detector detected something..${normal}\n"
	exit $rc
else
	echo "\n${green}${bold}Mess Detector says :)${normal}\n"
fi

echo "\n\n${red}${bold} STYLECHECKS NOW GET EXECUTED BY STYLECI, PLEASE DO NOT USE THIS SCRIPT ${normal}\n\n"