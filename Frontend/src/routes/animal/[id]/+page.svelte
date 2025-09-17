<script lang="ts">
	export let data;
	const animal = data.animal;

	import { onMount } from 'svelte';

	onMount(() => {
		const myCarouselElement = document.querySelector('#carouselExample');
		if (myCarouselElement) {
			const carousel = new window.bootstrap.Carousel(myCarouselElement, {
				interval: 3000,
				touch: false
			});
		}
	});
</script>

<h1>{animal.name}</h1>

<main class="single">
	<div class="single-img">
		<div id="carouselExample" class="carousel slide">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img
						src={`http://localhost:8000/animals/images/${animal.thumbnail}`}
						alt="animal thumbnail"
					/>
				</div>
				<div class="carousel-item">
					<img
						src={`http://localhost:8000/animals/images/${animal.thumbnail}`}
						alt="animal thumbnail"
					/>
				</div>
				<div class="carousel-item">
					<img
						src={`http://localhost:8000/animals/images/${animal.thumbnail}`}
						alt="animal thumbnail"
					/>
				</div>
			</div>
			<button
				class="carousel-control-prev"
				type="button"
				data-bs-target="#carouselExample"
				data-bs-slide="prev"
			>
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button
				class="carousel-control-next"
				type="button"
				data-bs-target="#carouselExample"
				data-bs-slide="next"
			>
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
		</div>
	</div>

	<div class="single-presentation">
		<p class="description">{@html animal.description}</p>
		<br /><br />
		<p>
			Il est agé de {animal.age} ans,
			{#each animal.breeds as breed}
				C'est un : <span class="breed"> {breed.name}</span>
			{/each} <br />
			<br />

			{#if animal.child === true}
				<span>
					{animal.name} adore les <img src="../src/assets/enfants.png" alt="enfant-logo" /><br />
				</span><br />
			{/if}
			{#if animal.dog === true}
				<span>
					{animal.name} adore les <img src="../src/assets/okchien.png" alt="chien-logo" /><br />
				</span><br />
			{:else}
				<span class="incompatible">
					{animal.name} n'est pas compatible avec les
					<img src="../src/assets/okchien.png" alt="chat-logo" /><br />
				</span><br />
			{/if}
			{#if animal.cat === true}
				<span>
					{animal.name} adore les <img src="../src/assets/okchat.png" alt="chat-logo" />
				</span>
			{:else}
				<span class="incompatible">
					{animal.name} n'est pas compatible avec les
					<img src="../src/assets/okchat.png" alt="chat-logo" />
				</span>
			{/if}
		</p>
	</div>
</main>

<style>
	.single {
		display: flex;
		flex-direction: row;
		justify-content: center;
		align-items: center;
		gap: 50px;
		margin: 20px 50px;
		flex-wrap: wrap;
	}
	.single-img {
		width: 500px;
		height: 500px;
		border: 2px solid #0f1851;
		border-radius: 8px;
		overflow: hidden;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	}
	.single-img img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}
	.single-presentation {
		width: 500px;
		height: 500px;
		border: 2px solid #0f1851;
		border-radius: 8px;
		overflow: auto;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		padding: 15px;
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
	p {
		font-size: 1.1rem;
		line-height: 1.6;
		width: 100%;
		height: max-content;
		position: relative;
		padding-top: 20px;
	}

	img {
		width: 40px;
	}
	.description {
		font-weight: bold;
		font-size: 1.2rem;
		height: 150px;
	}
	.breed {
		position: absolute;
		font-weight: bold;
		color: rgb(10, 35, 64);
		font-size: 2rem;
		right: 10px;
		top: 6px;

		font-family: 'bebas+neue', sans-serif;
	}
	.incompatible {
		color: red;
		font-weight: bold; /* optionnel */
	}
</style>
