#!/bin/bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
cd "$SCRIPT_DIR/.."

# If rsync is not installed, install it
if ! command -v rsync &> /dev/null; then
    echo "Installing rsync"
    apt update
    apt install -y rsync
fi

# Check if DEPLOY_USER, DEPLOY_HOST, and DEPLOY_PASS are set
if [[ -z "$DEPLOY_USER" || -z "$DEPLOY_HOST" || -z "$DEPLOY_PASS" ]]; then
    echo "Error: DEPLOY_USER, DEPLOY_HOST, and DEPLOY_PASS must be set."
    exit 1
fi

# Force SSH to pull our password from the env var.
export SSH_ASKPASS='./bin/sshpass.sh'
export SSH_ASKPASS_REQUIRE='force'

# Check if --apply is passed as an argument
if [[ "$1" == "--apply" ]]; then
    DRY_RUN=""
else
    DRY_RUN="--dry-run"
fi

pwd
echo -n "Starting sync"
if [ -n "$DRY_RUN" ]; then
    echo " (dry run)"
else
    echo " (APPLYING)"
fi
rsync \
    -e "ssh -o StrictHostKeyChecking=no" \
    -avz \
	--progress \
    --delete $DRY_RUN \
    --exclude-from='.distignore' \
    ./content/ $DEPLOY_USER@$DEPLOY_HOST:html/wp-content/
