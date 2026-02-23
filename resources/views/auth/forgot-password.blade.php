@extends("layout")
@section("content")

<div class="container py-5">
    <h2 class="mb-4">Új jelszó igénylése</h2>
  <div class="container">
    @if(session("success"))
        <p class="text-success text-center">{{ session('success') }}</p>
    @else
        <p class="text-danger text-center">{{ session('unsuccessful') }}</p>
  </div>
@endif
    <form action="/forgot-password" method="post">
        @csrf
        <hr class="w-50 mx-auto">

        <div class="row mb-4">
            <div class="col-md-6">
                <h4>Új jelszó igénylése</h4>
                <div class="mb-3">
                    <label for="email" class="form-label">Email címe:</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
             {{-- <div class="col-md-6">
                <h4>Privacy Settings</h4>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="profileVisibilityCheck" checked>
                    <label class="form-check-label" for="profileVisibilityCheck">Make profile visible to others</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="activityTrackingCheck" checked>
                    <label class="form-check-label" for="activityTrackingCheck">Allow activity tracking for personalized experience</label>
                </div>
            </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            {{-- <button type="button" class="btn btn-secondary btn-lg">Visszavonás</button> --}}
            <button type="submit" class="btn btn-primary btn-lg" name="mentes" id="mentes" value="mentes">Új jelszó igénylése</button>
        </div>
    </form>
</div>
@endsection
