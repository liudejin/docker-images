FROM php:7.0-cli-alpine3.7

COPY files /usr/src/
COPY docker-php.ini /usr/local/etc/php/conf.d/


ENV PHPIZE_DEPS \
        autoconf \
	gcc \
        g++ \
        make \
	cmake \
        libxml2-dev \
	openssl-dev \
        pcre-dev \
	freetype-dev \
	zlib-dev

RUN set -xe \
	&& echo 'http://mirrors.aliyun.com/alpine/v3.7/main/' > /etc/apk/repositories \
        && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
	&& apk add bzip2-dev \
	&& echo 'http://mirrors.aliyun.com/alpine/v3.7/community/' > /etc/apk/repositories \
	&& apk add libzip-dev \
        && docker-php-source extract \
 \
#============= Enable bz2 ======================
        && ( \
               	cd /usr/src/php/ext/bz2 \
                && phpize \
       	        && ./configure --with-bz2 \
                && make && make install \
       	        && docker-php-ext-enable bz2 \
        ) \
\
#============= Enable soap ======================
        && ( \
               	cd /usr/src/php/ext/soap \
                && phpize \
       	        && ./configure --enable-soap \
                && make && make install \
       	        && docker-php-ext-enable soap \
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
       	        docker-php-ext-install zip \
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
