<script lang="ts">
	import { getApiUrl } from '$lib/getApiUrl.js';
	import { goto } from '$app/navigation';
	import ErrorMessage from '$lib/ErrorMessage.svelte';

	let email = '';
	let password = '';
	let error = '';
	let API_URL: string;

	(async () => {
		API_URL = await getApiUrl();
	})();

	async function login() {
		try {
			const response = await fetch(`${API_URL}/login`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({ email, password })
			});

			const data = await response.json();
			console.log('Réponse du serveur:', data);

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
	<form on:submit|preventDefault={login}>
		<h1>Connexion</h1>

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
	</form>
</div>

<style>
	h1 {
		margin-top: -35px;
		margin-bottom: -10px;
	}
	.container_login {
		background-color: rgb(34, 71, 113);
		padding: 50px;
		margin-bottom: -70px;
	}
	form {
		background-color: rgb(97, 134, 180);
		width: min-content;
		padding-right: 15px;
		border-radius: 10px;
		box-shadow: 0 6px 10px white;
		width: 400px;
		height: 250px;
		margin: auto;

		display: flex;
		flex-direction: column;
		align-items: center;
		padding: 2rem;

		gap: 1rem;
	}
	input {
		width: 100%;
		height: 30px;
	}
	.btn {
		width: 100%;
	}
</style>
