<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PATCH')

    <!-- Name Field -->
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <!-- Email Field -->
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <!-- Profile Picture Field -->
    <div>
        <x-input-label for="phone_number" :value="__('Phone Number')" />
        <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $user->phone_number)" required />
        <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
    </div>
    
    <!-- Profile Picture Field -->
    <div class="space-y-2">
        <x-input-label for="profile_picture" :value="__('Profile Picture')" />
        <x-text-input id="profile_picture" name="profile_picture" type="file" class="mt-1 block w-full" />
        <p class="text-sm text-gray-500">{{ __('Upload a new profile picture (JPG, PNG, max 2MB)') }}</p>
        <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />

        <!-- Profile Picture Preview -->
        <div class="mt-4 flex items-center">
            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-avatar.jpg') }}" alt="Profile Picture" class="w-32 h-32 rounded-full object-cover border shadow">
        </div>
    </div>

    <!-- Save Button & Status Message -->
    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>

        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 dark:text-green-400">
                {{ __('Saved.') }}
            </p>
        @endif
    </div>
</form>
