#!/bin/sh

echo "[pre-commit] Running tests.."
vendor/bin/phpcbf ./app ./tests
# vendor/bin/phpmd app,tests text codesize,unusedcode,naming --exclude app/console,app/exceptions,app/providers

echo "[pre-commit] All done. Happy coding!"
