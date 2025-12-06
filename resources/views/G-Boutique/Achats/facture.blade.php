<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture Achat #{{ $achat->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 0; }
        .container { width: 100%; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header .logo img { width: 120px; }
        .header .boutique-info { text-align: right; }
        .header h2 { margin: 0; color: #2c3e50; }
        .header p { margin: 2px 0; }

        .client-info, .vente-info { margin-bottom: 20px; }
        .client-info p, .vente-info p { margin: 2px 0; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { border: 1px solid #ddd; padding: 8px; }
        table th { background-color: #3498db; color: #fff; text-align: left; }

        .total { text-align: right; font-size: 14px; font-weight: bold; margin-top: 10px; }
        .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                {{-- @if(isset($boutique->logo))
                    <img src="{{ asset( $boutique->logo) }}" alt="Logo">
                @else
                    <h2>{{ $boutique->nom }}</h2>
                @endif --}}
            </div>
            <div class="boutique-info">
                <p>{{ $boutique->adresse }}</p>
                <p>Téléphone : {{ $boutique->telephone }}</p>
                <p>Email : {{ $boutique->email ?? '' }}</p>
            </div>
        </div>

        <div class="client-info">
            <h3>Fournisseur :</h3>
            <p>{{ $achat->fournisseur->nom }}</p>
        </div>

        <div class="achat-info">
            <p><strong>Date :</strong> {{ $achat->date_achat }}</p>
            <p><strong>Achat n° :</strong> {{ $achat->id }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($achat->details as $detail)
                <tr>
                    <td>{{ $detail->produit->nom }}</td>
                    <td>{{ $detail->quantite }}</td>
                    <td>{{ number_format($detail->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($detail->quantite * $detail->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">Total général : {{ number_format($achat->total, 0, ',', ' ') }} FCFA</p>

        <div class="footer">
            <p>Merci pour votre confiance !</p>
        </div>
        {{-- <a href="{{ route('ventes.facture', $vente->id) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-file-pdf"></i>
                                    </a> --}}
    </div>
</body>
</html>
