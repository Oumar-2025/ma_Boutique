@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Utilisateurs</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Créer un utilisateur</h5>
                <a href="{{ route('users.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-list"></i>
                    Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nom" class="form-label">Nom complet</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('nom') is-invalid @enderror" id="nom" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="col-md-4">
                            <label for="iE" class="form-label">Email</label>
                            <input type="email" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="iE">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="iA" class="form-label">Mot de passe</label>
                            <input type="text" name="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" id="iA">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        @if(auth()->user()->role == 'super_admin' && auth()->user()->id == 1)
                        <div class="col-md-6">
                            <label for="boutique" class="form-label">Boutique</label>
                            <select name="boutique_id" id="boutique" class="form-select @error('boutique_id') is-invalid @enderror">
                                <option value="#">--Choisir--</option>
                                @foreach ($boutiques as $boutique)
                                    <option value="{{ $boutique->id }}" {{ old('boutique_id') == $boutique->id ? 'selected' : ''}}>{{ $boutique->nom }}</option>
                                @endforeach
                            </select>
                            @error('boutique_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="iA" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                                <option value="#">--Choisir--</option>
                                <option value="gerant" {{ old('gerant') == 'gerant' ? 'selected' : ''}}>Gérant(e)</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @elseif(auth()->user()->role == 'gerant' && auth()->user()->boutique_id != null)
                        <div class="col-md-4">
                            <label for="iA" class="form-label">Boutique</label>
                            <input type="hidden" name="boutique_id" value="{{auth()->user()->boutique_id}}">
                            <input type="text" class="form-control" value="{{auth()->user()->boutique->nom}}" readonly>
                            @error('boutique')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="iA" class="form-label">Annexe</label>
                            <select name="annexe_id" id="annexe" class="form-select @error('annexe_id') is-invalid @enderror">
                                <option value="#">--Choisir--</option>
                                @foreach ($annexes as $annexe)
                                    <option value="{{ $annexe->id }}" {{ old('annexe_id') == $annexe->id ? 'selected' : ''}}>{{ $annexe->nom }}</option>
                                @endforeach
                            </select>
                            @error('annexe_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="iA" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                                <option value="#">--Choisir--</option>
                                <option value="caissier" {{ old('caissier') == 'caissier' ? 'selected' : ''}}>Caissier(e)</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        {{-- <input type="hidden" name="boutique_id" value="{{ $boutique->id }}">
            <input type="hidden" name="annexe_id" value="{{ $annexe->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}"> --}}

                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-fw fa-save"></i>
                            <span>Enregistrer</span>
                        </button>
                        <button type="reset" class="btn btn-info" data-bs-dismiss="modal">
                            <i class="fa-solid fa-fw fa-times"></i>
                            <span>Annuler</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
