#!/bin/bash

path="web/resources/js"

browserify \
    $path/custom.js \
    -o $path/custom.bundle.js \
    --noparse=*.*