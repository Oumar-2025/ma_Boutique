@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4"><br>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Liste des utilisateurs</li>
        </ol>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Utilisateurs</h5>
                <a href="{{ route('users.create') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-plus"></i>
                    Ajouter</a>
            </div>
            <div class="card-body px-4 py-3">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="text-center">
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-link">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-link">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-link text-info" data-bs-toggle="modal"
                                        data-bs-target="#passwordModal"
                                        data-password="{{ $user->plain_password ?? 'Mot de passe non disponible' }}"
                                        data-user="{{ $user->name }}" title="Voir le mot de passe">
                                        <i class="fa-solid fa-key"></i>
                                    </button>
                                    {{-- Modal voir password --}}
                                    <div class="modal fade" id="passwordModal" tabindex="-1"
                                        aria-labelledby="passwordModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content border-info shadow">
                                                <div class="modal-header bg-info text-white">
                                                    <h5 class="modal-title" id="passwordModalLabel">Mot de passe utilisateur
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Utilisateur :</strong> <span id="modalUserName"></span></p>
                                                    <div class="input-group">
                                                        <input type="password" id="modalPassword" class="form-control"
                                                            readonly>
                                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">👁️</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Bouton pour ouvrir le modal -->
                                    <button type="button" class="btn btn-link text-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $user->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <!-- Header -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">
                                                        Confirmation
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fermer"></button>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer
                                                    <strong>{{ $user->name }}</strong> ?
                                                </div>

                                                <!-- Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>

                                                    <!-- ✅ Formulaire unique ici -->
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted text-center">Aucun utilisatuer trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const input = document.getElementById('modalPassword');
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        const passwordModal = document.getElementById('passwordModal');
        passwordModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const password = button.getAttribute('data-password');
            const userName = button.getAttribute('data-user');
            document.getElementById('modalPassword').value = password;
            document.getElementById('modalUserName').textContent = userName;
        });
    </script>
@endsection
