FROM ldjbenben/php:7.2-cli-alpine

ENV SRC_DIR /usr/src
ENV SWOOLE_VERSION 4.0.1

ADD libs/swoole-${SWOOLE_VERSION}.tar.gz ${SRC_DIR}/

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
\
#============================== Swoole ==================================
	&& cd ${SRC_DIR}/swoole-src-${SWOOLE_VERSION} \
        && phpize \
        && ./configure --enable-async-redis --enable-openssl --enable-mysqlnd --enable-coroutine \
        && make clean > /dev/null \
        && make \
        && make install \
        && rm -f ${SRC_DIR}/swoole-${SWOOLE_VERSION}.tar.gz \
        && rm -rf ${SRC_DIR}/swoole-src-${SWOOLE_VERSION} \
        && docker-php-ext-enable swoole \
\
\
\
&& apk del .build-deps \
&& pecl update-channels \
&& rm -rf /tmp/pear ~/.pearrc \
&& cd / \
&& docker-php-source delete

EXPOSE 9501
