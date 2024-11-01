# 使用官方 PHP 镜像
FROM php:8.1-apache

# 安装必要的 PHP 扩展和工具
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql

# 设置工作目录
WORKDIR /var/www/html/

# 复制 .env 文件
# COPY .env ./

# 复制项目文件
COPY . .

# 安装 Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 运行 Composer 安装
RUN composer install --no-scripts --no-plugins

# 设置 PHP 错误显示
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-errors.ini
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-errors.ini

# 设置文件夹权限（可选）
RUN chown -R www-data:www-data /var/www/html

# 暴露容器的80端口
EXPOSE 80