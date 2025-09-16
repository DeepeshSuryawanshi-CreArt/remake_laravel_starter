<x-guest-layout>
    <div class="page" data-animsition-in="fade-in" data-animsition-out="fade-out">
        <div class="page-content">
            <div class="page-brand-info">
                <div class="brand">
                    <img class="brand-img" src="../../assets/images/logo@2x.png" alt="...">
                    <h2 class="brand-text font-size-40">Remark</h2>
                </div>
                <p class="font-size-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>

            <div class="page-login-main">
                <div class="brand hidden-md-up">
                    <img class="brand-img" src="../../assets/images/logo-colored@2x.png" alt="...">
                    <h3 class="brand-text font-size-40">Remark</h3>
                </div>

                <!-- Display Session Status -->
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Display Auth Errors -->
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h3 class="font-size-24">Sign In</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>

                <form method="post" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="email" class="form-control empty" :value="old('email')" id="inputEmail"
                            name="email" required>
                        <label class="floating-label" for="inputEmail">Email</label>
                    </div>
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="password" class="form-control empty" id="inputPassword" name="password">
                        <label class="floating-label" for="inputPassword">Password</label>
                    </div>
                    <div class="form-group clearfix">
                        <div class="checkbox-custom checkbox-inline checkbox-primary float-left">
                            <input type="checkbox" id="remember" name="checkbox">
                            <label for="inputCheckbox">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                </form>

                <p>No account? <a href="{{ route('register') }}">Sign Up</a></p>

                <footer class="page-copyright">
                    <p>WEBSITE BY Creation Studio</p>
                    <p>© 2018. All RIGHT RESERVED.</p>
                    <div class="social">
                        <a class="btn btn-icon btn-round social-twitter mx-5" href="javascript:void(0)">
                            <i class="icon bd-twitter" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-icon btn-round social-facebook mx-5" href="javascript:void(0)">
                            <i class="icon bd-facebook" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-icon btn-round social-google-plus mx-5" href="javascript:void(0)">
                            <i class="icon bd-google-plus" aria-hidden="true"></i>
                        </a>
                    </div>
                </footer>
            </div>

        </div>
    </div>
</x-guest-layout>