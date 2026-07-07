<section class="space-y-6">

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Hapus Akun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Apakah kamu yakin ingin menghapus akun ini?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Setelah akun dihapus, semua data dan sumber daya terkait akan dihapus secara permanen. Masukkan password kamu untuk memastikan bahwa kamu benar-benar ingin menghapus akun ini secara permanen.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

           <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end sm:gap-0">
                <x-secondary-button x-on:click="$dispatch('close')" class="w-full justify-center sm:w-auto">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="w-full justify-center sm:w-auto sm:ms-3">
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>