FROM ldjbenben/swoole:4.3-php7.3-cli

ENV GIT_DEPS \
        git

RUN  echo 'http://mirrors.aliyun.com/alpine/v3.8/main/' > /etc/apk/repositories \
        && apk add --no-cache --virtual .build-deps $GIT_DEP $GIT_DEPS \
&& php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php composer-setup.php \
&& php -r "unlink('composer-setup.php');" \
&& mv composer.phar /usr/local/bin/composer \
&& composer config -g repo.packagist composer https://packagist.laravel-china.org
