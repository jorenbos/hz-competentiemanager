#!/bin/sh

echo "[pre-commit] Running tests.."
composer fix
composer test

echo "[pre-commit] All done. Happy coding!"
