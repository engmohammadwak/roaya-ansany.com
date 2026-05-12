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

## ⚙️ خطوات التثبيت

```bash
# 1. استنساخ المشروع
git clone https://github.com/engmohammadwak/roaya-ansany.com.git
cd roaya-ansany.com

# 2. تثبيت الـ dependencies
composer install --optimize-autoloader --no-dev

# 3. نسخ ملف البيئة
cp .env.example .env

# 4. توليد مفتاح التطبيق
php artisan key:generate

# 5. إعداد قاعدة البيانات في .env
# DB_DATABASE=roaya_ansany
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 6. تشغيل الـ migrations
php artisan migrate --seed

# 7. ربط مجلد التخزين
php artisan storage:link

# 8. إنشاء جدول الإشعارات (مطلوب لإشعارات الداشبورد)
php artisan notifications:table
php artisan migrate

# 9. إنشاء مستخدم الداشبورد
php artisan make:filament-user

# 10. تحسين الأداء
php artisan optimize
php artisan view:cache
php artisan config:cache
php artisan route:cache
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
MAIL_HOST=smtp.gmail.com        # أو smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@email.com
MAIL_FROM_NAME="رؤية إنسانية"

# ====== Paymob ======
# يتم ضبطه من داخل الداشبورد ← إعدادات الدفع
```

> ⚠️ **ملاحظة Gmail:** استخدم **App Password** وليس كلمة المرور العادية.
> من إعدادات Google → Security → 2-Step Verification → App Passwords

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
  - 📧 **إيميل** على `engmohammadwk@gmail.com` يحتوي: الاسم، المبلغ، الحملة، رقم العملية

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
# بعد أي git pull على السيرفر شغّل:
php artisan optimize:clear
php artisan migrate
php artisan storage:link   # مرة وحدة فقط

# صلاحيات المجلدات (مهم جداً)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# لو الصور ما تظهر
php artisan storage:link

# لو CSS/JS ما يتحدث
php artisan view:clear
php artisan config:clear
```

### إعداد Cron (لو في Queue أو Scheduled Tasks)
```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

### إعداد Queue Worker (للإيميلات بشكل async — اختياري)
```bash
php artisan queue:work --sleep=3 --tries=3 --daemon
```

---

## 🛠️ أوامر مفيدة

```bash
# مسح كل الـ cache
php artisan optimize:clear

# إعادة بناء كل شي
php artisan optimize

# عرض الـ routes
php artisan route:list

# فحص الإيميل (test)
php artisan tinker
# ثم: Mail::raw('test', fn($m) => $m->to('engmohammadwk@gmail.com')->subject('test'));
```

---

## 📁 هيكل المجلدات المهمة

```
app/
├── Filament/           ← لوحة التحكم (Resources, Pages, Widgets)
├── Http/Controllers/   ← Controllers (Payment, Contact, Blog...)
├── Mail/               ← Mailables (PaymentNotification...)
├── Models/             ← Eloquent Models
└── Services/           ← خدمات مساعدة

resources/
├── views/
│   ├── filament/       ← views لوحة التحكم المخصصة
│   ├── emails/         ← قوالب الإيميلات
│   └── pages/          ← صفحات الموقع
```
