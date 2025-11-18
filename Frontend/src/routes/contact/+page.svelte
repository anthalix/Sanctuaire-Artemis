<script lang="ts">
	import { onMount } from 'svelte';
	import { getApiUrl } from '$lib/getApiUrl.js';
	let API_URL: string;
	let user: {
		id: number;
		username: string;
		email: string;
		roles: string[];
		tel: string;
		adresse: string;
	} | null = null;
	let tel = '';
	let adresse = '';
	let success = '';
	let error = '';
	let message = '';

	onMount(() => {
		const storedUser = localStorage.getItem('user');
		if (storedUser) {
			user = JSON.parse(storedUser);
		} else {
			window.location.href = '/login';
		}
	});
	(async () => {
		API_URL = await getApiUrl();
	})();
	async function sendMessage() {
		if (!user) {
			error = 'Utilisateur non trouvé';
			return;
		}
		try {
			if (!API_URL) API_URL = await getApiUrl();
			const response = await fetch(`${API_URL}/message`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					Authorization: `Bearer ${localStorage.getItem('token')}` // si tu utilises JWT
				},
				body: JSON.stringify({
					userId: user.id,
					message: message
				})
			});

			if (!response.ok) {
				throw new Error('Erreur lors de l’envoi du message');
			}

			success = 'Message envoyé avec succès';
			message = ''; // reset du champ
			setTimeout(() => {
				success = '';
			}, 3000);
		} catch (error) {
			console.error(error);
			error = 'Message non envoyé';
		}
	}
</script>

<div class="container_register">
	<div class="card">
		<ul>
			<li>Pseudo : {user?.username}</li>
			<li>Email : {user?.email}</li>
			<li>Téléphone : {user?.tel}</li>
			<li>Adresse : {user?.adresse}</li>
			<a href="Modif">Modifier mes infos</a>
		</ul>
	</div>
	<div class="select_register">
		<h1>Nous contacter</h1>
		<form on:submit|preventDefault={sendMessage}>
			<textarea
				bind:value={message}
				placeholder="Votre message"
				rows="5"
				class="border p-2 rounded w-full"
			>
			</textarea>

			<button type="submit" class="btn btn-primary text-white p-1 rounded">Envoyer</button>
		</form>

		{#if success}<p class="success">{success}</p>{/if}
		{#if error}<p class="error">{error}</p>{/if}
	</div>
</div>

<style>
	form {
		width: 500px;
		display: flex;
		flex-direction: column;
		gap: 1rem;
		align-items: center;
	}

	textarea {
		width: 100%;
		padding-left: 15px;
		font-size: 0.8rem;
	}

	p.success {
		color: rgb(34, 98, 34);
		background-color: greenyellow;
		margin-top: 2rem;
		width: 100%;
	}
	p.error {
		color: red;
		background-color: rgb(248, 99, 99);
		margin-top: 2rem;
		width: 100%;
	}

	.container_register {
		display: flex;
		justify-content: center;
		align-items: center;
		margin-bottom: -70px;
		height: 100%;
		width: 100%;
		background-color: rgb(34, 71, 113);
	}
	.select_register {
		background-color: rgb(97, 134, 180);
		margin: 30px;
		padding: 2rem;
		border-radius: 10px;
		box-shadow: 0 6px 10px white;
		width: min-content;
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 1rem;
	}
	button {
		width: 50%;
		font-size: 0.8rem;
	}
	.card {
		background-color: rgb(14, 39, 88);
		padding-right: 50px;
		border-radius: 10px;
		box-shadow: 0 6px 10px white;
		width: 600px;
		color: rgb(254, 253, 253);
		margin-right: 150px;
	}
	.btn {
		width: 100%;
		margin-top: 25px;
	}
</style>
