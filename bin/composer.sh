#!/bin/bash

docker run --rm --interactive \
    --volume $PWD:/app \
    composer "$@"

