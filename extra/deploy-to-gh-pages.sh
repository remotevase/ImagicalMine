#!/bin/bash
rm -rf extra || exit 0;
mkdir extra; 
node plugins/DevTools//ImagicalMine_1.4.phar
( cd extra
 git init
 git config user.name "Travis-CI"
 git config user.email "travis@nodemeatspace.com"
 git add .
 git commit -m "Deployed to Github Pages"
git push --force --quiet "https://${GITHUB_TOKEN}@$github.com/${GITHUB_REPO}.git" master:gh-pages > /dev/null 2>&1
)
