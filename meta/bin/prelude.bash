# This file should be sourced, not run

set -o errexit
set -o nounset
set -o pipefail

# These are not exported, but will be visible in the tool's script if they need them
__ORIG_PWD=$PWD
__HERE=$(dirname "$0")

function warn  { echo "$@" >&2; }
function die   { warn "$@"; exit 1; }

cd "$__HERE"/../..
