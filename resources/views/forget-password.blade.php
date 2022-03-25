<div dir="rtl">
    <h1>تغير كلمة المرور</h1>
    <p>مرحبا {{ $data['user']->first_name }}</p>
    <a href="http://localhost:4200/auth/reset-password/{{$data['token']}}">لتغير كلمة المرور اضغط هنا</a>
</div>