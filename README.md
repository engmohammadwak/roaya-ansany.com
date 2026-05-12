# رؤية إنسانية - Roaya Ansany

موقع رؤية إنسانية مبني بـ Laravel 11 + Filament 3

## متطلبات التشغيل
- PHP >= 8.2
- Composer
- MySQL
- Node.js (اختياري)

## خطوات التثبيت

```bash
# 1. استنساخ المشروع
git clone https://github.com/engmohammadwak/roaya-ansany.com.git
cd roaya-ansany.com

# 2. تثبيت الـ dependencies
composer install

# 3. نسخ ملف البيئة
cp .env.example .env

# 4. توليد مفتاح التطبيق
php artisan key:generate

# 5. تعديل بيانات قاعدة البيانات في .env
# DB_DATABASE=roaya_ansany
# DB_USERNAME=root
# DB_PASSWORD=

# 6. تشغيل الـ migrations والـ seeders
php artisan migrate --seed

# 7. ربط مجلد التخزين
php artisan storage:link

# 8. إنشاء مستخدم الداشبورد
php artisan make:filament-user

# 9. تشغيل السيرفر
php artisan serve
```

## الروابط
- الموقع العربي: `http://localhost:8000/ar`
- الموقع الإنجليزي: `http://localhost:8000/en`
- الداشبورد: `http://localhost:8000/admin`

## هيكل الداشبورد
- 📊 إحصائيات عامة (تبرعات، حملات، مقالات، رسائل)
- 📝 إدارة المقالات (إضافة، تعديل، حذف)
- 📢 إدارة الحملات
- 💰 عرض التبرعات
- ✉️ عرض رسائل التواصل
- ⚙️ إعدادات الموقع الكاملة (نصوص، صور، سوشيال ميديا، إلخ)
