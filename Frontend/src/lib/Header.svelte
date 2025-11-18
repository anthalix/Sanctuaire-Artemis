<script>
	import { goto } from '$app/navigation';

	function logout() {
		// Supprime le token JWT
		localStorage.removeItem('user');
		localStorage.removeItem('token');

		// Réinitialise le store utilisateur

		// Redirige vers la page de login
		goto('/login');
	}
</script>

<header>
	<div id="main-nav">
		<div>
			<img class="logo" src="../src/assets/logo.png" alt="Logo de l'entreprise" />
		</div>
		<div id="navbar-nav">
			<ul class="navbar-ul">
				<li class="navbar-link">
					<a aria-label="page d'accueil" href="/">Accueil</a>
				</li>
				<li class="navbar-link">
					<a aria-label="page conditions" href="/Adoption">Conditions d'adoption</a>
				</li>
				<li class="navbar-link">
					<a aria-label="page contact" href="/contact">Contact</a>
				</li>
				<li class="navbar-link">
					<a aria-label="page animaux adoptés" href="/adoptes">Animaux adoptés</a>
				</li>
				<li class="navbar-link">
					<a aria-label="page animaux adoptés" href="/Register">S'enregistrer</a>
				</li>
				<button on:click={logout} class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
					Déconnexion
				</button>
			</ul>
		</div>
	</div>
</header>
