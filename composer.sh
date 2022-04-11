#!/bin/bash -eu

PWD=$(cd $(dirname $0) && pwd)

docker run -it --rm --interactive --volume $PWD/src:/app composer:2.0.9 $@
