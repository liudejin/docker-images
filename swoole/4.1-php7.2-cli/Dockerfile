FROM php:7.2.9-cli-alpine3.8

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
\
RUN cd /usr/src \
	&& ( \
		cd /usr/src/php/ext/sockets \
		&& phpize \
		&& ./configure --enable-sockets \
		&& make && make install \
		&& docker-php-ext-enable sockets \
	) \
	&& ( \
		cd /usr/src/php/ext/openssl \
		&& mv config0.m4 config.m4 \
		&& phpize \
		&& ./configure \
		&& make && make install \
		&& docker-php-ext-enable openssl \
	) \
	&& echo -e "yes\nyes\nyes\nyes\nyes\nyes\n" | pecl install swoole \
	&& docker-php-ext-enable swoole \
\
&& apk del .build-deps \
&& pecl update-channels \
&& rm -rf /tmp/pear ~/.pearrc \
&& cd / \
&& docker-php-source delete

EXPOSE 9501
