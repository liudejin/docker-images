FROM ldjbenben/swoole:4.2-php7.3-cli

ENV GIT_DEPS \
        git

RUN  echo 'http://mirrors.aliyun.com/alpine/v3.8/main/' > /etc/apk/repositories \
        && apk add --no-cache --virtual .build-deps $GIT_DEP $GIT_DEPS
