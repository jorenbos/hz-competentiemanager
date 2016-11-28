#!/bin/sh

echo "[pre-commit] Running tests.."
vendor/bin/phpcbf ./app ./tests
vendor/bin/phpmd 'app,tests' text 'phpmd-ruleset.xml'

echo "[pre-commit] All done. Happy coding!"
