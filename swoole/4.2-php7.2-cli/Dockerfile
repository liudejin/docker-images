FROM alpine/git:latest

RUN cd /usr && git clone https://github.com/swoole/swoole-src.git && cd swoole-src && git checkout -b v4.2.9 v4.2.9


FROM ldjbenben/php:7.2-cli-alpine

# COPY --from=0 /usr/php-ext-excel-export /usr/src/php-ext-excel-export/
COPY --from=0 /usr/swoole-src /usr/src/swoole-src/

ENV PHPIZE_DEPS \
        autoconf \
        g++ \
        make \
        libxml2-dev \
        pcre-dev

ENV SWOOLE_DEPS \
        gcc \
        openssl-dev \
        hiredis-dev \
        nghttp2-dev

RUN set -xe \
        && echo 'http://mirrors.aliyun.com/alpine/v3.8/main/' > /etc/apk/repositories \
        && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        && apk add --no-cache --virtual .swoole-deps \
        $SWOOLE_DEPS \
        && docker-php-source extract \
	&& cd /usr/src/swoole-src \
	&& phpize \
        && ./configure --enable-openssl \
		--enable-sockets \
		--enable-http2 \
		--enable-async-redis \
		--enable-mysqlnd \
        && make && make install \
#        && echo -e "yes\nyes\nyes\nyes\nyes\nyes\n" | pecl install swoole \
        && docker-php-ext-enable swoole \
\
&& apk del .build-deps \
&& pecl update-channels \
&& rm -rf /tmp/pear ~/.pearrc \
&& cd / \
&& docker-php-source delete

