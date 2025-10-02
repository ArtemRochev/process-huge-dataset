## Description

PHP application with a single API endpoint:

- `GET /process-huge-dataset` - Returns a JSON array of objects

Implementation points:

1. **Simulated Long-Running Operation**  
   The handler has a `sleep(10)` command to simulate a long-running process.

2. **Caching Strategy**
    - The response will be cached for **1 minute**.
    - If **no cache exists at all** (even stale), and a request is already **processing the cache update**, the server will return a `202 Accepted` status.
    - If a **stale cache exists**, and another request is already refreshing it, the endpoint **will return the stale cached value**, accompanied by the header:
      ```
      X-Cache-Status: STALE
      ```

3. **Concurrency Control**
    - Only **one concurrent process** can fetch fresh data and update the cache at any given time.
    - This ensures that heavy computation or database access is performed once even under concurrent load.

## RUN
```cd docker && cp env-example .env && docker-compose up -d```<br>
<br>
Or:<br>
set ```REDIS_DSN``` in .env<br>
```docker build -t phd -f docker/Dockerfile .```<br>
```docker run -d phd```
