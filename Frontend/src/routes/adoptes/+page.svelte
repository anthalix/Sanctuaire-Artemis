<script lang="ts">

    export let data: { adoptes: any[], error?: string };

</script>

<div class="animal-container">
    <h1>Nos Adoptés :</h1>


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
 .list{

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
 h1{
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