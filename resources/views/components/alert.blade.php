{{-- Part 1: Validation Errors (Red Alert) --}}
{{-- $errors->any() checks if there is at least one validation failure in the current session --}}
@if ($errors->any())
    {{-- alert-dismissible: Bootstrap class that allows the alert to be closed --}}
    {{-- fade show: Provides a smooth disappearing animation when closed --}}
    <!-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
        
        {{-- Strong and Icon: Visual indicators to grab user attention --}}
        <strong><i class="fa fa-exclamation-triangle"></i> Validation Errors!</strong>
        
        {{-- Unordered List: Neatly organizes multiple errors (e.g., Name missing, Email invalid) --}}
        <ul class="mt-2 mb-0">
            {{-- $errors->all() converts the error MessageBag into an array we can loop through --}}
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        {{-- The Close Button --}}
        {{-- data-bs-dismiss="alert": This is the critical Bootstrap attribute that triggers the delete action --}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> -->
@endif

{{-- Part 2: Success Messages (Green Alert) --}}
{{-- session('flash_message') checks if a success message was sent from the Controller redirect --}}
@if (session('flash_message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        
        <strong><i class="fa fa-check-circle"></i> Success!</strong>
        
        {{-- Display the specific message text defined in your Controller --}}
        <p class="mb-0">{{ session('flash_message') }}</p>

        {{-- The same dismissible button logic used for the error alert --}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif