#!/bin/sh

echo "[pre-commit] Running tests.."
vendor/bin/phpcbf ./app ./tests
#This doesn't work on windows for some reason, run these tests from your vagrant box
#vendor/bin/phpmd app,tests text codesize,unusedcode,naming --exclude app/Console/*,app/Exceptions/*,app/Providers/*

echo "[pre-commit] All done. Happy coding!"
