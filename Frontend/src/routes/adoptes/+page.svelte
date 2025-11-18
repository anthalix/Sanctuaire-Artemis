<script lang="ts">
	export let data: { adoptes: any[]; error?: string | null; BASE_URL: string };
	let BASE_URL = data.BASE_URL;
</script>

<div class="animal-container">
	<h1>Nos Heureux élus :</h1>

	<div class="trombi">
		<div class="list">
			{#each data.adoptes as animal}
				<div class="animal-card">
					<h2>{animal.name}</h2>
					<a href="animal/{animal.id}" title="CHATS ">
						<img
							src={`${BASE_URL}/animals/images/${animal.thumbnail}`}
							alt={`Photo de ${animal.name}`}
							width="200"
							height="200"
							style="object-fit: cover; border-radius: 8px;"
						/>
					</a>
				</div>
			{/each}
		</div>
	</div>
</div>

<style>
	.animal-container {
		text-align: center;
		margin-top: 20px;
		margin-bottom: 20px;
	}
	.list {
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		gap: 20px;
	}
	.animal-card {
		border: 1px solid #0f1851;
		border-radius: 8px;
		padding: 10px;
		width: 220px;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		transition: transform 0.2s;
		background-color: white;
	}
</style>
