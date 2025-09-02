@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
            <h1 class="mt-4">Produits (stock)</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center text-white">
                <h4 class="row">Vente</h4>
                <div class="btn-group">
                    <a href="#" class="btn btn-light btn-sm">
                        <i class="fa-solid fa-list"></i> Afficher
                    </a>
                </div>
            </div><br>

            <div class="row mb-3">
                {{-- Formulaire de saisie colis --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">Ajouter un produit au panier</div>
                        <div class="card-body">
                            <form action="{{ route('panier.ajouter') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="produit_id" class="form-label">Nom</label>
                                        <select name="produit_id" id="produit_id"
                                            class="form-select @error('produit_id') is-invalid @enderror">
                                            <option value="">Sélectionner un produit</option>
                                            {{-- Boucle à travers les produits disponibles --}}
                                            @foreach ($produits as $produit)
                                                <option value="{{ $produit->id }}"
                                                    {{ old('produit_id') == $produit->id ? 'selected' : '' }}>
                                                    {{ $produit->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('produit_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="quantite" class="form-label">Quantité</label>
                                        <input type="number" id="quantite"
                                            class="form-control @error('quantite') is-invalid @enderror" name="quantite"
                                            placeholder="Nombre" value="{{ old('quantite') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="prix_vente" class="form-label">P.U (Fcfa)</label>
                                        <input type="number" id="prix_vente" class="form-control" name="prix_vente"
                                            value="{{ old('prix_vente') }}" placeholder="Entrer le prix">
                                    </div>
                                </div>



                                    <div class="card-footer">
                                        <!-- Assure-toi que le bouton n'a pas type="submit" -->
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-fw fa-plus"></i>
                                            <span>Ajouter au pannier</span></button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i
                                                class="fas fa-fw fa-times"></i>
                                            <span>Annuler</span></button>

                                    </div>


                            </form>
                        </div>
                    </div>
                </div>
                {{-- Liste du panier + client + validation --}}
            <div class="col-md-6">
                <div class="card mb-3">
    <div class="card-header bg-info text-white">Colis dans le panier</div>
    <div class="card-body">
        @php
            $totalQuantite = 0;
            $totalMontant = 0;
            $totalPU = 0;
        @endphp

        <table class="table" id="tablePanier">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Quantité</th>
                    <th>P.U</th>
                    <th>Montant</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(session('panier'))
                    @foreach(session('panier') as $id => $item)
                        @php
                            $montant = $item['prix'] * $item['quantite'];
                            $totalQuantite += $item['quantite'];
                            $totalPU += $item['prix'];
                            $totalMontant += $montant;
                        @endphp
                        <tr>
                            <td>{{ $item['nom'] }}</td>
                            <td>{{ $item['quantite'] }}</td>
                            <td>{{ number_format($item['prix'], 0, '.', ' ') }}</td>
                            <td>{{ number_format($montant, 0, '.', ' ') }}</td>
                            <td>
                                <form action="{{ route('panier.supprimer', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th>{{ number_format($totalQuantite, 0, '.', ' ') }}</th>
                    <th>{{ number_format($totalPU, 0, '.', ' ') }} F</th>
                    <th colspan="2">{{ number_format($totalMontant, 0, '.', ' ') }} F CFA</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

            </div>
                            <div class="col-md-12"><br>
                    {{-- Formulaire de finalisation --}}
                <div class="card">
                    <div class="card-header bg-dark mb-3 text-white">Finaliser la vente</div>
                    <div class="card-body">
                        <form id="formSubmitPanier" method="POST" action="#">
                            @csrf
                            <div class="row mb-3">
                                <div class="input-group mb-3">
                                    <div class="flex-grow-1">
                                        <select id="client_id" name="client_id"
                                            class="form-select select2 @error('client_id') is-invalid @enderror">
                                            <option value="">Sélectionner un client</option>
                                            {{-- @foreach ($clients as $client)
                                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                    {{ $client->prenom }} {{ $client->nom }} - {{ $client->telephone }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary" id="button-addon2"
                                        data-bs-toggle="modal" data-bs-target="#ajoutClientModal">
                                        <i class="fa-solid fa-user-plus"></i>
                                    </button>
                                </div>

                                @error('client_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror

                                <!-- Destinataire -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="nomdestinat" class="form-label">Nom destinataire</label>
                                        <input type="text"
                                            class="form-control @error('nomdestinat') is-invalid @enderror"
                                            name="nomdestinat" value="{{ old('nomdestinat') }}" placeholder="Nom complet">
                                        @error('nomdestinat')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telephonedestinat" class="form-label">Téléphone du destinataire</label>
                                        <input type="text"
                                            class="form-control @error('telephonedestinat') is-invalid @enderror"
                                            name="telephonedestinat" value="{{ old('telephonedestinat') }}"
                                            placeholder="Téléphone du destinataire">
                                        @error('telephonedestinat')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            {{-- <input type="hidden" name="etat" value="{{ old('etat', 'en_attente') }}">
                        <input type="hidden" name="entreprise_id" value="{{ auth()->user()->entreprise_id }}">
                        <input type="hidden" name="branche_id" value="{{ auth()->user()->branche_id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}"> --}}
                            {{-- <input type="hidden" name="panier_colis" id="panier_colis"> --}}

                                <div class="card-footer">
                                    <button type="submit" name="action" value="valider_imprimer"
                                        class="btn btn-primary">
                                        <i class="fas fa-fw fa-save"></i>
                                        <span>Enregistré & Imprimé</span></button>
                                    <button type="submit" name="action" value="valider" class="btn btn-warning">
                                        <i class="fas fa-fw fa-save"></i>
                                        <span>Enregistré</span></button>
                                    <a href="reset" class="btn btn-outline-secondary"><i
                                            class="fas fa-fw fa-times"></i>
                                        <span>Annuler</span></a>
                                </div>

                        </form>
                    </div>
                </div>
                </div>
            </div>



        </div>
    </div>

    <!-- Modal Ajout Client -->
    {{-- <div class="modal fade" id="ajoutClientModal" tabindex="-1" aria-labelledby="ajoutClientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formAjoutClient" action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="ajoutClientModalLabel">Ajouter un client</h5>
          <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label for="prenom" class="form-label">Prénom</label>
              <input type="text" id="prenom" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}">
              @error('prenom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4">
              <label for="nom" class="form-label">Nom</label>
              <input type="text" id="nom" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}">
              @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4">
              <label for="telephone" class="form-label">Téléphone</label>
              <input type="text" id="telephone" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
              @error('telephone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row g-3 mt-2">
            <div class="col-md-4">
              <label for="type_piece" class="form-label">Type de pièce</label>
              <select name="type_piece" id="type_piece" class="form-select @error('type_piece') is-invalid @enderror">
                <option value="">-- Sélectionnez --</option>
                <option value="Carte d'identité" {{ old('type_piece') == "Carte d'identité" ? 'selected' : '' }}>Carte d'identité</option>
                <option value="NINA" {{ old('type_piece') == "NINA" ? 'selected' : '' }}>NINA</option>
                <option value="Biométrique" {{ old('type_piece') == "Biométrique" ? 'selected' : '' }}>Biométrique</option>
                <option value="Passeport" {{ old('type_piece') == "Passeport" ? 'selected' : '' }}>Passeport</option>
                <option value="Permis" {{ old('type_piece') == "Permis" ? 'selected' : '' }}>Permis</option>
              </select>
              @error('type_piece')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4">
              <label for="numero_piece" class="form-label">Numéro de la pièce</label>
              <input type="text" id="numero_piece" name="numero_piece" class="form-control @error('numero_piece') is-invalid @enderror" value="{{ old('numero_piece') }}">
              @error('numero_piece')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4">
              <label for="photo_piece" class="form-label">Photo pièce (optionnel)</label>
              <input type="file" id="photo_piece" name="photo_piece" class="form-control">
            </div>
          </div>

          <div class="row g-3 mt-2">
            <div class="col-md-6">
              <label for="email" class="form-label">Adresse Email</label>
              <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="adresse" class="form-label">Adresse</label>
              <input type="text" id="adresse" name="adresse" class="form-control @error('adresse') is-invalid @enderror" value="{{ old('adresse') }}">
              @error('adresse')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>


          <input type="hidden" name="entreprise_id" value="{{ auth()->user()->entreprise_id }}">
          <input type="hidden" name="branche_id" value="{{ auth()->user()->branche_id }}">
          <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        </div>
      </form>
    </div>
  </div>
</div> --}}
@endsection
