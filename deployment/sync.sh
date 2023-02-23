#!/usr/bin/env bash

JUMP_HOST=''
TARGET_HOST='104.248.42.73'
SSH_USER='root'

PROXY_JUMP="${SSH_USER}@${JUMP_HOST}"
TARGET="${SSH_USER}@${TARGET_HOST}"

FILES='.env docker-compose.yml Caddyfile'

### scp through jump server
# scp -r -oProxyJump=${PROXY_JUMP} ${FILES} ${TARGET}:/root/caddy
### Normal scp
scp -r ${FILES} ${TARGET}:/root/caddy

### Connect through jump server to host
# ssh -J ${SSH_USER}@${JUMP_HOST} ${SSH_USER}@${TARGET_HOST} "cd /root/caddy; docker compose up -d --force-recreate; exit;"
### Connect directly
ssh ${SSH_USER}@${TARGET_HOST} "cd /root/caddy; docker compose up -d --force-recreate; exit;"

echo "******* Done *******"
