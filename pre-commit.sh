#!/bin/sh

# Execute auto fix for style issues
echo "[pre-commit] Fixing some style issues.."
composer fix

# PHP Codesniffer
echo "[pre-commit] Running tests.."
# composer test
