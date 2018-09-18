## Supported tags

- 4.1-php7.2-cli ([Dockerfile](https://github.com/liudejin/docker-images/blob/master/swoole/4.1-php7.2-cli/Dockerfile))
- 4.1-php7.2-fpm ([Dockerfile](https://github.com/liudejin/docker-images/blob/master/swoole/4.1-php7.2-fpm/Dockerfile))

## Extensions

- bcmath
- ctype
- curl
- date
- dom
- fileinfo
- filter
- ftp
- gd
- hash
- iconv
- json
- libxml
- mbstring
- mysqlnd
- openssl
- pcre
- PDO
- pdo_sqlite
- Phar
- posix
- readline
- Reflection
- session
- SimpleXML
- sockets
- sodium
- SPL
- sqlite3
- swoole
- tokenizer
- xml
- xmlreader
- xmlwriter
- zip
- zlib



## How to use?

For example, if you want start a server you can use the below command to run a server container.

- Start a server container

Note: Because in swoole start a server or use the asynchronous codes must be run in 'php-cli' environment
so you have to use these tags whose suffixes are 'cli'. 

```
docker run \
--name swoole-server-demo \
--restart=always \
--network "web" \
-v $PWD/src:/usr/app \
-d \
ldjbenben/swoole:4.1-php7.2-cli \
php /usr/app/index.php
```

- Start a client container

You can find the source files of the demo in [github](https://github.com/liudejin/docker-images/tree/master/swoole/demo)

```
docker run \
--name swoole-client-demo \
--restart=always \
--network "web" \
-v "$PWD/src":/var/www/html \
-d \
ldjbenben/swoole:4.1-php7.2-fpm
```

- Start a nginx container

Because we used the version of php-fpm to run the client application so we have to start a nginx container:

```
docker run \
--name $name \
--restart=always \
--network "web" \
-p 8080:80 \
-v $PWD/../swoole-client-demo/src:/usr/share/nginx/html/swoole-client-demo \
-v `pwd`/conf.d:/usr/share/nginx/conf.d \
-v `pwd`/nginx.conf:/etc/nginx/nginx.conf:ro \
-d \
nginx:alpine
```

If your server ip is '192.168.2.100' you can access 'http://192.168.2.100:8080' in the browser to see the result.

The browser will output ‘Hello Swoole!’ if everything is ok.

