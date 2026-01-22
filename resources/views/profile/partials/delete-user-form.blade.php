<section class="mt-4">
    <header>
        <h2 class="h5 font-weight-bold text-danger">
            {{ __('Delete Account') }}
        </h2>

        <p class="text-muted small">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
    </header>

    <button
        class="btn btn-danger"
        data-toggle="modal" 
        data-target="#confirmUserDeletion"
    >{{ __('Delete Account') }}</button>

    <div class="modal fade" id="confirmUserDeletion" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                    @csrf
                    @method('delete')

                    <h5 class="modal-title font-weight-bold mb-3" id="deleteModalLabel">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h5>

                    <p class="text-muted small">
                        {{ __('Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="form-group mt-3">
                        <label for="password" class="sr-only">{{ __('Password') }}</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control"
                            placeholder="{{ __('Password') }}"
                        />
                        @if($errors->userDeletion->get('password'))
                            <small class="text-danger mt-1">{{ $errors->userDeletion->get('password')[0] }}</small>
                        @endif
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>

                        <button type="submit" class="btn btn-danger">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>