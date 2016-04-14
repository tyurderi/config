#!/bin/bash

path="web/resources/js"

browserify \
    $path/custom.js \
    -o $path/custom.bundle.js \
    --noparse=*.*

if [ "$1" == "--minify" ]; then
    minifyjs -mi $path/custom.bundle.js -o $path/custom.min.js
    mv $path/custom.min.js $path/custom.bundle.js
fi