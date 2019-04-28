FROM alpine/git:latest

RUN cd /usr && git clone https://github.com/viest/php-ext-excel-export.git


FROM php:7.2-fpm-alpine3.8

COPY --from=0 /usr/php-ext-excel-export /usr/src/php/ext/php-ext-excel-export/
COPY files /usr/src/

ENV PHPIZE_DEPS \
        autoconf \
	gcc \
        g++ \
        make \
        libxml2-dev \
        pcre-dev \
	freetype-dev

ENV PHPIZE_DEPS_PERSIST \
	gettext-dev \
	imagemagick-dev \
	rabbitmq-c-dev \
	libintl

RUN set -xe \
	 && echo 'http://mirrors.aliyun.com/alpine/v3.8/main/' > /etc/apk/repositories \
        && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        && apk add --no-cache --virtual .build-deps-persist\
	$PHPIZE_DEPS_PERSIST \
        && docker-php-source extract \
\
#========================= msgpack ==========================
&& pecl install msgpack \
&& docker-php-ext-enable msgpack \
#========================= protobuf ==========================
&& pecl install protobuf \
&& docker-php-ext-enable protobuf \
#========================= imagick ==========================
&& pecl install imagick \
&& docker-php-ext-enable imagick \
#========================= igbinary ==========================
&& pecl install igbinary \
&& docker-php-ext-enable igbinary \
#========================= Amqp ==========================
&& pecl install amqp \
&& docker-php-ext-enable amqp \
#========================= Mongodb ==========================
&& pecl install mongodb \
&& docker-php-ext-enable mongodb \
#============= Enable mysqli ======================
        && ( \
                cd /usr/src/php/ext/mysqli \
                && phpize \
                && ./configure --with-mysqli \
                && make && make install \
                && docker-php-ext-enable mysqli \
        ) \
#============= Enable xmlrpc ======================
        && ( \
                cd /usr/src/php/ext/xmlrpc \
                && phpize \
                && ./configure --with-xmlrpc \
                && make && make install \
                && docker-php-ext-enable xmlrpc \
        ) \
#============= Enable sysvsem ======================
        && ( \
                cd /usr/src/php/ext/sysvsem \
                && phpize \
                && ./configure --enable-sysvsem \
                && make && make install \
                && docker-php-ext-enable sysvsem \
        ) \
#============= Enable shmop ======================
        && ( \
                cd /usr/src/php/ext/shmop \
                && phpize \
                && ./configure --enable-shmop \
                && make && make install \
                && docker-php-ext-enable shmop \
        ) \
#============= Enable pcntl ======================
        && ( \
                cd /usr/src/php/ext/pcntl \
                && phpize \
                && ./configure --enable-pcntl \
                && make && make install \
                && docker-php-ext-enable pcntl \
        ) \
#============= Enable gettext ======================
        && ( \
                cd /usr/src/php/ext/gettext \
                && phpize \
                && ./configure --with-gettext \
                && make && make install \
                && docker-php-ext-enable gettext \
        ) \
#============= Enable bcmath ======================
       	&& ( \
               	cd /usr/src/php/ext/bcmath \
                && phpize \
       	        && ./configure --enable-math \
                && make && make install \
       	        && docker-php-ext-enable bcmath \
        ) \
#============= Enable sockets ======================
       	&& ( \
               	cd /usr/src/php/ext/sockets \
                && phpize \
       	        && ./configure --enable-sockets \
                && make && make install \
       	        && docker-php-ext-enable sockets \
        ) \
#============= Enable zip ======================
       	&& ( \
               	cd /usr/src/php/ext/zip \
                && phpize \
       	        && ./configure --enable-zip \
                && make && make install \
       	        && docker-php-ext-enable zip \
        ) \
#============= Enable openssl ====================
	&& ( \
                cd /usr/src/php/ext/openssl \
                && mv config0.m4 config.m4 \
                && phpize \
                && ./configure \
                && make && make install \
                && docker-php-ext-enable openssl \
        ) \
\
######################### GD library ##############################
\
&& cd /usr/src \
&& mkdir freetype \
&& tar xf freetype-2.9.1.tar.gz -C freetype --strip-components=1 \
&& cd freetype \
&& ./configure --prefix=/usr && make && make install && make clean \
&& rm -rf /usr/src/freetype-2.9.1.tar.gz \
&& rm -rf /usr/src/freetype \
\
## jpeg-9
&& cd /usr/src \
&& mkdir jpeg \
&& tar xf jpegsrc.v9.tar.gz -C jpeg --strip-components=1 \
&& cd jpeg \
&& ./configure --prefix=/usr/local/libjpeg && make && make install && make clean \
&& rm -rf /usr/src/jpegsrc.v9.tar.gz \
&& rm -rf /usr/src/jpeg \
\
## libwebp
&& cd /usr/src \
&& mkdir libwebp \
&& tar xf libwebp.0.6.0.tar.gz -C libwebp --strip-components=1 \
&& cd libwebp \
&& ./configure --prefix=/usr/local/libwebp \
            --enable-libwebpmux     \
            --enable-libwebpdemux   \
            --enable-libwebpdecoder \
            --enable-libwebpextras  \
            --enable-swap-16bit-csp \
            --disable-static \
&& make && make install && make clean \
&& rm -rf /usr/src/libwebp-0.6.0.tar.gz \
&& rm -rf /usr/src/libwebp \
\
# zlib
&& cd /usr/src \
&& mkdir zlib \
&& tar xf zlib-1.2.11.tar.gz -C zlib --strip-components=1 \
&& cd zlib \
&& ./configure --prefix=/usr && make && make install && make clean \
&& rm -rf /usr/src/zlib-1.2.11.tar.gz \
&& rm -rf /usr/src/zlib \
\
## libpng
&& cd /usr/src \
&& mkdir libpng \
&& tar xf libpng-1.6.34.tar.gz -C libpng --strip-components=1 \
&& cd libpng \
&& ./configure --prefix=/usr/local/libpng && make && make install && make clean \
&& ( \
        cd /usr/src/php/ext/gd \
        && phpize \
        && ./configure \
        --with-jpeg-dir=/usr/local/libjpeg \
        --with-png-dir=/usr/local/libpng \
#        --with-freetype-dir=/usr \
        --with-webp-dir=/usr/local/libwebp \
        --with-gd \
        --enable-gd-native-ttf \
        --with-zlib \
        && make \
        && make install \
        && make clean \
) \
&& docker-php-ext-enable gd \
&& rm -rf /usr/src/libpng-1.6.34.tar.gz \
&& rm -rf /usr/src/libpng \
\
#============= Enable pdo_mysql ======================
        && ( \
                cd /usr/src/php/ext/pdo_mysql \
                && phpize \
                && ./configure \
                && make && make install \
                && docker-php-ext-enable pdo_mysql \
        ) \
\
#========================= Redis ==========================
&& pecl install redis \
&& docker-php-ext-enable redis \
\
\
# ============================== xlswriter =======================
&& pecl install xlswriter \
&& docker-php-ext-enable xlswriter \
\
\
&& apk del .build-deps \
&& pecl update-channels \
&& rm -rf /tmp/pear ~/.pearrc \
&& docker-php-source delete
