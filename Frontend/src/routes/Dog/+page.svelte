<script lang="ts">
	// data vient automatiquement de ton +page.ts
	export let data;
	const dogs = data.dogs;
	let Race = '';
	let Age = '';
	let Sexe = '';
	let Taille = '';

	const breeds = Array.from(
		new Map(dogs.flatMap((dog) => dog.breeds).map((breed) => [breed.name, breed])).values()
	);

	// recalculer la liste filtrée à chaque changement
	$: filteredDogs = dogs.filter((dog) => {
		const matchRace = !Race || dog.breeds.some((breed) => breed.name === Race);

		const matchSexe = !Sexe || dog.sex === Sexe;

		// ⚠️ Age est une string depuis <select>, donc on convertit
		const matchAge = !Age || dog.age === Number(Age);

		const matchTaille = !Taille || dog.taille === Taille;

		return matchRace && matchSexe && matchAge && matchTaille;
	});
</script>

<h1>Liste des chiens 🐾</h1>

<div class="animal-container">
	<div class="select">
		<form class="form">
			<select bind:value={Race} aria-label="tri par race" class="form-select">
				<option value=""> Race </option>
				{#each breeds as breed}
					<option value={breed.name}>{breed.name}</option>
				{/each}
			</select>
			<select bind:value={Sexe} aria-label="tri par sexe" class="form-select">
				<option value=""> Sexe </option>
				{#each Array.from(new Set(dogs.map((dog) => dog.sex))) as sexe}
					<option value={sexe}>{sexe}</option>
				{/each}
			</select>
			<select bind:value={Age} aria-label="tri par age" class="form-select">
				<option value=""> Age </option>
				{#each Array.from(new Set(dogs.map((dog) => dog.age))) as age}
					<option value={age}>{age}</option>
				{/each}
			</select>

			<select bind:value={Taille} aria-label="tri par taille" class="form-select">
				<option value=""> Taille </option>
				{#each Array.from(new Set(dogs.map((dog) => dog.taille))) as taille}
					<option value={taille}>{taille}</option>
				{/each}
			</select>
			<button
				type="button"
				class="btn btn-secondary"
				on:click={() => {
					Race = '';
					Sexe = '';
					Age = '';
					Taille = '';
				}}
			>
				Réinitialiser
			</button>
		</form>
	</div>

	<div class="row">
		{#if filteredDogs.length > 0}
			{#each filteredDogs as dog}
				<div class="col-md-2 mb-2">
					<div class="card position-relative">
						{#if dog.status === 'urgent'}
							<div class="ribbon">URGENT</div>
						{/if}
						<a href="animal/{dog.id}" title="CHIENS ">
							<img
								src={`http://localhost:8000/animals/images/${dog.thumbnail}`}
								class="card-img-top"
								alt={dog.name}
							/>
						</a>
						<h5 class="card-title">{dog.name}</h5>
					</div>
				</div>
			{/each}
		{:else}
			<p>Aucun chien ne correspond à vos critères 🐾</p>
		{/if}
	</div>
</div>

<style>
	.animal-container {
		text-align: center;
		margin-top: 20px;
		margin-bottom: 20px;
		display: flex;
		flex-direction: row;
	}
	.ribbon {
		width: 120px;
		height: 30px;
		background: red;
		color: white;
		font-weight: bold;
		text-align: center;
		line-height: 30px;
		border-radius: 10px;
		position: absolute;
		top: 10px;
		right: -30px;
		transform: rotate(45deg);
		z-index: 10;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
	}
	.select {
		background-color: steelblue;
		width: 220px;
		height: 280px;
		border-radius: 5px;
		margin-top: 25px;
		display: flex;
		justify-content: center;
		align-items: center;
		margin-left: auto;
		margin-right: auto;
	}
	.card {
		background-color: white;
		border: 1px solid #0f1851;
		border-radius: 8px;
		padding: 10px;
		width: 220px;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		transition: transform 0.2s;
		text-align: center;
		margin-top: 25px;
	}
	.row {
		width: 80%;
		margin-left: auto;
		display: flex;
		margin-right: 50px;
		flex-direction: row;
		justify-content: left;
		gap: 50px;
	}

	h5 {
		font-size: 1rem;
		color: rgb(34, 71, 113);
		text-shadow: 2px 2px 4px rgba(12, 29, 76, 0.5);
		margin-bottom: 20px;
		margin-top: 20px;
		font-family: 'bebas+neue', sans-serif;
		text-align: center;
		border-radius: 5px;
	}
	.form {
		display: flex;
		flex-direction: column;
		gap: 15px;
	}
	select {
		margin: auto;
		width: 150px;

		border: 1px solid #0d255c;
		border-radius: 4px;
		font-size: 0.8rem;
	}
	h1 {
		font-size: 3rem;
		color: rgb(34, 71, 113);
		text-shadow: 2px 2px 4px rgba(12, 29, 76, 0.5);
		margin-bottom: 20px;
		margin-top: 20px;
		font-family: 'bebas+neue', sans-serif;
		text-align: center;
		border-radius: 5px;

		padding: 20px 40px;
	}
</style>
