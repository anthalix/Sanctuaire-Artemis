<script lang="ts">
	let username = '';
	let email = '';
	let tel = '';
	let adresse = '';
	let password = '';
	let message = '';

	async function register() {
		const res = await fetch('http://localhost:8000/api/register', {
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
</script>

<div class="container_register">
	<div class="select_register">
		<form on:submit|preventDefault={register} class="flex flex-col gap-3">
			<h2>Créer un compte</h2>
			<div class="form">
				<input
					type="text"
					placeholder="Pseudo"
					bind:value={username}
					required
					class=" p-2 border rounded"
				/>
				<input
					type="email"
					placeholder="Email"
					bind:value={email}
					required
					class=" p-2 border rounded"
				/>
				<input
					type="text"
					placeholder="telephone"
					bind:value={tel}
					required
					class=" p-2 border rounded"
				/>
			</div>
			<textarea
				placeholder="Adresse"
				bind:value={adresse}
				required
				class=" p-2 border rounded"
				id="adresse"
			>
			</textarea>

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
		width: 100%;
	}
	.form input {
		width: 175px;
		padding-left: 15px;
		font-size: 0.8rem;
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
		background-color: rgb(61, 93, 132);
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
