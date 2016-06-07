#!/bin/bash
rm -rf out || exit 0;
mkdir out; 
node build.js
( cd service-download
 git init
 git config user.name "Travis-CI"
 git config user.email "travis@nodemeatspace.com"
 cp ../CNAME ./CNAME
 cp ../countryiso.js ./countryiso.js
 git add .
 git commit -m "Deployed to Github Pages"
git push --force --quiet "https://${GITHUB_TOKEN}@$github.com/${GITHUB_REPO}.git" master:gh-pages > /dev/null 2>&1
)
