@extends('../G-Boutique/layouts')
@section('contenu')
 <div class="container-fluid px-4">
        <h1 class="mt-4">Boutique</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Creer une boutique</li>
        </ol>
        <form action="{{ route('boutique.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nom" class="form-label">Nom de l'entreprise</label>
                <input type="nom" name="nom" class="form-control @error('nom') is-invalid @enderror" id="nom" required>
                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" name="logo" class="form-control" id="logo">
                
            </div>
            <div class="col-md-6">
                <label for="iE" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="iE">
            </div>
            <div class="col-md-6">
                <label for="iT" class="form-label">Telephone</label>
                <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror" id="iT">
                @error('telephone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="iA" class="form-label">Adresse</label>
                <input type="text" name="adresse" class="form-control" id="iA">
            </div>
            <div class="col-md-6">
                <label for="iTb" class="form-label">Type de boutique</label>
                <select name="type_boutique" id="iTb" class="form-select @error('type_boutique') is-invalid @enderror">
                    <option value="">--Choisir--</option>
                    <option value="Alimentation">Alimentation</option>
                    <option value="Quincaillerie">Quincaillerie</option>
                    <option value="Magasin">Magasin</option>
                </select>
                @error('adresse')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
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