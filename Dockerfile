#########################
# 1. Temel İmaj Olarak PHP 7.4-FPM Alıyoruz
#########################
FROM php:7.4-fpm

#########################
# 2. Sistemde Composer Kurulumu için Gerekli Paketleri Yükle
#########################
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

#########################
# 3. Composer'ı Global Olarak Kur
#########################
COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

#########################
# 4. Çalışma Dizini
#########################
WORKDIR /var/www/html

#########################
# 5. Composer Dependencies'i Yükle (kod mount edildikten sonra)
#########################
#    NOT: volumes ile mount ettikten sonra, 'composer install'
#    komutu hem host kodunu hem de vendor klasörünü container içinde oluşturacak.
#########################

#########################
# 6. Permissions Ayarı (opsiyonel, host→container UID/GID farkından ötürü)
#########################
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

#########################
# 7. Config Dosyalarını Kopyala
#########################
#    php.ini zaten docker-compose volumes ile mount edilecek.
#########################

#########################
# 8. Çalıştırılacak Komut (Boş Bırakıyoruz, docker-compose override eder)
#########################
CMD ["php-fpm"]
