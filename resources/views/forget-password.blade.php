<div dir="rtl">
    <h1>تغير كلمة المرور</h1>
    <p>مرحبا {{ $data['user']->first_name }}</p>
    <a href="https://examcommunity.herokuapp.com/reset-password/{{$data['token']}}">اضغط هنا لتغير كلمة المرور</a>
</div>