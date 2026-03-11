@extends('layouts.app')

@section('title', 'Nouvel Envoi - FMEXPRESS')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 py-8">
    <div class="max-w-5xl mx-auto px-6">
        <!-- HEADER -->
        <div class="mb-8 flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-gray-900">📦 Créer un nouvel envoi</h1>
                <p class="text-gray-600 mt-1">Ajoutez tous vos articles dans un seul envoi</p>
            </div>
        </div>

        @if ($errors->any())
        <div class="mb-6 bg-red-100 border-2 border-red-500 rounded-xl p-4">
            <h3 class="font-bold text-red-800 mb-2">❌ Erreurs de validation :</h3>
            <ul class="list-disc list-inside text-red-700 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('envois.store') }}" class="space-y-6">
            @csrf

            <!-- ÉTAPE 1 : EXPÉDITEUR -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-xl">🇫🇷</div>
                    <h2 class="text-xl font-black text-gray-900">Expéditeur (France)</h2>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Ville *</label>
                        <input 
                            type="text" 
                            name="expediteur_ville" 
                            value="{{ old('expediteur_ville') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            placeholder="Paris, Lyon, Marseille..."
                            required
                        >
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Adresse complète *</label>
                        <input 
                            type="text" 
                            name="expediteur_adresse" 
                            value="{{ old('expediteur_adresse') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            placeholder="123 Rue de la République"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Code Postal *</label>
                        <input 
                            type="text" 
                            name="expediteur_code_postal" 
                            value="{{ old('expediteur_code_postal') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            placeholder="75001"
                            required
                        >
                    </div>
                </div>
            </div>

            <!-- ÉTAPE 2 : DESTINATAIRE -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-xl">🇧🇯</div>
                    <h2 class="text-xl font-black text-gray-900">Destinataire (Bénin)</h2>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nom complet *</label>
                        <input 
                            type="text" 
                            name="destinataire_nom" 
                            value="{{ old('destinataire_nom') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            placeholder="Jean Dupont"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Téléphone *</label>
                        <input 
                            type="tel" 
                            name="destinataire_telephone" 
                            value="{{ old('destinataire_telephone') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            placeholder="+229 XX XX XX XX"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Ville *</label>
                        <input 
                            type="text" 
                            name="destinataire_ville" 
                            value="{{ old('destinataire_ville') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            placeholder="Cotonou, Porto-Novo, Parakou..."
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Adresse complète *</label>
                        <input 
                            type="text" 
                            name="destinataire_adresse" 
                            value="{{ old('destinataire_adresse') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            placeholder="Quartier, rue, numéro"
                            required
                        >
                    </div>
                </div>
            </div>

            <!-- ÉTAPE 3 : ARTICLES (PANIER) -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center text-xl">🛒</div>
                        <h2 class="text-xl font-black text-gray-900">Articles à envoyer</h2>
                    </div>
                    <button type="button" onclick="ajouterArticle()" class="px-4 py-2 bg-green-500 text-white rounded-lg font-bold hover:bg-green-600 transition">
                        ➕ Ajouter un article
                    </button>
                </div>

                <!-- FORMULAIRE D'AJOUT D'ARTICLE -->
                <div id="form_ajout_article" class="mb-6 p-4 bg-gray-50 rounded-lg border-2 border-gray-200">
                    <h3 class="font-bold text-gray-900 mb-4">Ajouter un article</h3>
                    <div class="grid grid-cols-4 gap-3">
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Catégorie</label>
                            <select id="temp_categorie" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="">Sélectionnez...</option>
                                <optgroup label="🔌 Électronique - Prix par Unité">
                                    <option value="TELEPHONE" data-prix="60" data-forfait="true">📱 Téléphone - 60€/u</option>
                                    <option value="MONTRE" data-prix="40" data-forfait="true">⌚ Montre - 40€/u</option>
                                    <option value="ECOUTEURS" data-prix="45" data-forfait="true">🎧 Écouteurs - 45€/u</option>
                                    <option value="APPAREIL_PHOTO" data-prix="100" data-forfait="true">📷 Appareil photo - 100€/u</option>
                                </optgroup>
                                <optgroup label="💻 Électronique - Au Poids">
                                    <option value="ORDINATEUR_PORTABLE" data-prix="35" data-forfait="false">💻 Ordinateur portable - 35€/kg</option>
                                    <option value="ORDINATEUR_BUREAU" data-prix="40" data-forfait="false">🖥️ Ordinateur bureau - 40€/kg</option>
                                    <option value="CONSOLE_JEU" data-prix="40" data-forfait="false">🎮 Console - 40€/kg</option>
                                </optgroup>
                                <optgroup label="📦 Produits Standard">
                                    <option value="STANDARD" data-prix="15" data-forfait="false">📦 Standard - 15€/kg</option>
                                    <option value="DOCUMENT" data-prix="10" data-forfait="false">📄 Document - 10€/kg</option>
                                </optgroup>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Quantité</label>
                            <input type="number" id="temp_quantite" value="1" min="1" max="50" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Poids total (kg)</label>
                            <input type="number" id="temp_poids" step="0.1" min="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="1.5">
                        </div>
                    </div>

                    <button type="button" onclick="ajouterArticle()" class="mt-3 w-full py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition">
                        ✅ Ajouter au panier
                    </button>
                </div>

                <!-- LISTE DES ARTICLES -->
                <div id="liste_articles" class="space-y-2">
                    <!-- Les articles seront ajoutés ici dynamiquement -->
                </div>

                <!-- RÉCAPITULATIF -->
                <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-green-50 rounded-lg border-2 border-blue-200">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-xs text-gray-600 font-semibold">Total articles</div>
                            <div id="total_articles" class="text-2xl font-black text-blue-600">0</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-600 font-semibold">Poids total</div>
                            <div id="total_poids" class="text-2xl font-black text-purple-600">0 kg</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-600 font-semibold">Prix de base</div>
                            <div id="total_prix" class="text-2xl font-black text-green-600">0€</div>
                        </div>
                    </div>
                </div>

                <!-- CHAMPS CACHÉS POUR ENVOYER LES DONNÉES -->
                <input type="hidden" name="articles_json" id="articles_json" required>
                <input type="hidden" name="poids_total_colis" id="poids_total_colis">
            </div>

            <!-- ÉTAPE 4 : INFORMATIONS COMPLÉMENTAIRES -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center text-xl">📝</div>
                    <h2 class="text-xl font-black text-gray-900">Informations complémentaires</h2>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Valeur déclarée totale (€)</label>
                        <input 
                            type="number" 
                            name="valeur_declaree" 
                            value="{{ old('valeur_declaree') }}"
                            step="0.01"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            placeholder="500.00"
                        >
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Description du contenu</label>
                        <textarea 
                            name="description_contenu" 
                            rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            placeholder="Décrivez votre envoi..."
                        >{{ old('description_contenu') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- ÉTAPE 5 : MODE DE LIVRAISON -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center text-xl">⚡</div>
                    <h2 class="text-xl font-black text-gray-900">Mode de livraison</h2>
                </div>

                <div class="space-y-4">
                    <div class="bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl p-4">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">⚡</div>
                            <div>
                                <div class="font-black text-lg">FMEXPRESS - Service Premium</div>
                                <div class="text-sm opacity-90">Livraison rapide et fiable garantie !</div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="mode_livraison" value="EXPRESS" class="peer sr-only" required checked>
                            <div class="p-6 border-2 border-gray-300 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 transition hover:shadow-lg">
                                <div class="text-4xl mb-3 text-center">✈️</div>
                                <div class="font-black text-gray-900 text-lg text-center mb-2">Express</div>
                                <div class="text-sm text-gray-600 text-center mb-3">7-10 jours ouvrés</div>
                                <div class="text-center">
                                    <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-bold">
                                        Prix normal
                                    </span>
                                </div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="mode_livraison" value="URGENTE" class="peer sr-only">
                            <div class="p-6 border-2 border-gray-300 rounded-xl peer-checked:border-red-500 peer-checked:bg-red-50 transition hover:shadow-lg">
                                <div class="text-4xl mb-3 text-center">🚀</div>
                                <div class="font-black text-gray-900 text-lg text-center mb-2">Urgente</div>
                                <div class="text-sm text-gray-600 text-center mb-3">3-5 jours ouvrés</div>
                                <div class="text-center">
                                    <span class="px-4 py-2 bg-red-100 text-red-700 rounded-full text-sm font-bold">
                                        +50% (Plus rapide)
                                    </span>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="flex items-center gap-3 p-4 bg-yellow-50 border-2 border-yellow-200 rounded-lg">
                        <input type="checkbox" name="assurance" value="1" id="assurance" class="w-5 h-5">
                        <label for="assurance" class="font-bold text-gray-900 cursor-pointer">
                            🛡️ Ajouter une assurance (2% de la valeur déclarée)
                        </label>
                    </div>
                </div>
            </div>

            <!-- BOUTONS -->
            <div class="flex gap-4">
                <a href="{{ route('dashboard') }}" class="flex-1 py-4 bg-gray-200 text-gray-700 rounded-lg font-bold text-center hover:bg-gray-300 transition">
                    Annuler
                </a>
                <button type="submit" class="flex-1 py-4 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-lg font-bold hover:shadow-xl transition">
                    ✅ Créer l'envoi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JAVASCRIPT POUR GESTION DU PANIER -->
<script>
let articles = [];

// Configuration des catégories
const categoriesConfig = {
    'TELEPHONE': { label: '📱 Téléphone', prix: 60, forfait: true },
    'MONTRE': { label: '⌚ Montre', prix: 40, forfait: true },
    'ECOUTEURS': { label: '🎧 Écouteurs', prix: 45, forfait: true },
    'APPAREIL_PHOTO': { label: '📷 Appareil photo', prix: 100, forfait: true },
    'ORDINATEUR_PORTABLE': { label: '💻 Ordinateur portable', prix: 35, forfait: false },
    'ORDINATEUR_BUREAU': { label: '🖥️ Ordinateur bureau', prix: 40, forfait: false },
    'CONSOLE_JEU': { label: '🎮 Console', prix: 40, forfait: false },
    'STANDARD': { label: '📦 Standard', prix: 15, forfait: false },
    'DOCUMENT': { label: '📄 Document', prix: 10, forfait: false },
};

function ajouterArticle() {
    const categorieSelect = document.getElementById('temp_categorie');
    const quantiteInput = document.getElementById('temp_quantite');
    const poidsInput = document.getElementById('temp_poids');

    const categorie = categorieSelect.value;
    const quantite = parseInt(quantiteInput.value) || 1;
    const poids = parseFloat(poidsInput.value) || 0;

    if (!categorie || poids <= 0) {
        alert('Veuillez sélectionner une catégorie et entrer un poids valide');
        return;
    }

    const config = categoriesConfig[categorie];
    let prixTotal;

    if (config.forfait) {
        // Prix forfaitaire : prix × quantité
        prixTotal = config.prix * quantite;
    } else {
        // Prix au poids : poids × prix/kg
        prixTotal = poids * config.prix;
    }

    const article = {
        categorie: categorie,
        label: config.label,
        quantite: quantite,
        poids: poids,
        prix_unitaire: config.prix,
        prix_total: prixTotal,
        forfait: config.forfait
    };

    articles.push(article);
    afficherArticles();

    // Réinitialiser le formulaire
    categorieSelect.value = '';
    quantiteInput.value = 1;
    poidsInput.value = '';
}

function supprimerArticle(index) {
    articles.splice(index, 1);
    afficherArticles();
}

function afficherArticles() {
    const listeContainer = document.getElementById('liste_articles');
    
    if (articles.length === 0) {
        listeContainer.innerHTML = '<div class="text-center py-8 text-gray-500">Aucun article ajouté</div>';
        document.getElementById('total_articles').textContent = '0';
        document.getElementById('total_poids').textContent = '0 kg';
        document.getElementById('total_prix').textContent = '0€';
        document.getElementById('articles_json').value = '';
        document.getElementById('poids_total_colis').value = '';
        return;
    }

    let html = '';
    let totalPoids = 0;
    let totalPrix = 0;

    articles.forEach((article, index) => {
        totalPoids += article.poids;
        totalPrix += article.prix_total;

        html += `
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex-1">
                    <div class="font-bold text-gray-900">${article.label}</div>
                    <div class="text-sm text-gray-600">
                        ${article.forfait ? 
                            `Quantité: ${article.quantite} × ${article.prix_unitaire}€ = ${article.prix_total.toFixed(2)}€` : 
                            `${article.poids}kg × ${article.prix_unitaire}€/kg = ${article.prix_total.toFixed(2)}€`
                        }
                        <span class="ml-2">• Poids: ${article.poids}kg</span>
                    </div>
                </div>
                <button type="button" onclick="supprimerArticle(${index})" class="px-3 py-1 bg-red-500 text-white rounded-lg text-sm font-bold hover:bg-red-600 transition">
                    ❌
                </button>
            </div>
        `;
    });

    listeContainer.innerHTML = html;

    // Mettre à jour les totaux
    document.getElementById('total_articles').textContent = articles.length;
    document.getElementById('total_poids').textContent = totalPoids.toFixed(2) + ' kg';
    document.getElementById('total_prix').textContent = totalPrix.toFixed(2) + '€';

    // Mettre à jour les champs cachés
    document.getElementById('articles_json').value = JSON.stringify(articles);
    document.getElementById('poids_total_colis').value = totalPoids.toFixed(2);
}

// Initialiser
document.addEventListener('DOMContentLoaded', function() {
    afficherArticles();
});
</script>
@endsection