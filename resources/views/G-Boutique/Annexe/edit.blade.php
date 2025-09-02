@extends('../G-Boutique/layouts')
@section('contenu')
 <div class="container-fluid px-4">
        <h1 class="mt-4">Annexes</h1>
        <div class="card">
        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                    <h5 style="color:white;">Modifier une annexe</h5>
                    <a href="{{ route('annexe.index') }}" class="btn btn-outline-light btn-sm">Liste</a>
            </div>
            <div class="card-body px-4 py-3">
        <form action="{{ route('annexe.update', $annexe->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nom" class="form-label">Nom de l'annexe</label>
                <input type="nom" name="nom" value="{{ $annexe->nom }}" class="form-control @error('nom') is-invalid @enderror" id="nom" required>
                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="iE" class="form-label">Email</label>
                <input type="email" name="email" value="{{ $annexe->email }}" class="form-control" id="iE">
            </div>
            </div>
            <div class="row mb-3">
            <div class="col-md-4">
                <label for="iT" class="form-label">Telephone</label>
                <input type="text" name="telephone" value="{{ $annexe->telephone }}" class="form-control @error('telephone') is-invalid @enderror" id="iT">
                @error('telephone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="iA" class="form-label">Adresse</label>
                <input type="text" value="{{ $annexe->adresse }}" name="adresse" class="form-control" id="iA">
            </div>
            <div class="col-md-4">
                <label for="iTb" class="form-label">Boutique</label>
                <select name="boutique_id" id="iTb" class="form-select @error('boutique_id') is-invalid @enderror">
                    @foreach ($boutiques as $boutique)
                        <option value="{{ $boutique->id }}" {{ $annexe->boutique_id == $boutique->id ? 'selected' : '' }}>
                            {{ $boutique->nom }}
                        </option>
                    @endforeach
                </select>
                @error('adresse')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solide fa-fw fa-save"></i>
                <span>Modifier</span>
            </button>
            <button type="reset" class="btn btn-info" data-bs-dismiss="modal">
                <i class="fa-solide fa-fw fa-times"></i>
                <span>Annuler</span>
            </button>
        </div>
        </form>
 </div>
 </div>
 </div>

@endsection
