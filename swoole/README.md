## Supported tags

- 4.1-php7.2-cli ([Dockerfile](https://github.com/liudejin/docker-images/blob/master/swoole/4.1-php7.2-cli/Dockerfile))
- 4.1-php7.2-fpm ([Dockerfile](https://github.com/liudejin/docker-images/blob/master/swoole/4.1-php7.2-fpm/Dockerfile))

## How to use?

For example, if you want start a server you can use the below command to run a server container.

- Start a server

Note: Because in swoole start a server or use the asynchronous codes must be run in 'php-cli' environment
so you have to use these tags whose suffixes are 'cli'. 

```
docker run \
--name swoole-server \
--network "swoole" \
-v $PWD/www/server:/usr/app \
-d \
ldjbenben/swoole:4.1-php7.2-cli \
php /usr/app/index.php
```

- Start a client

You can find the source files of the demo in [github](https://github.com/liudejin/docker-images/tree/master/swoole/demo)

```
docker run \
-d \
--name swoole-client \
--network 'swoole' \
-v "$PWD/www/client":/var/www/html \
ldjbenben/swoole:4.1-php7.2-fpm
```

Because we used the version of php-fpm to run the client application so we have to start a nginx container:

```
docker run \
--name swoole-nginx \
--network 'swoole' \
-p 8080:80 \
-v $PWD/www:/usr/share/nginx/html \
-v `pwd`/conf.d:/usr/share/nginx/conf.d \
-v `pwd`/nginx.conf:/etc/nginx/nginx.conf:ro \
-d \
nginx:alpine
```

If your server ip is '192.168.2.100' you can access 'http://192.168.2.100:8080' in the browser to see the result.

The browser will output ‘Hello Swoole!’ if everything is ok.
