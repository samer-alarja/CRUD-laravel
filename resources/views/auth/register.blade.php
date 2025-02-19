<x-app-layout>
    <x-guest-layout>
        <form id="rigster-form" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('first name :')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
                <span class="text-danger" id="name-error"></span>
            </div>

            <br>
            <div>
                <x-input-label for="last_name" :value="__('last name :')" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                    :value="old('last_name')" required autofocus autocomplete="last_name" />
                <span class="text-danger" id="last_name-error"></span>
            </div>
            <!-- type -->
            <p style="margin:10px 0 5px 0">ruls :</p>
            <div>
                <input id="user" type="radio" name="usertype" value="user">
                <label for="user">student</lable>

                    <input id="admin" type="radio" name="usertype" value="admin" style="margin-left:20px">
                    <label for="admin">teacher</lable>
            </div>
            <span class="text-danger" id="usertype-error"></span>
            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <span class="text-danger" id="email-error"></span>
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <span class="text-danger" id="password-error"></span>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <span class="text-danger" id="password_confirmation-error"></span>
            </div>

            <!-- gender         -->
            <div>
                <p style="margin-top:10px">gender :</p>
                <input id="female" type="radio" name="gender" value="female">
                <label for="female">female</lable>

                    <input id="male" type="radio" name="gender" value="male" style="margin-left:20px">
                    <label for="male">male</lable>
            </div>
            <span class="text-danger" id="gender-error"></span>

            <!-- Confirm date -->
            <div class="form-group" style="margin-top:10px">
                <label for="birthdate">Birthdate :</label>
                <input type="date" name="birthdate" class="form-control" id="birthdate" required>
                <span class="text-danger" id="birthdate-error"></span>

            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>
<script>
    $(document).ready(function () {
        $('#rigster-form').on('submit', function (event) {
            event.preventDefault();
            $('#name-error').text('');
            $('#last_name-error').text('');
            $('#usertype-error').text('');
            $('#email-error').text('');
            $('#password-error').text('');
            $('#password_confirmation-error').text('');
            $('#gender-error').text('');
            $('#birthdate-error').text('');

            var formData = new FormData(this);
            $.ajax({
                url: $('#rigster-form').attr('action'),
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.redirect_url) {
                        window.location.href = response.redirect_url;
                    }
                },
                error: function (xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.name) {
                        $('#name-error').text(errors.name[0]);
                    }
                    if (errors.last_name) {
                        $('#last_name-error').text(errors.last_name[0]);
                    }
                    if (errors.usertype) {
                        $('#usertype-error').text(errors.usertype[0]);
                    }
                    if (errors.email) {
                        $('#email-error').text(errors.email[0]);
                    }
                    if (errors.password) {
                        $('#password-error').text(errors.password[0]);
                    }
                    if (errors.password_confirmation) {
                        $('#password_confirmation-error').text(errors.password_confirmation[0]);
                    }
                    if (errors.gender) {
                        $('#gender-error').text(errors.gender[0]);
                    }
                    if (errors.birthdate) {
                        $('#birthdate-error').text(errors.birthdate[0]);
                    }
                }
            });
        });
    });
</script>