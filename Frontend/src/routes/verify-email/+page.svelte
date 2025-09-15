<script lang="ts">
	import { onMount } from 'svelte';
	import { goto } from '$app/navigation';

	let success = '';
	let error = '';
	let user: { id: number; username: string; email: string; roles: string[] } | null = null;

	onMount(async () => {
		const params = new URLSearchParams(window.location.search);
		const url = params.get('url');

		if (!url) {
			error = 'Lien de vérification invalide.';
			return;
		}

		try {
			const response = await fetch(url);
			const data = await response.json();

			if (response.ok) {
				success = data.message;
				user = data.user; // on stocke les infos de l'utilisateur
				setTimeout(() => {
					goto('/login')
				}, 10000);
			} else {
				error = data.error || 'Une erreur inconnue est survenue.';
			}
		} catch (e) {
			console.error(e);
			error = 'Erreur de connexion au serveur.';
		}
	});
</script>
{#if success}
	<p class="text-green-600 font-semibold">{success}</p>

	{#if user}
		<div class="mt-4 p-4 border rounded bg-gray-100">
			<p><strong>Nom d'utilisateur :</strong> {user.username}</p>
			<p><strong>Email :</strong> {user.email}</p>
		
		</div>
	{/if}



{:else if error}
	<p class="text-red-600 font-semibold">{error}</p>
{/if}

