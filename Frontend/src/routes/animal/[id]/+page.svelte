<script lang="ts">
	export let data;
	const animal = data.animal;

	import { onMount } from 'svelte';

	onMount(() => {
		const myCarouselElement = document.querySelector('#carouselExample');
		const carousel = new window.bootstrap.Carousel(myCarouselElement, {
			interval: 5000,
			touch: false
		});
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
		<h2>A propos de {animal.name} :</h2>

		<p>
			{@html animal.description} <br /><br />

			Il est agé de {animal.age} ans,
			{#each animal.breeds as breed}
				C'est un {breed.name} !
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
				<span>
					{animal.name} n'est pas compatible avec les
					<img src="../src/assets/okchien.png" alt="chat-logo" /><br />
				</span><br />
			{/if}
			{#if animal.cat === true}
				<span>
					{animal.name} adore les <img src="../src/assets/okchat.png" alt="chat-logo" />
				</span>
			{:else}
				<span>
					{animal.name} n'est pas compatible avec les
					<img src="../src/assets/okchat.png" alt="chat-logo" />
				</span>
			{/if}
		</p>
	</div>
</main>

<style>
	h1 {
		width: min-content;
		height: min-content;
		margin: auto;
		margin-top: 25px;
	}
	p {
		text-align: justify;
		width: 95%;
		height: min-content;
		font-size: x-large;
		padding-top: 25px;
		padding-left: 15px;
		margin-top: 65px;
		margin-right: 25px;
	}
	h2 {
		background-color: rgb(32, 69, 90);
		border: 1px solid white;
		border-radius: 10px;

		margin-top: 20px;
		color: white;
		padding: 7px 15px;
		width: max-content;
	}
	img {
		width: 40px;
	}

</style>
