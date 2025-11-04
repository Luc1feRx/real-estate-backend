# You can override PHP_BASE from docker-compose build args.
ARG PHP_BASE=php:8.4-fpm-alpine
FROM ${PHP_BASE}

# ---------- System deps ----------
RUN set -eux; \
    apk update; \
    apk add --no-cache \
      bash git curl tzdata \
      icu-dev libzip-dev oniguruma-dev \
      freetype-dev libpng-dev libjpeg-turbo-dev \
      libxml2-dev linux-headers autoconf make g++;

# ---------- PHP extensions (Laravel common set) ----------
# gd needs configure to enable jpeg/freetype
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) \
      pdo_mysql bcmath exif pcntl intl zip gd opcache

# ---------- PECL extensions ----------
# redis php extension (optional but recommended when you use Redis)
RUN pecl install redis \
 && docker-php-ext-enable redis

# ---------- Composer ----------
# Grab official composer binary (small & fast)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ---------- PHP runtime tweaks ----------
# Use production php.ini as baseline
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
 && { \
      echo "memory_limit=512M"; \
      echo "upload_max_filesize=64M"; \
      echo "post_max_size=64M"; \
      echo "max_execution_time=120"; \
      echo "date.timezone=UTC"; \
    } >> "$PHP_INI_DIR/php.ini"

# Opcache defaults; can be overridden by env
RUN { \
      echo "opcache.enable=1"; \
      echo "opcache.enable_cli=1"; \
      echo "opcache.memory_consumption=192"; \
      echo "opcache.max_accelerated_files=20000"; \
      echo "opcache.validate_timestamps=\${PHP_OPCACHE_VALIDATE_TIMESTAMPS:-1}"; \
      echo "opcache.revalidate_freq=0"; \
    } > /usr/local/etc/php/conf.d/opcache.ini

RUN apk add --no-cache bash curl

# Bật repo edge để lấy Node mới nhất
RUN echo "https://dl-cdn.alpinelinux.org/alpine/edge/main" >> /etc/apk/repositories \
  && echo "https://dl-cdn.alpinelinux.org/alpine/edge/community" >> /etc/apk/repositories \
  && apk update \
  && apk add --no-cache nodejs-current npm \
  && npm i -g npm@latest yarn pnpm \
  && node -v && npm -v

# ---------- Workdir ----------
WORKDIR /var/www/html

# Avoid permission surprises in container
RUN addgroup -g 1000 -S www && adduser -u 1000 -S www -G www \
 && chown -R www:www /var/www/html
USER www

EXPOSE 9000
CMD ["php-fpm"]
