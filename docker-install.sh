#!/bin/bash

# Install docker from Docker's Repository
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/debian $(lsb_release -cs) stable"
curl -fsSL https://download.docker.com/linux/debian/gpg | sudo apt-key add -
sudo apt-get install apt-transport-https ca-certificates curl gnupg2 software-properties-common
sudo apt update
sudo apt-get install docker-ce docker-ce-cli containerd.io docker-compose

