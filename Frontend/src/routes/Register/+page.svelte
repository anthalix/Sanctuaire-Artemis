<script lang="ts">
	let username = '';
	let email = '';
	let tel = '';
	let adresse = '';
	let password = '';
	let message = '';
	import { getApiUrl } from '$lib/getApiUrl.js';
	let API_URL: string;

	(async () => {
		API_URL = await getApiUrl();
	})();
	async function register() {
		const res = await fetch(`${API_URL}/register`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ username, email, tel, adresse, password })
		});

		if (res.ok) {
			message = 'un email de confirmation vous a été envoyer !';
		} else {
			const text = await res.text();
			try {
				const json = JSON.parse(text);
				message = 'Erreur : ' + (json.error || 'Erreur inconnue');
			} catch (e) {
				console.error('Réponse non JSON reçue :', text);
				message = 'Erreur inattendue (voir console).';
			}
		}
	}

	// Fonction qui formate le numéro avec des tirets tous les 2 chiffres
	function formatTel(event: Event) {
		const target = event.target as HTMLInputElement;
		let value = target.value.replace(/\D/g, ''); // supprime tout sauf chiffres
		value = value.slice(0, 10); // limite à 10 chiffres (numéro FR classique)

		// ajoute un tiret tous les 2 chiffres
		let formatted = value.replace(/(\d{2})(?=\d)/g, '$1-');
		tel = formatted;
	}
</script>

<div class="container_register">
	<div class="select_register">
		<form on:submit|preventDefault={register} class="flex flex-col gap-3">
			<h1>Créer un compte</h1>
			<div class="form">
				<label for="username"></label>
				<input
					type="text"
					placeholder="Pseudo"
					bind:value={username}
					required
					class=" p-2 border rounded"
				/>
				<label for="email"></label>
				<input
					type="email"
					placeholder="Email"
					bind:value={email}
					required
					class=" p-1 border rounded"
				/>
				<label for="tel"></label>
				<input
					type="tel"
					placeholder="telephone"
					bind:value={tel}
					on:input={formatTel}
					required
					class=" p-2 border rounded"
				/>
			</div>
			<label for="adresse"></label>
			<textarea
				placeholder="Adresse"
				bind:value={adresse}
				required
				class=" p-2 border rounded"
				id="adresse"
			>
			</textarea>
			<label for="password"></label>
			<input
				type="password"
				placeholder="Mot de passe"
				bind:value={password}
				required
				class=" p-2 border rounded"
				id="password"
			/>
			<button type="submit" class="btn btn-primary">S’inscrire</button>
		</form>
	</div>
</div>

{#if message}
	<p>{message}</p>
{/if}

<style>
	form {
		width: 100%;
		display: flex;
		flex-direction: column;
		gap: 1rem;
		align-items: center;
	}
	#adresse {
		width: 100%;
	}
	textarea {
		width: 100%;
		padding-left: 15px;
		font-size: 0.8rem;
	}
	.form {
		display: flex;
		flex-direction: row;
		gap: 1rem;
		margin-left: -22px;
		margin-right: 10px;

		width: 100%;
	}
	input {
		width: 170px;
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
	#password {
		width: 100%;
	}
</style>
