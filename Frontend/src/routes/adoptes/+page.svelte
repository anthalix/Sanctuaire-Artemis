<script lang="ts">

    export let data: { adoptes: any[], error?: string };

</script>

<div class="animal-container">
    <h1>Nos Adoptés</h1>


    <div class="trombi">
        <div class="list">



            {#each data.adoptes as animal}
                <div class="animal-card">
                    <h2>{animal.name}</h2>
                    <a href="animal/{animal.id}" title="CHATS ">
                        <img
                                src={`http://localhost:8000/animals/images/${animal.thumbnail}`}
                                alt={`Photo de ${animal.name}`}
                                width="200"
                        />
                    </a>
                </div>
            {/each}


        </div>
    </div>

</div>
<style>


 .list{

     margin-left: 300px;

 }


</style>