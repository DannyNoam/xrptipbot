#!/bin/bash

# Create network for access between DB/Application
docker network rm tipbotnetwork
docker network create tipbotnetwork

# Clean up Docker images/containers
docker rm -f csctipbot
docker rmi -f csctipbot
docker rm -f mariadb
docker rmi -f mariadb

# Build and run docker containers
cd ../db && docker build -t mariadb .
docker run -d --network tipbotnetwork --name mariadb mariadb
cd .. && docker build -t csctipbot .
docker run -d --network tipbotnetwork --name csctipbot csctipbot




