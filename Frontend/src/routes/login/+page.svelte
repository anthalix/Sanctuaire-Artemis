<script lang="ts">
	import { goto } from '$app/navigation';

	let email = '';
	let password = '';
	let error = '';

	async function login() {
		try {
			const response = await fetch('http://localhost:8000/api/login', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({ email, password })
			});

			const data = await response.json();

			if (!response.ok) {
				error = data.message || 'Identifiants incorrects';
				return;
			}

			// Stockage du token JWT (à adapter selon ta réponse backend)
			localStorage.setItem('token', data.token);
			localStorage.setItem('user', JSON.stringify(data.user));

			// Redirection vers la page de contact
			goto('/contact');
		} catch (e) {
			error = 'Erreur de connexion au serveur.';
			console.error(e);
		}
	}
</script>

<div class="container_login">
	<div class="select_login">
		<form on:submit|preventDefault={login}>
			<h2 >Connexion</h2>

			<input
				type="email"
				placeholder="Email"
				bind:value={email}
				required
				class="w-full p-2 border rounded"
			/>

			<input
				type="password"
				placeholder="Mot de passe"
				bind:value={password}
				required
				class="w-full p-2 border rounded"
			/>

			<button type="submit" class="btn btn-primary"> Se connecter </button>

			{#if error}
				<p class="text-red-500">{error}</p>
			{/if}
		</form>
	</div>
</div>
