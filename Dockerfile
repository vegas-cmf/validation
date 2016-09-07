FROM amsdard/phalcon:3.0.1-fpm-5.6
MAINTAINER Radoslaw Fafara <radek@amsterdamstandard.com>

ENV apt_update "apt-get update"
ENV apt_install "apt-get -y install --no-install-recommends"
ENV apt_clean "rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*"

# Install mongodb PHP module with required packages
RUN ${apt_update} && ${apt_install} libssl-dev \
    && pecl install mongo \
    && echo "extension=mongo.so" > ${PHP_INI_DIR}/conf.d/mongo.ini \
    && ${apt_clean}