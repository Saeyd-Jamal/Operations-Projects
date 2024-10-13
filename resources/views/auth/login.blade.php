@include('layouts.partials.header',['title' => config('app.name')])
    <div class="wrapper vh-100">
        <div class="row align-items-center h-100">
            <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="{{route('login')}}" method="POST" >
                @csrf
                <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="#">
                    <img src="{{asset('img/logo.png')}}" alt="logo..." style="max-width:90%;">
                </a>
                <h1 class="h3 m-3">تسجيل الدخول</h1>
                <div class="form-group">
                    <label for="username" class="sr-only">اسم المستخدم</label>
                    <x-form.input type="text" id="username" name="username" class="form-control-lg" placeholder="أدخل اسم المستخدم الخاص بك" required autofocus />
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="sr-only">كلمة المرور</label>
                    <x-form.input type="password" name="password" id="inputPassword" class="form-control-lg" placeholder="أدخل كلمة المرور" required="" />
                </div>
                {{-- <div class="checkbox mb-3">
                    <label>
                    <input type="checkbox" value="remember-me"> Stay logged in </label>
                </div> --}}
                <button class="btn btn-lg btn-primary btn-block" type="submit">هيا بنا</button>
                <div class="btn-box w-100 mt-3 mb-1">
                    <p class="text-muted font-weight-bold h6">© تم الإنشاء بواسطة <a href="https://saeyd-jamal.github.io/My_Portfolio/" target="_blank">م.السيد الأخرس</a></p>
                </div>
            </form>
        </div>
    </div>
@include('layouts.partials.footer')
