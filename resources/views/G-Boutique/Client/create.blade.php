@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Client</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Creer un client</li>
        </ol>
        <form action="{{ route('client.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" class="form-control @error('prenom') is-invalid @enderror"
                        id="prenom" required>
                    @error('prenom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" class="form-control @error('nom') is-invalid @enderror"
                        id="nom" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="iT" class="form-label">Telephone</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}" class="form-control @error('telephone') is-invalid @enderror"
                        id="iT">
                    @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="iE" class="form-label">Email</label>
                    <input type="email" value="{{ old('email') }}" name="email" class="form-control" id="iE">
                </div>
                <div class="col-md-4">
                    <label for="iA" class="form-label">Adresse</label>
                    <input type="text" name="adresse" value="{{ old('adresse') }}" class="form-control" id="iA">
                </div>

                {{-- <input type="hidden" name="boutique_id" value="{{ $boutique->id }}">
            <input type="hidden" name="annexe_id" value="{{ $annexe->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}"> --}}

            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solide fa-fw fa-save"></i>
                    <span>Enregistrer</span>
                </button>
                <button type="reset" class="btn btn-info" data-bs-dismiss="modal">
                    <i class="fa-solide fa-fw fa-times"></i>
                    <span>Annuler</span>
                </button>
            </div>
        </form>
    </div>
@endsection
