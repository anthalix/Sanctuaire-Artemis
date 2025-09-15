<script lang="ts">
	let username = '';
	let email = '';
    let tel ="";
    let adresse="";
	let password = '';
	let message = '';

	async function register() {
		const res = await fetch('http://localhost:8000/api/register', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ username, email,tel , adresse, password })
			
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
		}}
	}
</script>
<div class="container_register">
<div class="select_register">


	<form on:submit|preventDefault={register} >
			<h2>Créer un compte</h2>
		<input type="text" placeholder="Nom" bind:value={username} required class="w-full p-2 border rounded"/>
		<input type="email" placeholder="Email" bind:value={email} required class="w-full p-2 border rounded"/>
        <input type="text" placeholder="telephone" bind:value={tel} required class="w-full p-2 border rounded"/>
        <textarea placeholder="Adresse" bind:value={adresse} required class="w-full p-2 border rounded">
            </textarea>

		<input type="password" placeholder="Mot de passe" bind:value={password} required class="w-full p-2 border rounded"/>
		<button type="submit" class="btn btn-primary">S’inscrire</button>
	</form>
</div>
</div>

{#if message}
	<p>{message}</p>
{/if}
