<script>
	export let error = '';
</script>

{#if error}
	<p class="text-red-500 w-[150px] break-words p-1 border border-red-300 rounded">
		{error}
	</p>
{/if}
