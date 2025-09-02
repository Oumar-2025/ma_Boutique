@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Produit</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Détails du produit : {{ $produit->nom }}</h5>
                <a href="{{ route('produit.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-list"></i>
                    Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <table class="table">
                    <tr>
                        <td><img src="{{ asset($produit->image) }}" alt="{{ $produit->nom }}" class="img-fluid"
                                style="max-width: 200px;"></td>
                    </tr>
                    <tr>
                        <th>Catégorie :</th>
                        <td>{{ $produit->categorie->nom }}</td>
                    </tr>
                    <tr>
                        <th>Nom :</th>
                        <td>{{ $produit->nom }}</td>
                    </tr>
                    <tr>
                        <th>Prix d'achat :</th>
                        <td>{{ $produit->prix_achat }}</td>
                    </tr>
                    <tr>
                        <th>Prix de vente :</th>
                        <td>{{ $produit->prix_vente }}</td>
                    </tr>
                    <tr>
                        <th>Stock :</th>
                        <td>{{ $produit->stock }}</td>
                    </tr>

                </table>
                {!! DNS1D::getBarcodeHTML($produit->code_barre, 'C128', 2, 60) !!}
                <p class="mt-2">{{ $produit->code_barre }}</p>
            </div>
        </div>
    @endsection
