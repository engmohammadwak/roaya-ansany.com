<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; direction: rtl; }
  .card { background: #fff; border-radius: 12px; max-width: 560px; margin: auto; padding: 32px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
  .badge { display: inline-block; padding: 6px 18px; border-radius: 20px; font-size: 14px; font-weight: bold; margin-bottom: 20px; }
  .badge.success { background: #d1fae5; color: #065f46; }
  .badge.fail    { background: #fee2e2; color: #991b1b; }
  .amount { font-size: 32px; font-weight: 900; color: #1e293b; margin: 12px 0; }
  table { width: 100%; border-collapse: collapse; margin-top: 16px; }
  td { padding: 10px 8px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
  td:first-child { color: #64748b; width: 40%; }
  td:last-child { font-weight: 600; color: #1e293b; }
  .footer { text-align: center; color: #94a3b8; font-size: 12px; margin-top: 24px; }
</style>
</head>
<body>
<div class="card">
  <div class="badge {{ $success ? 'success' : 'fail' }}">
    {{ $success ? '✅ عملية ناجحة' : '❌ عملية فاشلة' }}
  </div>

  <div class="amount">
    {{ number_format($donation->amount, 2) }} {{ $donation->currency }}
  </div>

  <table>
    <tr><td>الاسم</td><td>{{ $donation->name ?: '—' }}</td></tr>
    <tr><td>البريد</td><td>{{ $donation->email ?: '—' }}</td></tr>
    <tr><td>الحملة</td><td>{{ $donation->campaign?->title_ar ?: $donation->campaign?->title ?: '—' }}</td></tr>
    <tr><td>الوصف</td><td>{{ $donation->description ?: '—' }}</td></tr>
    <tr><td>رقم العملية</td><td>{{ $donation->transaction_id ?: $donation->gateway_ref ?: '—' }}</td></tr>
    <tr><td>الحالة</td><td>{{ $success ? 'ناجحة' : 'فاشلة' }}</td></tr>
    <tr><td>التاريخ</td><td>{{ $donation->updated_at?->format('Y-m-d H:i') }}</td></tr>
  </table>

  <div class="footer">تنبيه تلقائي من لوحة تحكم الموقع</div>
</div>
</body>
</html>
