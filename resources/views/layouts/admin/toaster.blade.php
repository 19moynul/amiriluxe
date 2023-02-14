<style>
    .mi-fixed-alert p{
        margin-bottom: 0px;
        font-weight: 700;
        text-transform: uppercase
    }
</style>
<div class="mi-fixed-alert">
    @if ($success = Session::get('success'))
    <div class="alert success transparent fade show" role="alert">
        <p>{{ $success }}
            {{-- <button type="button" class="btn-close ps-3" data-bs-dismiss="alert" aria-label="Close"></button> --}}
        </p>
    </div>
    @endif

    @if ($warning = Session::get('warning'))
    <div class="alert warning transparent fade show" role="alert">
        <p>{{ $warning }}
            {{-- <button type="button" class="btn-close ps-3" data-bs-dismiss="alert" aria-label="Close"></button> --}}
        </p>
    </div>
    @endif

    @if ($error = Session::get('error'))
    <div class="alert danger transparent fade show" role="alert">
        <p>{{ $error }}
            {{-- <button type="button" class="btn-close ps-3" data-bs-dismiss="alert" aria-label="Close"></button> --}}
        </p>
    </div>
    @endif

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert danger fade show" role="alert">
        <p class="mb-0">{{ $error }}
            {{-- <button type="button" class="btn-close ps-3" data-bs-dismiss="alert" aria-label="Close"></button> --}}
        </p>
    </div>
    @endforeach
    @endif

</div>
