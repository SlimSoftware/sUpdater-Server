rm -rf output
mkdir output
cd ../
rsync -Rr . build/output/ --exclude-from "build/rsyncignore.txt"

cd build/output
mv .env.example.prod .env.example
mv docker-compose.prod.yml docker-compose.yml

npm install --omit=dev
npm run build
composer install --no-dev

cd ../
tag=`git tag --points-at HEAD`
zip -r sUpdater-Server-$tag.zip output