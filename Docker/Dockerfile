FROM navidonskis/nginx-php7.1
MAINTAINER Matt McGowan

RUN export DEBIAN_FRONTEND=noninteractive && \
  apt-get update > /dev/null && \
  apt-get install -y \
  #-o Dpkg::Options::=--force-confdef \
  -o Dpkg::Options::=--force-confnew \
  php7.1-mysql \
  php7.1-curl \
  php7.1-gd \
  php7.1-intl \
  php7.1-mcrypt \
  php-memcache \
  php7.1-sqlite \
  php7.1-tidy \
  php7.1-xmlrpc \
  php7.1-pgsql \
  php7.1-ldap \
  freetds-common \
  php7.1-pgsql \
  php7.1-sqlite3 \
  php7.1-json \
  php7.1-xml \
  php7.1-mbstring \
  php7.1-soap \
  php7.1-zip \
  php7.1-cli \
  php7.1-sybase \
  php7.1-odbc \
  php7.1-bcmath

RUN apt-get autoremove -y && \
  apt-get clean && \
  apt-get autoclean
#  curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
#RUN apt install -y php-bcmath

COPY SCMS.tar /var/www
WORKDIR /var/www
RUN tar xf /var/www/SCMS.tar
RUN ls -l && pwd && ls -l /var/www/SCMS
RUN unlink SCMS.tar

WORKDIR /var/www/SCMS
RUN composer install; exit 0
