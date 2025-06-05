#!/bin/bash
# Build script that runs .build-script in a container and exports files
set -x

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

# Set up variables
BUILD_DIR="/tmp/fairserver-build"
CONTAINER_NAME="fair-builder"

# Clean up any existing build directory
rm -rf "$BUILD_DIR"

# Make a clean copy of the repo, using rsync
echo "Syncing to $BUILD_DIR…" >&2
rsync \
	-a \
	--progress \
	--exclude='.git' \
	--exclude-from='.distignore' \
	"$SCRIPT_DIR/.." "$BUILD_DIR"

# Run the build script inside a composer container
echo "Running build script…" >&2
docker run \
	--rm \
	--name "$CONTAINER_NAME" \
	-v "$BUILD_DIR:/app" \
	-w /app \
	composer:latest \
	bash -c "./.build-script"

echo "Building image…" >&2
docker build \
	--tag ghcr.io/fairpm/server:latest \
	--build-context src="$BUILD_DIR" \
	"$SCRIPT_DIR/container"

echo "Pushing to GitHub Container Registry…" >&2
docker push ghcr.io/fairpm/server:latest
