#!/bin/bash

source ~/.server-path.txt
if [ -h "$PRODUCTION_SERVER_PATH/kanban" ]; then
    rm "$PRODUCTION_SERVER_PATH/kanban"
else
  echo "$PRODUCTION_SERVER_PATH/kanban" symlink does not exists
fi
ln -fs "$PRODUCTION_SERVER_PATH/current/public" "$PRODUCTION_SERVER_PATH/kanban" && \

#cd $PRODUCTION_SERVER_PATH/current && \
#php bin/console cache:clear && \
chmod -R 755 "$PRODUCTION_SERVER_PATH/current/public/" && \
rm ~/.server-path.txt