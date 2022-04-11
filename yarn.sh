#!/bin/bash -eu

PWD=$(cd $(dirname $0) && pwd)

# Create Image
COUNT_DOCKER_IMAGE="$(docker images yarn -q | wc -l | sed 's/^[ \t]*//')"
if [ $COUNT_DOCKER_IMAGE == "0" ]; then
    docker build $PWD/docker-images/yarn -t yarn
fi

docker run --rm -t --init -v $PWD:/app -w /app --entrypoint yarn --net tq-docker-template yarn $@