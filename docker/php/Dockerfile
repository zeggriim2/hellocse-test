FROM dunglas/frankenphp

# Installer les extensions PHP nécessaires pour MariaDB
RUN apt-get update && apt-get install -y \
    libmariadb-dev unzip zip libpng-dev libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

ARG USER=application
ARG UID=1000
ARG GID=1000

RUN \
    # Add user and group
    groupadd -g ${UID} ${USER} && \
    useradd -u ${UID} -g ${USER} -m ${USER};

RUN \
	useradd -D ${USER}; \
	# Add additional capability to bind to port 80 and 443
	setcap CAP_NET_BIND_SERVICE=+eip /usr/local/bin/frankenphp; \
	# Give write access to /data/caddy and /config/caddy
	chown -R ${USER}:${USER} /data/caddy && chown -R ${USER}:${USER} /config/caddy;

USER application
