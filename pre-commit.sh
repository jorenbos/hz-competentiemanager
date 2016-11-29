#!/bin/sh

echo "[pre-commit] Running tests.."
vendor/bin/phpcbf ./app ./tests
vendor/bin/phpmd 'app,tests,!app/console,!app/exceptions,!app/providers' text 'phpmd-ruleset.xml'

echo "[pre-commit] All done. Happy coding!"
