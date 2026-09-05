 #!/bin/bash

# Go to project folder dynamically
cd "$(dirname "$0")" || exit

# Ensure local changes do not block pull
/usr/bin/git reset --hard HEAD
/usr/bin/git clean -fd
/usr/bin/git pull origin main

echo "Deployment completed: $(date)" >> deploy.log