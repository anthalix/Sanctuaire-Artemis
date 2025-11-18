<script lang="ts">
	import { onMount } from 'svelte';
	import { getApiUrl } from '$lib/getApiUrl.js';

	let API_URL: string;
	let user: {
		id: number;
		username: string;
		email: string;
		tel: string;
		adresse: string;
		roles: string[];
	} | null = null;

	let username = '';
	let email = '';
	let tel = '';
	let adresse = '';

	onMount(async () => {
		API_URL = await getApiUrl(); // ✅ Initialisé ici

		const storedUser = localStorage.getItem('user');
		if (storedUser) {
			const parsedUser = JSON.parse(storedUser);
			user = parsedUser;
			username = parsedUser.username;
			email = parsedUser.email;
			tel = parsedUser.tel;
			adresse = parsedUser.adresse;
		} else {
			alert('Utilisateur non connecté');
			window.location.href = '/login';
		}
		console.log('Utilisateur chargé:', user);
	});

	async function modif() {
		if (!user || !API_URL) return; // ✅ Vérification ajoutée

		const res = await fetch(`${API_URL}/modif`, {
			// ✅ Parenthèses au lieu de backticks
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				Authorization: `Bearer ${localStorage.getItem('token')}`
			},
			body: JSON.stringify({ username, email, tel, adresse })
		});

		const text = await res.text();
		let updated;

		try {
			updated = JSON.parse(text);
		} catch (e) {
			console.error('❌ Réponse NON JSON', text);
			alert('Erreur serveur : réponse invalide');
			return;
		}

		if (!res.ok) {
			console.error('Erreur serveur', updated);
			alert(updated.error || 'Erreur lors de la mise à jour');
			return;
		}

		if (updated.user) {
			localStorage.setItem('user', JSON.stringify(updated.user));
			alert('Profil mis à jour avec succès !');
		}
	}

	function formatTel(event: Event) {
		const input = event.currentTarget as HTMLInputElement;
		const selectionStart = input.selectionStart || 0;

		// Garde seulement les chiffres
		let digits = input.value.replace(/\D/g, '').slice(0, 10);

		// Découpe en paires
		const groups: string[] = [];
		for (let i = 0; i < digits.length; i += 2) {
			groups.push(digits.substring(i, i + 2));
		}

		const formatted = groups.join('-');

		// Ajuste la position du curseur
		const oldLength = input.value.length;
		input.value = formatted;
		const newLength = formatted.length;
		const diff = newLength - oldLength;

		input.selectionStart = input.selectionEnd = selectionStart + diff;

		// Mets à jour le binding
		tel = formatted;
	}
</script>

<form on:submit|preventDefault={modif} class="p-4 border rounded max-w-md mx-auto mt-6">
	<div class="mb-3">
		<label for="username">Nom d'utilisateur</label>
		<input id="username" type="text" bind:value={username} class="p-2 border rounded w-full" />
	</div>

	<div class="mb-3">
		<label for="email">Email</label>
		<input id="email" type="email" bind:value={email} class="p-2 border rounded w-full" />
	</div>

	<div class="mb-3">
		<label for="tel">Téléphone</label>
		<input
			id="tel"
			type="tel"
			bind:value={tel}
			on:input={formatTel}
			class="p-2 border rounded w-full"
		/>
	</div>

	<div class="mb-3">
		<label for="adresse">Adresse</label>
		<input id="adresse" type="text" bind:value={adresse} class="p-2 border rounded w-full" />
	</div>

	<button type="submit" class="bg-blue-500 text-white p-2 rounded">Mettre à jour</button>
</form>
