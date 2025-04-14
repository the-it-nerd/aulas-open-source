FROM dunglas/frankenphp:1.5-php8.3-alpine
ARG COMPOSER_VERSION=2.7.0

# Define Magento Root earlier for use in USER setup
ARG MAGENTO_ROOT=/app
ARG USER_ID=1000
ARG GROUP_ID=1000

ARG COMPOSER_ALLOW_SUPERUSER=1
ARG COMPOSER_HOME=/composer
ARG CRONTAB=""

# Environment Variables
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer \
    COMPOSER_MEMORY_LIMIT=-1 \
    COMPOSER_CLEAR_CACHE=false \
    PATH="${COMPOSER_HOME}/vendor/bin:/usr/local/node/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin" \
    PHP_MEMORY_LIMIT=-1 \
    PHP_VALIDATE_TIMESTAMPS=1 \
    DEBUG=false \
    MAGENTO_RUN_MODE=developer \
    CADDY_GLOBAL_OPTIONS="auto_https off" \
    FRANKENPHP_CONFIG="worker /app/pub/index.php"

# Create appuser and appgroup
RUN addgroup -g ${GROUP_ID} appgroup && \
    adduser -u ${USER_ID} -G appgroup -s /bin/sh -D appuser

RUN apk update && apk upgrade

# Add Node.js repository and install Node.js 22
RUN apk add --no-cache curl xz && \
    curl -sL https://unofficial-builds.nodejs.org/download/release/v22.0.0/node-v22.0.0-linux-x64-musl.tar.xz -o node-v22.0.0-linux-x64-musl.tar.xz && \
    tar -xJf node-v22.0.0-linux-x64-musl.tar.xz && \
    mv node-v22.0.0-linux-x64-musl /usr/local/node && \
    ln -s /usr/local/node/bin/node /usr/local/bin/node && \
    ln -s /usr/local/node/bin/npm /usr/local/bin/npm && \
    ln -s /usr/local/node/bin/npx /usr/local/bin/npx && \
    rm node-v22.0.0-linux-x64-musl.tar.xz

# Install base packages and build dependencies
RUN apk add --no-cache \
    acl \
    bash \
    git \
    mariadb-client \
    msmtp \
    nano \
    openssh-client \
    python3 \
    py3-pip \
    sudo \
    unzip \
    vim \
    gnupg \
    ca-certificates \
    lsb-release \
    autoconf \
    alpine-sdk \
    g++ \
    gcc \
    make \
    libbz2 \
    libjpeg-turbo-dev \
    libpng-dev \
    freetype-dev \
    gmp-dev \
    icu-dev \
    openldap-dev \
    pcre-dev \
    aspell-dev \
    tidyhtml-dev \
    libxslt-dev \
    libzip-dev \
    yaml-dev \
    zip \
    py3-yaml \
    procps \
    redis

# Install required PHP Extensions
# Install required PHP Extensions for Magento 2.4.7
# Ensure 'redis' is included even if using DragonflyDB, as Magento checks for it.
# Added opcache explicitly.
RUN install-php-extensions \
    bcmath \
    bz2 \
    calendar \
    ctype \
    curl \
    dom \
    exif \
    fileinfo \
    ftp \
    gd \
    gettext \
    gmp \
    iconv \
    intl \
    ldap \
    mbstring \
    mysqli \
    opcache \
    pcntl \
    pdo_mysql \
    phar \
    redis \
    session \
    simplexml \
    soap \
    sockets \
    sodium \
    sysvmsg \
    sysvsem \
    sysvshm \
    tidy \
    tokenizer \
    xml \
    xsl \
    zip \
    xdebug

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --version=${COMPOSER_VERSION} --filename=composer && \
    composer --version

# Configuration files setup (adjust paths if necessary)
# These will be copied relative to the build context
COPY etc/php-cli.ini /usr/local/etc/php/conf.d/zz-magento.ini
COPY etc/php-xdebug.ini /usr/local/etc/php/conf.d/zz-xdebug-settings.ini
COPY etc/php-pcov.ini /usr/local/etc/php/conf.d/zz-pcov-settings.ini
COPY etc/mail.ini /usr/local/etc/php/conf.d/zz-mail.ini
COPY --link Caddy/Caddyfile /etc/caddy/Caddyfile

# COPY config/php/php-gnupg.ini /usr/local/etc/php/conf.d/gnupg.ini # Only if gnupg is really needed and installed

# Install Grunt
RUN npm install -g grunt-cli

# Create Magento root directory and set permissions
RUN mkdir -p ${MAGENTO_ROOT}/pub ${MAGENTO_ROOT}/var ${MAGENTO_ROOT}/generated /composer && \
    chown -R appuser:appgroup ${MAGENTO_ROOT} /composer /var/log/ /data/caddy/


ENV MAGE_MODE=developer XDEBUG_MODE=on

# Switch to non-root user
USER appuser:appgroup

WORKDIR ${MAGENTO_ROOT}

EXPOSE 80
# Use the explicit config file path
CMD [ "frankenphp", "run", "--config", "/etc/caddy/Caddyfile", "--watch" ]
