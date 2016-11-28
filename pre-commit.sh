#!/bin/sh

echo "[pre-commit] Running tests.."
exec vendor/bin/phpcbf ./app ./tests
exec vendor/bin/phpmd 'app,tests' text 'phpmd-ruleset.xml'

echo "[pre-commit] All done. Happy coding!"
