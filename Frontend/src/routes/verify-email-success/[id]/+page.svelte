<script lang="ts">
	import { onMount } from 'svelte';
	import { goto } from '$app/navigation';
	export let params: { id: string };

	let successMessage = 'Email vérifié avec succès !';
	let user: { id: number; username: string; email: string; roles: string[] } | null = null;

	onMount(async () => {
		const userId = params.id;

		if (!userId) return;

		try {
			const response = await fetch(`http://localhost:8000/api/front-user/${userId}`);
			if (response.ok) {
				user = await response.json();
				localStorage.setItem('user', JSON.stringify(user));
			} else {
				console.error('Erreur récupération utilisateur');
			}
		} catch (e) {
			console.error('Erreur récupération utilisateur', e);
		}

		setTimeout(() => goto('/login'), 5000);
	});
</script>

<p>{successMessage}</p>

{#if user}
	<div>
		<p>Nom d'utilisateur : {user.username}</p>
		<p>Email : {user.email}</p>
		<p>Rôles : {user.roles.join(', ')}</p>
	</div>
{/if}
