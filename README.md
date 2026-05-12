# 🌍 رؤية إنسانية — Roaya Ansany

موقع تبرعات وحملات إنسانية مبني بـ **Laravel 11** + **Filament 3**، يدعم اللغتين العربية والإنجليزية، ويتكامل مع بوابة دفع **Paymob**.

---

## 🧩 نظرة عامة على المشروع

| العنصر | التفاصيل |
|---|---|
| Framework | Laravel 11 |
| Admin Panel | Filament 3 |
| قاعدة البيانات | MySQL |
| بوابة الدفع | Paymob (Intention API) |
| اللغات | عربي / إنجليزي (RTL + LTR) |
| الاستضافة | Linux Server / cPanel |

---

## 📦 متطلبات السيرفر

```
PHP >= 8.2
BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML extensions
Composer >= 2
MySQL >= 8
Node.js >= 18 (لبناء الأصول — اختياري في Production)
```

---

## 🚀 رفع المشروع على السيرفر — شرح مفصل

### 🔹 الطريقة 1: cPanel العادي (File Manager + Terminal)

#### الخطوة 1 — إعداد قاعدة البيانات
```
1. cPanel → MySQL Databases
2. اضغط "Create New Database"  → اسم مثل: roaya_ansany
3. اضغط "Create New User"       → اسم + كلمة مرور قوية
4. ادمج المستخدم بالقاعدة → أعطه صلاحية "ALL PRIVILEGES"
```

#### الخطوة 2 — رفع الملفات
```
1. cPanel → File Manager
2. افتح مجلد public_html (hو مجلد الدومين الرئيسي)
3. ارفع كل ملفات المشروع باستثناء مجلد public/ ← هذا يروح لـ public_html
```

> ⚠️ **مهم جداً:** محتوى مجلد `public/` فقط يروح داخل `public_html`، وباقي المشروع (app, routes, resources...) يروح خارج `public_html` في مجلد مستقل مثل `roaya_ansany/`

هيكل الملفات على السيرفر:
```
home/
├── public_html/          ← دا يشوفه المتصفح (محتوى public/)
└── roaya_ansany/         ← باقي المشروع (app, routes, vendor...)
```

#### الخطوة 3 — تعديل index.php
افتح `public_html/index.php` وعدّل السطرين التاليتين:
```php
// قبل
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// بعد
require __DIR__.'/../../roaya_ansany/vendor/autoload.php';
$app = require_once __DIR__.'/../../roaya_ansany/bootstrap/app.php';
```

#### الخطوة 4 — Terminal في cPanel
```bash
# انتقل لمجلد المشروع
cd ~/roaya_ansany

# تثبيت المكتبات
composer install --optimize-autoloader --no-dev

# نسخ .env
cp .env.example .env

# عدّل بيانات الـ .env
nano .env

# توليد المفتاح
php artisan key:generate

# تشغيل الـ migrations
php artisan migrate --seed

# ربط Storage
php artisan storage:link

# جدول الإشعارات
php artisan notifications:table
php artisan migrate

# إنشاء مستخدم الداشبورد
php artisan make:filament-user

# تحسين الأداء
php artisan optimize
```

---

### 🔹 الطريقة 2: VPS / SSH (الطريقة المحترفة)

#### الخطوة 1 — الدخول للسيرفر
```bash
ssh root@YOUR_SERVER_IP
# أو
 ssh username@YOUR_SERVER_IP -p 22
```

#### الخطوة 2 — تثبيت المتطلبات (لو Ubuntu)
```bash
apt update && apt upgrade -y
apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-mbstring \
    php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip \
    php8.2-gd php8.2-intl unzip curl git

# Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```

#### الخطوة 3 — استنساخ المشروع
```bash
cd /var/www
git clone https://github.com/engmohammadwak/roaya-ansany.com.git roaya
cd roaya
```

#### الخطوة 4 — إعداد المشروع
```bash
composer install --optimize-autoloader --no-dev
cp .env.example .env
nano .env                          # عدّل كل البيانات
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan notifications:table
php artisan migrate
php artisan make:filament-user
php artisan optimize
```

#### الخطوة 5 — صلاحيات المجلدات
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data /var/www/roaya
```

#### الخطوة 6 — إعداد Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/roaya/public;

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # منع الوصول لملفات حساسة
    location ~* /(\.(env|git|htaccess)|vendor|storage/app) {
        deny all;
    }
}
```

```bash
# تفعيل الإعداد
ln -s /etc/nginx/sites-available/roaya /etc/nginx/sites-enabled/
nginx -t && systemctl reload nginx

# HTTPS بـ Let's Encrypt
apt install certbot python3-certbot-nginx -y
certbot --nginx -d your-domain.com -d www.your-domain.com
```

---

### 🔹 الطريقة 3: تحديث تلقائي بـ Git (Auto Deploy)

بعد أي تعديل و push على GitHub، شغّل هذا على السيرفر:

```bash
cd /var/www/roaya    # أو ~/roaya_ansany على cPanel

git pull origin main

composer install --optimize-autoloader --no-dev

php artisan migrate --force

php artisan optimize:clear
php artisan optimize
```

#### أتمتة أكثر: Deploy Script
احفظ هذا كـ `deploy.sh` في جذر المشروع:

```bash
#!/bin/bash
set -e

echo "🔄 جاري تحديث المشروع..."

git pull origin main

echo "📦 تثبيت المكتبات..."
composer install --optimize-autoloader --no-dev --quiet

echo "🗄️ تشغيل الميجراشن..."
php artisan migrate --force

echo "🧹 تنظيف الكاش..."
php artisan optimize:clear

echo "⚡ بناء الكاش..."
php artisan optimize

echo "✅ تم التحديث بنجاح!"
```

```bash
# تشغيله
 chmod +x deploy.sh
./deploy.sh
```

---

## 📄 إعداد ملف `.env`

```env
APP_NAME="رؤية إنسانية"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=roaya_ansany
DB_USERNAME=root
DB_PASSWORD=your_password

# ====== إعدادات الإيميل ======
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@email.com
MAIL_FROM_NAME="رؤية إنسانية"

# ====== Paymob ======
# يتم ضبطه من داخل الداشبورد
```

> ⚠️ **Gmail:** استخدم App Password من: Google → Security → 2-Step Verification → App Passwords

---

## 🗂️ هيكل الداشبورد

| القسم | الوظيفة |
|---|---|
| 📊 الإحصائيات | تبرعات، حملات، مقالات، رسائل |
| 💰 التبرعات | عرض كل التبرعات مع حالة الدفع |
| 📢 الحملات | إنشاء وإدارة حملات التبرع |
| 📝 المقالات | إدارة المدونة |
| ✉️ الرسائل | رسائل تواصل معنا |
| ⚙️ إعدادات الموقع | ألوان، نصوص، لوجو، روابط النافبار |
| 💳 إعدادات الدفع | Paymob API keys، test/live mode |

---

## 💳 نظام الدفع (Paymob)

- يعمل في **Test Mode** تلقائياً حتى تفعّله من الداشبورد
- عند اكتمال الدفع أو فشله يصلك:
  - 🔔 **إشعار في الداشبورد** (notification bell)
  - 📧 **إيميل** على `engmohammadwk@gmail.com`

---

## 🔗 الروابط

```
الموقع العربي  : https://your-domain.com/ar
الموقع الإنجليزي: https://your-domain.com/en
الداشبورد      : https://your-domain.com/admin
```

---

## 🖥️ ملاحظات السيرفر المهمة

```bash
# بعد أي git pull شغّل دائماً:
php artisan optimize:clear
php artisan migrate --force

# صلاحيات المجلدات
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# لو الصور ما تظهر
php artisan storage:link

# لو CSS/JS ما يتحدث
php artisan view:clear && php artisan config:clear
```

### إعداد Cron
```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

### Queue Worker
```bash
php artisan queue:work --sleep=3 --tries=3 --daemon
```

---

## 🛠️ أوامر مفيدة

```bash
# مسح كل cache
php artisan optimize:clear

# إعادة بناء
php artisan optimize

# عرض الـ routes
php artisan route:list

# فحص الإيميل
php artisan tinker
# ثم: Mail::raw('test', fn($m) => $m->to('engmohammadwk@gmail.com')->subject('test'));
```

---

## 📁 هيكل المجلدات

```
app/
├── Filament/           ← لوحة التحكم (Resources, Pages, Widgets)
├── Http/Controllers/   ← Controllers (Payment, Contact, Blog...)
├── Http/Middleware/     ← حماية (SecurityHeaders, BlockSuspicious, PaymentLimit)
├── Mail/               ← Mailables (PaymentNotification)
├── Models/             ← Eloquent Models
└── Services/           ← خدمات مساعدة

resources/views/
├── filament/           ← views الداشبورد المخصصة
├── emails/             ← قوالب الإيميلات
└── pages/              ← صفحات الموقع
```
