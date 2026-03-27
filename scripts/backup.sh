#!/usr/bin/env bash
# =============================================================================
# backup.sh — Database + uploads backup for Product Gallery
# © 2026 RAMRAS TECHNOLOGIES. All Rights Reserved.
#
# Usage:
#   bash scripts/backup.sh
#
# Schedule (add to crontab):
#   0 2 * * * /path/to/project/scripts/backup.sh >> /var/log/pg_backup.log 2>&1
#
# Environment variables (can also be sourced from .backup.env):
#   DB_HOST, DB_NAME, DB_USER, DB_PASS
#   BACKUP_DIR  — where to store backups (default: /var/backups/product-gallery)
#   KEEP_DAYS   — how many days to retain (default: 30)
# =============================================================================

set -euo pipefail

# Load optional env file
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
ENV_FILE="${SCRIPT_DIR}/../.env"
if [ -f "${ENV_FILE}" ]; then
    # Parse CI4 .env for DB credentials
    DB_HOST="${DB_HOST:-$(grep 'database.default.hostname' "${ENV_FILE}" | cut -d= -f2 | tr -d ' ')}"
    DB_NAME="${DB_NAME:-$(grep 'database.default.database'  "${ENV_FILE}" | cut -d= -f2 | tr -d ' ')}"
    DB_USER="${DB_USER:-$(grep 'database.default.username'  "${ENV_FILE}" | cut -d= -f2 | tr -d ' ')}"
    DB_PASS="${DB_PASS:-$(grep 'database.default.password'  "${ENV_FILE}" | cut -d= -f2 | tr -d ' ')}"
fi

DB_HOST="${DB_HOST:-localhost}"
DB_NAME="${DB_NAME:-product_gallery}"
DB_USER="${DB_USER:-root}"
DB_PASS="${DB_PASS:-}"
BACKUP_DIR="${BACKUP_DIR:-/var/backups/product-gallery}"
KEEP_DAYS="${KEEP_DAYS:-30}"
PROJECT_DIR="${SCRIPT_DIR}/.."
TIMESTAMP=$(date '+%Y%m%d_%H%M%S')

mkdir -p "${BACKUP_DIR}"

# 1. Database dump
DB_FILE="${BACKUP_DIR}/db_${TIMESTAMP}.sql.gz"
echo "[$(date '+%H:%M:%S')] Dumping database ${DB_NAME}..."
MYSQL_PWD="${DB_PASS}" mysqldump \
    --host="${DB_HOST}" \
    --user="${DB_USER}" \
    --single-transaction \
    --routines \
    --triggers \
    "${DB_NAME}" | gzip > "${DB_FILE}"
echo "[$(date '+%H:%M:%S')] DB backup: ${DB_FILE}"

# 2. Uploads archive
UPLOADS_FILE="${BACKUP_DIR}/uploads_${TIMESTAMP}.tar.gz"
echo "[$(date '+%H:%M:%S')] Archiving uploads..."
tar -czf "${UPLOADS_FILE}" -C "${PROJECT_DIR}/public" uploads/
echo "[$(date '+%H:%M:%S')] Uploads backup: ${UPLOADS_FILE}"

# 3. Remove backups older than KEEP_DAYS
echo "[$(date '+%H:%M:%S')] Removing backups older than ${KEEP_DAYS} days..."
find "${BACKUP_DIR}" -name "*.gz" -mtime "+${KEEP_DAYS}" -delete

echo "[$(date '+%H:%M:%S')] Backup complete."
