local:<br>
```cd docker && cp env-example .env && docker-compose up -d```<br><br>
deploy:<br>
set ```REDIS_DSN``` in .env<br>
```docker build -t phd -f docker/Dockerfile .```<br>
```docker run -d phd```
