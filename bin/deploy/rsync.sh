#!/bin/bash

# --- conf
host="ns.weebox.com"
port="22"
user="matthieu"
dir="/home/eexdev/http/blog/"

# http://stackoverflow.com/questions/59895/can-a-bash-script-tell-what-directory-its-stored-in
here="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# command
rsync -azC --force --delete --progress --exclude-from=$here/rsync_exclude.txt -e "ssh -p$port" $here/../../ $user@$host:$dir
