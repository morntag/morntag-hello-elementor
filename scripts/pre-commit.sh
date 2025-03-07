#!/bin/bash

# Get the current version from the PHP file - compatible with BSD and GNU grep
CURRENT_VERSION=$(grep "Version:" style.css | sed 's/.*Version: \(.*\)/\1/')

# If empty, set to 1.0.0
if [ -z "$CURRENT_VERSION" ]; then
    CURRENT_VERSION="1.0.0"
fi

# Increment patch version
NEW_VERSION=$(echo $CURRENT_VERSION | awk -F. '{$NF = $NF + 1;} 1' OFS=.)

# Update version in file - compatible with BSD and GNU sed
if [[ "$OSTYPE" == "darwin"* ]]; then
    # macOS
    sed -i '' "s/Version: .*/Version: $NEW_VERSION/" style.css
else
    # Linux
    sed -i "s/Version: .*/Version: $NEW_VERSION/" style.css
fi

# Add the modified file to the commit
git add style.css
echo "Version bumped from $CURRENT_VERSION to $NEW_VERSION"

