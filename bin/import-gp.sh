#!/bin/bash
set -eo pipefail

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
cd "$SCRIPT_DIR/.."

SLUG="$1"
if [ -z "$SLUG" ]; then
	echo "Usage: $0 <slug>"
	exit 1
fi

PROJECT_DIR="./gp-data/translations/$SLUG"

if [ ! -d "$PROJECT_DIR" ]; then
	echo "Project directory not found: $PROJECT_DIR"
	exit 1
fi

# Import originals first.
echo "Importing originals (from en-gb)" >&2
if [ ! -f "$PROJECT_DIR/en-gb/default.po" ]; then
	echo "Originals file not found: $PROJECT_DIR/en-gb/default.po"
	exit 1
fi
wp $WP_ARGS glotpress import-originals "$SLUG" "$PROJECT_DIR/en-gb/default.po"

for dir in "$PROJECT_DIR"/*; do
	if [ ! -d "$dir" ]; then
		continue
	fi

	locale=$(basename "$dir")
	echo "Importing translations for $locale" >&2
	for file in "$dir"/*.po; do
	if [ ! -f "$file" ]; then
		continue
	fi

	set="$(basename "$file" .po)"
	echo "  Importing $set" >&2
	wp $WP_ARGS fair-translate translation-set ensure "$SLUG" "$locale" --set="$set"
	wp $WP_ARGS glotpress translation-set import "$SLUG" "$locale" "$file" --set="$set"
	done
done
