#!/usr/bin/env bash
# =============================================================================
# deploy.sh — Production deploy script for Product Gallery
# © 2026 RAMRAS TECHNOLOGIES. All Rights Reserved.
#
# Usage:
#   bash scripts/deploy.sh
#
# Expects:
#   - PROJECT_DIR set to the absolute path of the project root
#   - .env configured on the server
# =============================================================================

set -euo pipefail

PROJECT_DIR="${PROJECT_DIR:-$(cd "$(dirname "$0")/.." && pwd)}"
PHP="${PHP_BIN:-php}"

echo "==> Deploying Product Gallery from ${PROJECT_DIR}"
cd "${PROJECT_DIR}"

# 1. Pull latest code from main
echo "==> Pulling latest code..."
git fetch origin
git checkout main
git pull origin main

# 2. Install / update Composer dependencies (no dev)
echo "==> Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Run pending database migrations
echo "==> Running migrations..."
${PHP} spark migrate --no-interaction

# 4. Clear application caches
echo "==> Clearing caches..."
${PHP} spark cache:clear
${PHP} spark optimize --env=production 2>/dev/null || true

# 5. Set correct file permissions
echo "==> Setting permissions..."
chmod -R 775 writable/
chown -R www-data:www-data writable/ public/uploads/ 2>/dev/null || true

echo "==> Deploy complete at $(date '+%Y-%m-%d %H:%M:%S')"
