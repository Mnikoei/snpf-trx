# README: سرویس‌های تراکنش و کاربر

## معرفی
منطق این تسک بصورت سرویس‌های مجزا با انتیتی‌های مستقل و کنار هم مثل ساختار پکیج‌های لاراولی پیاده شده.

### سرویس تراکنش
- **مسیر منطق سرویس**: `app/Services/Transaction`
- پیاده‌سازی با استاندارد **حسابداری دو سندی** صورت گرفته است که به عنوان هسته اکثر سیستم‌های مالی شناخته می‌شود.
- **تعریف اندپوینت‌ها**: در مسیر `app/Services/Transaction/Routes/routes.php` قرار دارد.

### سرویس کاربر
- **مسیر**: `app/Services/User`
- مدیریت منطق مرتبط با کاربران، ساختار یافته به صورت یک سرویس ماژولار مستقل.

## ساختار
```plaintext
app/
  Services/
    Transaction/
      Routes/
      Controllers/
      Models/
      Database/
      Tests/
    User/
      Entities/
      Routes/
      Controllers/
      Models/
      Database/
      Tests/
```

و در آخر اینکه برای تست و تست نویسی بیشتر فرصت بیشتری نیاز داشتم اما تا جای ممکن سعی کردم منطق خوانا و تست‌ها حداقل در حد عنوان نوشته بشه.
