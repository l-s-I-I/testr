# اختيار صورة PHP
FROM php:8.0-cli

# نسخ ملفات المشروع
COPY . /var/www/html/

# تحديد مجلد العمل
WORKDIR /var/www/html/

# تثبيت التبعيات اللازمة
RUN apt-get update && apt-get install -y \
    curl \
    libcurl4-openssl-dev \
    && docker-php-ext-install curl

# تشغيل السكربت عند بدء الحاوية
CMD ["php", "bot.php"]
