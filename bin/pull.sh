#!/bin/bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
cd $SCRIPT_DIR/..

# Force SSH to pull our password from the env var.
export SSH_ASKPASS='./bin/sshpass.sh'
export SSH_ASKPASS_REQUIRE='force'

# same as -rlptgoD
# -r = recursive
OPTS='-r'
# -L = follow links
OPTS+=' -L'
# preserve permissions, group, owner
OPTS+=' -pgo'
# -t = preserve modification times
OPTS+=' -t'

rsync \
	-vz \
	--exclude-from='.distignore' \
	$OPTS \
	$DEPLOY_USER@$DEPLOY_HOST:html/wp-content/ ./content/
