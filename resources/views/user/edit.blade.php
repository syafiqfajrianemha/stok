<x-guest-layout>
    <form method="POST" action="{{ route('user.update', $user->id) }}">
        @csrf
        @method('PATCH')

        <div>
            <x-input-label for="name" :value="__('Nama*')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ !old('name') ? $user->name : old('name') }}" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email*')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ !old('email') ? $user->email : old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="role" :value="__('Role*')" />
            <x-select-option id="role" class="block mt-1 w-full" name="role" required>
                <option selected disabled>Pilih Role</option>
                <option value="admin" @if ($user->role == "admin") selected @endif>Admin</option>
                <option value="karyawan" @if ($user->role == "karyawan") selected @endif>Karyawan</option>
            </x-select-option>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Edit') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
